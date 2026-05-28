<section class="teamsnap-band">
	<div class="container teamsnap-band__inner">
		<div>
			<p class="eyebrow"><?php esc_html_e( 'TeamSnap Hub', 'ffc-academy' ); ?></p>
			<h2><?php esc_html_e( 'Family Logistics Stay in TeamSnap.', 'ffc-academy' ); ?></h2>
			<p><?php esc_html_e( 'The website promotes the academy while TeamSnap handles the live operational details families already use: schedules, rosters, messages, and registration links.', 'ffc-academy' ); ?></p>
		</div>
		<div class="teamsnap-actions">
			<?php echo ffc_teamsnap_button( __( 'Open TeamSnap', 'ffc-academy' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<a class="button button--light" href="<?php echo esc_url( get_post_type_archive_link( 'ffc_game' ) ); ?>"><?php esc_html_e( 'Website Schedule', 'ffc-academy' ); ?></a>
		</div>
	</div>
	<div class="container teamsnap-panel">
		<?php $embed = ffc_teamsnap_embed(); ?>
		<?php if ( $embed ) : ?>
			<div class="teamsnap-embed"><?php echo $embed; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
		<?php else : ?>
			<?php echo ffc_teamsnap_links_markup(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<?php endif; ?>
	</div>
</section>
