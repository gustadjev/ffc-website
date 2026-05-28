<?php
get_header();
?>
<main id="primary" class="site-main">
	<section class="page-hero">
		<div class="container">
			<p class="eyebrow"><?php esc_html_e( 'Offside', 'ffc-academy' ); ?></p>
			<h1><?php esc_html_e( 'Page Not Found', 'ffc-academy' ); ?></h1>
			<?php echo ffc_button( __( 'Return Home', 'ffc-academy' ), home_url( '/' ), 'accent' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
	</section>
</main>
<?php
get_footer();
