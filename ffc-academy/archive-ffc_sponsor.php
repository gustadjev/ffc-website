<?php
get_header();
?>
<main id="primary" class="site-main">
	<section class="page-hero">
		<div class="container">
			<p class="eyebrow"><?php esc_html_e( 'Partnerships', 'ffc-academy' ); ?></p>
			<h1><?php esc_html_e( 'Sponsors', 'ffc-academy' ); ?></h1>
		</div>
	</section>
	<section class="section sponsor-section">
		<div class="container sponsor-grid">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					?>
					<?php get_template_part( 'template-parts/card', 'sponsor' ); ?>
			<?php endwhile; else : ?>
				<p class="empty-state"><?php esc_html_e( 'Sponsor information can be added from the WordPress admin.', 'ffc-academy' ); ?></p>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();
