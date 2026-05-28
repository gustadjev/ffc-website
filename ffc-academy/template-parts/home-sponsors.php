<?php
$home_id  = ffc_home_page_id();
$sponsors = new WP_Query(
	array(
		'post_type'      => 'ffc_sponsor',
		'posts_per_page' => 6,
	)
);
?>
<section class="section sponsor-section">
	<div class="container section-heading">
		<p class="eyebrow"><?php echo esc_html( ffc_get_field( 'home_sponsors_kicker', $home_id, __( 'Community Partners', 'ffc-academy' ) ) ); ?></p>
		<h2><?php echo esc_html( ffc_get_field( 'home_sponsors_title', $home_id, __( 'Sponsors Fuel Player Growth', 'ffc-academy' ) ) ); ?></h2>
		<a href="<?php echo esc_url( get_post_type_archive_link( 'ffc_sponsor' ) ); ?>"><?php echo esc_html( ffc_get_field( 'home_sponsors_link_label', $home_id, __( 'Partner With F.F.C.', 'ffc-academy' ) ) ); ?></a>
	</div>
	<div class="container sponsor-grid">
		<?php if ( $sponsors->have_posts() ) : ?>
			<?php
			while ( $sponsors->have_posts() ) :
				$sponsors->the_post();
				?>
				<?php get_template_part( 'template-parts/card', 'sponsor' ); ?>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
		<?php else : ?>
			<article class="sponsor-card sponsor-card--placeholder reveal">
				<span><?php echo esc_html( ffc_get_field( 'home_sponsors_placeholder_tier', $home_id, __( 'Partnership Opportunity', 'ffc-academy' ) ) ); ?></span>
				<h3><?php echo esc_html( ffc_get_field( 'home_sponsors_placeholder_title', $home_id, __( 'Partner With F.F.C.', 'ffc-academy' ) ) ); ?></h3>
				<p><?php echo esc_html( ffc_get_field( 'home_sponsors_placeholder_copy', $home_id, __( 'Support youth development, tournament access, and a professional academy environment.', 'ffc-academy' ) ) ); ?></p>
				<a href="<?php echo esc_url( ffc_get_field( 'home_sponsors_placeholder_cta_url', $home_id, ffc_archive_link_by_slug( 'contact', home_url( '/contact/' ) ) ) ); ?>"><?php echo esc_html( ffc_get_field( 'home_sponsors_placeholder_cta_label', $home_id, __( 'Start a Conversation', 'ffc-academy' ) ) ); ?></a>
			</article>
		<?php endif; ?>
	</div>
</section>
