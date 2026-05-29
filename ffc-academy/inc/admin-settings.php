<?php
/**
 * Native settings for global editable theme content.
 *
 * @package FFCAcademy
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ffc_native_settings_fields(): array {
	$fields = array(
		'tryout_page_url'           => array(
			'label' => __( 'Tryout Page URL', 'ffc-academy' ),
			'type'  => 'url',
		),
		'utility_bar_text'          => array(
			'label' => __( 'Top Bar Text', 'ffc-academy' ),
			'type'  => 'text',
		),
		'utility_tryouts_label'     => array(
			'label' => __( 'Top Bar Tryouts Label', 'ffc-academy' ),
			'type'  => 'text',
		),
		'utility_schedule_label'    => array(
			'label' => __( 'Top Bar Schedule Label', 'ffc-academy' ),
			'type'  => 'text',
		),
		'utility_teamsnap_label'    => array(
			'label' => __( 'Top Bar TeamSnap Label', 'ffc-academy' ),
			'type'  => 'text',
		),
		'header_cta_label'          => array(
			'label' => __( 'Header CTA Label', 'ffc-academy' ),
			'type'  => 'text',
		),
		'footer_cta_one_label'      => array(
			'label' => __( 'Footer CTA 1 Label', 'ffc-academy' ),
			'type'  => 'text',
		),
		'footer_cta_one_url'        => array(
			'label' => __( 'Footer CTA 1 URL', 'ffc-academy' ),
			'type'  => 'url',
		),
		'footer_cta_two_label'      => array(
			'label' => __( 'Footer CTA 2 Label', 'ffc-academy' ),
			'type'  => 'text',
		),
		'footer_cta_two_url'        => array(
			'label' => __( 'Footer CTA 2 URL', 'ffc-academy' ),
			'type'  => 'url',
		),
		'footer_brand_copy'         => array(
			'label' => __( 'Footer Brand Copy', 'ffc-academy' ),
			'type'  => 'textarea',
		),
		'footer_teamsnap_label'     => array(
			'label' => __( 'Footer TeamSnap Label', 'ffc-academy' ),
			'type'  => 'text',
		),
		'footer_contact_heading'    => array(
			'label' => __( 'Footer Contact Heading', 'ffc-academy' ),
			'type'  => 'text',
		),
		'footer_mailing_label'      => array(
			'label' => __( 'Footer Mailing Label', 'ffc-academy' ),
			'type'  => 'text',
		),
		'footer_mailing_address'    => array(
			'label' => __( 'Footer Mailing Address', 'ffc-academy' ),
			'type'  => 'textarea',
		),
		'footer_training_label'     => array(
			'label' => __( 'Footer Training Label', 'ffc-academy' ),
			'type'  => 'text',
		),
		'footer_training_text'      => array(
			'label' => __( 'Footer Training Text', 'ffc-academy' ),
			'type'  => 'textarea',
		),
		'footer_copyright_note'     => array(
			'label' => __( 'Footer Copyright Note', 'ffc-academy' ),
			'type'  => 'text',
		),
		'footer_copyright_text'     => array(
			'label'       => __( 'Footer Copyright Text', 'ffc-academy' ),
			'type'        => 'textarea',
			'default'     => __( '@2026 freedomfutbolclub. All rights reserved | Webiste by Bpsquare - Powered by TeamSnap', 'ffc-academy' ),
			'description' => __( 'Optional tokens: {year}, {site_name}, {brand_name}, {brand_short_name}, and {note}. Saved text renders directly in the footer.', 'ffc-academy' ),
		),
		'teamsnap_public_url'       => array(
			'label' => __( 'TeamSnap Main Team URL', 'ffc-academy' ),
			'type'  => 'url',
		),
		'teamsnap_schedule_url'     => array(
			'label' => __( 'TeamSnap Schedule URL', 'ffc-academy' ),
			'type'  => 'url',
		),
		'teamsnap_roster_url'       => array(
			'label' => __( 'TeamSnap Roster URL', 'ffc-academy' ),
			'type'  => 'url',
		),
		'teamsnap_registration_url' => array(
			'label' => __( 'TeamSnap Registration URL', 'ffc-academy' ),
			'type'  => 'url',
		),
		'teamsnap_app_url'          => array(
			'label' => __( 'TeamSnap App / Login URL', 'ffc-academy' ),
			'type'  => 'url',
		),
		'teamsnap_embed_code'       => array(
			'label'       => __( 'TeamSnap Embed Code', 'ffc-academy' ),
			'type'        => 'textarea',
			'description' => __( 'Paste a TeamSnap iframe/widget embed code. If left blank, the website shows TeamSnap link cards instead.', 'ffc-academy' ),
		),
		'turnstile_site_key'        => array(
			'label'       => __( 'Cloudflare Turnstile Site Key', 'ffc-academy' ),
			'type'        => 'text',
			'description' => __( 'Optional. Add both Turnstile keys to protect the tryout form and built-in contact form from spam.', 'ffc-academy' ),
		),
		'turnstile_secret_key'      => array(
			'label'       => __( 'Cloudflare Turnstile Secret Key', 'ffc-academy' ),
			'type'        => 'password',
			'description' => __( 'Stored as a WordPress option. Leave blank to disable Turnstile.', 'ffc-academy' ),
		),
		'instagram_url'             => array(
			'label' => __( 'Instagram URL', 'ffc-academy' ),
			'type'  => 'url',
		),
		'facebook_url'              => array(
			'label' => __( 'Facebook URL', 'ffc-academy' ),
			'type'  => 'url',
		),
		'youtube_url'               => array(
			'label' => __( 'YouTube URL', 'ffc-academy' ),
			'type'  => 'url',
		),
		'tiktok_url'                => array(
			'label' => __( 'TikTok URL', 'ffc-academy' ),
			'type'  => 'url',
		),
	);

	foreach ( ffc_global_display_settings() as $key => $setting ) {
		$fields[ $key ] = array(
			'label'       => $setting['label'],
			'type'        => $setting['type'] ?? 'text',
			'default'     => $setting['default'] ?? '',
			'description' => $setting['description'] ?? '',
		);
	}

	return $fields;
}

add_action( 'admin_menu', 'ffc_register_native_settings_page' );
function ffc_register_native_settings_page(): void {
	add_options_page(
		__( 'F.F.C. Settings', 'ffc-academy' ),
		__( 'F.F.C. Settings', 'ffc-academy' ),
		'manage_options',
		'ffc-theme-settings',
		'ffc_render_native_settings_page'
	);
}

add_action( 'admin_init', 'ffc_register_native_settings' );
function ffc_register_native_settings(): void {
	foreach ( ffc_native_settings_fields() as $key => $field ) {
		register_setting(
			'ffc_native_settings',
			'ffc_' . $key,
			array(
				'type'              => 'string',
				'sanitize_callback' => 'url' === $field['type'] ? 'esc_url_raw' : 'sanitize_textarea_field',
				'default'           => $field['default'] ?? '',
			)
		);
	}
}

add_action( 'admin_post_ffc_send_test_emails', 'ffc_send_test_emails' );
function ffc_send_test_emails(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have permission to send test emails.', 'ffc-academy' ), esc_html__( 'Forbidden', 'ffc-academy' ), array( 'response' => 403 ) );
	}

	check_admin_referer( 'ffc_send_test_emails', 'ffc_email_test_nonce' );

	$recipient = isset( $_POST['ffc_test_email_recipient'] ) ? sanitize_email( wp_unslash( $_POST['ffc_test_email_recipient'] ) ) : get_option( 'admin_email' );
	$status    = 'error';

	if ( is_email( $recipient ) ) {
		$brand   = ffc_brand_name();
		$samples = array(
			sprintf(
				/* translators: %s: brand name. */
				__( '%s test: tryout admin notification', 'ffc-academy' ),
				$brand
			) => __( "This confirms that admin tryout notification emails can be sent from the F.F.C. theme.\n\nIf this landed in spam, configure an SMTP or transactional mail plugin before launch.", 'ffc-academy' ),
			sprintf(
				/* translators: %s: brand name. */
				__( '%s test: parent confirmation', 'ffc-academy' ),
				$brand
			) => __( "This confirms that parent confirmation emails can be sent from the F.F.C. theme.\n\nUse this test after configuring WP Mail SMTP or another authenticated sender.", 'ffc-academy' ),
			sprintf(
				/* translators: %s: brand name. */
				__( '%s test: contact form notification', 'ffc-academy' ),
				$brand
			) => __( "This confirms that the built-in contact form notification can be sent from the F.F.C. theme.\n\nReply-To behavior should be tested with a real contact form submission before launch.", 'ffc-academy' ),
		);

		$sent_all = true;
		foreach ( $samples as $subject => $message ) {
			if ( ! wp_mail( $recipient, $subject, $message ) ) {
				$sent_all = false;
			}
		}

		$status = $sent_all ? 'success' : 'error';
	}

	wp_safe_redirect(
		add_query_arg(
			array(
				'page'           => 'ffc-theme-settings',
				'ffc_email_test' => $status,
			),
			admin_url( 'options-general.php' )
		)
	);
	exit;
}

