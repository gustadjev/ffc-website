<?php
/**
 * F.F.C. Academy theme bootstrap.
 *
 * @package FFCAcademy
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'FFC_THEME_VERSION', '1.2.25' );
define( 'FFC_THEME_DIR', get_template_directory() );
define( 'FFC_THEME_URI', get_template_directory_uri() );

require_once FFC_THEME_DIR . '/inc/template-functions.php';
require_once FFC_THEME_DIR . '/inc/post-types.php';
require_once FFC_THEME_DIR . '/inc/acf.php';
require_once FFC_THEME_DIR . '/inc/admin-settings.php';
require_once FFC_THEME_DIR . '/inc/customizer.php';
require_once FFC_THEME_DIR . '/inc/editor.php';
require_once FFC_THEME_DIR . '/inc/teamsnap.php';
require_once FFC_THEME_DIR . '/inc/spam-protection.php';
require_once FFC_THEME_DIR . '/inc/tryouts.php';
require_once FFC_THEME_DIR . '/inc/admin-columns.php';
require_once FFC_THEME_DIR . '/inc/contact.php';
require_once FFC_THEME_DIR . '/inc/blocks.php';

add_filter( 'hfe_footer_enabled', '__return_false', 999 );
add_filter( 'hfe_before_footer_enabled', '__return_false', 999 );
add_filter( 'enable_hfe_render_footer', '__return_false', 999 );

add_action( 'after_setup_theme', 'ffc_theme_setup' );
function ffc_theme_setup(): void {
	load_theme_textdomain( 'ffc-academy', FFC_THEME_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 220,
			'width'       => 220,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'appearance-tools' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor.css' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Navigation', 'ffc-academy' ),
			'footer'  => __( 'Footer Navigation', 'ffc-academy' ),
			'social'  => __( 'Social Links', 'ffc-academy' ),
		)
	);

	add_image_size( 'ffc-hero', 1920, 1080, true );
	add_image_size( 'ffc-card', 720, 520, true );
	add_image_size( 'ffc-square', 720, 720, true );
}

add_action( 'after_switch_theme', 'ffc_set_default_front_page' );
function ffc_set_default_front_page(): void {
	if ( (int) get_option( 'page_on_front' ) ) {
		return;
	}

	$home_page = get_page_by_path( 'home' );
	if ( $home_page instanceof WP_Post ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', (int) $home_page->ID );
	}
}

add_action( 'enqueue_block_editor_assets', 'ffc_enqueue_block_editor_assets' );
function ffc_enqueue_block_editor_assets(): void {
	wp_enqueue_style(
		'ffc-editor-fonts',
		'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;500;600;700;800;900&display=swap',
		array(),
		null
	);
}

add_action( 'wp_enqueue_scripts', 'ffc_enqueue_assets' );
function ffc_enqueue_assets(): void {
	$css_file = FFC_THEME_DIR . '/assets/css/main.css';
	$js_file  = FFC_THEME_DIR . '/assets/js/main.js';

	wp_enqueue_style(
		'ffc-fonts',
		'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;500;600;700;800;900&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'ffc-theme',
		FFC_THEME_URI . '/assets/css/main.css',
		array( 'ffc-fonts' ),
		file_exists( $css_file ) ? (string) filemtime( $css_file ) : FFC_THEME_VERSION
	);

	wp_enqueue_script(
		'ffc-theme',
		FFC_THEME_URI . '/assets/js/main.js',
		array(),
		file_exists( $js_file ) ? (string) filemtime( $js_file ) : FFC_THEME_VERSION,
		true
	);

	wp_localize_script(
		'ffc-theme',
		'ffcTheme',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'ffc_theme_nonce' ),
		)
	);
}

add_action( 'wp_head', 'ffc_add_site_schema' );
function ffc_add_site_schema(): void {
	$schema = array(
		'@context' => 'https://schema.org',
		'@type'    => 'SportsOrganization',
		'name'     => ffc_brand_name(),
		'sport'    => 'Soccer',
		'url'      => home_url( '/' ),
		'logo'     => ffc_get_logo_url(),
	);

	printf(
		'<script type="application/ld+json">%s</script>' . "\n",
		wp_json_encode( array_filter( $schema ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
	);
}

add_action( 'wp_head', 'ffc_random_uuid_polyfill', 0 );
function ffc_random_uuid_polyfill(): void {
	?>
	<script>
		window.crypto = window.crypto || {};
		if (typeof window.crypto.randomUUID !== 'function') {
			window.crypto.randomUUID = function () {
				var bytes = new Uint8Array(16);
				if (window.crypto.getRandomValues) {
					window.crypto.getRandomValues(bytes);
				} else {
					for (var i = 0; i < bytes.length; i += 1) {
						bytes[i] = Math.floor(Math.random() * 256);
					}
				}
				bytes[6] = (bytes[6] & 15) | 64;
				bytes[8] = (bytes[8] & 63) | 128;
				var hex = Array.prototype.map.call(bytes, function (byte) {
					return ('0' + byte.toString(16)).slice(-2);
				}).join('');
				return hex.slice(0, 8) + '-' + hex.slice(8, 12) + '-' + hex.slice(12, 16) + '-' + hex.slice(16, 20) + '-' + hex.slice(20);
			};
		}
	</script>
	<?php
}
