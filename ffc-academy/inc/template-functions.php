<?php
/**
 * Shared template helpers.
 *
 * @package FFCAcademy
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ffc_get_logo_url(): string {
	$custom_logo_id = get_theme_mod( 'custom_logo' );
	$logo           = $custom_logo_id ? wp_get_attachment_image_url( $custom_logo_id, 'full' ) : '';

	return $logo ?: ffc_upload_asset_url( '2025/09/cropped-FFC-Logo.jpg', FFC_THEME_URI . '/assets/images/ffc-logo-placeholder.svg' );
}

function ffc_upload_asset_url( string $relative_path, string $fallback = '' ): string {
	$uploads = wp_get_upload_dir();
	$path    = trailingslashit( $uploads['basedir'] ) . ltrim( $relative_path, '/' );

	if ( file_exists( $path ) ) {
		return trailingslashit( $uploads['baseurl'] ) . ltrim( $relative_path, '/' );
	}

	return $fallback;
}

function ffc_theme_image( string $name = 'hero' ): string {
	$images = array(
		'hero'      => '2023/11/pexels-robo-michalec-9508142-1536x1024.jpg',
		'training'  => '2023/10/pexels-kampus-production-8941650-1536x1024.jpg',
		'match'     => '2023/11/pexels-lucas-andrade-3316948-1170x600.jpg',
		'community' => '2023/10/pexels-gillingham-town-14250916-1170x600.jpg',
		'gallery_1' => '2023/11/pexels-diego-santacruz-12616083-900x550.jpg',
		'gallery_2' => '2023/10/pexels-noelle-otto-906073-900x550.jpg',
		'gallery_3' => '2023/11/pexels-robo-michalec-9695668-900x550.jpg',
		'gallery_4' => '2023/10/pexels-lucas-andrade-3316948-1-1-900x550.jpg',
	);

	return ffc_upload_asset_url( $images[ $name ] ?? $images['hero'], FFC_THEME_URI . '/assets/images/ffc-logo-placeholder.svg' );
}

function ffc_logo_markup( string $class = 'site-logo' ): string {
	if ( has_custom_logo() ) {
		return get_custom_logo();
	}

	return sprintf(
		'<a class="%1$s %1$s--fallback" href="%2$s" aria-label="%3$s"><img src="%4$s" alt="%3$s"></a>',
		esc_attr( $class ),
		esc_url( home_url( '/' ) ),
		esc_attr__( 'F.F.C. Home', 'ffc-academy' ),
		esc_url( ffc_get_logo_url() )
	);
}

function ffc_get_field( string $key, $post_id = null, $default = '' ) {
	if ( function_exists( 'get_field' ) ) {
		$value = get_field( $key, $post_id );
		return null !== $value && false !== $value && '' !== $value ? $value : $default;
	}

	return get_post_meta( $post_id ?: get_the_ID(), $key, true ) ?: $default;
}

function ffc_image_url_from_field( $image, string $size = 'full', string $fallback = '' ): string {
	if ( is_array( $image ) ) {
		if ( ! empty( $image['sizes'][ $size ] ) ) {
			return $image['sizes'][ $size ];
		}
		if ( ! empty( $image['url'] ) ) {
			return $image['url'];
		}
	}

	if ( is_numeric( $image ) ) {
		$url = wp_get_attachment_image_url( (int) $image, $size );
		return $url ?: $fallback;
	}

	return is_string( $image ) && $image ? $image : $fallback;
}

function ffc_option( string $key, $default = '' ) {
	$value = get_option( 'ffc_' . $key, null );

	if ( null === $value || false === $value || '' === $value ) {
		return $default;
	}

	return $value;
}

function ffc_home_page_id(): int {
	$front_id = (int) get_option( 'page_on_front' );
	if ( $front_id ) {
		return $front_id;
	}

	$home_page = get_page_by_path( 'home' );

	return $home_page instanceof WP_Post ? (int) $home_page->ID : 0;
}

function ffc_page_id_by_slug( string $slug ): int {
	$page = get_page_by_path( $slug );

	return $page instanceof WP_Post ? (int) $page->ID : 0;
}

function ffc_tryout_page_id(): int {
	$page_id = ffc_page_id_by_slug( 'tryouts' );
	if ( $page_id ) {
		return $page_id;
	}

	$tryout_url = ffc_option( 'tryout_page_url' );

	return $tryout_url ? (int) url_to_postid( $tryout_url ) : 0;
}

function ffc_brand_name( bool $short = false ): string {
	return $short
		? (string) ffc_option( 'brand_short_name', __( 'F.F.C.', 'ffc-academy' ) )
		: (string) ffc_option( 'brand_full_name', __( 'Freedom Futbol Club', 'ffc-academy' ) );
}

function ffc_footer_copyright_text(): string {
	$note = (string) ffc_option( 'footer_copyright_note', __( 'Powered by TeamSnap-connected club operations.', 'ffc-academy' ) );
	$text = (string) ffc_option( 'footer_copyright_text', __( '@2026 freedomfutbolclub. All rights reserved | Webiste by Bpsquare - Powered by TeamSnap', 'ffc-academy' ) );

	$tokens = array(
		'{copyright}'       => '&copy;',
		'{year}'            => gmdate( 'Y' ),
		'{site_name}'       => get_bloginfo( 'name' ),
		'{brand_name}'      => ffc_brand_name(),
		'{brand_short_name}' => ffc_brand_name( true ),
		'{note}'            => $note,
	);

	return strtr( $text, $tokens );
}

function ffc_global_display_settings(): array {
	return array(
		'brand_short_name'                    => array(
			'label'   => __( 'Brand Short Name', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'F.F.C.', 'ffc-academy' ),
		),
		'brand_full_name'                     => array(
			'label'   => __( 'Brand Full Name', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Freedom Futbol Club', 'ffc-academy' ),
		),
		'default_page_eyebrow'                => array(
			'label'   => __( 'Default Page Eyebrow', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'F.F.C. Academy', 'ffc-academy' ),
		),
		'blog_archive_eyebrow'                => array(
			'label'   => __( 'Blog / Updates Eyebrow', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'F.F.C.', 'ffc-academy' ),
		),
		'blog_empty_message'                  => array(
			'label'   => __( 'Blog Empty Message', 'ffc-academy' ),
			'type'    => 'textarea',
			'default' => __( 'No updates are available yet.', 'ffc-academy' ),
		),
		'search_eyebrow'                      => array(
			'label'   => __( 'Search Page Eyebrow', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Search', 'ffc-academy' ),
		),
		'search_empty_message'                => array(
			'label'   => __( 'Search Empty Message', 'ffc-academy' ),
			'type'    => 'textarea',
			'default' => __( 'No results found.', 'ffc-academy' ),
		),
		'not_found_kicker'                    => array(
			'label'   => __( '404 Kicker', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Offside', 'ffc-academy' ),
		),
		'not_found_title'                     => array(
			'label'   => __( '404 Title', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Page Not Found', 'ffc-academy' ),
		),
		'not_found_button_label'              => array(
			'label'   => __( '404 Button Label', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Return Home', 'ffc-academy' ),
		),
		'archive_game_kicker'                 => array(
			'label'   => __( 'Schedule Archive Kicker', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Match Calendar', 'ffc-academy' ),
		),
		'archive_game_title'                  => array(
			'label'   => __( 'Schedule Archive Title', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Schedule', 'ffc-academy' ),
		),
		'archive_game_empty_message'          => array(
			'label'   => __( 'Schedule Empty Message', 'ffc-academy' ),
			'type'    => 'textarea',
			'default' => __( 'No scheduled games have been added yet.', 'ffc-academy' ),
		),
		'archive_game_embed_kicker'           => array(
			'label'   => __( 'Schedule TeamSnap Embed Kicker', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Live TeamSnap Calendar', 'ffc-academy' ),
		),
		'archive_score_kicker'                => array(
			'label'   => __( 'Scores Archive Kicker', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Results Center', 'ffc-academy' ),
		),
		'archive_score_title'                 => array(
			'label'   => __( 'Scores Archive Title', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Scores & Standings', 'ffc-academy' ),
		),
		'archive_score_empty_message'         => array(
			'label'   => __( 'Scores Empty Message', 'ffc-academy' ),
			'type'    => 'textarea',
			'default' => __( 'Scores and match recaps will appear here.', 'ffc-academy' ),
		),
		'archive_coach_kicker'                => array(
			'label'   => __( 'Coaches Archive Kicker', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Player Development', 'ffc-academy' ),
		),
		'archive_coach_title'                 => array(
			'label'   => __( 'Coaches Archive Title', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Coaching Staff', 'ffc-academy' ),
		),
		'archive_coach_empty_message'         => array(
			'label'   => __( 'Coaches Empty Message', 'ffc-academy' ),
			'type'    => 'textarea',
			'default' => __( 'Coach profiles can be added from the WordPress admin.', 'ffc-academy' ),
		),
		'archive_gallery_kicker'              => array(
			'label'   => __( 'Gallery Archive Kicker', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Visual Storytelling', 'ffc-academy' ),
		),
		'archive_gallery_title'               => array(
			'label'   => __( 'Gallery Archive Title', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Gallery', 'ffc-academy' ),
		),
		'archive_gallery_empty_message'       => array(
			'label'   => __( 'Gallery Empty Message', 'ffc-academy' ),
			'type'    => 'textarea',
			'default' => __( 'Gallery items will appear here.', 'ffc-academy' ),
		),
		'archive_sponsor_kicker'              => array(
			'label'   => __( 'Sponsors Archive Kicker', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Partnerships', 'ffc-academy' ),
		),
		'archive_sponsor_title'               => array(
			'label'   => __( 'Sponsors Archive Title', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Sponsors', 'ffc-academy' ),
		),
		'archive_sponsor_empty_message'       => array(
			'label'   => __( 'Sponsors Empty Message', 'ffc-academy' ),
			'type'    => 'textarea',
			'default' => __( 'Sponsor information can be added from the WordPress admin.', 'ffc-academy' ),
		),
		'archive_announcement_kicker'         => array(
			'label'   => __( 'Announcements Archive Kicker', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Academy Desk', 'ffc-academy' ),
		),
		'archive_announcement_title'          => array(
			'label'   => __( 'Announcements Archive Title', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Announcements', 'ffc-academy' ),
		),
		'archive_announcement_empty_message'  => array(
			'label'   => __( 'Announcements Empty Message', 'ffc-academy' ),
			'type'    => 'textarea',
			'default' => __( 'Announcements will appear here.', 'ffc-academy' ),
		),
		'filter_season_label'                 => array(
			'label'   => __( 'Season Filter Label', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Season', 'ffc-academy' ),
		),
		'filter_team_label'                   => array(
			'label'   => __( 'Team Filter Label', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Team', 'ffc-academy' ),
		),
		'filter_opponent_label'               => array(
			'label'   => __( 'Opponent Filter Label', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Opponent', 'ffc-academy' ),
		),
		'filter_result_label'                 => array(
			'label'   => __( 'Result Filter Label', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Result', 'ffc-academy' ),
		),
		'filter_result_win_label'             => array(
			'label'   => __( 'Result Filter Win Label', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Win', 'ffc-academy' ),
		),
		'filter_result_loss_label'            => array(
			'label'   => __( 'Result Filter Loss Label', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Loss', 'ffc-academy' ),
		),
		'filter_result_draw_label'            => array(
			'label'   => __( 'Result Filter Draw Label', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Draw', 'ffc-academy' ),
		),
		'filter_all_label'                    => array(
			'label'   => __( 'All Filter Label', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'All', 'ffc-academy' ),
		),
		'filter_apply_label'                  => array(
			'label'   => __( 'Apply Filter Button Label', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Apply', 'ffc-academy' ),
		),
		'filter_reset_label'                  => array(
			'label'   => __( 'Reset Filter Button Label', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Reset', 'ffc-academy' ),
		),
		'schedule_list_label'                 => array(
			'label'   => __( 'Schedule List View Label', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'List', 'ffc-academy' ),
		),
		'schedule_calendar_label'             => array(
			'label'   => __( 'Schedule Calendar View Label', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Calendar', 'ffc-academy' ),
		),
		'teamsnap_default_button_label'        => array(
			'label'   => __( 'TeamSnap Default Button Label', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Open TeamSnap', 'ffc-academy' ),
		),
		'teamsnap_calendar_button_label'       => array(
			'label'   => __( 'TeamSnap Calendar Button Label', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'TeamSnap Calendar', 'ffc-academy' ),
		),
		'teamsnap_footer_link_label'           => array(
			'label'   => __( 'Footer TeamSnap Link Label', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'TeamSnap', 'ffc-academy' ),
		),
		'teamsnap_schedule_label'              => array(
			'label'   => __( 'TeamSnap Schedule Card Label', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Schedule', 'ffc-academy' ),
		),
		'teamsnap_schedule_description'        => array(
			'label'   => __( 'TeamSnap Schedule Card Description', 'ffc-academy' ),
			'type'    => 'textarea',
			'default' => __( 'Practices, matches, fields, and calendar updates.', 'ffc-academy' ),
		),
		'teamsnap_roster_label'                => array(
			'label'   => __( 'TeamSnap Roster Card Label', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Roster', 'ffc-academy' ),
		),
		'teamsnap_roster_description'          => array(
			'label'   => __( 'TeamSnap Roster Card Description', 'ffc-academy' ),
			'type'    => 'textarea',
			'default' => __( 'Team contacts, player details, and family communication.', 'ffc-academy' ),
		),
		'teamsnap_registration_label'          => array(
			'label'   => __( 'TeamSnap Registration Card Label', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Registration', 'ffc-academy' ),
		),
		'teamsnap_registration_description'    => array(
			'label'   => __( 'TeamSnap Registration Card Description', 'ffc-academy' ),
			'type'    => 'textarea',
			'default' => __( 'TeamSnap forms, dues, waivers, and season signups.', 'ffc-academy' ),
		),
		'teamsnap_app_label'                   => array(
			'label'   => __( 'TeamSnap App Card Label', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'TeamSnap App', 'ffc-academy' ),
		),
		'teamsnap_app_description'             => array(
			'label'   => __( 'TeamSnap App Card Description', 'ffc-academy' ),
			'type'    => 'textarea',
			'default' => __( 'Open the mobile app or TeamSnap login.', 'ffc-academy' ),
		),
		'teamsnap_empty_message'               => array(
			'label'   => __( 'TeamSnap Empty Message', 'ffc-academy' ),
			'type'    => 'textarea',
			'default' => __( 'Add TeamSnap links in F.F.C. Settings to connect families directly to schedules, rosters, registration, and the TeamSnap app.', 'ffc-academy' ),
		),
		'match_vs_label'                       => array(
			'label'   => __( 'Match Versus Label', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'vs', 'ffc-academy' ),
		),
		'card_teamsnap_label'                  => array(
			'label'   => __( 'Game Card TeamSnap Link Label', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'TeamSnap', 'ffc-academy' ),
		),
		'card_map_label'                       => array(
			'label'   => __( 'Game Card Map Link Label', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Map', 'ffc-academy' ),
		),
		'card_highlights_label'                => array(
			'label'   => __( 'Score Card Highlights Link Label', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Highlights', 'ffc-academy' ),
		),
		'card_contact_coach_label'             => array(
			'label'   => __( 'Coach Card Contact Link Label', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Contact Coach', 'ffc-academy' ),
		),
		'card_visit_sponsor_label'             => array(
			'label'   => __( 'Sponsor Card Default Link Label', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Visit Sponsor', 'ffc-academy' ),
		),
		'card_schedule_details_label'          => array(
			'label'   => __( 'Schedule Details Link Label', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Schedule Details', 'ffc-academy' ),
		),
		'card_recent_result_label'             => array(
			'label'   => __( 'Recent Result Label', 'ffc-academy' ),
			'type'    => 'text',
			'default' => __( 'Recent Result', 'ffc-academy' ),
		),
	);
}

function ffc_button( string $label, string $url, string $variant = 'primary' ): string {
	if ( empty( $label ) || empty( $url ) ) {
		return '';
	}

	return sprintf(
		'<a class="button button--%1$s" href="%2$s">%3$s</a>',
		esc_attr( $variant ),
		esc_url( $url ),
		esc_html( $label )
	);
}

function ffc_page_has_editor_content( int $post_id = 0 ): bool {
	$post_id = $post_id ?: get_the_ID();
	if ( ! $post_id ) {
		return false;
	}

	$content = (string) get_post_field( 'post_content', $post_id );

	return '' !== trim( $content ) || ffc_page_has_elementor_layout( $post_id );
}

function ffc_page_has_elementor_layout( int $post_id = 0 ): bool {
	$post_id = $post_id ?: get_the_ID();
	if ( ! $post_id ) {
		return false;
	}

	$elementor_data = trim( (string) get_post_meta( $post_id, '_elementor_data', true ) );
	if ( '' === $elementor_data || in_array( $elementor_data, array( '[]', '{}', 'null' ), true ) ) {
		return false;
	}

	$decoded = json_decode( $elementor_data, true );
	if ( JSON_ERROR_NONE === json_last_error() ) {
		return is_array( $decoded ) && ! empty( $decoded );
	}

	return true;
}

function ffc_is_builder_page( int $post_id = 0 ): bool {
	$post_id = $post_id ?: get_the_ID();
	if ( ! $post_id ) {
		return false;
	}

	if ( function_exists( 'ffc_is_theme_managed_page' ) && ffc_is_theme_managed_page( $post_id ) ) {
		return false;
	}

	$template            = (string) get_page_template_slug( $post_id );
	$elementor_edit_mode = (string) get_post_meta( $post_id, '_elementor_edit_mode', true );

	return 'templates/page-builder-fullwidth.php' === $template || ( 'builder' === $elementor_edit_mode && ffc_page_has_elementor_layout( $post_id ) );
}

function ffc_should_render_editor_canvas( int $post_id = 0 ): bool {
	return ffc_is_builder_page( $post_id );
}

function ffc_render_builder_page( int $post_id = 0 ): void {
	$post_id = $post_id ?: get_the_ID();
	$page    = $post_id ? get_post( $post_id ) : null;

	if ( ! $page instanceof WP_Post ) {
		return;
	}

	$previous_post   = $GLOBALS['post'] ?? null;
	$GLOBALS['post'] = $page; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
	setup_postdata( $page );
	?>
	<main id="primary" class="site-main builder-page">
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'builder-page__content' ); ?>>
			<?php the_content(); ?>
		</article>
	</main>
	<?php
	wp_reset_postdata();

	if ( $previous_post instanceof WP_Post ) {
		$GLOBALS['post'] = $previous_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
	}
}

function ffc_page_content_section( int $post_id = 0, string $class = 'section page-editor-content' ): void {
	$post_id = $post_id ?: get_the_ID();
	$page    = $post_id ? get_post( $post_id ) : null;

	if ( ! $page instanceof WP_Post || ! ffc_page_has_editor_content( $post_id ) ) {
		return;
	}

	$previous_post   = $GLOBALS['post'] ?? null;
	$GLOBALS['post'] = $page; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
	setup_postdata( $page );
	?>
	<section class="<?php echo esc_attr( $class ); ?>">
		<div class="container content-area">
			<?php the_content(); ?>
		</div>
	</section>
	<?php
	wp_reset_postdata();

	if ( $previous_post instanceof WP_Post ) {
		$GLOBALS['post'] = $previous_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
	}
}

function ffc_post_date_badge( int $post_id = 0 ): string {
	$post_id = $post_id ?: get_the_ID();

	return sprintf(
		'<time class="date-badge" datetime="%1$s"><span>%2$s</span><strong>%3$s</strong></time>',
		esc_attr( get_the_date( 'c', $post_id ) ),
		esc_html( get_the_date( 'M', $post_id ) ),
		esc_html( get_the_date( 'j', $post_id ) )
	);
}

function ffc_result_class( string $result ): string {
	$result = strtolower( trim( $result ) );

	if ( in_array( $result, array( 'win', 'w' ), true ) ) {
		return 'is-win';
	}

	if ( in_array( $result, array( 'loss', 'l' ), true ) ) {
		return 'is-loss';
	}

	if ( in_array( $result, array( 'draw', 'tie', 'd', 't' ), true ) ) {
		return 'is-draw';
	}

	return 'is-pending';
}

function ffc_archive_link_by_slug( string $slug, string $fallback = '#' ): string {
	$page = get_page_by_path( $slug );
	return $page ? get_permalink( $page ) : $fallback;
}

function ffc_default_menu(): void {
	$items = array(
		'Home'     => home_url( '/' ),
		'About'    => ffc_archive_link_by_slug( 'about', '#' ),
		'Schedule' => get_post_type_archive_link( 'ffc_game' ),
		'Scores'   => get_post_type_archive_link( 'ffc_score' ),
		'Tryouts'  => ffc_archive_link_by_slug( 'tryouts', '#' ),
		'Contact'  => ffc_archive_link_by_slug( 'contact', '#' ),
	);

	echo '<ul id="primary-menu" class="menu">';
	foreach ( $items as $label => $url ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( $url ?: '#' ), esc_html( $label ) );
	}
	echo '</ul>';
}

function ffc_tax_filter_select( string $taxonomy, string $name, string $label ): string {
	$terms = get_terms(
		array(
			'taxonomy'   => $taxonomy,
			'hide_empty' => true,
		)
	);
	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		return '';
	}

	$current = isset( $_GET[ $name ] ) ? sanitize_text_field( wp_unslash( $_GET[ $name ] ) ) : '';
	$output  = '<label class="filter-label"><span>' . esc_html( $label ) . '</span><select name="' . esc_attr( $name ) . '">';
	$output .= '<option value="">' . esc_html( ffc_option( 'filter_all_label', __( 'All', 'ffc-academy' ) ) ) . '</option>';

	foreach ( $terms as $term ) {
		$output .= sprintf(
			'<option value="%1$s" %2$s>%3$s</option>',
			esc_attr( $term->slug ),
			selected( $current, $term->slug, false ),
			esc_html( $term->name )
		);
	}

	$output .= '</select></label>';

	return $output;
}

function ffc_social_icon( string $key ): string {
	$icons = array(
		'instagram' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7.8 2h8.4A5.8 5.8 0 0 1 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8A5.8 5.8 0 0 1 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2Zm0 2A3.8 3.8 0 0 0 4 7.8v8.4A3.8 3.8 0 0 0 7.8 20h8.4a3.8 3.8 0 0 0 3.8-3.8V7.8A3.8 3.8 0 0 0 16.2 4H7.8Zm8.7 2.2a1.3 1.3 0 1 1 0 2.6 1.3 1.3 0 0 1 0-2.6ZM12 7.4a4.6 4.6 0 1 1 0 9.2 4.6 4.6 0 0 1 0-9.2Zm0 2a2.6 2.6 0 1 0 0 5.2 2.6 2.6 0 0 0 0-5.2Z"/></svg>',
		'facebook'  => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 8h3V4h-3c-3.1 0-5 1.9-5 5v2H6v4h3v7h4v-7h3.2l.8-4h-4V9c0-.7.3-1 1-1Z"/></svg>',
		'youtube'   => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21.6 7.2a3 3 0 0 0-2.1-2.1C17.6 4.6 12 4.6 12 4.6s-5.6 0-7.5.5a3 3 0 0 0-2.1 2.1A31.2 31.2 0 0 0 2 12a31.2 31.2 0 0 0 .4 4.8 3 3 0 0 0 2.1 2.1c1.9.5 7.5.5 7.5.5s5.6 0 7.5-.5a3 3 0 0 0 2.1-2.1A31.2 31.2 0 0 0 22 12a31.2 31.2 0 0 0-.4-4.8ZM10 15.3V8.7l5.7 3.3L10 15.3Z"/></svg>',
		'tiktok'    => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M16.4 3c.4 2.4 1.8 3.9 4.1 4.1v3.5a7.1 7.1 0 0 1-4-1.2v6.1A5.5 5.5 0 1 1 11 10v3.6a2 2 0 1 0 1.5 1.9V3h3.9Z"/></svg>',
	);

	return $icons[ $key ] ?? '';
}

function ffc_social_links_markup( string $class = 'social-icons', bool $show_placeholders = false ): string {
	$channels = array(
		'instagram' => __( 'Instagram', 'ffc-academy' ),
		'facebook'  => __( 'Facebook', 'ffc-academy' ),
		'youtube'   => __( 'YouTube', 'ffc-academy' ),
		'tiktok'    => __( 'TikTok', 'ffc-academy' ),
	);

	$links = '';
	foreach ( $channels as $key => $label ) {
		$url = ffc_option( $key . '_url' );
		if ( ! $url ) {
			if ( $show_placeholders ) {
				$placeholder_label = sprintf(
					/* translators: %s: social network name. */
					__( 'Add %s URL in F.F.C. Settings', 'ffc-academy' ),
					$label
				);
				$links .= sprintf(
					'<a class="social-icons__placeholder" href="#" aria-disabled="true" aria-label="%1$s" title="%1$s"><span class="screen-reader-text">%2$s</span>%3$s</a>',
					esc_attr( $placeholder_label ),
					esc_html( $placeholder_label ),
					ffc_social_icon( $key )
				);
			}

			continue;
		}

		$links .= sprintf(
			'<a href="%1$s" target="_blank" rel="noopener" aria-label="%2$s"><span class="screen-reader-text">%2$s</span>%3$s</a>',
			esc_url( $url ),
			esc_attr( $label ),
			ffc_social_icon( $key )
		);
	}

	if ( '' === $links ) {
		return '';
	}

	$output  = '<div class="' . esc_attr( $class ) . '">';
	$output .= $links;
	$output .= '</div>';

	return $output;
}

