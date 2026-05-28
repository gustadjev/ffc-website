<?php
get_header();
?>
<main id="primary" class="site-main">
	<section class="page-hero">
		<div class="container">
			<p class="eyebrow"><?php echo esc_html( ffc_option( 'archive_coach_kicker', __( 'Player Development', 'ffc-academy' ) ) ); ?></p>
			<h1><?php echo esc_html( ffc_option( 'archive_coach_title', __( 'Coaching Staff', 'ffc-academy' ) ) ); ?></h1>
		</div>
	</section>
	<section class="section section--light">
		<div class="container coach-grid">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					?>
					<?php get_template_part( 'template-parts/card', 'coach' ); ?>
			<?php endwhile; else : ?>
				<p class="empty-state"><?php echo esc_html( ffc_option( 'archive_coach_empty_message', __( 'Coach profiles can be added from the WordPress admin.', 'ffc-academy' ) ) ); ?></p>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();
