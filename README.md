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
- Custom post types for games, scores, coaches, announcements, sponsors, gallery items, and tryout registrations.
- Custom taxonomies for teams, seasons, gallery categories, and sponsor tiers.
- ACF local field groups for admin-friendly content management.
- TeamSnap settings and helper integration for public links and API-ready event fetching.
- Tryout registration form with nonce protection, honeypot spam trap, private admin storage, admin notification, and parent confirmation email.
- Gallery filtering, media lightbox, lazy-loaded images, and responsive grids.
- Sports organization and sports event schema support.

## Required Plugins

- Advanced Custom Fields Pro or Advanced Custom Fields.
- WP Mail SMTP or a transactional email provider for reliable tryout notifications.
- SEO plugin such as Yoast SEO, Rank Math, or The SEO Framework.
- Caching/performance plugin such as WP Rocket, LiteSpeed Cache, or W3 Total Cache.
- Image optimization plugin such as ShortPixel, Imagify, or EWWW Image Optimizer.

## Recommended Setup

1. Upload the official F.F.C. logo in **Appearance > Customize > Site Identity**.
2. Create pages for Home, About, Tryouts, Contact, and any team overview content.
3. Assign the Tryouts page to the **Tryout Registration** page template.
4. Set homepage display in **Settings > Reading**.
5. Create the primary menu with Home, About, Teams, Schedule, Scores, Gallery, Tryouts, Coaches, Sponsors, and Contact.
6. Add TeamSnap, Instagram, Facebook, YouTube, and TikTok URLs in **F.F.C. Settings**.
7. Add games, scores, announcements, coaches, sponsors, and gallery items from the WordPress admin.
8. Visit **Settings > Permalinks** and save once after activation to flush rewrite rules.

## TeamSnap Integration

The theme supports two integration paths:

- Public TeamSnap links through **F.F.C. Settings**.
- API-ready event fetching through `ffc_get_teamsnap_events()` using a TeamSnap API key and team ID.

TeamSnap API responses are cached for 15 minutes with WordPress transients. If TeamSnap account permissions or endpoint availability change, replace the endpoint in `inc/teamsnap.php` with the approved TeamSnap feed endpoint for the academy account.

## Tryout Registrations

Registrations are stored as private `Tryout Registrations` posts. The form collects:

- Player name, date of birth, age group, position, experience.
- Parent/guardian contact details.
- Emergency contact and medical notes.
- Preferred tryout date and comments.

For production, configure SMTP before opening registration publicly.

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
