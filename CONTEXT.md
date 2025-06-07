# Ai Marketing Academy Plugin - Codebase Context

Below is a high‑level guided tour of the “jp” codebase (the Ai Marketing Academy WordPress plugin), covering its purpose, how it’s wired together, and where the main pieces live.

## 1. Plugin entry point & metadata

All of the orchestration begins in the main plugin file, `jp.php`, which declares the plugin header and wires in everything else (autoload, utility functions, REST routes, page templates, admin screens, etc.):

```php
/**
 * Plugin Name:  Ai Marketing Academy
 * Version:      1.2.2
 **/
define('JP_PLUGIN_ROOT_DIR_PATH', plugin_dir_path(__FILE__));
define('JP_PLUGIN_ROOT_DIR_URL', plugin_dir_url(__FILE__));

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/utils.php';
// custom rest endpoint
require_once __DIR__ . '/rest/routes.php';
// …and then action/filter hooks, ACF, pages, admin, etc.
```

## 2. Dependency management & autoloading

### PHP (Composer)

- **composer.json** sets up PSR‑4 autoloading for the `JP\` namespace under `src/` and pulls in Stripe’s PHP SDK:

```jsonc
{
  "name": "joshkennedy/jp",
  "autoload": {
    "psr-4": { "JP\\": "src/" }
  },
  "require": {
    "stripe/stripe-php": "^17.1"
  }
}
```

After running `composer install`, the `vendor/autoload.php` loader is available in `jp.php`.

### JavaScript / TypeScript (package.json + Webpack)

- The plugin also ships front‑end assets built with WordPress Scripts and TypeScript.

```jsonc
{
  "name": "jp",
  "module": "index.ts",
  "scripts": {
    "dev": "wp-scripts start --webpack-src-dir=assets/src --output-path=assets/build --webpack-copy-php",
    "build": "wp-scripts build --webpack-src-dir=assets/src --output-path=assets/build --webpack-copy-php"
  },
  "devDependencies": {
    "@wordpress/scripts": "^30.12.0",
    "ts-loader": "^9.5.2"
  },
  "dependencies": {
    "embla-carousel": "^8.5.2",
    "js-cookie": "^3.0.5"
  }
}
```

- **webpack.config.js** extends the default WP Scripts config to add multiple entrypoints (profile, registration form, icon‑card nav, etc.):

```js
const defaults = require("@wordpress/scripts/config/webpack.config.js");
module.exports = {
  ...defaults,
  entry: {
    ...defaults.entry(),
    profile: { import: "./assets/src/profile.ts" },
    "aim-template": { import: "./assets/src/aim-template.ts" },
    "icon-card-nav": { import: "./assets/src/icon-card-nav.ts" },
    "registration-form": { import: "./assets/src/registration-form.ts" }
  },
  module: {
    ...defaults.module,
    rules: [
      ...defaults.module.rules,
      {
        test: /\.tsx?$/,
        use: [{ loader: "ts-loader", options: { configFile: "tsconfig.json", transpileOnly: true } }]
      }
    ]
  },
  resolve: { extensions: [".ts", ".tsx", ...(defaults.resolve?.extensions || [".js", ".jsx"]) ] }
};
```

## 3. Project README & Bun cron‑job

Most of the code is PHP, but there’s a tiny Bun/TypeScript stub (`index.ts`) and instructions for scheduling via cron‑job.org in `README.md`:

```md
# jp

To install dependencies:

```bash
bun install
```

To run:

```bash
bun run index.ts
```

This project was created using `bun init` and uses the cron-job.org Console.

