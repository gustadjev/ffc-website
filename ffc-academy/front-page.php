<?php
/**
 * F.F.C. homepage.
 *
 * @package FFCAcademy
 */

get_header();

$front_id = (int) get_option( 'page_on_front' );
if ( ffc_is_builder_page( $front_id ) ) {
	ffc_render_builder_page( $front_id );
	get_footer();
	return;
}

$tryout_url = ffc_option( 'tryout_page_url', ffc_archive_link_by_slug( 'tryouts', home_url( '/tryouts/' ) ) );
$fallback_slides = array(
	array(
		'image'   => ffc_theme_image( 'hero' ),
		'kicker'  => __( 'Freedom Futbol Club', 'ffc-academy' ),
		'title'   => __( 'A Serious Soccer Home for Growing Players.', 'ffc-academy' ),
		'copy'    => __( 'Elite standards, family communication, and a clear development pathway for young athletes ready to train, compete, and belong.', 'ffc-academy' ),
		'label'   => __( 'Academy Pathway', 'ffc-academy' ),
		'meta'    => __( 'U8-U18 player development', 'ffc-academy' ),
		'primary' => array( __( 'Register for Tryouts', 'ffc-academy' ), $tryout_url ),
		'second'  => array( __( 'View Schedule', 'ffc-academy' ), get_post_type_archive_link( 'ffc_game' ) ),
	),
	array(
		'image'   => ffc_theme_image( 'match' ),
		'kicker'  => __( 'Matchday Ready', 'ffc-academy' ),
		'title'   => __( 'Train With Purpose. Compete With Confidence.', 'ffc-academy' ),
		'copy'    => __( 'Structured sessions prepare players for the pace, pressure, and decision-making of real match environments.', 'ffc-academy' ),
		'label'   => __( 'Next Match', 'ffc-academy' ),
		'meta'    => __( 'Schedules managed through TeamSnap', 'ffc-academy' ),
		'primary' => array( __( 'Open TeamSnap', 'ffc-academy' ), ffc_option( 'teamsnap_public_url' ) ?: ffc_option( 'teamsnap_schedule_url' ) ?: get_post_type_archive_link( 'ffc_game' ) ),
		'second'  => array( __( 'Latest Scores', 'ffc-academy' ), get_post_type_archive_link( 'ffc_score' ) ),
	),
	array(
		'image'   => ffc_theme_image( 'training' ),
		'kicker'  => __( 'Player Development', 'ffc-academy' ),
		'title'   => __( 'Build the Habits That Last Beyond the Field.', 'ffc-academy' ),
		'copy'    => __( 'F.F.C. emphasizes teamwork, sportsmanship, dedication, and excellence in every training block.', 'ffc-academy' ),
		'label'   => __( 'Club Culture', 'ffc-academy' ),
		'meta'    => __( 'Discipline, unity, leadership', 'ffc-academy' ),
		'primary' => array( __( 'About F.F.C.', 'ffc-academy' ), ffc_archive_link_by_slug( 'about', home_url( '/about/' ) ) ),
		'second'  => array( __( 'Contact Us', 'ffc-academy' ), ffc_archive_link_by_slug( 'contact', home_url( '/contact/' ) ) ),
	),
);
$acf_slides  = ffc_get_field( 'home_slides', get_option( 'page_on_front' ), array() );
$hero_slides = array();

if ( is_array( $acf_slides ) && ! empty( $acf_slides ) ) {
	foreach ( $acf_slides as $slide ) {
		$hero_slides[] = array(
			'image'   => ffc_image_url_from_field( $slide['image'] ?? '', 'ffc-hero', ffc_theme_image( 'hero' ) ),
			'kicker'  => $slide['kicker'] ?: __( 'Freedom Futbol Club', 'ffc-academy' ),
			'title'   => $slide['title'] ?: __( 'A Serious Soccer Home for Growing Players.', 'ffc-academy' ),
			'copy'    => $slide['copy'] ?: '',
			'label'   => $slide['card_label'] ?: __( 'Club Hub', 'ffc-academy' ),
			'meta'    => $slide['card_meta'] ?: '',
			'primary' => array( $slide['primary_label'] ?: __( 'Register for Tryouts', 'ffc-academy' ), $slide['primary_url'] ?: $tryout_url ),
			'second'  => array( $slide['secondary_label'] ?: __( 'View Schedule', 'ffc-academy' ), $slide['secondary_url'] ?: get_post_type_archive_link( 'ffc_game' ) ),
		);
	}
} else {
	for ( $i = 1; $i <= 3; $i++ ) {
		$title = ffc_get_field( "home_slide_{$i}_title", $front_id, '' );
		$image = ffc_get_field( "home_slide_{$i}_image", $front_id, '' );

		if ( ! $title && ! $image ) {
			continue;
		}

		$fallback      = $fallback_slides[ $i - 1 ];
		$hero_slides[] = array(
			'image'   => ffc_image_url_from_field( $image, 'ffc-hero', $fallback['image'] ),
			'kicker'  => ffc_get_field( "home_slide_{$i}_kicker", $front_id, $fallback['kicker'] ),
			'title'   => $title ?: $fallback['title'],
			'copy'    => ffc_get_field( "home_slide_{$i}_copy", $front_id, $fallback['copy'] ),
			'label'   => ffc_get_field( "home_slide_{$i}_card_label", $front_id, $fallback['label'] ),
			'meta'    => ffc_get_field( "home_slide_{$i}_card_meta", $front_id, $fallback['meta'] ),
			'primary' => array(
				ffc_get_field( "home_slide_{$i}_primary_label", $front_id, $fallback['primary'][0] ),
				ffc_get_field( "home_slide_{$i}_primary_url", $front_id, $fallback['primary'][1] ),
			),
			'second'  => array(
				ffc_get_field( "home_slide_{$i}_secondary_label", $front_id, $fallback['second'][0] ),
				ffc_get_field( "home_slide_{$i}_secondary_url", $front_id, $fallback['second'][1] ),
			),
		);
	}
}

