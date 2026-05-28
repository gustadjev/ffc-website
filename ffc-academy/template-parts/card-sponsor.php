<?php
$url = ffc_get_field( 'sponsor_url', get_the_ID() );
$cta = ffc_get_field( 'sponsor_cta', get_the_ID(), ffc_option( 'card_visit_sponsor_label', __( 'Visit Sponsor', 'ffc-academy' ) ) );
?>
<article class="sponsor-card reveal">
	<?php if ( has_post_thumbnail() ) : ?>
		<figure><?php the_post_thumbnail( 'ffc-square', array( 'loading' => 'lazy' ) ); ?></figure>
	<?php endif; ?>
	<h3><?php the_title(); ?></h3>
	<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
	<?php
	if ( $url ) :
		?>
		<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $cta ); ?></a><?php endif; ?>
</article>
