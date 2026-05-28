<?php
get_header();
?>
<main id="primary" class="site-main">
	<section class="page-hero">
		<div class="container">
			<p class="eyebrow"><?php echo esc_html( ffc_option( 'archive_score_kicker', __( 'Results Center', 'ffc-academy' ) ) ); ?></p>
			<h1><?php echo esc_html( ffc_option( 'archive_score_title', __( 'Scores & Standings', 'ffc-academy' ) ) ); ?></h1>
		</div>
	</section>
	<section class="section section--light">
		<form class="container filters" method="get">
			<?php echo ffc_tax_filter_select( 'ffc_season', 'season', ffc_option( 'filter_season_label', __( 'Season', 'ffc-academy' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php echo ffc_tax_filter_select( 'ffc_team', 'team', ffc_option( 'filter_team_label', __( 'Team', 'ffc-academy' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<label class="filter-label"><span><?php echo esc_html( ffc_option( 'filter_opponent_label', __( 'Opponent', 'ffc-academy' ) ) ); ?></span><input name="opponent" value="<?php echo esc_attr( isset( $_GET['opponent'] ) ? sanitize_text_field( wp_unslash( $_GET['opponent'] ) ) : '' ); ?>"></label>
			<label class="filter-label"><span><?php echo esc_html( ffc_option( 'filter_result_label', __( 'Result', 'ffc-academy' ) ) ); ?></span><select name="result">
				<option value=""><?php echo esc_html( ffc_option( 'filter_all_label', __( 'All', 'ffc-academy' ) ) ); ?></option>
				<?php
				foreach ( array(
					'win'  => ffc_option( 'filter_result_win_label', __( 'Win', 'ffc-academy' ) ),
					'loss' => ffc_option( 'filter_result_loss_label', __( 'Loss', 'ffc-academy' ) ),
					'draw' => ffc_option( 'filter_result_draw_label', __( 'Draw', 'ffc-academy' ) ),
				) as $value => $label ) :
					?>
					<option value="<?php echo esc_attr( $value ); ?>" <?php selected( isset( $_GET['result'] ) ? sanitize_key( wp_unslash( $_GET['result'] ) ) : '', $value ); ?>><?php echo esc_html( $label ); ?></option>
				<?php endforeach; ?>
			</select></label>
			<button type="submit"><?php echo esc_html( ffc_option( 'filter_apply_label', __( 'Apply', 'ffc-academy' ) ) ); ?></button>
			<a class="button button--secondary" href="<?php echo esc_url( get_post_type_archive_link( 'ffc_score' ) ); ?>"><?php echo esc_html( ffc_option( 'filter_reset_label', __( 'Reset', 'ffc-academy' ) ) ); ?></a>
		</form>
		<div class="container score-grid">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					?>
					<?php get_template_part( 'template-parts/card', 'score' ); ?>
					<?php
			endwhile;
				the_posts_pagination(); else :
					?>
				<p class="empty-state"><?php echo esc_html( ffc_option( 'archive_score_empty_message', __( 'Scores and match recaps will appear here.', 'ffc-academy' ) ) ); ?></p>
							<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();
