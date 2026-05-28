<?php
/**
 * Page template.
 *
 * @package FFCAcademy
 */

get_header();
?>
<main id="primary" class="site-main">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<section class="page-hero">
			<div class="container">
				<p class="eyebrow"><?php echo esc_html( ffc_option( 'default_page_eyebrow', __( 'F.F.C. Academy', 'ffc-academy' ) ) ); ?></p>
				<h1><?php the_title(); ?></h1>
			</div>
		</section>
		<article class="section">
			<div class="container content-area">
				<?php the_content(); ?>
			</div>
		</article>
	<?php endwhile; ?>
</main>
<?php
get_footer();