if ( empty( $hero_slides ) ) {
	$hero_slides = $fallback_slides;
} else {
	$hero_slides = array_values( $hero_slides );
}
?>
<main id="primary" class="site-main">
	<section class="home-slider" data-hero-slider aria-label="<?php esc_attr_e( 'Featured F.F.C. stories', 'ffc-academy' ); ?>">
		<div class="home-slider__track">
			<?php foreach ( $hero_slides as $index => $slide ) : ?>
				<article class="home-slide <?php echo 0 === $index ? 'is-active' : ''; ?>" style="--slide-image:url('<?php echo esc_url( $slide['image'] ); ?>')" data-hero-slide <?php echo 0 === $index ? '' : 'aria-hidden="true"'; ?>>
					<div class="container home-slide__inner">
						<div class="home-slide__content">
							<p class="eyebrow"><?php echo esc_html( $slide['kicker'] ); ?></p>
							<h1><?php echo esc_html( $slide['title'] ); ?></h1>
							<p><?php echo esc_html( $slide['copy'] ); ?></p>
							<div class="button-row">
								<?php echo ffc_button( $slide['primary'][0], $slide['primary'][1], 'accent' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<?php echo ffc_button( $slide['second'][0], $slide['second'][1], 'light' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
						</div>
						<aside class="home-match-card">
							<span><?php echo esc_html( $slide['label'] ); ?></span>
							<strong><?php echo esc_html( $slide['meta'] ); ?></strong>
							<div>
								<a href="<?php echo esc_url( $slide['primary'][1] ); ?>"><?php echo esc_html( $slide['primary'][0] ); ?></a>
								<a href="<?php echo esc_url( $slide['second'][1] ); ?>"><?php echo esc_html( $slide['second'][0] ); ?></a>
							</div>
						</aside>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
		<button type="button" class="home-slider__chevron home-slider__chevron--prev" data-hero-prev aria-label="<?php esc_attr_e( 'Previous slide', 'ffc-academy' ); ?>"><span aria-hidden="true">&lsaquo;</span></button>
		<button type="button" class="home-slider__chevron home-slider__chevron--next" data-hero-next aria-label="<?php esc_attr_e( 'Next slide', 'ffc-academy' ); ?>"><span aria-hidden="true">&rsaquo;</span></button>
		<div class="container home-slider__controls">
			<div class="home-slider__dots" role="tablist" aria-label="<?php esc_attr_e( 'Hero slides', 'ffc-academy' ); ?>">
				<?php foreach ( $hero_slides as $index => $slide ) : ?>
					<button type="button" class="<?php echo 0 === $index ? 'is-active' : ''; ?>" data-hero-dot="<?php echo esc_attr( $index ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Show slide %d', 'ffc-academy' ), $index + 1 ) ); ?>"></button>
				<?php endforeach; ?>
			</div>
			<button type="button" class="home-slider__pause" data-hero-pause aria-pressed="false"><?php esc_html_e( 'Pause', 'ffc-academy' ); ?></button>
		</div>
	</section>

	<?php ffc_page_content_section( $front_id ); ?>
	<?php get_template_part( 'template-parts/home', 'programs' ); ?>
	<?php get_template_part( 'template-parts/home', 'matches' ); ?>
	<?php get_template_part( 'template-parts/home', 'development' ); ?>
	<?php get_template_part( 'template-parts/home', 'gallery' ); ?>
	<?php get_template_part( 'template-parts/home', 'teamsnap' ); ?>
	<?php get_template_part( 'template-parts/home', 'tryout-cta' ); ?>
</main>
<?php
get_footer();
