<?php
$gallery = new WP_Query(
	array(
		'post_type'      => 'ffc_gallery',
		'posts_per_page' => 6,
	)
);
?>
<section class="section section--ivory">
	<div class="container section-heading">
		<p class="eyebrow"><?php esc_html_e( 'Club Culture', 'ffc-academy' ); ?></p>
		<h2><?php esc_html_e( 'Featured Gallery', 'ffc-academy' ); ?></h2>
		<a href="<?php echo esc_url( get_post_type_archive_link( 'ffc_gallery' ) ); ?>"><?php esc_html_e( 'Open Gallery', 'ffc-academy' ); ?></a>
	</div>
	<div class="container gallery-grid">
		<?php if ( $gallery->have_posts() ) : ?>
			<?php
			while ( $gallery->have_posts() ) :
				$gallery->the_post();
				?>
				<?php get_template_part( 'template-parts/card', 'gallery' ); ?>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
		<?php else : ?>
			<?php
			$fallback_gallery = array(
				array( 'Training Intensity', ffc_theme_image( 'gallery_1' ) ),
				array( 'Matchday Focus', ffc_theme_image( 'gallery_2' ) ),
				array( 'Team Standards', ffc_theme_image( 'gallery_3' ) ),
				array( 'Player Growth', ffc_theme_image( 'gallery_4' ) ),
			);
			foreach ( $fallback_gallery as $item ) :
				?>
				<article class="gallery-card reveal">
					<button class="gallery-card__button" type="button" data-lightbox-src="<?php echo esc_url( $item[1] ); ?>" data-lightbox-type="photo">
						<img src="<?php echo esc_url( $item[1] ); ?>" alt="<?php echo esc_attr( $item[0] ); ?>" loading="lazy">
						<span><?php echo esc_html( $item[0] ); ?></span>
					</button>
				</article>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</section>
