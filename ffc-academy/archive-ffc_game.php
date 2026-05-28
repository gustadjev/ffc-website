<?php
get_header();
?>
<main id="primary" class="site-main">
	<section class="page-hero">
		<div class="container">
			<p class="eyebrow"><?php esc_html_e( 'Match Calendar', 'ffc-academy' ); ?></p>
			<h1><?php esc_html_e( 'Schedule', 'ffc-academy' ); ?></h1>
		</div>
	</section>
	<section class="section section--light">
		<form class="container filters" method="get">
			<?php echo ffc_tax_filter_select( 'ffc_season', 'season', __( 'Season', 'ffc-academy' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php echo ffc_tax_filter_select( 'ffc_team', 'team', __( 'Team', 'ffc-academy' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<label class="filter-label"><span><?php esc_html_e( 'Opponent', 'ffc-academy' ); ?></span><input name="opponent" value="<?php echo esc_attr( isset( $_GET['opponent'] ) ? sanitize_text_field( wp_unslash( $_GET['opponent'] ) ) : '' ); ?>"></label>
			<button type="submit"><?php esc_html_e( 'Apply', 'ffc-academy' ); ?></button>
			<a class="button button--secondary" href="<?php echo esc_url( get_post_type_archive_link( 'ffc_game' ) ); ?>"><?php esc_html_e( 'Reset', 'ffc-academy' ); ?></a>
		</form>
		<div class="container filters" data-view-switcher>
			<button class="is-active" type="button" data-view="list"><?php esc_html_e( 'List', 'ffc-academy' ); ?></button>
			<button type="button" data-view="calendar"><?php esc_html_e( 'Calendar', 'ffc-academy' ); ?></button>
			<?php echo ffc_teamsnap_button( __( 'TeamSnap Calendar', 'ffc-academy' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
		<?php if ( ffc_teamsnap_embed() ) : ?>
			<div class="container schedule-embed-panel">
				<p class="eyebrow"><?php esc_html_e( 'Live TeamSnap Calendar', 'ffc-academy' ); ?></p>
				<div class="teamsnap-embed"><?php echo ffc_teamsnap_embed(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
			</div>
		<?php endif; ?>
		<div class="container match-grid is-list" data-schedule-view>
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					?>
					<?php get_template_part( 'template-parts/card', 'game' ); ?>
			<?php endwhile; else : ?>
				<p class="empty-state"><?php esc_html_e( 'No scheduled games have been added yet.', 'ffc-academy' ); ?></p>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();
