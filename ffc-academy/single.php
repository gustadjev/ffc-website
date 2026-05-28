<?php
/**
 * Single content template.
 *
 * @package FFCAcademy
 */

get_header();
?>
<main id="primary" class="site-main">
	<?php while ( have_posts() ) : the_post(); ?>
		<section class="page-hero page-hero--single">
			<div class="container">
				<p class="eyebrow"><?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ?? 'F.F.C.' ); ?></p>
				<h1><?php the_title(); ?></h1>
			</div>
		</section>
		<article class="section">
			<div class="container content-area">
				<?php if ( has_post_thumbnail() ) : ?>
					<figure class="featured-media"><?php the_post_thumbnail( 'ffc-hero', array( 'loading' => 'eager' ) ); ?></figure>
				<?php endif; ?>
				<?php the_content(); ?>
			</div>
		</article>
	<?php endwhile; ?>
</main>
<?php
get_footer();
