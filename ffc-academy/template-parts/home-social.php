<?php $home_id = ffc_home_page_id(); ?>
<section class="social-band">
	<div class="container social-band__inner">
		<div>
			<p class="eyebrow"><?php echo esc_html( ffc_get_field( 'home_social_kicker', $home_id, __( 'Follow the Phoenix', 'ffc-academy' ) ) ); ?></p>
			<h2><?php echo esc_html( ffc_get_field( 'home_social_title', $home_id, __( 'Matchday Moments, Training Clips, and Club Updates', 'ffc-academy' ) ) ); ?></h2>
		</div>
		<?php echo ffc_social_links_markup( 'social-icons social-icons--large', true ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
</section>
