"""
Configuration module – loads settings from environment variables / .env file.
"""
import os
from dotenv import load_dotenv

load_dotenv()


class Config:
    # WordPress
    WP_URL: str = os.getenv("WP_URL", "")
    WP_USERNAME: str = os.getenv("WP_USERNAME", "")
    WP_APP_PASSWORD: str = os.getenv("WP_APP_PASSWORD", "")

    # OpenAI
    OPENAI_API_KEY: str = os.getenv("OPENAI_API_KEY", "")
    OPENAI_MODEL: str = os.getenv("OPENAI_MODEL", "gpt-4o")
    IMAGE_MODEL: str = os.getenv("IMAGE_MODEL", "dall-e-3")
    IMAGE_SIZE: str = os.getenv("IMAGE_SIZE", "1024x1024")

    # HTTP / retry settings
    MAX_RETRIES: int = int(os.getenv("MAX_RETRIES", "3"))
    REQUEST_TIMEOUT: int = int(os.getenv("REQUEST_TIMEOUT", "60"))

    def validate(self) -> None:
        """Raise ValueError if required settings are missing."""
        missing = []
        for field in ("WP_URL", "WP_USERNAME", "WP_APP_PASSWORD", "OPENAI_API_KEY"):
            if not getattr(self, field):
                missing.append(field)
        if missing:
            raise ValueError(
                f"Missing required environment variables: {', '.join(missing)}. "
                "Copy .env.example to .env and fill in the values."
            )


config = Config()
