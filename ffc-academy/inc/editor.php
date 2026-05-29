<?php
/**
 * Admin editor experience for theme-managed pages.
 *
 * @package FFCAcademy
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ffc_is_theme_managed_page( $post ): bool {
	if ( is_numeric( $post ) ) {
		$post = get_post( (int) $post );
	}

	if ( ! $post instanceof WP_Post || 'page' !== $post->post_type ) {
		return false;
	}

	$front_page_id = (int) get_option( 'page_on_front' );
	$managed_slugs = array( 'about', 'contact', 'tryouts' );

	return $front_page_id === (int) $post->ID || in_array( $post->post_name, $managed_slugs, true );
}

function ffc_structured_content_post_types(): array {
	return array(
		'ffc_game',
		'ffc_score',
		'ffc_coach',
		'ffc_announcement',
		'ffc_sponsor',
		'ffc_gallery',
		'ffc_tryout_session',
		'ffc_tryout',
	);
}

function ffc_is_structured_content_post( $post ): bool {
	if ( is_numeric( $post ) ) {
		$post = get_post( (int) $post );
	}

	return $post instanceof WP_Post && in_array( $post->post_type, ffc_structured_content_post_types(), true );
}

function ffc_is_structured_content_post_type( string $post_type ): bool {
	return in_array( $post_type, ffc_structured_content_post_types(), true );
}

add_filter( 'use_block_editor_for_post', 'ffc_use_classic_editor_for_theme_pages', 9999, 2 );
function ffc_use_classic_editor_for_theme_pages( bool $use_block_editor, WP_Post $post ): bool {
	if ( ffc_is_theme_managed_page( $post ) || ffc_is_structured_content_post( $post ) ) {
		return false;
	}

	return $use_block_editor;
}

add_filter( 'use_block_editor_for_post_type', 'ffc_use_classic_editor_for_structured_post_types', 9999, 2 );
function ffc_use_classic_editor_for_structured_post_types( bool $use_block_editor, string $post_type ): bool {
	if ( ffc_is_structured_content_post_type( $post_type ) ) {
		return false;
	}

	return $use_block_editor;
}

add_filter( 'gutenberg_can_edit_post', 'ffc_disable_gutenberg_for_theme_pages', 9999, 2 );
function ffc_disable_gutenberg_for_theme_pages( bool $can_edit, WP_Post $post ): bool {
	if ( ffc_is_theme_managed_page( $post ) || ffc_is_structured_content_post( $post ) ) {
		return false;
	}

	return $can_edit;
}

add_filter( 'gutenberg_can_edit_post_type', 'ffc_disable_gutenberg_for_structured_post_types', 9999, 2 );
function ffc_disable_gutenberg_for_structured_post_types( bool $can_edit, string $post_type ): bool {
	if ( ffc_is_structured_content_post_type( $post_type ) ) {
		return false;
	}

	return $can_edit;
}

add_action( 'admin_notices', 'ffc_site_editor_context_notice' );
function ffc_site_editor_context_notice(): void {
	$pagenow = $GLOBALS['pagenow'] ?? '';
	if ( 'site-editor.php' !== $pagenow ) {
		return;
	}

	?>
	<div class="notice notice-info">
		<p><?php esc_html_e( 'F.F.C. Academy is a hybrid theme. The Style Book previews Gutenberg block colors, typography, and patterns. Homepage, footer, TeamSnap, tryout, schedule, score, and gallery content is still managed through F.F.C. Settings and the structured page/content fields.', 'ffc-academy' ); ?></p>
	</div>
	<?php
}

add_action( 'admin_init', 'ffc_force_classic_editor_for_theme_pages', 20 );
function ffc_force_classic_editor_for_theme_pages(): void {
	$pagenow = $GLOBALS['pagenow'] ?? '';
	if ( 'post.php' !== $pagenow ) {
		return;
	}

	$post_id = isset( $_GET['post'] ) ? absint( wp_unslash( $_GET['post'] ) ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( ! $post_id || ( ! ffc_is_theme_managed_page( $post_id ) && ! ffc_is_structured_content_post( $post_id ) ) ) {
		return;
	}

	if ( isset( $_GET['classic-editor'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return;
	}

	wp_safe_redirect(
		add_query_arg(
			array(
				'post'           => $post_id,
				'action'         => 'edit',
				'classic-editor' => 1,
			),
			admin_url( 'post.php' )
		)
	);
	exit;
}

add_action( 'admin_init', 'ffc_clear_builder_mode_for_theme_pages', 5 );
function ffc_clear_builder_mode_for_theme_pages(): void {
	$pagenow = $GLOBALS['pagenow'] ?? '';
	if ( 'post.php' !== $pagenow ) {
		return;
	}

	$post_id = isset( $_GET['post'] ) ? absint( wp_unslash( $_GET['post'] ) ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( ! $post_id || ( ! ffc_is_theme_managed_page( $post_id ) && ! ffc_is_structured_content_post( $post_id ) ) ) {
		return;
	}

	if ( 'builder' === (string) get_post_meta( $post_id, '_elementor_edit_mode', true ) ) {
		delete_post_meta( $post_id, '_elementor_edit_mode' );
	}
}

add_action( 'add_meta_boxes', 'ffc_add_structured_content_editing_help', 10, 2 );
function ffc_add_structured_content_editing_help( string $post_type, WP_Post $post ): void {
	if ( ! ffc_is_structured_content_post_type( $post_type ) ) {
		return;
	}

	add_meta_box(
		'ffc-structured-content-editing-help',
		__( 'F.F.C. Content Guide', 'ffc-academy' ),
		'ffc_render_structured_content_editing_help',
		$post_type,
		'side',
		'high'
	);
}

function ffc_render_structured_content_editing_help( WP_Post $post ): void {
	$guides = array(
		'ffc_game'         => __( 'Add the opponent, date/time, location, field, home/away status, map link, and TeamSnap event link in Game Details. Use the title as an internal/admin-friendly game name.', 'ffc-academy' ),
		'ffc_score'        => __( 'Add the final score, result, recap details, highlights link, season, and team in Score Details. The excerpt/content can be used for match recap copy.', 'ffc-academy' ),
		'ffc_coach'        => __( 'Add the coach role, certifications, philosophy, contact email, and profile photo. The main editor is for the coach biography.', 'ffc-academy' ),
		'ffc_announcement' => __( 'Use the title, excerpt, featured image, and main editor for club announcements, weather notices, tournament updates, and practice updates.', 'ffc-academy' ),
		'ffc_sponsor'      => __( 'Add sponsor website, CTA label, tier, logo/featured image, and sponsor description. Mark Featured Sponsor when it should be highlighted.', 'ffc-academy' ),
		'ffc_gallery'      => __( 'Choose the media type, add a photo or video URL, assign a gallery category, and use the title as the public gallery caption.', 'ffc-academy' ),
		'ffc_tryout_session' => __( 'Schedule tryout sessions with date/time, optional registration open/close times, location, age group, registration status, capacity, and optional TeamSnap link. Only published, open sessions inside the registration window with capacity appear on the public tryout form.', 'ffc-academy' ),
		'ffc_tryout'       => __( 'Use Registration Details to review or manually add player tryout submissions. Public form submissions are stored here automatically.', 'ffc-academy' ),
	);
	?>
	<p><?php echo esc_html( $guides[ $post->post_type ] ?? __( 'Use the fields on this screen to manage structured F.F.C. website content.', 'ffc-academy' ) ); ?></p>
	<p><?php esc_html_e( 'These content types use the classic WordPress editor so custom fields stay visible and reliable.', 'ffc-academy' ); ?></p>
	<?php
}

add_action( 'add_meta_boxes_page', 'ffc_add_theme_page_editing_help' );
function ffc_add_theme_page_editing_help( WP_Post $post ): void {
	if ( ! ffc_is_theme_managed_page( $post ) ) {
		return;
	}

	add_meta_box(
		'ffc-theme-page-editing-help',
		__( 'F.F.C. Editing Guide', 'ffc-academy' ),
		'ffc_render_theme_page_editing_help',
		'page',
		'side',
		'high'
	);
}

function ffc_render_theme_page_editing_help( WP_Post $post ): void {
	$is_front_page = (int) get_option( 'page_on_front' ) === (int) $post->ID;
	?>
	<p><?php esc_html_e( 'This page uses structured F.F.C. content fields so the front end keeps its designed layout.', 'ffc-academy' ); ?></p>
	<?php if ( $is_front_page ) : ?>
		<p><?php esc_html_e( 'Edit the slider in F.F.C. Homepage Slider. Edit the remaining homepage sections in F.F.C. Homepage Sections.', 'ffc-academy' ); ?></p>
	<?php elseif ( 'about' === $post->post_name ) : ?>
		<p><?php esc_html_e( 'Edit the hero, intro, values, story, and CTA sections in the F.F.C. About Page Content panel below the title.', 'ffc-academy' ); ?></p>
	<?php elseif ( 'contact' === $post->post_name ) : ?>
		<p><?php esc_html_e( 'Edit contact page headings and contact methods in the F.F.C. Contact Page Content panel below the title.', 'ffc-academy' ); ?></p>
	<?php elseif ( 'tryouts' === $post->post_name ) : ?>
		<p><?php esc_html_e( 'Edit the tryout hero, introduction, and registration form intro in the F.F.C. Tryout Page Content panel below the title.', 'ffc-academy' ); ?></p>
	<?php endif; ?>
	<p><?php esc_html_e( 'Footer, TeamSnap, and social media URLs are edited in F.F.C. Settings or Appearance > Customize.', 'ffc-academy' ); ?></p>
	<?php
}

add_action( 'admin_head-post.php', 'ffc_hide_builder_button_for_theme_pages' );
add_action( 'admin_head-post-new.php', 'ffc_hide_builder_button_for_theme_pages' );
function ffc_hide_builder_button_for_theme_pages(): void {
	$screen = get_current_screen();
	if ( ! $screen || ( 'page' !== $screen->post_type && ! ffc_is_structured_content_post_type( (string) $screen->post_type ) ) ) {
		return;
	}

	$post_id = isset( $_GET['post'] ) ? absint( wp_unslash( $_GET['post'] ) ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( 'page' === $screen->post_type && ( ! $post_id || ! ffc_is_theme_managed_page( $post_id ) ) ) {
		return;
	}
	?>
	<style>
		.ffc-theme-managed-page #post-body-content > .acf-postbox,
		.ffc-structured-content #post-body-content > .acf-postbox {
			margin: 20px 0;
		}

		.ffc-theme-managed-page #post-body-content > .acf-postbox .inside,
		.ffc-structured-content #post-body-content > .acf-postbox .inside {
			margin: 0;
		}

		.ffc-theme-managed-page #postdivrich,
		.ffc-theme-managed-page .block-editor-writing-flow,
		.ffc-theme-managed-page .edit-post-visual-editor__post-title-wrapper {
			display: none !important;
		}

		#elementor-switch-mode,
		.elementor-switch-mode,
		.elementor-editor-button {
			display: none !important;
		}
	</style>
	<?php
}

add_filter( 'admin_body_class', 'ffc_add_theme_managed_admin_body_class' );
function ffc_add_theme_managed_admin_body_class( string $classes ): string {
	$screen = get_current_screen();
	if ( ! $screen || ( 'page' !== $screen->post_type && ! ffc_is_structured_content_post_type( (string) $screen->post_type ) ) ) {
		return $classes;
	}

	$post_id = isset( $_GET['post'] ) ? absint( wp_unslash( $_GET['post'] ) ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( $post_id && ffc_is_theme_managed_page( $post_id ) ) {
		$classes .= ' ffc-theme-managed-page';
	}
	if ( ffc_is_structured_content_post_type( (string) $screen->post_type ) ) {
		$classes .= ' ffc-structured-content';
	}

	return $classes;
}

add_action( 'admin_footer-post.php', 'ffc_move_theme_fields_into_main_column' );
add_action( 'admin_footer-post-new.php', 'ffc_move_theme_fields_into_main_column' );
function ffc_move_theme_fields_into_main_column(): void {
	$screen = get_current_screen();
	if ( ! $screen || ( 'page' !== $screen->post_type && ! ffc_is_structured_content_post_type( (string) $screen->post_type ) ) ) {
		return;
	}

	$post_id = isset( $_GET['post'] ) ? absint( wp_unslash( $_GET['post'] ) ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( 'page' === $screen->post_type && ( ! $post_id || ! ffc_is_theme_managed_page( $post_id ) ) ) {
		return;
	}
	?>
	<script>
		(function () {
			var attempts = 0;

			function moveThemeFields() {
				var content = document.getElementById('post-body-content');
				var editor = document.getElementById('postdivrich');
				var fieldGroups = [
					'acf-group_ffc_homepage_slider_basic',
					'acf-group_ffc_homepage',
					'acf-group_ffc_about_page',
					'acf-group_ffc_contact_page',
					'acf-group_ffc_tryout_page',
					'acf-group_ffc_game_details',
					'acf-group_ffc_score_details',
					'acf-group_ffc_people_media',
					'acf-group_ffc_gallery_details',
					'acf-group_ffc_sponsor_details',
					'acf-group_ffc_tryout_session_details',
					'acf-group_ffc_tryout_registration_details'
				];

				if (!content) {
					return;
				}

				fieldGroups.forEach(function (id) {
					var box = document.getElementById(id);
					if (!box) {
						return;
					}

					box.classList.add('ffc-admin-content-panel');
					content.insertBefore(box, editor || null);
				});
			}

			function scheduleMove() {
				moveThemeFields();
				attempts += 1;
				if (attempts < 20) {
					window.setTimeout(scheduleMove, 150);
				}
			}

			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', scheduleMove);
			} else {
				scheduleMove();
			}
		}());
	</script>
	<?php
}

add_action( 'admin_init', 'ffc_cleanup_legacy_page_builder_metadata' );
function ffc_cleanup_legacy_page_builder_metadata(): void {
	$cleanup_version = '1.2.12';
	if ( get_option( 'ffc_legacy_editor_cleanup_version' ) === $cleanup_version ) {
		return;
	}

	$pages = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'any',
			'posts_per_page' => -1,
			'fields'         => 'ids',
		)
	);

	foreach ( $pages as $page_id ) {
		delete_post_meta( $page_id, '_elementor_edit_mode' );

		$template = (string) get_post_meta( $page_id, '_wp_page_template', true );
		if ( str_starts_with( $template, 'page-templates/' ) ) {
			update_post_meta( $page_id, '_wp_page_template', 'default' );
		}
	}

	update_option( 'ffc_legacy_editor_cleanup_version', $cleanup_version );
}
