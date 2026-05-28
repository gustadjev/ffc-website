<?php
/**
 * Default index.
 *
 * @package FFCAcademy
 */

get_header();
?>
<main id="primary" class="site-main section">
	<div class="container">
		<header class="archive-header">
			<p class="eyebrow"><?php esc_html_e( 'F.F.C.', 'ffc-academy' ); ?></p>
			<h1><?php single_post_title(); ?></h1>
		</header>
		<div class="post-grid">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'template-parts/card', 'post' ); ?>
				<?php endwhile; ?>
				<?php the_posts_pagination(); ?>
			<?php else : ?>
				<p><?php esc_html_e( 'No updates are available yet.', 'ffc-academy' ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</main>
<?php
get_footer();
