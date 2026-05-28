<?php
$announcements = new WP_Query( array(
	'post_type'      => 'ffc_announcement',
	'posts_per_page' => 3,
) );
?>
<section class="section section--light">
	<div class="container section-heading">
		<p class="eyebrow"><?php esc_html_e( 'Academy Desk', 'ffc-academy' ); ?></p>
		<h2><?php esc_html_e( 'Announcements', 'ffc-academy' ); ?></h2>
		<a href="<?php echo esc_url( get_post_type_archive_link( 'ffc_announcement' ) ); ?>"><?php esc_html_e( 'All Updates', 'ffc-academy' ); ?></a>
	</div>
	<div class="container post-grid">
		<?php if ( $announcements->have_posts() ) : ?>
			<?php while ( $announcements->have_posts() ) : $announcements->the_post(); ?>
				<?php get_template_part( 'template-parts/card', 'post' ); ?>
			<?php endwhile; wp_reset_postdata(); ?>
		<?php else : ?>
			<article class="card notice-card reveal"><div class="card__body"><span class="date-badge"><?php esc_html_e( 'Club', 'ffc-academy' ); ?></span><h2><?php esc_html_e( 'Tryout Window Opening Soon', 'ffc-academy' ); ?></h2><p><?php esc_html_e( 'Families can register online and receive follow-up details from academy staff.', 'ffc-academy' ); ?></p></div></article>
			<article class="card notice-card reveal"><div class="card__body"><span class="date-badge"><?php esc_html_e( 'Training', 'ffc-academy' ); ?></span><h2><?php esc_html_e( 'Summer Development Blocks', 'ffc-academy' ); ?></h2><p><?php esc_html_e( 'Age-group sessions will focus on technical speed, decision-making, and finishing.', 'ffc-academy' ); ?></p></div></article>
			<article class="card notice-card reveal"><div class="card__body"><span class="date-badge"><?php esc_html_e( 'Community', 'ffc-academy' ); ?></span><h2><?php esc_html_e( 'Sponsor Partnerships', 'ffc-academy' ); ?></h2><p><?php esc_html_e( 'Local partners can support player pathways, equipment, and tournament travel.', 'ffc-academy' ); ?></p></div></article>
		<?php endif; ?>
	</div>
</section>
