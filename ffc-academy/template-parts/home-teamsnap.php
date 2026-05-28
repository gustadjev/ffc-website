<?php $home_id = ffc_home_page_id(); ?>
<section class="teamsnap-band">
	<div class="container teamsnap-band__inner">
		<div>
			<p class="eyebrow"><?php echo esc_html( ffc_get_field( 'home_teamsnap_kicker', $home_id, __( 'TeamSnap Hub', 'ffc-academy' ) ) ); ?></p>
			<h2><?php echo esc_html( ffc_get_field( 'home_teamsnap_title', $home_id, __( 'Family Logistics Stay in TeamSnap.', 'ffc-academy' ) ) ); ?></h2>
			<p><?php echo esc_html( ffc_get_field( 'home_teamsnap_copy', $home_id, __( 'The website promotes the academy while TeamSnap handles the live operational details families already use: schedules, rosters, messages, and registration links.', 'ffc-academy' ) ) ); ?></p>
		</div>
		<div class="teamsnap-actions">
			<?php echo ffc_teamsnap_button( ffc_get_field( 'home_teamsnap_button_label', $home_id, __( 'Open TeamSnap', 'ffc-academy' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<a class="button button--light" href="<?php echo esc_url( get_post_type_archive_link( 'ffc_game' ) ); ?>"><?php echo esc_html( ffc_get_field( 'home_teamsnap_schedule_label', $home_id, __( 'Website Schedule', 'ffc-academy' ) ) ); ?></a>
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
