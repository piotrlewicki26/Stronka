# FleetMonitor Pro – WordPress Website

A **professional WordPress website** for vehicle monitoring and fleet management, featuring:

- 🚗 **GPS Fleet Tracking** — Custom Post Types for Vehicles and Fleets with full GPS metadata
- 🛒 **WooCommerce Store** — Professional e-commerce shop for GPS hardware (trackers, OBD devices, dashcams, accessories)
- 📊 **REST API** — `/fleetmonitor/v1/` endpoints for real-time vehicle position updates
- 🎨 **Custom Theme** — `FleetMonitor Pro` – fully responsive, professional design with hero map animation, pricing tables, testimonials, and blog
- 🔌 **Core Plugin** — `FleetMonitor Core` – all business logic, demo content, and WooCommerce integration

---

## Repository Structure

```
wp-content/
├── themes/
│   └── fleetmonitor/               ← FleetMonitor Pro theme
│       ├── style.css               ← Theme header + full CSS (~2900 lines)
│       ├── functions.php           ← Theme setup, WooCommerce hooks, helpers
│       ├── header.php              ← Sticky transparent → scrolled header with mobile menu
│       ├── footer.php              ← Footer with 4-column layout, social links, payments
│       ├── front-page.php          ← Homepage: Hero, Features, Products, Pricing, Testimonials, Blog, CTA
│       ├── index.php               ← Blog archive fallback
│       ├── single.php              ← Single blog post
│       ├── page.php                ← Generic page template
│       ├── page-contact.php        ← Contact page template (Template Name: Contact Page)
│       ├── 404.php                 ← 404 error page
│       ├── sidebar.php             ← Blog sidebar
│       ├── inc/
│       │   └── class-walker-nav-menu.php  ← Custom nav walker with dropdown support
│       ├── template-parts/
│       │   └── content/
│       │       └── content-post.php  ← Blog card partial
│       ├── woocommerce/
│       │   ├── archive-product.php  ← Shop page with sidebar filters
│       │   └── single-product.php   ← Product detail page
│       └── assets/
│           ├── css/
│           │   └── editor-style.css
│           └── js/
│               └── main.js         ← Preloader, sticky header, mobile menu, pricing toggle,
│                                      counter animation, contact AJAX, scroll-to-top
│
└── plugins/
    └── fleetmonitor-core/          ← FleetMonitor Core plugin
        ├── fleetmonitor-core.php   ← Plugin main file
        ├── includes/
        │   ├── class-vehicles.php  ← CPT registration (fm_vehicle, fm_fleet, fm_testimonial)
        │   ├── class-woocommerce.php  ← WooCommerce integration + sample products
        │   ├── class-rest-api.php  ← REST API endpoints (fleetmonitor/v1)
        │   └── class-demo-content.php ← Demo installer (vehicles, testimonials, blog posts)
        ├── admin/
        │   └── class-admin.php     ← Admin dashboard, settings, API key manager
        └── assets/
            └── css/
                └── admin.css
```

---

## Quick Start

### 1. WordPress Installation

This repository contains only the theme and plugin. You need a standard WordPress installation.

**Requirements:**
- PHP 8.0+
- WordPress 6.0+
- MySQL 5.7+ or MariaDB 10.4+

```bash
# Using WP-CLI (recommended):
wp core download
wp config create --dbname=fleetmonitor --dbuser=root --dbpass=password
wp core install \
  --url="http://localhost" \
  --title="FleetMonitor Pro" \
  --admin_user="admin" \
  --admin_password="yourpassword" \
  --admin_email="admin@fleetmonitor.pro"
```

### 2. Copy Theme & Plugin

```bash
# Copy theme
cp -r wp-content/themes/fleetmonitor /path/to/wordpress/wp-content/themes/

# Copy plugin
cp -r wp-content/plugins/fleetmonitor-core /path/to/wordpress/wp-content/plugins/
```

### 3. Install WooCommerce

WooCommerce is required for the store functionality:

