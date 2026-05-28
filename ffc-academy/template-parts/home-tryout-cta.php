<?php $tryout_url = ffc_option( 'tryout_page_url', ffc_archive_link_by_slug( 'tryouts', home_url( '/tryouts/' ) ) ); ?>
<section class="tryout-cta" style="--cta-image:url('<?php echo esc_url( ffc_theme_image( 'match' ) ); ?>')">
	<div class="container tryout-cta__inner">
		<div>
			<p class="eyebrow"><?php echo esc_html( ffc_get_field( 'home_tryout_kicker', get_option( 'page_on_front' ), __( 'Player Evaluations', 'ffc-academy' ) ) ); ?></p>
			<h2><?php echo esc_html( ffc_get_field( 'home_tryout_title', get_option( 'page_on_front' ), __( 'Ready to Compete for a Place at F.F.C.?', 'ffc-academy' ) ) ); ?></h2>
			<p><?php echo esc_html( ffc_get_field( 'home_tryout_copy', get_option( 'page_on_front' ), __( 'Register for tryouts and our staff will follow up with age-group placement, evaluation timing, and next steps.', 'ffc-academy' ) ) ); ?></p>
		</div>
		<?php echo ffc_button( ffc_get_field( 'home_tryout_button_label', get_option( 'page_on_front' ), __( 'Start Registration', 'ffc-academy' ) ), $tryout_url, 'accent' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
</section>
