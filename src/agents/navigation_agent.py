"""
Navigation / Menu Agent

Builds WordPress navigation menus that reflect the created page hierarchy.
"""
from __future__ import annotations

import subprocess
from typing import TYPE_CHECKING

if TYPE_CHECKING:
    from src.wordpress_client import WordPressClient


class NavigationAgent:
    """Creates and populates WordPress navigation menus."""

    def __init__(self, wp: "WordPressClient") -> None:
        self._wp = wp
        self._wpcli_ok = self._check_wpcli()

    # ------------------------------------------------------------------
    # Public API
    # ------------------------------------------------------------------

    def build_main_menu(
        self,
        pages: list[dict],
        created_pages: dict[str, dict],
        menu_name: str = "Main Menu",
        location: str = "primary",
    ) -> dict:
        """
        Create a navigation menu and add all top-level pages to it.

        *pages*         – list of page definitions (from ContentAgent)
        *created_pages* – slug → WP page object map (from PageBuilderAgent)
        *menu_name*     – display name of the menu
        *location*      – theme location to assign the menu to

        Returns a result dict with keys: menu_name, items_added, method.
        """
        result = {"menu_name": menu_name, "items_added": 0, "method": "none"}

        if self._wpcli_ok:
            return self._build_via_wpcli(pages, created_pages, menu_name, location, result)
        return self._build_via_rest(pages, created_pages, menu_name, result)

    # ------------------------------------------------------------------
    # WP-CLI path  (preferred – works on any WP installation)
    # ------------------------------------------------------------------

    def _build_via_wpcli(
        self,
        pages: list[dict],
        created_pages: dict[str, dict],
        menu_name: str,
        location: str,
        result: dict,
    ) -> dict:
        # Create the menu
        create_proc = subprocess.run(
            ["wp", "menu", "create", menu_name, "--allow-root"],
            capture_output=True,
            timeout=30,
        )
        if create_proc.returncode != 0:
            result["method"] = "wpcli-failed"
            return result

        # Get menu ID from output (WP-CLI prints "Success: Created menu X.")
        menu_id_str = create_proc.stdout.decode(errors="replace").strip().split()[-1].rstrip(".")
        try:
            menu_id = int(menu_id_str)
        except ValueError:
            result["method"] = "wpcli-failed"
            return result

        # Assign to theme location
        subprocess.run(
            ["wp", "menu", "location", "assign", str(menu_id), location, "--allow-root"],
            capture_output=True,
            timeout=30,
        )

        # Add page items (top-level first, then children)
        order = 1
        parent_item_ids: dict[str, int] = {}

        top_level = [p for p in pages if not p.get("parent_slug")]
        children = [p for p in pages if p.get("parent_slug")]

        for page_def in top_level + children:
            slug = page_def["slug"]
            if slug not in created_pages:
                continue
            page_id = created_pages[slug]["id"]

            cmd = [
                "wp", "menu", "item", "add-post",
                str(menu_id), str(page_id),
                f"--title={page_def['title']}",
                f"--position={order}",
                "--allow-root",
            ]
            parent_slug = page_def.get("parent_slug")
            if parent_slug and parent_slug in parent_item_ids:
                cmd.append(f"--parent-id={parent_item_ids[parent_slug]}")

            proc = subprocess.run(cmd, capture_output=True, timeout=30)
            if proc.returncode == 0:
                result["items_added"] += 1
                order += 1
                # Store menu item id for child pages
                item_id_str = proc.stdout.decode(errors="replace").strip().split()[-1].rstrip(".")
                try:
                    parent_item_ids[slug] = int(item_id_str)
                except ValueError:
                    pass

        result["method"] = "wpcli"
        return result

    # ------------------------------------------------------------------
    # REST API path  (requires WP REST API Menu Routes plugin)
    # ------------------------------------------------------------------

    def _build_via_rest(
        self,
        pages: list[dict],
        created_pages: dict[str, dict],
        menu_name: str,
        result: dict,
    ) -> dict:
        # Check if menus endpoint is available
        menus = self._wp.list_menus()
        if menus is None:
            result["method"] = "rest-unavailable"
            return result

        # Try to find existing menu or skip creation (REST menu creation
        # requires the WP REST API Menu Routes plugin or WP 5.9+ full FSE)
        result["method"] = "rest-skipped"
        return result

    # ------------------------------------------------------------------
    # Helper
    # ------------------------------------------------------------------

    @staticmethod
    def _check_wpcli() -> bool:
        try:
            subprocess.run(["wp", "--info"], check=True, capture_output=True, timeout=10)
            return True
        except (FileNotFoundError, subprocess.CalledProcessError, subprocess.TimeoutExpired):
            return False
