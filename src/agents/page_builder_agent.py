"""
Page / Subpage Builder Agent

Creates the full page hierarchy in WordPress using the REST API.
"""
from __future__ import annotations

from typing import TYPE_CHECKING

from src.agents.content_agent import ContentAgent

if TYPE_CHECKING:
    from src.wordpress_client import WordPressClient


class PageBuilderAgent:
    """Creates and manages WordPress pages, preserving parent/child relationships."""

    def __init__(self, wp: "WordPressClient", content_agent: ContentAgent) -> None:
        self._wp = wp
        self._content = content_agent

    # ------------------------------------------------------------------
    # Public API
    # ------------------------------------------------------------------

    def build_site(
        self,
        site_description: str,
        pages: list[dict],
        media_map: dict[str, dict],
        status: str = "draft",
        language: str = "en",
    ) -> dict[str, dict]:
        """
        Create all pages in WordPress.

        *pages*      – list of page definitions from ContentAgent.plan_site_structure
        *media_map*  – dict mapping page_slug → WP media object (may be empty)
        *status*     – 'draft' or 'publish'

        Returns a dict mapping page_slug → created WP page object.
        """
        created: dict[str, dict] = {}  # slug → WP page object

        # Two-pass approach: first top-level pages, then children
        top_level = [p for p in pages if not p.get("parent_slug")]
        children = [p for p in pages if p.get("parent_slug")]

        for page_def in top_level + children:
            wp_page = self._create_single_page(
                site_description=site_description,
                page_def=page_def,
                created=created,
                media_map=media_map,
                status=status,
                language=language,
            )
            created[page_def["slug"]] = wp_page

        return created

    # ------------------------------------------------------------------
    # Internal helpers
    # ------------------------------------------------------------------

    def _create_single_page(
        self,
        site_description: str,
        page_def: dict,
        created: dict[str, dict],
        media_map: dict[str, dict],
        status: str,
        language: str,
    ) -> dict:
        slug = page_def["slug"]
        title = page_def["title"]
        description = page_def.get("description", "")

        # Generate content via LLM
        content_data = self._content.generate_page_content(
            site_description=site_description,
            page_title=title,
            page_description=description,
            language=language,
        )

        # Build Gutenberg block content
        gutenberg_content = self._content.generate_gutenberg_blocks(
            heading=content_data["heading"],
            subheading=content_data["subheading"],
            body_html=content_data["body_html"],
        )

        # Resolve parent page id
        parent_slug = page_def.get("parent_slug")
        parent_id = 0
        if parent_slug and parent_slug in created:
            parent_id = created[parent_slug]["id"]

        # Resolve featured image
        featured_media = 0
        if slug in media_map:
            featured_media = media_map[slug].get("id", 0)

        # Create the page via REST API
        wp_page = self._wp.create_page(
            title=title,
            content=gutenberg_content,
            slug=slug,
            status=status,
            parent_id=parent_id,
            featured_media=featured_media,
            meta_description=content_data["meta_description"],
        )
        return wp_page
