"""
Theme & Design Agent

Handles theme selection and basic customization via the WordPress REST API
and the WP Customizer settings endpoint.
"""
from __future__ import annotations

import subprocess
from typing import TYPE_CHECKING

from src.config import config

if TYPE_CHECKING:
    from src.wordpress_client import WordPressClient


class ThemeAgent:
    """
    Applies and configures WordPress themes.

    Theme *installation* requires WP-CLI access (SSH / subprocess).
    Theme *activation* and basic *customization* use the REST API where
    the WP Customize endpoint is available; otherwise WP-CLI is used as
    fallback.
    """

    def __init__(self, wp: "WordPressClient") -> None:
        self._wp = wp

    # ------------------------------------------------------------------
    # Public API
    # ------------------------------------------------------------------

    def apply_theme(
        self,
        theme_slug: str,
        site_title: str = "",
        site_tagline: str = "",
        install_if_missing: bool = True,
    ) -> dict:
        """
        Activate *theme_slug* on the WordPress site.

        If WP-CLI is available and *install_if_missing* is True, the theme
        will be installed from the WordPress.org repository first.

        Returns a result dict with keys 'theme', 'installed', 'activated'.
        """
        result = {"theme": theme_slug, "installed": False, "activated": False}

        if install_if_missing and self._wpcli_available():
            install_ok = self._wpcli_install_theme(theme_slug)
            result["installed"] = install_ok

        activated = self._wpcli_activate_theme(theme_slug)
        result["activated"] = activated

        # Update site title / tagline via REST API settings
        settings: dict = {}
        if site_title:
            settings["title"] = site_title
        if site_tagline:
            settings["description"] = site_tagline
        if settings:
            try:
                self._wp.update_site_settings(settings)
            except Exception:
                pass  # Non-fatal – settings endpoint may require extra auth

        return result

    def set_homepage(self, page_id: int) -> bool:
        """
        Configure WordPress to display a static front page.

        Requires the wp-json/wp/v2/settings endpoint to accept
        'show_on_front' and 'page_on_front' keys, which is standard
        since WP 4.7 with the necessary capabilities.
        """
        try:
            self._wp.update_site_settings(
                {"show_on_front": "page", "page_on_front": page_id}
            )
            return True
        except Exception:
            # Fall back to WP-CLI
            if self._wpcli_available():
                self._run_wpcli(
                    ["option", "update", "show_on_front", "page"],
                    ["option", "update", "page_on_front", str(page_id)],
                )
                return True
            return False

    # ------------------------------------------------------------------
    # WP-CLI helpers
    # ------------------------------------------------------------------

    @staticmethod
    def _wpcli_available() -> bool:
        try:
            subprocess.run(
                ["wp", "--info"],
                check=True,
                capture_output=True,
                timeout=10,
            )
            return True
        except (FileNotFoundError, subprocess.CalledProcessError, subprocess.TimeoutExpired):
            return False

    @staticmethod
    def _wpcli_install_theme(theme_slug: str) -> bool:
        try:
            result = subprocess.run(
                ["wp", "theme", "install", theme_slug, "--activate", "--allow-root"],
                capture_output=True,
                timeout=120,
            )
            return result.returncode == 0
        except Exception:
            return False

    @staticmethod
    def _wpcli_activate_theme(theme_slug: str) -> bool:
        try:
            result = subprocess.run(
                ["wp", "theme", "activate", theme_slug, "--allow-root"],
                capture_output=True,
                timeout=30,
            )
            return result.returncode == 0
        except Exception:
            return False

    @staticmethod
    def _run_wpcli(*commands: list[str]) -> None:
        for cmd in commands:
            subprocess.run(["wp"] + cmd + ["--allow-root"], capture_output=True, timeout=30)