```bash
wp plugin install woocommerce --activate
```

Or install via **WordPress Admin → Plugins → Add New → WooCommerce**.

### 4. Activate Theme & Plugin

```bash
wp theme activate fleetmonitor
wp plugin activate fleetmonitor-core
```

Or via **WordPress Admin → Appearance → Themes** and **Plugins**.

### 5. Install Demo Content

Navigate to **WordPress Admin → FleetMonitor → Demo Content** and click **"Install Demo Content"**.

This will create:
- 6 WooCommerce GPS/fleet products with categories
- 5 sample vehicles with GPS metadata
- 3 customer testimonials
- 3 blog posts about fleet management

### 6. Create Pages

Create these pages in **WordPress Admin → Pages → Add New**:

| Title | Template | Slug |
|-------|----------|------|
| Home | (default) | `/` |
| Shop | (WooCommerce auto-creates) | `/shop/` |
| Contact | **Contact Page** | `/contact/` |
| About Us | (default) | `/about/` |
| Blog | (default) | `/blog/` |
| Pricing | (default) | `/pricing/` |
| Privacy Policy | (default) | `/privacy-policy/` |
| Terms of Service | (default) | `/terms-of-service/` |

### 7. Set Homepage

Go to **WordPress Admin → Settings → Reading** and set:
- **Your homepage displays:** A static page
- **Homepage:** Home
- **Posts page:** Blog

### 8. Configure Navigation Menus

Go to **WordPress Admin → Appearance → Menus** and create:

**Primary Menu** (for the header) – assign to "Primary Navigation":
- Home
- Services (dropdown: GPS Tracking, Fleet Analytics, Driver Monitoring, Route Optimisation)
- Shop
- Pricing
- Blog
- Contact

**Footer menus** for Products, Company, and Support columns.

### 9. Customise via Customizer

Go to **WordPress Admin → Appearance → Customize** to configure:

- **Site Identity** – Logo, site name, tagline
- **Hero Section** – Headline, description, button text & URL
- **Company Information** – Phone, email, address
- **Social Media Links** – Facebook, Twitter, LinkedIn, YouTube, Instagram
- **Stats Section** – 4 customisable stat values and labels

---

## WooCommerce Store Setup

### Payment Gateways

Install and configure your preferred payment gateways:

```bash
# Stripe (recommended)
wp plugin install woocommerce-gateway-stripe --activate

# PayPal
wp plugin install woocommerce-paypal-payments --activate
```

### Shipping

Go to **WooCommerce → Settings → Shipping** to configure zones and rates.

### Currency

Go to **WooCommerce → Settings → General** to set your currency (default: EUR).

### Product Categories

The plugin automatically creates these categories on first activation:
- GPS Trackers
- OBD Devices
- Dashcams
- Fleet Software
- Accessories

---

## REST API

The FleetMonitor Core plugin exposes a REST API at `/wp-json/fleetmonitor/v1/`:

### Authentication

Include in request header:
```
X-FleetMonitor-Key: your_api_key_here
```

Generate API keys at **WordPress Admin → FleetMonitor → API Keys**.

### Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| `GET` | `/fleetmonitor/v1/dashboard` | Fleet summary statistics |
| `GET` | `/fleetmonitor/v1/vehicles` | List all vehicles |
| `GET` | `/fleetmonitor/v1/vehicles/{id}` | Get single vehicle |
| `POST` | `/fleetmonitor/v1/vehicles/{id}/position` | Update GPS position (from device) |
| `GET` | `/fleetmonitor/v1/stats` | Platform statistics |

### Example: Update Vehicle Position

```bash
curl -X POST https://yoursite.com/wp-json/fleetmonitor/v1/vehicles/42/position \
  -H "X-Device-Key: device_secret_key" \
  -H "Content-Type: application/json" \
  -d '{
    "lat": 50.0647,
    "lng": 19.9450,
    "speed": 78.5,
    "heading": 215,
    "ts": "2024-01-15T10:30:00Z"
  }'
```

