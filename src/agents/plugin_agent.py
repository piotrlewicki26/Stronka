"""
Plugin Management Agent

Installs and activates WordPress plugins using WP-CLI.
Falls back gracefully when WP-CLI is not available.
"""
from __future__ import annotations

import subprocess
from dataclasses import dataclass, field
@dataclass
class PluginSpec:
    slug: str
    description: str = ""
    options: dict = field(default_factory=dict)


# Recommended default plugins for most sites
DEFAULT_PLUGINS: list[PluginSpec] = [
    PluginSpec("wordpress-seo", "Yoast SEO – on-page SEO management"),
    PluginSpec("contact-form-7", "Contact Form 7 – flexible contact forms"),
    PluginSpec("w3-total-cache", "W3 Total Cache – performance caching"),
    PluginSpec("wordfence", "Wordfence Security – firewall and malware scanner"),
    PluginSpec("wp-rest-api-menu-routes", "WP REST API Menu Routes – exposes menus via REST"),
]


class PluginAgent:
    """Installs and activates WordPress plugins via WP-CLI."""

    def __init__(self) -> None:
        self._wpcli_ok = self._check_wpcli()

    # ------------------------------------------------------------------
    # Public API
    # ------------------------------------------------------------------

    def install_defaults(self) -> list[dict]:
        """Install and activate the default recommended plugins."""
        return self.install_plugins(DEFAULT_PLUGINS)

    def install_plugins(self, plugins: list[PluginSpec]) -> list[dict]:
        """
        Install and activate each plugin in *plugins*.

        Returns a list of result dicts with keys:
            slug, installed, activated, error
        """
        results = []
        for plugin in plugins:
            result = self._install_and_activate(plugin.slug)
            results.append(result)
        return results

    def install_plugin(self, slug: str) -> dict:
        return self._install_and_activate(slug)

    # ------------------------------------------------------------------
    # Internal helpers
    # ------------------------------------------------------------------

    def _install_and_activate(self, slug: str) -> dict:
        result = {"slug": slug, "installed": False, "activated": False, "error": ""}
        if not self._wpcli_ok:
            result["error"] = "WP-CLI not available"
            return result
        try:
            install = subprocess.run(
                ["wp", "plugin", "install", slug, "--allow-root"],
                capture_output=True,
                timeout=120,
            )
            result["installed"] = install.returncode == 0
            if not result["installed"]:
                result["error"] = install.stderr.decode(errors="replace").strip()
                return result

            activate = subprocess.run(
                ["wp", "plugin", "activate", slug, "--allow-root"],
                capture_output=True,
                timeout=30,
            )
            result["activated"] = activate.returncode == 0
            if not result["activated"]:
                result["error"] = activate.stderr.decode(errors="replace").strip()
        except subprocess.TimeoutExpired:
            result["error"] = "Timed out"
        except Exception as exc:
            result["error"] = str(exc)
        return result

    @staticmethod
    def _check_wpcli() -> bool:
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
