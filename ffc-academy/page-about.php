<?php
/**
 * About page template for the about slug.
 *
 * @package FFCAcademy
 */

get_header();

$page_id = get_queried_object_id();
if ( ffc_is_builder_page( $page_id ) ) {
	ffc_render_builder_page( $page_id );
	get_footer();
	return;
}

$tryouts  = ffc_archive_link_by_slug( 'tryouts', home_url( '/tryouts/' ) );
$contact  = ffc_archive_link_by_slug( 'contact', home_url( '/contact/' ) );
$values   = array(
	array(
		'image' => ffc_theme_image( 'training' ),
		'title' => __( 'Teamwork', 'ffc-academy' ),
		'copy'  => __( 'We build inclusive teams that pursue common goals with trust and accountability.', 'ffc-academy' ),
	),
	array(
		'image' => ffc_theme_image( 'match' ),
		'title' => __( 'Sportsmanship', 'ffc-academy' ),
		'copy'  => __( 'Players, coaches, and families represent the club with respect on every touchline.', 'ffc-academy' ),
	),
	array(
		'image' => ffc_theme_image( 'gallery_1' ),
		'title' => __( 'Dedication', 'ffc-academy' ),
		'copy'  => __( 'Consistent effort, preparation, and coachability drive long-term player development.', 'ffc-academy' ),
	),
	array(
		'image' => ffc_theme_image( 'gallery_3' ),
		'title' => __( 'Excellence', 'ffc-academy' ),
		'copy'  => __( 'We aim to deliver a quality soccer experience for every player and family.', 'ffc-academy' ),
	),
);
$timeline = array(
	array(
		'label' => __( 'Foundation', 'ffc-academy' ),
		'title' => __( 'A Place to Belong', 'ffc-academy' ),
		'copy'  => __( 'F.F.C. gives players a structured club home where training, communication, and team culture all work together.', 'ffc-academy' ),
	),
	array(
		'label' => __( 'Development', 'ffc-academy' ),
		'title' => __( 'A Path to Improve', 'ffc-academy' ),
		'copy'  => __( 'Age-appropriate coaching helps players grow in confidence, skill, decision-making, and love for the game.', 'ffc-academy' ),
	),
	array(
		'label' => __( 'Competition', 'ffc-academy' ),
		'title' => __( 'A Standard to Chase', 'ffc-academy' ),
		'copy'  => __( 'Matchdays and tournaments become opportunities to test progress, learn resilience, and represent the club well.', 'ffc-academy' ),
	),
);
?>
<main id="primary" class="site-main">
	<section class="about-hero">
		<div class="container about-hero__inner">
			<div>
				<p class="eyebrow"><?php echo esc_html( ffc_get_field( 'about_hero_kicker', $page_id, __( 'About F.F.C.', 'ffc-academy' ) ) ); ?></p>
				<h1><?php echo esc_html( ffc_get_field( 'about_hero_title', $page_id, __( 'Freedom Futbol Club', 'ffc-academy' ) ) ); ?></h1>
			</div>
			<p><?php echo esc_html( ffc_get_field( 'about_hero_copy', $page_id, __( 'F.F.C. is a youth soccer academy built around player growth, positive team culture, and clear communication for families. We create an environment where young athletes can train with purpose, compete with confidence, and learn values that carry beyond the field.', 'ffc-academy' ) ) ); ?></p>
		</div>
	</section>

	<section class="about-intro section">
		<div class="container about-intro__grid">
			<div class="about-intro__copy">
				<h2><?php echo esc_html( ffc_get_field( 'about_intro_title', $page_id, __( 'A Club Environment for Ambitious Young Players', 'ffc-academy' ) ) ); ?></h2>
				<p><?php echo esc_html( ffc_get_field( 'about_intro_copy_one', $page_id, __( 'Our academy model balances high standards with a family-friendly experience. Players are challenged technically and tactically, while coaches emphasize teamwork, sportsmanship, dedication, and resilience.', 'ffc-academy' ) ) ); ?></p>
				<p><?php echo esc_html( ffc_get_field( 'about_intro_copy_two', $page_id, __( 'From foundational age groups through competitive teams, F.F.C. provides structured training, match preparation, and a shared identity rooted in discipline, unity, and continuous improvement.', 'ffc-academy' ) ) ); ?></p>
			</div>
			<figure class="about-intro__image">
				<img src="<?php echo esc_url( ffc_image_url_from_field( ffc_get_field( 'about_intro_image', $page_id ), 'ffc-card', ffc_theme_image( 'community' ) ) ); ?>" alt="<?php esc_attr_e( 'F.F.C. players and families at a soccer field', 'ffc-academy' ); ?>" loading="lazy">
			</figure>
		</div>
	</section>

	<section class="about-values section section--light">
		<div class="container section-heading">
			<div>
				<p class="eyebrow"><?php echo esc_html( ffc_get_field( 'about_values_kicker', $page_id, __( 'What We Value', 'ffc-academy' ) ) ); ?></p>
				<h2><?php echo esc_html( ffc_get_field( 'about_values_title', $page_id, __( 'The Standards Behind the Crest', 'ffc-academy' ) ) ); ?></h2>
			</div>
		</div>
		<div class="container about-value-grid">
			<?php foreach ( $values as $index => $value ) : ?>
				<?php $number = $index + 1; ?>
				<article>
					<img src="<?php echo esc_url( ffc_image_url_from_field( ffc_get_field( "about_value_{$number}_image", $page_id ), 'ffc-card', $value['image'] ) ); ?>" alt="" loading="lazy">
					<h3><?php echo esc_html( ffc_get_field( "about_value_{$number}_title", $page_id, $value['title'] ) ); ?></h3>
					<p><?php echo esc_html( ffc_get_field( "about_value_{$number}_copy", $page_id, $value['copy'] ) ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="about-history section">
		<div class="container about-history__grid">
			<div>
				<p class="eyebrow"><?php echo esc_html( ffc_get_field( 'about_story_kicker', $page_id, __( 'Our Story', 'ffc-academy' ) ) ); ?></p>
				<h2><?php echo esc_html( ffc_get_field( 'about_story_title', $page_id, __( 'Growing the Game With Community at the Center', 'ffc-academy' ) ) ); ?></h2>
			</div>
			<div class="about-timeline">
				<?php foreach ( $timeline as $index => $item ) : ?>
					<?php $number = $index + 1; ?>
					<article>
						<span><?php echo esc_html( ffc_get_field( "about_timeline_{$number}_label", $page_id, $item['label'] ) ); ?></span>
						<h3><?php echo esc_html( ffc_get_field( "about_timeline_{$number}_title", $page_id, $item['title'] ) ); ?></h3>
						<p><?php echo esc_html( ffc_get_field( "about_timeline_{$number}_copy", $page_id, $item['copy'] ) ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php ffc_page_content_section( $page_id ); ?>

	<section class="about-cta">
		<div class="container about-cta__inner">
			<h2><?php echo esc_html( ffc_get_field( 'about_cta_title', $page_id, __( 'Ready to Learn More?', 'ffc-academy' ) ) ); ?></h2>
			<div class="button-row">
				<?php echo ffc_button( ffc_get_field( 'about_cta_primary_label', $page_id, __( 'Register for Tryouts', 'ffc-academy' ) ), ffc_get_field( 'about_cta_primary_url', $page_id, $tryouts ), 'accent' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php echo ffc_button( ffc_get_field( 'about_cta_secondary_label', $page_id, __( 'Contact F.F.C.', 'ffc-academy' ) ), ffc_get_field( 'about_cta_secondary_url', $page_id, $contact ), 'light' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
