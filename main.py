#!/usr/bin/env python3
"""
WordPress AI Agent – CLI entry point.

Usage examples
--------------
# Basic run (creates pages as drafts)
python main.py build "GPS vehicle monitoring and fleet management company"

# Publish pages immediately, use Polish content
python main.py build "Firma monitoringu GPS pojazdów" --status publish --language pl

# Skip image generation (faster, no DALL-E cost)
python main.py build "My site" --no-images

# Use a specific theme
python main.py build "My site" --theme astra
"""
from __future__ import annotations

import json
import sys

import click
from rich.console import Console
from rich.json import JSON
from rich.panel import Panel

console = Console()


@click.group()
def cli() -> None:
    """WordPress AI Agent – build complete websites from a single prompt."""


@cli.command()
@click.argument("prompt")
@click.option(
    "--theme",
    default="twentytwentyfour",
    show_default=True,
    help="WordPress theme slug to activate.",
)
@click.option(
    "--status",
    type=click.Choice(["draft", "publish"]),
    default="draft",
    show_default=True,
    help="Status for created pages.",
)
@click.option(
    "--language",
    default="en",
    show_default=True,
    help="Language code for generated content (e.g. en, pl, de).",
)
@click.option(
    "--images/--no-images",
    default=True,
    show_default=True,
    help="Generate hero images with DALL-E.",
)
@click.option(
    "--plugins/--no-plugins",
    default=True,
    show_default=True,
    help="Install recommended plugins.",
)
@click.option(
    "--output",
    type=click.Path(writable=True),
    default=None,
    help="Save JSON summary to a file.",
)
def build(
    prompt: str,
    theme: str,
    status: str,
    language: str,
    images: bool,
    plugins: bool,
    output: str | None,
) -> None:
    """Build a complete WordPress website from PROMPT."""
    # Import here so config validation errors show up cleanly
    try:
        from src.orchestrator import Orchestrator
    except ValueError as exc:
        console.print(f"[bold red]Configuration error:[/bold red] {exc}")
        sys.exit(1)

    console.print(
        Panel(
            f"[bold cyan]WordPress AI Agent[/bold cyan]\n\n"
            f"Prompt  : {prompt}\n"
            f"Theme   : {theme}\n"
            f"Status  : {status}\n"
            f"Language: {language}\n"
            f"Images  : {images}\n"
            f"Plugins : {plugins}",
            title="Build Configuration",
        )
    )

    orchestrator = Orchestrator()
    try:
        summary = orchestrator.build_site(
            prompt=prompt,
            theme=theme,
            status=status,
            language=language,
            install_plugins=plugins,
            generate_images=images,
        )
    except Exception as exc:
        console.print_exception()
        console.print(f"[bold red]Build failed:[/bold red] {exc}")
        sys.exit(1)

    # Print summary
    console.print("\n[bold green]✓ Site build complete![/bold green]")
    console.print(JSON(json.dumps(summary, ensure_ascii=False, indent=2)))

    if output:
        with open(output, "w", encoding="utf-8") as fh:
            json.dump(summary, fh, ensure_ascii=False, indent=2)
        console.print(f"\nSummary saved to [cyan]{output}[/cyan]")


@cli.command()
def check() -> None:
    """Check connectivity to WordPress and validate configuration."""
    try:
        from src.config import config
        config.validate()
    except ValueError as exc:
        console.print(f"[bold red]Configuration error:[/bold red] {exc}")
        sys.exit(1)

    from src.wordpress_client import WordPressClient
    wp = WordPressClient()
    try:
        settings = wp.get_site_settings()
        console.print("[bold green]✓ WordPress connection OK[/bold green]")
        console.print(f"  Site title : {settings.get('title', '(unknown)')}")
        console.print(f"  Site URL   : {settings.get('url', '(unknown)')}")
    except Exception as exc:
        console.print(f"[bold red]✗ WordPress connection failed:[/bold red] {exc}")
        sys.exit(1)


if __name__ == "__main__":
    cli()
