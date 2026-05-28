<?php
$home_id = ffc_home_page_id();
$matches = new WP_Query(
	array(
		'post_type'      => 'ffc_game',
		'posts_per_page' => 3,
		'meta_key'       => 'game_datetime',
		'orderby'        => 'meta_value',
		'order'          => 'ASC',
		'meta_query'     => array(
			array(
				'key'     => 'game_datetime',
				'value'   => current_time( 'mysql' ),
				'compare' => '>=',
				'type'    => 'DATETIME',
			),
		),
	)
);
?>
<section class="section section--light">
	<div class="container section-heading">
		<p class="eyebrow"><?php echo esc_html( ffc_get_field( 'home_matches_kicker', $home_id, __( 'Next Up', 'ffc-academy' ) ) ); ?></p>
		<h2><?php echo esc_html( ffc_get_field( 'home_matches_title', $home_id, __( 'Upcoming Matches', 'ffc-academy' ) ) ); ?></h2>
		<a href="<?php echo esc_url( get_post_type_archive_link( 'ffc_game' ) ); ?>"><?php echo esc_html( ffc_get_field( 'home_matches_link_label', $home_id, __( 'Full Schedule', 'ffc-academy' ) ) ); ?></a>
	</div>
	<div class="container match-grid">
		<?php if ( $matches->have_posts() ) : ?>
			<?php
			while ( $matches->have_posts() ) :
				$matches->the_post();
				?>
				<?php get_template_part( 'template-parts/card', 'game' ); ?>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
		<?php else : ?>
			<p class="empty-state"><?php echo esc_html( ffc_get_field( 'home_matches_empty_message', $home_id, __( 'Upcoming match details will be posted soon.', 'ffc-academy' ) ) ); ?></p>
		<?php endif; ?>
	</div>
</section>
