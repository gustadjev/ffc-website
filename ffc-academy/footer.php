<?php
/**
 * Site footer.
 *
 * @package FFCAcademy
 */

$footer_teamsnap_url = ffc_option( 'teamsnap_public_url' ) ?: ffc_option( 'teamsnap_schedule_url' );
?>
<footer class="site-footer">
	<div class="footer-cta-row">
		<div class="container footer-cta-row__inner">
			<a href="<?php echo esc_url( ffc_option( 'footer_cta_one_url', get_post_type_archive_link( 'ffc_game' ) ) ); ?>"><?php echo esc_html( ffc_option( 'footer_cta_one_label', __( 'Training Locations', 'ffc-academy' ) ) ); ?></a>
			<a href="<?php echo esc_url( ffc_option( 'footer_cta_two_url', ffc_archive_link_by_slug( 'contact', home_url( '/contact/' ) ) ) ); ?>"><?php echo esc_html( ffc_option( 'footer_cta_two_label', __( 'Email Us', 'ffc-academy' ) ) ); ?></a>
		</div>
	</div>
	<div class="container site-footer__top">
		<div class="site-footer__brand">
			<?php echo ffc_logo_markup( 'footer-logo' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<p><?php echo esc_html( ffc_option( 'footer_brand_copy', __( 'Freedom Futbol Club develops young players through disciplined training, family communication, and competitive standards.', 'ffc-academy' ) ) ); ?></p>
			<?php echo ffc_teamsnap_button( ffc_option( 'footer_teamsnap_label', __( 'TeamSnap Access', 'ffc-academy' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>

		<address class="site-footer__contact">
			<h2><?php echo esc_html( ffc_option( 'footer_mailing_label', __( 'Mailing Address', 'ffc-academy' ) ) ); ?></h2>
			<p><?php echo nl2br( esc_html( ffc_option( 'footer_mailing_address', __( "Freedom Futbol Club\nUpdate address in F.F.C. Settings", 'ffc-academy' ) ) ) ); ?></p>
		</address>

		<div class="site-footer__facility">
			<h2><?php echo esc_html( ffc_option( 'footer_training_label', __( 'Training Facility', 'ffc-academy' ) ) ); ?></h2>
			<p><?php echo nl2br( esc_html( ffc_option( 'footer_training_text', __( 'Fields and training locations are shared through TeamSnap.', 'ffc-academy' ) ) ) ); ?></p>
			<h2><?php echo esc_html( ffc_option( 'footer_contact_heading', __( 'Follow F.F.C.', 'ffc-academy' ) ) ); ?></h2>
			<?php echo ffc_social_links_markup( 'social-icons social-icons--footer' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
	</div>
	<div class="site-footer__bottom">
		<p>
			&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>.
			<?php echo esc_html( ffc_option( 'footer_copyright_note', __( 'Powered by TeamSnap-connected club operations.', 'ffc-academy' ) ) ); ?>
			<?php if ( $footer_teamsnap_url ) : ?>
				<a class="site-footer__teamsnap-link" href="<?php echo esc_url( $footer_teamsnap_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'TeamSnap', 'ffc-academy' ); ?></a>
			<?php endif; ?>
		</p>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
