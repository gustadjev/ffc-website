<?php
get_header();
?>
<main id="primary" class="site-main">
	<section class="page-hero">
		<div class="container">
			<p class="eyebrow"><?php esc_html_e( 'Results Center', 'ffc-academy' ); ?></p>
			<h1><?php esc_html_e( 'Scores & Standings', 'ffc-academy' ); ?></h1>
		</div>
	</section>
	<section class="section section--light">
		<form class="container filters" method="get">
			<?php echo ffc_tax_filter_select( 'ffc_season', 'season', __( 'Season', 'ffc-academy' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php echo ffc_tax_filter_select( 'ffc_team', 'team', __( 'Team', 'ffc-academy' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<label class="filter-label"><span><?php esc_html_e( 'Opponent', 'ffc-academy' ); ?></span><input name="opponent" value="<?php echo esc_attr( isset( $_GET['opponent'] ) ? sanitize_text_field( wp_unslash( $_GET['opponent'] ) ) : '' ); ?>"></label>
			<label class="filter-label"><span><?php esc_html_e( 'Result', 'ffc-academy' ); ?></span><select name="result">
				<option value=""><?php esc_html_e( 'All', 'ffc-academy' ); ?></option>
				<?php foreach ( array( 'win' => 'Win', 'loss' => 'Loss', 'draw' => 'Draw' ) as $value => $label ) : ?>
					<option value="<?php echo esc_attr( $value ); ?>" <?php selected( isset( $_GET['result'] ) ? sanitize_key( wp_unslash( $_GET['result'] ) ) : '', $value ); ?>><?php echo esc_html( $label ); ?></option>
				<?php endforeach; ?>
			</select></label>
			<button type="submit"><?php esc_html_e( 'Apply', 'ffc-academy' ); ?></button>
			<a class="button button--secondary" href="<?php echo esc_url( get_post_type_archive_link( 'ffc_score' ) ); ?>"><?php esc_html_e( 'Reset', 'ffc-academy' ); ?></a>
		</form>
		<div class="container score-grid">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/card', 'score' ); ?>
			<?php endwhile; the_posts_pagination(); else : ?>
				<p class="empty-state"><?php esc_html_e( 'Scores and match recaps will appear here.', 'ffc-academy' ); ?></p>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();
