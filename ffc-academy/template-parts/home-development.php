<?php $home_id = ffc_home_page_id(); ?>
<section class="development-section">
	<div class="container development-grid">
		<div class="development-media reveal">
			<?php $development_image = ffc_image_url_from_field( ffc_get_field( 'home_development_image', $home_id ), 'ffc-hero', ffc_theme_image( 'training' ) ); ?>
			<img src="<?php echo esc_url( $development_image ); ?>" alt="<?php echo esc_attr( ffc_get_field( 'home_development_image_alt', $home_id, __( 'Youth soccer training session', 'ffc-academy' ) ) ); ?>" loading="lazy">
		</div>
		<div class="development-copy">
			<p class="eyebrow"><?php echo esc_html( ffc_get_field( 'home_development_kicker', $home_id, __( 'Player Development Model', 'ffc-academy' ) ) ); ?></p>
			<h2><?php echo esc_html( ffc_get_field( 'home_development_title', $home_id, __( 'Training With Standards, Care, and Competitive Intent.', 'ffc-academy' ) ) ); ?></h2>
			<div class="development-list">
				<div><strong><?php echo esc_html( ffc_get_field( 'home_development_item_1_title', $home_id, __( 'Technical Identity', 'ffc-academy' ) ) ); ?></strong><span><?php echo esc_html( ffc_get_field( 'home_development_item_1_copy', $home_id, __( 'First touch, passing detail, finishing, defending habits.', 'ffc-academy' ) ) ); ?></span></div>
				<div><strong><?php echo esc_html( ffc_get_field( 'home_development_item_2_title', $home_id, __( 'Game Intelligence', 'ffc-academy' ) ) ); ?></strong><span><?php echo esc_html( ffc_get_field( 'home_development_item_2_copy', $home_id, __( 'Scanning, spacing, decision speed, and pressure recognition.', 'ffc-academy' ) ) ); ?></span></div>
				<div><strong><?php echo esc_html( ffc_get_field( 'home_development_item_3_title', $home_id, __( 'Character Growth', 'ffc-academy' ) ) ); ?></strong><span><?php echo esc_html( ffc_get_field( 'home_development_item_3_copy', $home_id, __( 'Resilience, leadership, accountability, and team responsibility.', 'ffc-academy' ) ) ); ?></span></div>
			</div>
		</div>
	</div>
</section>
