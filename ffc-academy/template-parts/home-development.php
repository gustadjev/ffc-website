<section class="development-section">
	<div class="container development-grid">
		<div class="development-media reveal">
			<?php $development_image = ffc_image_url_from_field( ffc_get_field( 'home_development_image', get_option( 'page_on_front' ) ), 'ffc-hero', ffc_theme_image( 'training' ) ); ?>
			<img src="<?php echo esc_url( $development_image ); ?>" alt="<?php esc_attr_e( 'Youth soccer training session', 'ffc-academy' ); ?>" loading="lazy">
		</div>
		<div class="development-copy">
			<p class="eyebrow"><?php echo esc_html( ffc_get_field( 'home_development_kicker', get_option( 'page_on_front' ), __( 'Player Development Model', 'ffc-academy' ) ) ); ?></p>
			<h2><?php echo esc_html( ffc_get_field( 'home_development_title', get_option( 'page_on_front' ), __( 'Training With Standards, Care, and Competitive Intent.', 'ffc-academy' ) ) ); ?></h2>
			<div class="development-list">
				<div><strong><?php esc_html_e( 'Technical Identity', 'ffc-academy' ); ?></strong><span><?php esc_html_e( 'First touch, passing detail, finishing, defending habits.', 'ffc-academy' ); ?></span></div>
				<div><strong><?php esc_html_e( 'Game Intelligence', 'ffc-academy' ); ?></strong><span><?php esc_html_e( 'Scanning, spacing, decision speed, and pressure recognition.', 'ffc-academy' ); ?></span></div>
				<div><strong><?php esc_html_e( 'Character Growth', 'ffc-academy' ); ?></strong><span><?php esc_html_e( 'Resilience, leadership, accountability, and team responsibility.', 'ffc-academy' ); ?></span></div>
			</div>
		</div>
	</div>
</section>