add_action( 'pre_get_posts', 'ffc_apply_archive_filters' );
function ffc_apply_archive_filters( WP_Query $query ): void {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( ! $query->is_post_type_archive( array( 'ffc_game', 'ffc_score' ) ) ) {
		return;
	}

	$tax_query  = array();
	$meta_query = array();

	foreach ( array(
		'ffc_team'   => 'team',
		'ffc_season' => 'season',
	) as $taxonomy => $param ) {
		if ( ! empty( $_GET[ $param ] ) ) {
			$tax_query[] = array(
				'taxonomy' => $taxonomy,
				'field'    => 'slug',
				'terms'    => sanitize_text_field( wp_unslash( $_GET[ $param ] ) ),
			);
		}
	}

	if ( $query->is_post_type_archive( 'ffc_score' ) && ! empty( $_GET['result'] ) ) {
		$meta_query[] = array(
			'key'   => 'result',
			'value' => sanitize_text_field( wp_unslash( $_GET['result'] ) ),
		);
	}

	if ( ! empty( $_GET['opponent'] ) ) {
		$meta_query[] = array(
			'key'     => 'opponent',
			'value'   => sanitize_text_field( wp_unslash( $_GET['opponent'] ) ),
			'compare' => 'LIKE',
		);
	}

	if ( $tax_query ) {
		$query->set( 'tax_query', $tax_query );
	}

	if ( $meta_query ) {
		$query->set( 'meta_query', $meta_query );
	}

	$query->set( 'meta_key', 'game_datetime' );
	$query->set( 'orderby', 'meta_value' );
	$query->set( 'order', $query->is_post_type_archive( 'ffc_score' ) ? 'DESC' : 'ASC' );
}
