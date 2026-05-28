<?php
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
		<p class="eyebrow"><?php esc_html_e( 'Matchday', 'ffc-academy' ); ?></p>
		<h2><?php esc_html_e( 'Latest Scores', 'ffc-academy' ); ?></h2>
		<a href="<?php echo esc_url( get_post_type_archive_link( 'ffc_score' ) ); ?>"><?php esc_html_e( 'View Results', 'ffc-academy' ); ?></a>
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
			<?php
			$fallback_scores = array(
				array( 'River City FC', 3, 1, 'win', 'High press created early chances and a strong second-half finish.' ),
				array( 'Northside United', 2, 2, 'draw', 'Composed buildup and late equalizer showed excellent resilience.' ),
				array( 'Premier Academy', 1, 0, 'win', 'Compact defending protected the lead through the final whistle.' ),
				array( 'Lakeshore SC', 4, 2, 'win', 'Fast transitions and clinical finishing decided the match.' ),
			);
			foreach ( $fallback_scores as $score ) :
				?>
				<article class="score-card <?php echo esc_attr( ffc_result_class( $score[3] ) ); ?> reveal">
					<div class="score-card__result"><?php echo esc_html( strtoupper( substr( $score[3], 0, 1 ) ) ); ?></div>
					<h3><?php esc_html_e( 'F.F.C.', 'ffc-academy' ); ?> <span><?php echo esc_html( $score[1] ); ?></span></h3>
					<h3><?php echo esc_html( $score[0] ); ?> <span><?php echo esc_html( $score[2] ); ?></span></h3>
					<time><?php esc_html_e( 'Recent Result', 'ffc-academy' ); ?></time>
					<p><?php echo esc_html( $score[4] ); ?></p>
				</article>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</section>
