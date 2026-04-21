"""
Graphics & Visual Agent

Generates images via the OpenAI DALL-E API and uploads them to the
WordPress Media Library.
"""
from __future__ import annotations

import time
from typing import TYPE_CHECKING, Literal, get_args

import requests
from openai import OpenAI

from src.config import config

if TYPE_CHECKING:
    from src.wordpress_client import WordPressClient

# Valid DALL-E 3 size values accepted by the OpenAI API
_VALID_SIZES = {"1024x1024", "1792x1024", "1024x1792"}
ImageSize = Literal["1024x1024", "1792x1024", "1024x1792"]


class MediaAgent:
    """Generates images with DALL-E and manages the WordPress Media Library."""

    def __init__(self, wp: "WordPressClient") -> None:
        self._wp = wp
        self._client = OpenAI(api_key=config.OPENAI_API_KEY)
        self._image_model = config.IMAGE_MODEL
        raw_size = config.IMAGE_SIZE
        if raw_size not in _VALID_SIZES:
            raise ValueError(
                f"IMAGE_SIZE '{raw_size}' is not valid for DALL-E. "
                f"Accepted values: {sorted(_VALID_SIZES)}"
            )
        self._image_size: ImageSize = raw_size  # type: ignore[assignment]

    # ------------------------------------------------------------------
    # Public API
    # ------------------------------------------------------------------

    def generate_and_upload(
        self,
        prompt: str,
        filename: str,
        alt_text: str = "",
        caption: str = "",
    ) -> dict:
        """
        Generate an image from *prompt* using DALL-E and upload it to WordPress.

        Returns the WordPress media object (dict) including the 'id' and
        'source_url' fields.
        """
        image_bytes = self._generate_image(prompt)
        return self._wp.upload_media(
            image_bytes=image_bytes,
            filename=filename,
            alt_text=alt_text or prompt[:100],
            caption=caption,
        )

    def generate_site_images(
        self,
        image_prompts: dict[str, str],
    ) -> dict[str, dict]:
        """
        Generate and upload images for multiple pages.

        *image_prompts* maps page_slug → DALL-E prompt string.

        Returns a dict mapping page_slug → WordPress media object.
        """
        results: dict[str, dict] = {}
        for slug, prompt in image_prompts.items():
            filename = f"{slug}-hero.png"
            media = self.generate_and_upload(
                prompt=prompt,
                filename=filename,
                alt_text=f"Hero image for {slug} page",
            )
            results[slug] = media
            # Small delay to stay within DALL-E rate limits
            time.sleep(1)
        return results

    # ------------------------------------------------------------------
    # Internal helpers
    # ------------------------------------------------------------------

    def _generate_image(self, prompt: str) -> bytes:
        """Call DALL-E and return raw PNG bytes."""
        response = self._client.images.generate(
            model=self._image_model,
            prompt=prompt,
            n=1,
            size=self._image_size,
            response_format="url",
        )
        image_url = response.data[0].url
        img_response = requests.get(image_url, timeout=config.REQUEST_TIMEOUT)
        img_response.raise_for_status()
        return img_response.content
