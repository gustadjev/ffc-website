<?php
/**
 * Generic post card.
 *
 * @package FFCAcademy
 */
?>
<article <?php post_class( 'card reveal' ); ?>>
	<a class="card__media" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'ffc-card', array( 'loading' => 'lazy' ) ); ?>
		<?php endif; ?>
	</a>
	<div class="card__body">
		<?php echo ffc_post_date_badge(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
	</div>
</article>
