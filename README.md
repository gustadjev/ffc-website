# F.F.C. Academy WordPress Theme

Custom WordPress theme for F.F.C., a premium youth soccer academy website built for parents, players, coaches, sponsors, and community visitors.

## Theme Location

Installable theme directory:

`ffc-academy/`

Copy this folder into:

`wp-content/themes/ffc-academy`

Then activate **F.F.C. Academy** in WordPress Admin.

## Core Features

- Custom WordPress theme using PHP, CSS, JavaScript, and WordPress template hierarchy.
- Mobile-first sports academy design system derived from the F.F.C. navy and rose-gold identity.
- Custom post types for games, scores, coaches, announcements, sponsors, gallery items, tryout sessions, and tryout registrations.
- Custom taxonomies for teams, seasons, gallery categories, and sponsor tiers.
- ACF local field groups for admin-friendly content management.
- TeamSnap embed and public link support for schedules, roster links, registration links, and app access.
- Tryout registration form with nonce protection, honeypot spam trap, private admin storage, admin notification, and parent confirmation email.
- Gallery filtering, media lightbox, lazy-loaded images, and responsive grids.
- Sports organization and sports event schema support.
- Hybrid theme foundation with `theme.json`, branded Gutenberg palettes, editor styles, block styles, and reusable F.F.C. block patterns.

## Required Plugins

- Advanced Custom Fields, free or Pro, for structured page, post, and taxonomy fields.
- WP Mail SMTP or a transactional email provider for reliable tryout notifications.
- SEO plugin such as Yoast SEO, Rank Math, or The SEO Framework.
- Caching/performance plugin such as WP Rocket, LiteSpeed Cache, or W3 Total Cache.
- Image optimization plugin such as ShortPixel, Imagify, or EWWW Image Optimizer.

ACF Pro options pages are not required. Global theme settings use the native WordPress settings page at **Settings > F.F.C. Settings**.

## Recommended Setup

1. Upload the official F.F.C. logo in **Appearance > Customize > Site Identity**.
2. Create pages for Home, About, Tryouts, Contact, and any team overview content.
3. Assign the Tryouts page to the **Tryout Registration** page template.
4. Set homepage display in **Settings > Reading**.
5. Create the primary menu with Home, About, Teams, Schedule, Scores, Gallery, Tryouts, Coaches, Sponsors, and Contact.
6. Add TeamSnap, Instagram, Facebook, YouTube, and TikTok URLs in **F.F.C. Settings**.
7. Add games, scores, announcements, coaches, sponsors, and gallery items from the WordPress admin.
8. Visit **Settings > Permalinks** and save once after activation to flush rewrite rules.

## Content Editing Map

- Homepage slider: edit the Home page and update **F.F.C. Homepage Slider**.
- Homepage sections: edit the Home page and update **F.F.C. Homepage Sections**.
- About page: edit the About page and update **F.F.C. About Page Content**.
- Contact page: edit the Contact page and update **F.F.C. Contact Page Content**. Add a form plugin shortcode in the Contact Form Shortcode field if using a plugin form, or use the built-in fallback contact form.
- Tryout page, form labels, placeholders, email subjects, and no-session messaging: edit the Tryouts page and update **F.F.C. Tryout Page Content**.
- Footer copy, copyright text, social links, header labels, and TeamSnap links: **Settings > F.F.C. Settings**.
- Games, Scores, Coaches, Announcements, Sponsors, Gallery Items, Tryout Sessions, and Tryout Registrations: use their matching admin menu items.
- Teams, Seasons, Gallery Categories, and Sponsor Tiers: edit under the relevant content type taxonomy screens.

Theme-managed pages and structured content types intentionally use the classic WordPress editor so the custom fields stay visible and reliable for non-technical administrators.

## Gutenberg & Style Book

The theme is a hybrid theme. PHP templates still control the academy platform pages, while `theme.json` gives Gutenberg a branded F.F.C. design system.

- The WordPress Style Book previews block colors, typography, buttons, quotes, tables, and patterns.
- The Style Book does not edit the homepage slider, footer, TeamSnap links, tryout form, schedule cards, score cards, sponsor cards, or gallery templates.
- Reusable F.F.C. block patterns are available for normal posts and flexible page content.
- Global site copy and links remain in **Settings > F.F.C. Settings**.

## TeamSnap Integration

The theme supports TeamSnap through embed code and public links:

- Paste a TeamSnap iframe/widget in **Settings > F.F.C. Settings > TeamSnap Embed Code**.
- Add public TeamSnap URLs for the main team page, schedule, roster, registration, and app/login access.
- Add event-specific TeamSnap links on individual Games.

The current implementation does not require TeamSnap API credentials.

## Tryout Registrations

Before the public tryout form can be submitted, at least one **Tryout Session** must be published, open, scheduled in the future, and under capacity.

Tryout Sessions are managed in **Tryout Sessions** and include:

- Session date/time.
- Optional registration opens at and registration closes at times.
- Location and field.
- Age group.
- Registration status: open, closed, or full.
- Optional capacity.
- Optional TeamSnap event link and notes.

If no open sessions exist, the Tryouts page hides the registration form submit action and shows the editable no-sessions message from the Tryouts page fields. Server-side validation also rejects submissions for missing, closed, not-yet-open, past, full, or registration-closed sessions.

Registrations are stored as private `Tryout Registrations` posts. The form collects:

- Player name, date of birth, age group, position, experience.
- Parent/guardian contact details.
- Emergency contact and medical notes.
- Selected tryout session and comments.

For production, configure SMTP before opening registration publicly.

## Handoff Checklist

See [HANDOFF.md](HANDOFF.md) for the production handoff checklist, admin editing guide, QA checklist, and launch notes.

## Performance Notes

- Use WebP/AVIF uploads where possible.
- Serve the theme through a CDN.
- Enable page caching and browser caching.
- Compress uploaded gallery images.
- Keep embeds lazy-loaded and avoid loading multiple social widgets directly on the homepage.
- Replace the default remote hero image with an optimized local academy image when available.

## Security Notes

- Keep WordPress core, plugins, and PHP updated.
- Use least-privilege admin accounts for coaches and content editors.
- Configure SMTP with authenticated sending.
- Add a CAPTCHA plugin if form spam volume grows.
- Disable XML-RPC if it is not needed.
- Use a WAF or host-level firewall for production.

## Development

The project includes working development tooling for Sass, Stylelint, PHPCS, and WordPress Coding Standards.

### Requirements

- Node.js 18, matching `.nvmrc`.
- The Local PHP binary used by the npm PHP lint script, or update `package.json` if your PHP path changes.

### Install Tooling

```bash
npm install
COMPOSER_HOME="$PWD/.composer-cache" "/Users/elgusto/Library/Application Support/Local/lightning-services/php-8.2.29+0/bin/darwin-arm64/bin/php" composer.phar install
```

If `composer.phar` is not present, install Composer locally first:

```bash
curl -sS https://getcomposer.org/installer -o composer-setup.php
COMPOSER_HOME="$PWD/.composer-cache" "/Users/elgusto/Library/Application Support/Local/lightning-services/php-8.2.29+0/bin/darwin-arm64/bin/php" composer-setup.php --filename=composer.phar
```

### Commands

```bash
npm run build:css
npm run watch:css
npm run lint:css
npm run lint:php
npm run lint
```

`ffc-academy/assets/scss/main.scss` is the Sass source. `npm run build:css` compiles it to `ffc-academy/assets/css/main.css`.

PHPCS is configured in `phpcs.xml.dist` with WordPress Coding Standards and PHPCompatibilityWP. Stylelint is configured in `.stylelintrc.json`.
