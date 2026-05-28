<?php
$media_type = ffc_get_field( 'media_type', get_the_ID(), 'photo' );
$video_url  = ffc_get_field( 'video_url', get_the_ID() );
$lightbox   = 'photo' === $media_type ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : $video_url;
?>
<article class="gallery-card reveal" data-gallery-item data-category="<?php echo esc_attr( join( ' ', wp_get_post_terms( get_the_ID(), 'ffc_gallery_category', array( 'fields' => 'slugs' ) ) ) ); ?>">
	<button class="gallery-card__button" type="button" data-lightbox-src="<?php echo esc_url( $lightbox ); ?>" data-lightbox-type="<?php echo esc_attr( $media_type ); ?>">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'ffc-card', array( 'loading' => 'lazy' ) ); ?>
		<?php endif; ?>
		<span><?php the_title(); ?></span>
	</button>
</article>
