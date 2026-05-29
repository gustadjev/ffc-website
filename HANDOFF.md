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
- **Tryout page, form labels/placeholders/email copy, and no-session copy:** edit the Tryouts page, then update `F.F.C. Tryout Page Content`.
- **Tryout availability:** add at least one published, future, open `Tryout Session` before opening registration.
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

## Tryout Session Workflow

- Create Tryout Sessions before sending families to the registration page.
- A session appears on the public form only when it is published, has a future session date/time, has registration status `Open`, is inside the optional registration window, and is not over capacity.
- Leave `Registration Closes At` blank to use the session date/time as the cutoff.
- The public form uses a required session dropdown instead of a free preferred date field.
- If no valid sessions exist, the submit action is hidden and the Tryouts page shows the editable no-sessions message.
- The server rejects submissions if the selected session is missing, unpublished, closed, not yet open, past, full, or beyond the registration close time.
- Submitted registrations store both the selected session ID and a readable session label.

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
- Add at least one open future Tryout Session before public tryout launch.
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
- Tryout form is hidden/closed when no open future Tryout Session exists.
- Tryout form shows only open future sessions that still have capacity.
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
