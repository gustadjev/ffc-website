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

add_filter( 'use_block_editor_for_post', 'ffc_use_classic_editor_for_theme_pages', 9999, 2 );
function ffc_use_classic_editor_for_theme_pages( bool $use_block_editor, WP_Post $post ): bool {
	if ( ffc_is_theme_managed_page( $post ) ) {
		return false;
	}

	return $use_block_editor;
}

add_filter( 'gutenberg_can_edit_post', 'ffc_disable_gutenberg_for_theme_pages', 9999, 2 );
function ffc_disable_gutenberg_for_theme_pages( bool $can_edit, WP_Post $post ): bool {
	if ( ffc_is_theme_managed_page( $post ) ) {
		return false;
	}

	return $can_edit;
}

add_action( 'admin_init', 'ffc_force_classic_editor_for_theme_pages', 20 );
function ffc_force_classic_editor_for_theme_pages(): void {
	$pagenow = $GLOBALS['pagenow'] ?? '';
	if ( 'post.php' !== $pagenow ) {
		return;
	}

	$post_id = isset( $_GET['post'] ) ? absint( wp_unslash( $_GET['post'] ) ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( ! $post_id || ! ffc_is_theme_managed_page( $post_id ) ) {
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
	if ( ! $post_id || ! ffc_is_theme_managed_page( $post_id ) ) {
		return;
	}

	if ( 'builder' === (string) get_post_meta( $post_id, '_elementor_edit_mode', true ) ) {
		delete_post_meta( $post_id, '_elementor_edit_mode' );
	}
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
	if ( ! $screen || 'page' !== $screen->post_type ) {
		return;
	}

	$post_id = isset( $_GET['post'] ) ? absint( wp_unslash( $_GET['post'] ) ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( ! $post_id || ! ffc_is_theme_managed_page( $post_id ) ) {
		return;
	}
	?>
	<style>
		.ffc-theme-managed-page #post-body-content > .acf-postbox {
			margin: 20px 0;
		}

		.ffc-theme-managed-page #post-body-content > .acf-postbox .inside {
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
	if ( ! $screen || 'page' !== $screen->post_type ) {
		return $classes;
	}

	$post_id = isset( $_GET['post'] ) ? absint( wp_unslash( $_GET['post'] ) ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( $post_id && ffc_is_theme_managed_page( $post_id ) ) {
		$classes .= ' ffc-theme-managed-page';
	}

	return $classes;
}

add_action( 'admin_footer-post.php', 'ffc_move_theme_fields_into_main_column' );
function ffc_move_theme_fields_into_main_column(): void {
	$screen = get_current_screen();
	if ( ! $screen || 'page' !== $screen->post_type ) {
		return;
	}

	$post_id = isset( $_GET['post'] ) ? absint( wp_unslash( $_GET['post'] ) ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( ! $post_id || ! ffc_is_theme_managed_page( $post_id ) ) {
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
					'acf-group_ffc_tryout_page'
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
