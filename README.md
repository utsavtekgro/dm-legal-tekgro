# DM Legal — WordPress Starter Theme

A lean, security-hardened, performance-first classic theme for law firms and
professional-services sites. It ships a complete, standards-compliant
foundation to build on — not a page builder, not a bundle of plugins.

- **WordPress:** 6.4+ · **PHP:** 8.1+
- **Standards:** WordPress Coding Standards (WPCS), PSR-12-aligned docblocks
- **Accessibility:** WCAG 2.1 AA baseline (skip link, focus-visible, ARIA, reduced-motion)
- **Performance:** system-font stack (zero font requests), inlined critical CSS,
  deferred JS, no jQuery on the front end, emoji/Migrate trimming

## Installation

1. Copy the `dm-legal` folder into `wp-content/themes/`.
2. In **Appearance → Themes**, activate **DM Legal**.
3. Set a logo, menus (Primary, Footer), and the phone / consultation URL under
   **Appearance → Customize → Firm Contact**.

## Architecture

```
dm-legal/
├── style.css                 Theme header only (CSS lives in /assets)
├── functions.php             Constants + ordered module loader (no feature logic)
├── theme.json                Design tokens + block-editor settings
├── inc/
│   ├── setup.php             Theme supports, menus, image sizes, i18n, widgets
│   ├── security.php          Headers, disclosure removal, XML-RPC, REST guard
│   ├── enqueue.php           Assets, critical CSS, defer, perf trimming
│   ├── template-tags.php     Escaped output helpers (dates, meta, thumbnails)
│   ├── template-functions.php Body classes, JSON-LD schema, image hardening
│   └── customizer.php        Sanitized Customizer settings + live preview
├── template-parts/           content-*.php partials (list, card, single, page…)
├── assets/
│   ├── css/critical.css      Inlined above-the-fold CSS
│   ├── css/main.css          Full BEM stylesheet
│   └── js/navigation.js      Accessible, dependency-free menu toggle
└── header/footer/index/…     Standard template hierarchy
```

`functions.php` never contains feature logic — it only loads focused modules,
so each concern is independently auditable and testable.

## Security posture

Applied at the theme layer as defence-in-depth (each is filterable):

- Version/generator disclosure removed; core `?ver=` scrubbed from asset URLs.
- XML-RPC disabled (`dm_legal_enable_xmlrpc` to re-enable).
- REST `/wp/v2/users` blocked for anonymous callers (stops username enumeration).
- Safe security headers on front-end responses (`X-Content-Type-Options`,
  `Referrer-Policy`, `X-Frame-Options`, `Permissions-Policy`, COOP).
- Every dynamic value is escaped at output (`esc_html`, `esc_attr`, `esc_url`,
  `wp_kses_post`); every Customizer setting declares a `sanitize_callback`.

> A strict Content-Security-Policy is intentionally left to the server/plugin
> layer, where a per-site nonce-based policy can be authored without breakage.

## Performance strategy (path to 100/100)

- **Fonts:** native system serif/sans stacks → no external requests, no CLS.
- **CSS:** critical CSS inlined in `<head>`; full sheet preloaded, non-blocking.
- **JS:** single deferred navigation script; `comment-reply` only when needed.
- **Trimming:** emoji script, jQuery Migrate, RSD/WLW/shortlink head links removed.
- **Images:** responsive `srcset` via core; `loading`/`decoding`/`fetchpriority`
  set per context (LCP image eager+high, others lazy).

To push a real site to 100/100, pair the theme with server-side caching,
Brotli/gzip, HTTP/2+, and image conversion to WebP/AVIF.

## Testing checklist

- **PHP:** `php -l` passes on all files; run `phpcs` against `phpcs.xml.dist`.
- **A11y:** keyboard-only nav, visible focus, axe/Lighthouse a11y = 100.
- **Edge cases:** empty menus, no featured image, password-protected posts,
  no-results search, paginated content (`wp_link_pages`).
- **Perf:** Lighthouse mobile + desktop; confirm no render-blocking resources.
- **Browsers:** current Chrome, Firefox, Safari, Edge; iOS/Android Safari/Chrome.

## Extending

- Child theme: create one and enqueue after the parent for safe overrides.
- Schema: hook `dm_legal_schema` to add `LegalService` fields.
- Colours/type: edit tokens in `theme.json` **and** the mirror in
  `assets/css/critical.css` / `main.css` (kept in sync deliberately).
- Self-hosted fonts: add `@font-face` with `font-display: swap` and `preload`
  the primary weight only.

## License

GNU General Public License v2 or later.
