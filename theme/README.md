# Pemu Health Supplements — WordPress WooCommerce Theme

Production-grade, mobile-first WooCommerce theme built for Kenya's TikTok-driven supplement market.

---

## Requirements

| Dependency | Minimum Version |
|---|---|
| WordPress  | 6.4+ |
| WooCommerce| 8.0+ |
| PHP        | 8.1+ |
| Node.js    | 20+  |
| npm        | 10+  |

---

## Installation

### 1. Upload the theme

```bash
# Option A — upload via WP Admin
# Appearance → Themes → Add New → Upload Theme → pemu-theme.zip

# Option B — FTP / SSH
cp -r pemu-theme/ /path/to/wordpress/wp-content/themes/
```

### 2. Activate

```
WordPress Admin → Appearance → Themes → Pemu Health Supplements → Activate
```

### 3. Build assets

```bash
cd wp-content/themes/pemu-theme
npm install
npm run build
```

### 4. Configure via Customizer

```
WordPress Admin → Appearance → Customize → 🌿 Pemu Theme Settings
```

| Setting | Where | Notes |
|---|---|---|
| WhatsApp Number | Contact & Social | Format: `254712345678` (no +, no spaces) |
| Social URLs | Contact & Social | TikTok, Instagram, Facebook |
| Announcement bar | Announcement Bar | Text + optional link |
| Hero content | Homepage Hero | Headline, CTA labels, image |
| Homepage sections | Homepage Sections | Toggle visibility of each section |
| Free delivery threshold | Contact & Social | Default: 2000 (KES) |

---

## Development Workflow

```bash
# Start Vite dev server with HMR
npm run dev

# Production build (purged CSS, minified JS, content hash filenames)
npm run build

# Watch mode (rebuild on file save, no HMR — useful for PHP-only edits)
npm run watch
```

### Dev server setup

The Vite dev server proxies to your local WordPress install. Update `vite.config.js` proxy target:

```js
proxy: {
  '/wp-json':  'http://your-local-wp.local',
  '/wp-admin': 'http://your-local-wp.local',
},
```

Then in `functions.php` (dev mode only), enqueue Vite HMR client:

```php
// Temporary: only for local dev
if ( defined('WP_DEBUG') && WP_DEBUG ) {
  add_action('wp_head', fn() => print '<script type="module" src="http://localhost:5173/@vite/client"></script>');
}
```

---

## Theme Architecture

```
pemu-theme/
├── inc/               PHP modules (loaded in functions.php)
│   ├── helpers.php    SVG icons, utility functions
│   ├── setup.php      Theme supports, nav menus, image sizes
│   ├── enqueue.php    Conditional asset loading
│   ├── woocommerce.php All WC hooks and filters
│   ├── seo.php        JSON-LD, Open Graph, Twitter Card
│   ├── whatsapp.php   WhatsApp URL builder + message formatters
│   └── customizer.php Customizer panels and settings
│
├── template-parts/
│   ├── components/    Reusable partials (product card, FAB, badges)
│   └── sections/      Homepage sections (hero, categories, etc.)
│
├── woocommerce/       WC template overrides (layout only — hooks preserved)
│   ├── archive-product.php
│   ├── single-product.php
│   ├── content-product.php
│   ├── cart/mini-cart.php
│   ├── checkout/form-checkout.php
│   ├── checkout/thankyou.php
│   ├── myaccount/
│   ├── loop/
│   ├── notices/
│   └── global/
│
├── assets/
│   ├── css/main.css   Compiled Tailwind (git-ignored output)
│   ├── js/            Source JS files + vendor/alpine.min.js
│   └── images/        Logo, OG image, fallback product image
│
└── src/
    └── css/main.css   Tailwind source (input for Vite)
```

---

## WooCommerce Template Override Policy

**The Golden Rule:** Override templates for **styling only**. Never remove WC action hooks.

```php
// ✅ Safe — keeps all hooks, only changes markup/classes
do_action( 'woocommerce_checkout_billing' );

// ❌ NEVER remove hooks — breaks payment gateways and plugins
// do_action( 'woocommerce_checkout_billing' );  ← deleted
```

### Checking for outdated overrides

After any WooCommerce update:
1. Go to **WooCommerce → Status → System Status**
2. Scroll to **Theme Overrides**
3. Any outdated templates are listed with version numbers
4. Re-copy from `wp-content/plugins/woocommerce/templates/` and re-apply styling

---

## Dark / Light / System Mode

The theme implements full tri-state theming:

| Mode | Behaviour |
|---|---|
| `light` | Forces light mode regardless of OS |
| `dark` | Forces dark mode regardless of OS |
| `system` | Follows OS preference via `prefers-color-scheme` |

