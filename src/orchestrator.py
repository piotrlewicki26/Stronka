"""
Core Orchestrator

Coordinates all sub-agents to build a complete WordPress website from a
single high-level prompt.
"""
from __future__ import annotations

from rich.console import Console
from rich.progress import Progress, SpinnerColumn, TextColumn

from src.agents.content_agent import ContentAgent
from src.agents.media_agent import MediaAgent
from src.agents.navigation_agent import NavigationAgent
from src.agents.page_builder_agent import PageBuilderAgent
from src.agents.plugin_agent import PluginAgent
from src.agents.theme_agent import ThemeAgent
from src.config import config
from src.wordpress_client import WordPressClient

console = Console()


class Orchestrator:
    """
    Main entry point that wires all agents together and executes the
    site-building workflow.
    """

    def __init__(self) -> None:
        config.validate()
        self._wp = WordPressClient()
        self._content = ContentAgent()
        self._media = MediaAgent(self._wp)
        self._page_builder = PageBuilderAgent(self._wp, self._content)
        self._theme = ThemeAgent(self._wp)
        self._plugins = PluginAgent()
        self._navigation = NavigationAgent(self._wp)

    # ------------------------------------------------------------------
    # Public API
    # ------------------------------------------------------------------

    def build_site(
        self,
        prompt: str,
        theme: str = "twentytwentyfour",
        status: str = "draft",
        language: str = "en",
        install_plugins: bool = True,
        generate_images: bool = True,
    ) -> dict:
        """
        Build a complete WordPress website from *prompt*.

        Parameters
        ----------
        prompt          High-level description of the website to create.
        theme           WordPress theme slug to activate.
        status          Page status: 'draft' or 'publish'.
        language        Language code for generated content (e.g. 'en', 'pl').
        install_plugins Whether to install recommended plugins.
        generate_images Whether to generate hero images with DALL-E.

        Returns
        -------
        A summary dict with keys: pages, media, menu, plugins, theme.
        """
        summary: dict = {}

        with Progress(
            SpinnerColumn(),
            TextColumn("[progress.description]{task.description}"),
            console=console,
        ) as progress:

            # ── Step 1: Plan site structure ────────────────────────────
            task = progress.add_task("Planning site structure…", total=None)
            pages = self._content.plan_site_structure(prompt)
            progress.update(task, description=f"[green]✓[/green] Planned {len(pages)} pages")
            progress.stop_task(task)
            console.print(f"  Pages: {[p['slug'] for p in pages]}")

            # ── Step 2: Install plugins ────────────────────────────────
            if install_plugins:
                task = progress.add_task("Installing recommended plugins…", total=None)
                plugin_results = self._plugins.install_defaults()
                installed_count = sum(1 for r in plugin_results if r.get("activated"))
                progress.update(
                    task,
                    description=f"[green]✓[/green] Plugins: {installed_count}/{len(plugin_results)} activated",
                )
                progress.stop_task(task)
                summary["plugins"] = plugin_results
            else:
                summary["plugins"] = []

            # ── Step 3: Apply theme ────────────────────────────────────
            task = progress.add_task(f"Applying theme '{theme}'…", total=None)
            theme_result = self._theme.apply_theme(
                theme_slug=theme,
                site_title=prompt[:60],
            )
            progress.update(
                task,
                description=f"[green]✓[/green] Theme '{theme}' applied",
            )
            progress.stop_task(task)
            summary["theme"] = theme_result

            # ── Step 4: Generate images ────────────────────────────────
            media_map: dict[str, dict] = {}
            if generate_images:
                task = progress.add_task("Generating images with DALL-E…", total=None)
                image_prompts = self._content.generate_image_prompts_for_site(prompt, pages)
                media_map = self._media.generate_site_images(image_prompts)
                progress.update(
                    task,
                    description=f"[green]✓[/green] Generated {len(media_map)} images",
                )
                progress.stop_task(task)
                summary["media"] = {
                    slug: {"id": m.get("id"), "url": m.get("source_url")}
                    for slug, m in media_map.items()
                }
            else:
                summary["media"] = {}

            # ── Step 5: Create pages ───────────────────────────────────
            task = progress.add_task("Creating pages…", total=None)
            created_pages = self._page_builder.build_site(
                site_description=prompt,
                pages=pages,
                media_map=media_map,
                status=status,
                language=language,
            )
            progress.update(
                task,
                description=f"[green]✓[/green] Created {len(created_pages)} pages",
            )
            progress.stop_task(task)
            summary["pages"] = {
                slug: {
                    "id": page["id"],
                    "title": page.get("title", {}).get("rendered", slug),
                    "link": page.get("link", ""),
                    "status": page.get("status", status),
                }
                for slug, page in created_pages.items()
            }

            # ── Step 6: Set homepage ───────────────────────────────────
            homepage = next((p for p in pages if p.get("is_homepage")), None)
            if homepage and homepage["slug"] in created_pages:
                hp_id = created_pages[homepage["slug"]]["id"]
                self._theme.set_homepage(hp_id)
                console.print(f"  Homepage set to page id={hp_id} (slug={homepage['slug']})")

            # ── Step 7: Build navigation ───────────────────────────────
            task = progress.add_task("Building navigation menu…", total=None)
            menu_result = self._navigation.build_main_menu(
                pages=pages,
                created_pages=created_pages,
            )
            progress.update(
                task,
                description=f"[green]✓[/green] Menu '{menu_result['menu_name']}' built "
                f"({menu_result['items_added']} items via {menu_result['method']})",
            )
            progress.stop_task(task)
            summary["menu"] = menu_result

        return summary
