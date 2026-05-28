<?php
$home_id = ffc_home_page_id();
$scores = new WP_Query(
	array(
		'post_type'      => 'ffc_score',
		'posts_per_page' => 4,
		'meta_key'       => 'game_datetime',
		'orderby'        => 'meta_value',
		'order'          => 'DESC',
	)
);
?>
<section class="scoreboard">
	<div class="container section-heading section-heading--dark">
		<p class="eyebrow"><?php echo esc_html( ffc_get_field( 'home_scores_kicker', $home_id, __( 'Matchday', 'ffc-academy' ) ) ); ?></p>
		<h2><?php echo esc_html( ffc_get_field( 'home_scores_title', $home_id, __( 'Latest Scores', 'ffc-academy' ) ) ); ?></h2>
		<a href="<?php echo esc_url( get_post_type_archive_link( 'ffc_score' ) ); ?>"><?php echo esc_html( ffc_get_field( 'home_scores_link_label', $home_id, __( 'View Results', 'ffc-academy' ) ) ); ?></a>
	</div>
	<div class="container score-strip">
		<?php if ( $scores->have_posts() ) : ?>
			<?php
			while ( $scores->have_posts() ) :
				$scores->the_post();
				?>
				<?php get_template_part( 'template-parts/card', 'score' ); ?>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
		<?php else : ?>
			<p class="empty-state"><?php echo esc_html( ffc_get_field( 'home_scores_empty_message', $home_id, __( 'Recent results and match recaps will be posted after games.', 'ffc-academy' ) ) ); ?></p>
		<?php endif; ?>
	</div>
</section>