function ffc_render_native_settings_page(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$email_test_status = isset( $_GET['ffc_email_test'] ) ? sanitize_key( wp_unslash( $_GET['ffc_email_test'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'F.F.C. Settings', 'ffc-academy' ); ?></h1>
		<p><?php esc_html_e( 'Manage global club links, TeamSnap embeds, social links, header labels, and footer content.', 'ffc-academy' ); ?></p>
		<?php if ( 'success' === $email_test_status ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Test emails were handed to WordPress successfully. Confirm delivery in the inbox and spam folder.', 'ffc-academy' ); ?></p></div>
		<?php elseif ( 'error' === $email_test_status ) : ?>
			<div class="notice notice-error is-dismissible"><p><?php esc_html_e( 'The test email could not be sent. Confirm the recipient address and SMTP/transactional email configuration.', 'ffc-academy' ); ?></p></div>
		<?php endif; ?>
		<form method="post" action="options.php">
			<?php settings_fields( 'ffc_native_settings' ); ?>
			<table class="form-table" role="presentation">
				<tbody>
					<?php foreach ( ffc_native_settings_fields() as $key => $field ) : ?>
						<?php $value = get_option( 'ffc_' . $key, $field['default'] ?? '' ); ?>
						<tr>
							<th scope="row"><label for="ffc_<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $field['label'] ); ?></label></th>
							<td>
								<?php if ( 'textarea' === $field['type'] ) : ?>
									<textarea class="large-text" rows="4" id="ffc_<?php echo esc_attr( $key ); ?>" name="ffc_<?php echo esc_attr( $key ); ?>"><?php echo esc_textarea( $value ); ?></textarea>
								<?php else : ?>
									<input class="regular-text" type="<?php echo esc_attr( $field['type'] ); ?>" id="ffc_<?php echo esc_attr( $key ); ?>" name="ffc_<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $value ); ?>">
								<?php endif; ?>
								<?php if ( ! empty( $field['description'] ) ) : ?>
									<p class="description"><?php echo esc_html( $field['description'] ); ?></p>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php submit_button(); ?>
		</form>
		<hr>
		<h2><?php esc_html_e( 'Email Deliverability Test', 'ffc-academy' ); ?></h2>
		<p><?php esc_html_e( 'Send sample tryout, parent confirmation, and contact-form emails after SMTP is configured. WordPress can report a successful handoff even when a host later blocks delivery, so always confirm the messages arrive.', 'ffc-academy' ); ?></p>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="ffc_send_test_emails">
			<?php wp_nonce_field( 'ffc_send_test_emails', 'ffc_email_test_nonce' ); ?>
			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th scope="row"><label for="ffc_test_email_recipient"><?php esc_html_e( 'Test Recipient', 'ffc-academy' ); ?></label></th>
						<td><input class="regular-text" id="ffc_test_email_recipient" name="ffc_test_email_recipient" type="email" value="<?php echo esc_attr( get_option( 'admin_email' ) ); ?>"></td>
					</tr>
				</tbody>
			</table>
			<?php submit_button( __( 'Send Test Emails', 'ffc-academy' ), 'secondary', 'submit', false ); ?>
		</form>
	</div>
	<?php
}
