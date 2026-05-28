<?php
$home_id     = ffc_home_page_id();
$tryout_url  = ffc_option( 'tryout_page_url', ffc_archive_link_by_slug( 'tryouts', home_url( '/tryouts/' ) ) );
$tryout_image = ffc_image_url_from_field( ffc_get_field( 'home_tryout_image', $home_id ), 'ffc-hero', ffc_theme_image( 'match' ) );
?>
<section class="tryout-cta" style="--cta-image:url('<?php echo esc_url( $tryout_image ); ?>')">
	<div class="container tryout-cta__inner">
		<div>
			<p class="eyebrow"><?php echo esc_html( ffc_get_field( 'home_tryout_kicker', $home_id, __( 'Player Evaluations', 'ffc-academy' ) ) ); ?></p>
			<h2><?php echo esc_html( ffc_get_field( 'home_tryout_title', $home_id, __( 'Ready to Compete for a Place at F.F.C.?', 'ffc-academy' ) ) ); ?></h2>
			<p><?php echo esc_html( ffc_get_field( 'home_tryout_copy', $home_id, __( 'Register for tryouts and our staff will follow up with age-group placement, evaluation timing, and next steps.', 'ffc-academy' ) ) ); ?></p>
		</div>
		<?php echo ffc_button( ffc_get_field( 'home_tryout_button_label', $home_id, __( 'Start Registration', 'ffc-academy' ) ), $tryout_url, 'accent' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
</section>
