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
	if ( function_exists( 'get_field' ) ) {
		$value = get_field( $key, 'option' );
		if ( null !== $value && false !== $value && '' !== $value ) {
			return $value;
		}
	}

	return get_option( 'ffc_' . $key, $default );
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
	$output .= '<option value="">' . esc_html__( 'All', 'ffc-academy' ) . '</option>';

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

function ffc_social_links_markup( string $class = 'social-icons' ): string {
	$channels = array(
		'instagram' => __( 'Instagram', 'ffc-academy' ),
		'facebook'  => __( 'Facebook', 'ffc-academy' ),
		'youtube'   => __( 'YouTube', 'ffc-academy' ),
		'tiktok'    => __( 'TikTok', 'ffc-academy' ),
	);

	$output = '<div class="' . esc_attr( $class ) . '">';
	foreach ( $channels as $key => $label ) {
		$url = ffc_option( $key . '_url' );
		if ( ! $url ) {
			continue;
		}

		$output .= sprintf(
			'<a href="%1$s" target="_blank" rel="noopener" aria-label="%2$s"><span class="screen-reader-text">%2$s</span>%3$s</a>',
			esc_url( $url ),
			esc_attr( $label ),
			ffc_social_icon( $key )
		);
	}
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
