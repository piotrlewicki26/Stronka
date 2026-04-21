"""
Content Generation Agent

Uses the OpenAI Chat API to generate page copy, headings, meta descriptions,
and Gutenberg block HTML for each page of the website.
"""
from __future__ import annotations

import json
import re
from typing import Any

from openai import OpenAI

from src.config import config


class ContentAgent:
    """Generates textual content for WordPress pages using an LLM."""

    def __init__(self) -> None:
        self._client = OpenAI(api_key=config.OPENAI_API_KEY)
        self._model = config.OPENAI_MODEL

    # ------------------------------------------------------------------
    # Public API
    # ------------------------------------------------------------------

    def plan_site_structure(self, prompt: str) -> list[dict]:
        """
        Given a high-level prompt, return a list of page definitions.

        Each definition is a dict with keys:
            title, slug, description, is_homepage (bool), parent_slug (str|None)
        """
        system = (
            "You are a professional web architect. "
            "Given a description of a website, return a JSON array of page definitions. "
            "Each element must have these keys: "
            '"title" (string), "slug" (string, URL-safe), '
            '"description" (one-sentence purpose of the page), '
            '"is_homepage" (boolean, true for exactly one page), '
            '"parent_slug" (string slug of parent page, or null for top-level pages). '
            "Return ONLY the JSON array, no markdown fences, no extra text."
        )
        response = self._chat(system, prompt)
        pages = self._parse_json(response)
        if not isinstance(pages, list):
            raise ValueError(f"Expected a JSON array of pages, got: {response}")
        return pages

    def generate_page_content(
        self,
        site_description: str,
        page_title: str,
        page_description: str,
        language: str = "en",
    ) -> dict[str, str]:
        """
        Generate full page content for a single page.

        Returns a dict with keys:
            heading, subheading, body_html, meta_description, image_prompt
        """
        system = (
            "You are an expert copywriter and web content creator. "
            "Generate content for a single WordPress page. "
            "Return a JSON object with these keys: "
            '"heading" (H1 text), '
            '"subheading" (H2 intro text), '
            '"body_html" (full page body as valid Gutenberg-compatible HTML, '
            "use <h2>, <h3>, <p>, <ul>/<li> tags, min 300 words), "
            '"meta_description" (SEO meta description, max 160 chars), '
            '"image_prompt" (DALL-E prompt for a hero image for this page, max 200 chars). '
            f"Write all content in {language}. "
            "Return ONLY the JSON object, no markdown fences."
        )
        user = (
            f"Website: {site_description}\n"
            f"Page title: {page_title}\n"
            f"Page purpose: {page_description}"
        )
        response = self._chat(system, user)
        content = self._parse_json(response)
        required = {"heading", "subheading", "body_html", "meta_description", "image_prompt"}
        missing = required - set(content.keys())
        if missing:
            raise ValueError(f"LLM response missing keys: {missing}")
        return content

    def generate_gutenberg_blocks(self, heading: str, subheading: str, body_html: str) -> str:
        """
        Wrap generated content in Gutenberg block comments for clean WP output.
        """
        blocks = (
            f'<!-- wp:heading {{"level":1}} -->\n'
            f"<h1>{heading}</h1>\n"
            f"<!-- /wp:heading -->\n\n"
            f'<!-- wp:heading {{"level":2}} -->\n'
            f"<h2>{subheading}</h2>\n"
            f"<!-- /wp:heading -->\n\n"
            f"<!-- wp:html -->\n"
            f"{body_html}\n"
            f"<!-- /wp:html -->"
        )
        return blocks

    def generate_image_prompts_for_site(
        self, site_description: str, pages: list[dict]
    ) -> dict[str, str]:
        """Return a mapping of page slug → DALL-E image prompt."""
        system = (
            "You are a visual content director. "
            "For each page of a website, provide a detailed DALL-E image generation prompt "
            "that would produce a professional hero/banner image. "
            "Return a JSON object mapping page slug to image prompt string. "
            "Each prompt must be under 200 characters. "
            "Return ONLY the JSON object."
        )
        page_list = "\n".join(
            f"- slug={p['slug']}, title={p['title']}, purpose={p.get('description', '')}"
            for p in pages
        )
        user = f"Website: {site_description}\n\nPages:\n{page_list}"
        response = self._chat(system, user)
        return self._parse_json(response)

    # ------------------------------------------------------------------
    # Internal helpers
    # ------------------------------------------------------------------

    def _chat(self, system: str, user: str) -> str:
        resp = self._client.chat.completions.create(
            model=self._model,
            messages=[
                {"role": "system", "content": system},
                {"role": "user", "content": user},
            ],
            temperature=0.7,
        )
        return resp.choices[0].message.content.strip()

    @staticmethod
    def _parse_json(text: str) -> Any:
        # Strip optional markdown fences
        cleaned = re.sub(r"^```(?:json)?\s*", "", text.strip())
        cleaned = re.sub(r"\s*```$", "", cleaned)
        return json.loads(cleaned)
