<?php
get_header();
?>
<main id="primary" class="site-main">
	<section class="page-hero">
		<div class="container">
			<p class="eyebrow"><?php echo esc_html( ffc_option( 'archive_game_kicker', __( 'Match Calendar', 'ffc-academy' ) ) ); ?></p>
			<h1><?php echo esc_html( ffc_option( 'archive_game_title', __( 'Schedule', 'ffc-academy' ) ) ); ?></h1>
		</div>
	</section>
	<section class="section section--light">
		<form class="container filters" method="get">
			<?php echo ffc_tax_filter_select( 'ffc_season', 'season', ffc_option( 'filter_season_label', __( 'Season', 'ffc-academy' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php echo ffc_tax_filter_select( 'ffc_team', 'team', ffc_option( 'filter_team_label', __( 'Team', 'ffc-academy' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<label class="filter-label"><span><?php echo esc_html( ffc_option( 'filter_opponent_label', __( 'Opponent', 'ffc-academy' ) ) ); ?></span><input name="opponent" value="<?php echo esc_attr( isset( $_GET['opponent'] ) ? sanitize_text_field( wp_unslash( $_GET['opponent'] ) ) : '' ); ?>"></label>
			<button type="submit"><?php echo esc_html( ffc_option( 'filter_apply_label', __( 'Apply', 'ffc-academy' ) ) ); ?></button>
			<a class="button button--secondary" href="<?php echo esc_url( get_post_type_archive_link( 'ffc_game' ) ); ?>"><?php echo esc_html( ffc_option( 'filter_reset_label', __( 'Reset', 'ffc-academy' ) ) ); ?></a>
		</form>
		<div class="container filters" data-view-switcher>
			<button class="is-active" type="button" data-view="list"><?php echo esc_html( ffc_option( 'schedule_list_label', __( 'List', 'ffc-academy' ) ) ); ?></button>
			<button type="button" data-view="calendar"><?php echo esc_html( ffc_option( 'schedule_calendar_label', __( 'Calendar', 'ffc-academy' ) ) ); ?></button>
			<?php echo ffc_teamsnap_button( ffc_option( 'teamsnap_calendar_button_label', __( 'TeamSnap Calendar', 'ffc-academy' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
		<?php if ( ffc_teamsnap_embed() ) : ?>
			<div class="container schedule-embed-panel">
				<p class="eyebrow"><?php echo esc_html( ffc_option( 'archive_game_embed_kicker', __( 'Live TeamSnap Calendar', 'ffc-academy' ) ) ); ?></p>
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
				<p class="empty-state"><?php echo esc_html( ffc_option( 'archive_game_empty_message', __( 'No scheduled games have been added yet.', 'ffc-academy' ) ) ); ?></p>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();
