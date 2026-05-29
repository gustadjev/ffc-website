<?php
/**
 * Optional spam protection helpers.
 *
 * @package FFCAcademy
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', 'ffc_enqueue_turnstile_script' );
function ffc_enqueue_turnstile_script(): void {
	if ( ! ffc_turnstile_enabled() ) {
		return;
	}

	wp_enqueue_script(
		'ffc-turnstile',
		'https://challenges.cloudflare.com/turnstile/v0/api.js',
		array(),
		null,
		true
	);
	wp_script_add_data( 'ffc-turnstile', 'strategy', 'defer' );
}

function ffc_turnstile_enabled(): bool {
	return '' !== ffc_turnstile_site_key() && '' !== ffc_turnstile_secret_key();
}

function ffc_turnstile_site_key(): string {
	return trim( (string) ffc_option( 'turnstile_site_key', '' ) );
}

function ffc_turnstile_secret_key(): string {
	return trim( (string) ffc_option( 'turnstile_secret_key', '' ) );
}

function ffc_turnstile_markup(): string {
	if ( ! ffc_turnstile_enabled() ) {
		return '';
	}

	return sprintf(
		'<div class="ffc-turnstile cf-turnstile" data-sitekey="%s"></div>',
		esc_attr( ffc_turnstile_site_key() )
	);
}

function ffc_verify_turnstile_response(): bool {
	if ( ! ffc_turnstile_enabled() ) {
		return true;
	}

	$response_token = isset( $_POST['cf-turnstile-response'] ) ? sanitize_text_field( wp_unslash( $_POST['cf-turnstile-response'] ) ) : '';
	if ( '' === $response_token ) {
		return false;
	}

	$remote_ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$body      = array_filter(
		array(
			'secret'   => ffc_turnstile_secret_key(),
			'response' => $response_token,
			'remoteip' => $remote_ip,
		)
	);

	$verification = wp_remote_post(
		'https://challenges.cloudflare.com/turnstile/v0/siteverify',
		array(
			'timeout' => 10,
			'body'    => $body,
		)
	);

	if ( is_wp_error( $verification ) || 200 !== wp_remote_retrieve_response_code( $verification ) ) {
		return false;
	}

	$result = json_decode( wp_remote_retrieve_body( $verification ), true );

	return is_array( $result ) && ! empty( $result['success'] );
}
