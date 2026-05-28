<?php
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
		<p class="eyebrow"><?php esc_html_e( 'Next Up', 'ffc-academy' ); ?></p>
		<h2><?php esc_html_e( 'Upcoming Matches', 'ffc-academy' ); ?></h2>
		<a href="<?php echo esc_url( get_post_type_archive_link( 'ffc_game' ) ); ?>"><?php esc_html_e( 'Full Schedule', 'ffc-academy' ); ?></a>
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
			<?php
			$fallback_matches = array(
				array( 'Academy Showcase', 'Sat, Jun 8 - 9:00 AM', 'Freedom Training Ground', 'Home' ),
				array( 'Metro Select', 'Sun, Jun 16 - 2:30 PM', 'North Athletic Complex', 'Away' ),
				array( 'Summer Cup Group Stage', 'Fri, Jun 28 - 6:00 PM', 'Championship Fields', 'Neutral' ),
			);
			foreach ( $fallback_matches as $match ) :
				?>
				<article class="match-card reveal">
					<div class="match-card__flag"><?php echo esc_html( $match[3] ); ?></div>
					<h3><?php esc_html_e( 'F.F.C.', 'ffc-academy' ); ?> <span><?php esc_html_e( 'vs', 'ffc-academy' ); ?></span> <?php echo esc_html( $match[0] ); ?></h3>
					<time><?php echo esc_html( $match[1] ); ?></time>
					<p><?php echo esc_html( $match[2] ); ?></p>
					<div class="card-actions"><a href="<?php echo esc_url( get_post_type_archive_link( 'ffc_game' ) ); ?>"><?php esc_html_e( 'Schedule Details', 'ffc-academy' ); ?></a></div>
				</article>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</section>
