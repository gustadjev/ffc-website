<?php
get_header();
?>
<main id="primary" class="site-main">
	<section class="page-hero">
		<div class="container">
			<p class="eyebrow"><?php echo esc_html( ffc_option( 'archive_announcement_kicker', __( 'Academy Desk', 'ffc-academy' ) ) ); ?></p>
			<h1><?php echo esc_html( ffc_option( 'archive_announcement_title', __( 'Announcements', 'ffc-academy' ) ) ); ?></h1>
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
				<p class="empty-state"><?php echo esc_html( ffc_option( 'archive_announcement_empty_message', __( 'Announcements will appear here.', 'ffc-academy' ) ) ); ?></p>
							<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();
