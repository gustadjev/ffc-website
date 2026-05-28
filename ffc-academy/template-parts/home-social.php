<section class="social-band">
	<div class="container social-band__inner">
		<div>
			<p class="eyebrow"><?php esc_html_e( 'Follow the Phoenix', 'ffc-academy' ); ?></p>
			<h2><?php esc_html_e( 'Matchday Moments, Training Clips, and Club Updates', 'ffc-academy' ); ?></h2>
		</div>
		<div class="social-links social-links--large">
			<?php foreach ( array( 'instagram' => 'Instagram', 'facebook' => 'Facebook', 'youtube' => 'YouTube', 'tiktok' => 'TikTok' ) as $key => $label ) : ?>
				<?php $url = ffc_option( $key . '_url' ); ?>
				<?php if ( $url ) : ?>
					<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $label ); ?></a>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
