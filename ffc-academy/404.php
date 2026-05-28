<?php
get_header();
?>
<main id="primary" class="site-main">
	<section class="page-hero">
		<div class="container">
			<p class="eyebrow"><?php echo esc_html( ffc_option( 'not_found_kicker', __( 'Offside', 'ffc-academy' ) ) ); ?></p>
			<h1><?php echo esc_html( ffc_option( 'not_found_title', __( 'Page Not Found', 'ffc-academy' ) ) ); ?></h1>
			<?php echo ffc_button( ffc_option( 'not_found_button_label', __( 'Return Home', 'ffc-academy' ) ), home_url( '/' ), 'accent' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
	</section>
</main>
<?php
get_footer();
