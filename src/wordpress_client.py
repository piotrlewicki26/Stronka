"""
WordPress REST API client.

Wraps all HTTP interactions with the WordPress site so the rest of the
codebase never has to deal with raw requests / auth / retries.
"""
from __future__ import annotations

import io
import mimetypes
import os
from typing import Any
from urllib.parse import urljoin

import requests
from requests.auth import HTTPBasicAuth
from tenacity import retry, stop_after_attempt, wait_exponential

from src.config import config


class WordPressClient:
    """Thin wrapper around the WordPress REST API v2."""

    def __init__(self) -> None:
        self._base = config.WP_URL.rstrip("/") + "/wp-json/wp/v2/"
        self._auth = HTTPBasicAuth(config.WP_USERNAME, config.WP_APP_PASSWORD)
        self._timeout = config.REQUEST_TIMEOUT
        self._session = requests.Session()
        self._session.auth = self._auth
        self._session.headers.update({"Accept": "application/json"})

    # ------------------------------------------------------------------
    # Internal helpers
    # ------------------------------------------------------------------

    @retry(
        stop=stop_after_attempt(config.MAX_RETRIES),
        wait=wait_exponential(multiplier=1, min=2, max=10),
        reraise=True,
    )
    def _get(self, endpoint: str, params: dict | None = None) -> Any:
        url = urljoin(self._base, endpoint)
        resp = self._session.get(url, params=params, timeout=self._timeout)
        resp.raise_for_status()
        return resp.json()

    @retry(
        stop=stop_after_attempt(config.MAX_RETRIES),
        wait=wait_exponential(multiplier=1, min=2, max=10),
        reraise=True,
    )
    def _post(self, endpoint: str, data: dict) -> Any:
        url = urljoin(self._base, endpoint)
        resp = self._session.post(url, json=data, timeout=self._timeout)
        resp.raise_for_status()
        return resp.json()

    @retry(
        stop=stop_after_attempt(config.MAX_RETRIES),
        wait=wait_exponential(multiplier=1, min=2, max=10),
        reraise=True,
    )
    def _put(self, endpoint: str, data: dict) -> Any:
        url = urljoin(self._base, endpoint)
        resp = self._session.put(url, json=data, timeout=self._timeout)
        resp.raise_for_status()
        return resp.json()

    # ------------------------------------------------------------------
    # Pages
    # ------------------------------------------------------------------

    def create_page(
        self,
        title: str,
        content: str,
        slug: str,
        status: str = "draft",
        parent_id: int = 0,
        featured_media: int = 0,
        meta_description: str = "",
        template: str = "",
    ) -> dict:
        """Create a new WordPress page and return the API response."""
        payload: dict[str, Any] = {
            "title": title,
            "content": content,
            "slug": slug,
            "status": status,
        }
        if parent_id:
            payload["parent"] = parent_id
        if featured_media:
            payload["featured_media"] = featured_media
        if template:
            payload["template"] = template
        if meta_description:
            payload.setdefault("meta", {})["description"] = meta_description
        return self._post("pages", payload)

    def update_page(self, page_id: int, data: dict) -> dict:
        return self._put(f"pages/{page_id}", data)

    def list_pages(self) -> list[dict]:
        return self._get("pages", params={"per_page": 100})

    def get_page(self, page_id: int) -> dict:
        return self._get(f"pages/{page_id}")

    # ------------------------------------------------------------------
    # Posts
    # ------------------------------------------------------------------

    def create_post(
        self,
        title: str,
        content: str,
        slug: str,
        status: str = "draft",
        categories: list[int] | None = None,
        tags: list[int] | None = None,
        featured_media: int = 0,
    ) -> dict:
        payload: dict[str, Any] = {
            "title": title,
            "content": content,
            "slug": slug,
            "status": status,
        }
        if categories:
            payload["categories"] = categories
        if tags:
            payload["tags"] = tags
        if featured_media:
            payload["featured_media"] = featured_media
        return self._post("posts", payload)

    # ------------------------------------------------------------------
    # Media
    # ------------------------------------------------------------------

    @retry(
        stop=stop_after_attempt(config.MAX_RETRIES),
        wait=wait_exponential(multiplier=1, min=2, max=10),
        reraise=True,
    )
    def upload_media(
        self,
        image_bytes: bytes,
        filename: str,
        alt_text: str = "",
        caption: str = "",
    ) -> dict:
        """Upload raw image bytes to the WordPress Media Library."""
        mime_type = mimetypes.guess_type(filename)[0] or "image/png"
        url = urljoin(self._base, "media")
        headers = {
            "Content-Disposition": f'attachment; filename="{filename}"',
            "Content-Type": mime_type,
        }
        resp = self._session.post(
            url,
            data=io.BytesIO(image_bytes),
            headers=headers,
            timeout=self._timeout,
        )
        resp.raise_for_status()
        media = resp.json()
        media_id = media["id"]
        # Set alt text / caption if provided
        if alt_text or caption:
            update_payload: dict[str, Any] = {}
            if alt_text:
                update_payload["alt_text"] = alt_text
            if caption:
                update_payload["caption"] = caption
            self._put(f"media/{media_id}", update_payload)
        return media

    # ------------------------------------------------------------------
    # Menus  (requires WP REST API Menus plugin or WP 5.9+ block menus)
    # ------------------------------------------------------------------

    def list_menus(self) -> list[dict]:
        """List navigation menus via the WP menus endpoint (requires plugin)."""
        try:
            url = config.WP_URL.rstrip("/") + "/wp-json/wp/v2/menus"
            resp = self._session.get(url, timeout=self._timeout)
            resp.raise_for_status()
            return resp.json()
        except requests.HTTPError:
            # Endpoint may not be available on all installations
            return []

    @retry(
        stop=stop_after_attempt(config.MAX_RETRIES),
        wait=wait_exponential(multiplier=1, min=2, max=10),
        reraise=True,
    )
    def create_menu_item(
        self,
        menu_id: int,
        title: str,
        url: str,
        parent_item_id: int = 0,
        order: int = 1,
    ) -> dict:
        """Add an item to an existing navigation menu."""
        base = config.WP_URL.rstrip("/") + "/wp-json/wp/v2"
        payload: dict[str, Any] = {
            "title": title,
            "url": url,
            "menus": menu_id,
            "menu_order": order,
        }
        if parent_item_id:
            payload["parent"] = parent_item_id
        resp = self._session.post(
            f"{base}/menu-items",
            json=payload,
            timeout=self._timeout,
        )
        resp.raise_for_status()
        return resp.json()

    # ------------------------------------------------------------------
    # Categories & Tags
    # ------------------------------------------------------------------

    def create_category(self, name: str, slug: str, description: str = "") -> dict:
        return self._post("categories", {"name": name, "slug": slug, "description": description})

    def create_tag(self, name: str, slug: str) -> dict:
        return self._post("tags", {"name": name, "slug": slug})

    # ------------------------------------------------------------------
    # Site settings
    # ------------------------------------------------------------------

    def get_site_settings(self) -> dict:
        url = config.WP_URL.rstrip("/") + "/wp-json/wp/v2/settings"
        resp = self._session.get(url, timeout=self._timeout)
        resp.raise_for_status()
        return resp.json()

    def update_site_settings(self, data: dict) -> dict:
        url = config.WP_URL.rstrip("/") + "/wp-json/wp/v2/settings"
        resp = self._session.post(url, json=data, timeout=self._timeout)
        resp.raise_for_status()
        return resp.json()