### Example: Get Dashboard

```bash
curl https://yoursite.com/wp-json/fleetmonitor/v1/dashboard \
  -H "X-FleetMonitor-Key: your_api_key"
```

Response:
```json
{
  "total_vehicles": 28,
  "active": 19,
  "idle": 6,
  "offline": 3,
  "alerts": 1,
  "timestamp": "2024-01-15T10:30:00+00:00"
}
```

---

## Google Maps Integration

To enable the live map on the contact page and vehicle detail pages:

1. Obtain a Google Maps API key from [Google Cloud Console](https://console.cloud.google.com/)
2. Enable **Maps JavaScript API** and **Geocoding API**
3. Enter the key at **WordPress Admin → FleetMonitor → Settings → Google Maps API Key**

---

## Vehicle Management

### Adding Vehicles

1. Go to **WordPress Admin → Vehicles → Add New Vehicle**
2. Enter the vehicle title (e.g. "Mercedes Sprinter 314 – KR 12345A")
3. Fill in the **Vehicle Details** meta box:
   - Registration plate, make, model, year, VIN
   - Fuel type, current mileage
   - Assigned driver name
   - GPS Device ID, SIM/IMEI
   - Last known coordinates (lat/lng)
   - Insurance and next service dates
4. Assign **Vehicle Type** taxonomy (Car, Van, Truck, etc.)
5. Publish

### Vehicle Types Taxonomy

Default terms created on activation:
- Truck, Van, Car, Motorcycle, Bus, Trailer, Construction

---

## Theme Customisation

### Colours

Edit CSS custom properties in `style.css` at the `:root` block:

```css
:root {
  --color-primary:  #0a1f3d;  /* Dark navy – main brand colour */
  --color-accent:   #0e7afe;  /* Blue – buttons, links, highlights */
  --color-success:  #28a745;  /* Green */
  --color-warning:  #f76b1c;  /* Orange */
}
```

### Homepage Sections

The homepage (`front-page.php`) renders these sections in order:
1. **Hero** – animated map, stats counter, CTA buttons
2. **Trusted By** – logo strip
3. **Features** – 6-card grid (customisable in `front-page.php`)
4. **Stats** – 4 animated counters (configurable via Customizer)
5. **Products** – WooCommerce featured products (or placeholders)
6. **Pricing** – 3-plan pricing table with billing toggle
7. **Testimonials** – pulls from `fm_testimonial` CPT, or static fallback
8. **Latest Blog Posts** – conditional, only shows if posts exist
9. **CTA** – full-width call-to-action banner

---

## Recommended Plugins

| Plugin | Purpose |
|--------|---------|
| WooCommerce | E-commerce store (required) |
| Yoast SEO | SEO optimisation |
| WooCommerce Stripe Gateway | Credit card payments |
| WooCommerce PayPal Payments | PayPal payments |
| Smush / ShortPixel | Image optimisation |
| WP Super Cache / W3 Total Cache | Caching |
| WP Mail SMTP | Email deliverability |
| Cookie Notice | GDPR cookie consent |
| WPML or Polylang | Multilingual support |

---

## Performance Tips

1. **Caching** – Install W3 Total Cache or WP Super Cache
2. **Images** – Use WebP format; install Smush for compression
3. **Fonts** – The theme uses Google Fonts (Inter). For production, host locally using [GWWF](https://gwwf.io/)
4. **CDN** – Use Cloudflare or AWS CloudFront for static assets
5. **Database** – Schedule weekly WP-Cron for database optimisation

---

## License

This theme and plugin are released under the **GNU General Public License v2 or later**.

- Theme: `wp-content/themes/fleetmonitor/`
- Plugin: `wp-content/plugins/fleetmonitor-core/`

WooCommerce is a separate product by Automattic, licensed under GPL v3.

---

## Support

- Documentation: `INSTALLATION.md` (this file)
- REST API: `GET /wp-json/fleetmonitor/v1/` for full schema
- Admin panel: **WordPress Admin → FleetMonitor**
