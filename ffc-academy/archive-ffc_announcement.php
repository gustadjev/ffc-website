<?php
get_header();
?>
<main id="primary" class="site-main">
	<section class="page-hero">
		<div class="container">
			<p class="eyebrow"><?php esc_html_e( 'Academy Desk', 'ffc-academy' ); ?></p>
			<h1><?php esc_html_e( 'Announcements', 'ffc-academy' ); ?></h1>
		</div>
	</section>
	<section class="section section--light">
		<div class="container post-grid">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					?>
					<?php get_template_part( 'template-parts/card', 'post' ); ?>
					<?php
			endwhile;
				the_posts_pagination(); else :
					?>
				<p class="empty-state"><?php esc_html_e( 'Announcements will appear here.', 'ffc-academy' ); ?></p>
							<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();
