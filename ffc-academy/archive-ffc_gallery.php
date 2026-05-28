<?php
get_header();
$terms = get_terms(
	array(
		'taxonomy'   => 'ffc_gallery_category',
		'hide_empty' => true,
	)
);
$terms = is_wp_error( $terms ) ? array() : $terms;
?>
<main id="primary" class="site-main">
	<section class="page-hero">
		<div class="container">
			<p class="eyebrow"><?php esc_html_e( 'Visual Storytelling', 'ffc-academy' ); ?></p>
			<h1><?php esc_html_e( 'Gallery', 'ffc-academy' ); ?></h1>
		</div>
	</section>
	<section class="section section--ivory">
		<div class="container filters" data-gallery-filters>
			<button class="is-active" type="button" data-filter="all"><?php esc_html_e( 'All', 'ffc-academy' ); ?></button>
			<?php foreach ( $terms as $term ) : ?>
				<button type="button" data-filter="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></button>
			<?php endforeach; ?>
		</div>
		<div class="container gallery-grid">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					?>
					<?php get_template_part( 'template-parts/card', 'gallery' ); ?>
					<?php
			endwhile;
				the_posts_pagination(); else :
					?>
				<p class="empty-state"><?php esc_html_e( 'Gallery items will appear here.', 'ffc-academy' ); ?></p>
							<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();