**Implementation:**
- `assets/js/theme-toggle.js` — inlined in `<head>` before first paint (prevents FOUC)
- `localStorage['pemu-theme']` — persists preference
- Alpine.js `x-data="{ theme: ... }"` components in header trigger `window.pemuSetTheme(mode)`
- CSS custom properties in `src/css/main.css` for `:root` and `html.dark`

---

## WhatsApp Integration

WhatsApp deep-links appear in 5 locations:

| Location | Trigger | Message |
|---|---|---|
| Product page | Button below ATC | Product name + price + URL |
| Product card (hover) | WhatsApp icon | Product name + URL |
| Cart page | Above checkout button | Full cart summary + total |
| Thank you page | After order details | Order number tracking request |
| Floating FAB | Always visible | General inquiry |

Update the number: **Customize → Pemu → Contact & Social → WhatsApp Number**

Format: `254712345678` (country code + number, no `+`, no spaces)

---

## SEO & Open Graph

The theme outputs:
- `Product` JSON-LD on single product pages
- `Organization` + `WebSite` JSON-LD on all other pages
- `BreadcrumbList` JSON-LD on inner pages
- Full Open Graph tags (critical for TikTok/Facebook link previews)
- Twitter Card tags
- `product:price:amount` and `product:availability` meta

**Test with:**
- [Google Rich Results Test](https://search.google.com/test/rich-results)
- [Facebook Sharing Debugger](https://developers.facebook.com/tools/debug/)
- [TikTok Creator Portal link preview](https://ads.tiktok.com/help/article/landing-page-url-testing)

---

## Performance

Target: **≥ 95 Lighthouse mobile, 100 desktop**

| Optimisation | Implementation |
|---|---|
| Zero FOUC | `theme-toggle.js` inlined in `<head>` before any CSS |
| Tailwind purge | Vite + `@tailwindcss/vite` scans all PHP/JS |
| WC CSS removed | `add_filter('woocommerce_enqueue_styles', '__return_empty_array')` |
| Conditional JS | WC scripts only on WC pages, gallery only on product pages |
| Image WebP | `.htaccess` rewrite rule (see below) + Imagify plugin |
| Preload | Critical CSS, hero image (front page), product image (product page) |
| DNS prefetch | Google Fonts, WhatsApp |
| LCP | `fetchpriority="high"` on hero/product main images |

**Add to `.htaccess`** (after `# BEGIN WordPress`):

```apache
# Serve WebP if browser supports it and .webp file exists
<IfModule mod_rewrite.c>
  RewriteEngine On
  RewriteCond %{HTTP_ACCEPT} image/webp
  RewriteCond %{REQUEST_URI} \.(jpe?g|png)$
  RewriteCond %{DOCUMENT_ROOT}%{REQUEST_URI}.webp -f
  RewriteRule ^ %{REQUEST_URI}.webp [T=image/webp,L]
</IfModule>

<IfModule mod_expires.c>
  ExpiresActive On
  ExpiresByType image/webp        "access plus 1 year"
  ExpiresByType image/jpeg        "access plus 1 year"
  ExpiresByType image/png         "access plus 1 year"
  ExpiresByType text/css          "access plus 1 month"
  ExpiresByType application/javascript "access plus 1 month"
  ExpiresByType font/woff2        "access plus 1 year"
</IfModule>

<IfModule mod_deflate.c>
  AddOutputFilterByType DEFLATE text/html text/css application/javascript application/json font/woff2
</IfModule>
```

---

## Recommended Plugins

| Plugin | Purpose |
|---|---|
| **WooCommerce Pesapal** or **WooCommerce Lipisha** | M-Pesa STK push payments |
| **Yoast SEO** or **Rank Math** | XML sitemap, SEO meta (our `inc/seo.php` complements, not replaces) |
| **Imagify** or **ShortPixel** | WebP image conversion + optimisation |
| **WooCommerce Cash on Delivery** | Built-in, enable for COD option |

---

## Assets to Add After Setup

Place these files before going live:

| File | Size | Notes |
|---|---|---|
| `assets/images/logo.svg` | — | Hexagonal Pemu logo |
| `assets/images/logo-dark.svg` | — | White/reversed version |
| `assets/images/og-default.jpg` | 1200×630 | OG fallback image |
| `assets/images/fallback-product.webp` | 600×600 | Product image placeholder |
| `assets/js/vendor/alpine.min.js` | ~43KB | Alpine.js 3.x minified |

---

## Git Setup

Add to `.gitignore`:

```
/node_modules/
/assets/css/*.css
!/src/css/main.css
/assets/js/**/*.js.map
/assets/.vite/
```

Commit the compiled `assets/css/main.css` and vendor JS if deploying without a build step on the server.

---

*Pemu Health Supplements Theme v1.0.0 — © 2026 Pemu Health Supplements*
