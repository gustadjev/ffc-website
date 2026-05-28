<?php
get_header();
?>
<main id="primary" class="site-main">
	<section class="page-hero">
		<div class="container">
			<p class="eyebrow"><?php echo esc_html( ffc_option( 'search_eyebrow', __( 'Search', 'ffc-academy' ) ) ); ?></p>
			<h1><?php printf( esc_html__( 'Results for %s', 'ffc-academy' ), esc_html( get_search_query() ) ); ?></h1>
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
				<p class="empty-state"><?php echo esc_html( ffc_option( 'search_empty_message', __( 'No results found.', 'ffc-academy' ) ) ); ?></p>
							<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();
