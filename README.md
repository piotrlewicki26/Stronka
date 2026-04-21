# Stronka – WordPress AI Agent

> Strona na WordPress o tematyce monitoringu pojazdów GPS i zarządzaniu flotą  
> A Python-based AI agent that builds a complete WordPress website from a single prompt.

---

## Features

| Capability | Description |
|---|---|
| **Content Generation** | LLM-generated page copy, headings, meta descriptions (OpenAI GPT-4o) |
| **Image Generation** | Hero images created with DALL-E 3 and uploaded to the Media Library |
| **Page Builder** | Creates hierarchical pages (parent/child) via the WP REST API |
| **Theme Management** | Activates a theme and sets the static front page |
| **Plugin Installation** | Installs recommended plugins via WP-CLI (Yoast SEO, Contact Form 7, etc.) |
| **Navigation** | Builds a primary menu reflecting the created page structure |
| **Multi-language** | Pass `--language pl` (or any language code) for localised content |

---

## Architecture

```
main.py  (CLI)
└── src/orchestrator.py          ← coordinates all agents
    ├── src/wordpress_client.py  ← WordPress REST API wrapper
    ├── src/agents/
    │   ├── content_agent.py     ← GPT-4o: site structure + page copy
    │   ├── media_agent.py       ← DALL-E 3: image generation & upload
    │   ├── page_builder_agent.py← creates pages in WordPress
    │   ├── theme_agent.py       ← activates theme, sets homepage
    │   ├── plugin_agent.py      ← installs plugins via WP-CLI
    │   └── navigation_agent.py  ← builds navigation menus
    └── src/config.py            ← env-var configuration
```

---

## Quick Start

### 1. Install dependencies

```bash
pip install -r requirements.txt
```

### 2. Configure environment

```bash
cp .env.example .env
# Edit .env with your WordPress URL, credentials, and OpenAI API key
```

Required variables in `.env`:

| Variable | Description |
|---|---|
| `WP_URL` | Full URL of your WordPress site (e.g. `https://example.com`) |
| `WP_USERNAME` | WordPress admin username |
| `WP_APP_PASSWORD` | WordPress Application Password (Settings → Users → Application Passwords) |
| `OPENAI_API_KEY` | OpenAI API key |

### 3. Check connectivity

```bash
python main.py check
```

### 4. Build a website

```bash
# Create a GPS fleet management site (pages as drafts)
python main.py build "GPS vehicle monitoring and fleet management company website"

# Polish content, publish immediately
python main.py build "Firma monitoringu GPS pojazdów i zarządzania flotą" \
    --language pl --status publish

# Skip image generation (faster, no DALL-E cost)
python main.py build "My company site" --no-images

# Use a specific theme, save summary to file
python main.py build "My company site" --theme astra --output summary.json
```

### CLI Options

| Option | Default | Description |
|---|---|---|
| `--theme SLUG` | `twentytwentyfour` | WordPress theme slug |
| `--status` | `draft` | `draft` or `publish` |
| `--language CODE` | `en` | Content language (e.g. `pl`, `de`, `fr`) |
| `--images/--no-images` | enabled | Generate hero images with DALL-E |
| `--plugins/--no-plugins` | enabled | Install recommended plugins |
| `--output PATH` | — | Save JSON build summary to file |

---

## Default Plugins Installed

- **Yoast SEO** – on-page SEO management  
- **Contact Form 7** – flexible contact forms  
- **W3 Total Cache** – performance caching  
- **Wordfence** – firewall and malware scanner  
- **WP REST API Menu Routes** – exposes menus via REST API  

Plugin installation requires WP-CLI to be available on the server.

---

## Notes

- **WP-CLI** is required for theme/plugin installation and menu building.  
  Without it, pages and media are still created via the REST API.
- Pages are created as **drafts** by default — review before publishing.
- DALL-E 3 image generation incurs OpenAI API costs (~$0.04/image).
- The agent needs **admin-level** WordPress credentials.