…example curl to test endpoints…
```

The actual `index.ts` currently just logs a hello:

```ts
console.log("Hello via Bun!");
```

## 4. Folder structure at a glance

```
.
├── acf/                      # ACF local field definitions
├── admin/                    # WP‑admin settings & custom columns
├── assets/                   # Images, CSS, SVGs & built JS/CSS
│   └── src/                  # TS entrypoints (profile.ts, etc.)
├── pages/                    # Page‑specific enqueues & shortcodes
├── rest/                     # Custom WP‑REST API endpoints
├── src/                      # PHP classes (namespace JP\…)
├── templates/                # Custom archive/single template overrides
├── utils.php                 # Helper functions (asset URLs, etc.)
├── jp.php                    # Main plugin bootstrap
├── composer.json
├── package.json
└── webpack.config.js
```

## 5. Custom REST API endpoints (`rest/`)

The plugin exposes a small set of endpoints under `/wp-json/jp/v1/` via `rest/routes.php`:

```php
require_once __DIR__ . '/userbyemail.php';
require_once __DIR__ . '/customers.php';
require_once __DIR__ . '/sync-customers.php';
require_once __DIR__ . '/sync-tools.php';
```

- `userbyemail.php`: look up WP users by email (for LearnDash group info)
- `customers.php`: paginated list of subscriber users
- `sync-customers.php`: syncs Stripe subscriptions → LearnDash groups
- `sync-tools.php`: syncs an external “AiM tools” feed (titles, icons, categories) into a custom post type

## 6. ACF field groups & custom post type/taxonomy (`acf/`)

All ACF groups are registered in `acf/index.php` (no JSON import/export). This includes:

- Tool settings (URL & icon) for the custom post type “aim-tool”
- Lesson category options (color, singular label)
- Session options (date, “coming soon” flag)
- Registration of the custom taxonomy `aim-tool-category` and the CPT `aim-tool`

## 7. Admin settings & custom columns (`admin/`)

### jp-settings.php

Register Vimeo & Stripe API keys on the “General” Settings page:

```php
register_setting('general', 'jp_vimeo_api_key');
register_setting('general', 'jp_stripe_api_key');
add_settings_section(...);
add_settings_field(...); // Vimeo token input
add_settings_field(...); // Stripe token input
```

### lesson-admin-columns.php

Adds a custom “Program” column in the LearnDash Lessons admin list:

```php
use JP\CustomAdminColumn;
use \LearnDash\Core\Models\Lesson;

$lessonTypeColumn = new class extends CustomAdminColumn { ... };
$lessonTypeColumn->register();
```

## 8. Front‑end page hooks & shortcodes (`pages/`)

These files enqueue scripts/styles on specific URLs and register shortcodes:

- `pages/profile.php`: enqueues the profile bundle on `/profile`, registers `[aim_profile_lololes]` and `[aim_walkthrough_banner]`
- `pages/lesson-category.php`: intercepts the lesson‑category archive via `template_include`, enforces group‑based login protection on lessons
- `pages/registration-form.php`: enqueues the registration form bundle on URLs containing “registration`

## 9. Theme template overrides (`templates/`)

Custom archive template for lesson categories lives in `templates/lesson-cat-archive.php`. It leverages JP\IconCardNav, JP\ResourceCard, JP\JPTemplate, JP\LessonCategoryService, etc., to render a bespoke archive page.

## 10. Core PHP classes (namespace `JP\…`, `src/`)

Key classes:

| File                         | Responsibility                                                 |
|------------------------------|----------------------------------------------------------------|
| `JPTemplate.php`             | Template loader for archives/single                            |
| `SyncLogger.php`             | Logger for sync operations                                     |
| `StripeClient.php`           | Wraps Stripe client setup using WP option                      |
| `OpenGraph.php`              | OpenGraph parser fork for fetching external icons              |
| `VimeoUtils.php`             | Helpers for extracting Vimeo embed/thumbnail URLs               |
| `LessonService.php`          | Returns thumbnail URLs via featured image, Vimeo, or fallback  |
| `LessonCategoryService.php`  | Term metadata helpers and filtering sessions vs resources      |
| `IconCardNav.php`            | Carousel of icon cards using an accessor interface             |
| `ResourceCard.php`           | Renders a single “resource” card                               |
| `WalkthroughBanner.php`      | Shortcode/banner for a “take a tour” Vimeo pop‑up               |
| `Lolole.php`                 | Renders the List‑of‑List‑of‑Lessons component                   |
| `CustomAdminColumn.php`      | Base class for adding custom WP admin columns                  |

## 11. Utilities (`utils.php`)

A grab‑bag of helper functions:

- Asset URL/path resolution (`getAimAssetUrl()`, `getAimAssetPath()`, `enqueueAsset()`)
- URL checkers (`getCurrentURL()`, `is_url()`)
- Stripe ↔ LearnDash group mapping (`isPaidGroup()`, `stripeProductGroupMap()`)
- Simple `array_find()` for callbacks

## 12. Summary of responsibilities

- **Server‑side** classes (`src/`) are autoloaded via Composer (PSR‑4)
- **ACF** defines custom fields, tool CPT, and taxonomy (`acf/`)
- **REST endpoints** enable sync and lookup operations (`rest/`)
- **Admin** extensions handle settings pages and custom columns (`admin/`)
- **Front‑end** assets are built with WP Scripts/TypeScript and enqueued via page hooks (`pages/`)
- **Templates** override WP layouts for lesson categories (`templates/`)
- **Utilities** provide shared helper functions (`utils.php`)
- **README.md** and `index.ts` sketch out a Bun‑based cron job scaffold

Keep this file up to date as a quick reference for the plugin’s structure and design.