<?php
/**
 * Contact form fallback handling.
 *
 * @package FFCAcademy
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'template_redirect', 'ffc_handle_contact_form_submission' );
function ffc_handle_contact_form_submission(): void {
	$request_method = isset( $_SERVER['REQUEST_METHOD'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) : '';
	if ( 'POST' !== $request_method || empty( $_POST['ffc_contact_form'] ) ) {
		return;
	}

	$referer = wp_get_referer() ?: home_url( '/contact/' );
	$referer = remove_query_arg( 'ffc_contact_status', $referer );

	if (
		empty( $_POST['ffc_contact_nonce'] )
		|| ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ffc_contact_nonce'] ) ), 'ffc_contact_form' )
		|| ! empty( $_POST['ffc_contact_company'] )
	) {
		wp_safe_redirect( add_query_arg( 'ffc_contact_status', 'error', $referer ) );
		exit;
	}

	$name    = isset( $_POST['ffc_contact_name'] ) ? sanitize_text_field( wp_unslash( $_POST['ffc_contact_name'] ) ) : '';
	$email   = isset( $_POST['ffc_contact_email'] ) ? sanitize_email( wp_unslash( $_POST['ffc_contact_email'] ) ) : '';
	$message = isset( $_POST['ffc_contact_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['ffc_contact_message'] ) ) : '';

	if ( '' === $name || '' === $message || ! is_email( $email ) ) {
		wp_safe_redirect( add_query_arg( 'ffc_contact_status', 'error', $referer ) );
		exit;
	}

	$page_id          = ffc_page_id_by_slug( 'contact' );
	$subject_template = ffc_get_field(
		'contact_email_subject',
		$page_id,
		__( 'New F.F.C. Contact Message: {name}', 'ffc-academy' )
	);
	$subject          = strtr(
		$subject_template,
		array(
			'{name}'  => $name,
			'{email}' => $email,
		)
	);
	$body             = sprintf(
		/* translators: 1: contact name, 2: email address, 3: message. */
		__( "Name: %1\$s\nEmail: %2\$s\n\nMessage:\n%3\$s", 'ffc-academy' ),
		$name,
		$email,
		$message
	);
	$headers          = array( 'Reply-To: ' . $name . ' <' . $email . '>' );

	$sent = wp_mail( get_option( 'admin_email' ), $subject, $body, $headers );

	wp_safe_redirect( add_query_arg( 'ffc_contact_status', $sent ? 'success' : 'error', $referer ) );
	exit;
}
