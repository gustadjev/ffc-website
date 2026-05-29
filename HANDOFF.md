# F.F.C. Production Handoff Checklist

This checklist is for the final handoff of the F.F.C. Academy WordPress theme to a site owner, content admin, or launch partner.

## Admin Editing Guide

- **Global settings:** `Settings > F.F.C. Settings`.
- **Logo and site identity:** `Appearance > Customize > Site Identity`.
- **Header and footer menus:** `Appearance > Menus`.
- **Homepage slider:** edit the Home page, then update `F.F.C. Homepage Slider`.
- **Homepage sections:** edit the Home page, then update `F.F.C. Homepage Sections`.
- **About page:** edit the About page, then update `F.F.C. About Page Content`.
- **Contact page:** edit the Contact page, then update `F.F.C. Contact Page Content`.
- **Contact form:** add a form plugin shortcode in `Contact Form Shortcode`, or use the built-in fallback contact form.
- **Tryout page:** edit the Tryouts page, then update `F.F.C. Tryout Page Content`.
- **Tryout form labels/placeholders/email copy:** `Settings > F.F.C. Settings`.
- **Games and schedule:** `Games`, plus Teams and Seasons taxonomies.
- **Scores and results:** `Scores`, plus Teams and Seasons taxonomies.
- **Coaches:** `Coaches`.
- **Announcements:** `Announcements`.
- **Sponsors:** `Sponsors`, plus Sponsor Tiers.
- **Gallery:** `Gallery Items`, plus Gallery Categories.
- **Submitted tryout registrations:** `Tryout Registrations`.

The theme-managed pages and structured content types use the classic WordPress editor on purpose. This keeps custom fields visible and predictable for non-technical admins.

## Gutenberg And Style Book

F.F.C. Academy is a hybrid theme:

- PHP templates control the custom academy pages, archives, footer, forms, schedules, scores, and TeamSnap areas.
- `theme.json` controls Gutenberg block colors, typography, spacing presets, button styling, and Style Book previews.
- The Style Book is useful for reviewing the F.F.C. block design system, not for editing the custom homepage/footer/page templates.
- Editors can use the F.F.C. block styles and patterns in regular posts or flexible page content.

## Global Settings Source Of Truth

Global theme settings are native WordPress options saved under `Settings > F.F.C. Settings`.

ACF is used for structured content fields on pages, posts, and taxonomies. ACF option pages are not used by this theme, so ACF Pro is optional.

## TeamSnap Setup

- Add the public TeamSnap team URL.
- Add TeamSnap schedule, roster, registration, and app/login URLs if available.
- Paste a TeamSnap iframe/widget embed code when TeamSnap provides one.
- Add event-specific TeamSnap links on individual Games when needed.

This build is configured for TeamSnap embeds and links, not API credentials.

## Required Before Launch

- Confirm WordPress core, PHP, and plugins are updated.
- Install and activate Advanced Custom Fields.
- Install and configure WP Mail SMTP or an equivalent transactional mail plugin.
- Install an SEO plugin and set page titles/descriptions.
- Install a caching/performance plugin.
- Install an image optimization plugin.
- Set the production domain in WordPress `Settings > General`.
- Save `Settings > Permalinks` once after activating the theme.
- Upload the official logo and favicon.
- Assign Home as the static front page.
- Confirm the primary and footer menus are assigned.
- Replace placeholder copy, phone numbers, addresses, images, and sponsor examples.
- Add real social media URLs.
- Add real TeamSnap URLs or embed code.
- Submit a test tryout registration and confirm admin and parent emails are received.
- Review all public pages on mobile, tablet, desktop, and large desktop.

## QA Checklist

- Homepage slider images, arrows, links, and text are editable and working.
- Footer logo size, footer copy, social links, and copyright text render correctly.
- About, Contact, and Tryout pages render designed layouts and expose editable fields in admin.
- Games archive shows upcoming schedule content.
- Scores archive shows results and filters.
- Coaches archive shows profiles.
- Sponsors archive shows tiers and sponsor CTAs.
- Gallery archive shows images/videos and lightbox behavior.
- Tryout form validates required fields and stores private registrations.
- Admin can add and edit Games, Scores, Coaches, Announcements, Sponsors, Gallery Items, and Tryout Registrations.
- Teams, Seasons, Sponsor Tiers, and Gallery Categories can be added and edited.
- Navigation links point to intended pages.
- Page source includes schema where expected.
- No public PHP warnings, fatal errors, or visible debug output.

## Security And Operations

- Disable public debug display in production.
- Use least-privilege accounts for coaches and content editors.
- Keep admin accounts protected by strong passwords and two-factor authentication where possible.
- Keep WordPress core, plugins, and theme code updated.
- Configure backups before launch.
- Use HTTPS in production.
- Add CAPTCHA or another anti-spam layer if tryout form spam increases.

## Known Content Tasks

The theme is ready to support production content, but the final site owner still needs to provide real academy assets:

- Final homepage and about page images.
- Current schedules, scores, teams, and seasons.
- Coach headshots and biographies.
- Sponsor logos, tiers, and website URLs.
- Gallery photos and highlight videos.
- Final phone, email, address, and social media URLs.
