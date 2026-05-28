<?php
$home_id       = ffc_home_page_id();
$announcements = new WP_Query(
	array(
		'post_type'      => 'ffc_announcement',
		'posts_per_page' => 3,
	)
);
?>
<section class="section section--light">
	<div class="container section-heading">
		<p class="eyebrow"><?php echo esc_html( ffc_get_field( 'home_announcements_kicker', $home_id, __( 'Academy Desk', 'ffc-academy' ) ) ); ?></p>
		<h2><?php echo esc_html( ffc_get_field( 'home_announcements_title', $home_id, __( 'Announcements', 'ffc-academy' ) ) ); ?></h2>
		<a href="<?php echo esc_url( get_post_type_archive_link( 'ffc_announcement' ) ); ?>"><?php echo esc_html( ffc_get_field( 'home_announcements_link_label', $home_id, __( 'All Updates', 'ffc-academy' ) ) ); ?></a>
	</div>
	<div class="container post-grid">
		<?php if ( $announcements->have_posts() ) : ?>
			<?php
			while ( $announcements->have_posts() ) :
				$announcements->the_post();
				?>
				<?php get_template_part( 'template-parts/card', 'post' ); ?>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
		<?php else : ?>
			<p class="empty-state"><?php echo esc_html( ffc_get_field( 'home_announcements_empty_message', $home_id, __( 'Club updates, weather notices, and tournament announcements will appear here.', 'ffc-academy' ) ) ); ?></p>
		<?php endif; ?>
	</div>
</section>
