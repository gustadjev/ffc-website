<?php
/**
 * Tryout registration handling.
 *
 * @package FFCAcademy
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_post_nopriv_ffc_tryout_register', 'ffc_handle_tryout_registration' );
add_action( 'admin_post_ffc_tryout_register', 'ffc_handle_tryout_registration' );

function ffc_handle_tryout_registration(): void {
	if ( ! isset( $_POST['ffc_tryout_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ffc_tryout_nonce'] ) ), 'ffc_tryout_register' ) ) {
		wp_die( esc_html__( 'Security check failed.', 'ffc-academy' ), esc_html__( 'Forbidden', 'ffc-academy' ), array( 'response' => 403 ) );
	}

	$honeypot = isset( $_POST['website'] ) ? sanitize_text_field( wp_unslash( $_POST['website'] ) ) : '';
	if ( '' !== $honeypot ) {
		wp_safe_redirect( add_query_arg( 'tryout', 'success', wp_get_referer() ?: home_url( '/' ) ) );
		exit;
	}

	$fields = array(
		'player_first_name',
		'player_last_name',
		'date_of_birth',
		'age_group',
		'preferred_position',
		'previous_experience',
		'parent_name',
		'parent_email',
		'parent_phone',
		'emergency_contact',
		'medical_notes',
		'preferred_tryout_date',
		'additional_comments',
	);

	$data = array();
	foreach ( $fields as $field ) {
		$value          = isset( $_POST[ $field ] ) ? wp_unslash( $_POST[ $field ] ) : '';
		$data[ $field ] = is_array( $value ) ? '' : sanitize_textarea_field( $value );
	}

	$data['parent_email'] = sanitize_email( $data['parent_email'] );

	if ( empty( $data['player_first_name'] ) || empty( $data['player_last_name'] ) || empty( $data['parent_email'] ) || ! is_email( $data['parent_email'] ) ) {
		wp_safe_redirect( add_query_arg( 'tryout', 'error', wp_get_referer() ?: home_url( '/' ) ) );
		exit;
	}

	$post_id = wp_insert_post(
		array(
			'post_type'    => 'ffc_tryout',
			'post_status'  => 'private',
			'post_title'   => sprintf( '%s %s - %s', $data['player_first_name'], $data['player_last_name'], current_time( 'mysql' ) ),
			'post_content' => ffc_tryout_summary( $data ),
		)
	);

	if ( is_wp_error( $post_id ) ) {
		wp_safe_redirect( add_query_arg( 'tryout', 'error', wp_get_referer() ?: home_url( '/' ) ) );
		exit;
	}

	foreach ( $data as $key => $value ) {
		update_post_meta( $post_id, $key, $value );
	}

	$admin_email      = get_option( 'admin_email' );
	$tryout_page_id   = ffc_tryout_page_id();
	$subject_template = ffc_get_field( 'tryout_admin_email_subject', $tryout_page_id, __( 'New F.F.C. Tryout Registration: {player_first_name} {player_last_name}', 'ffc-academy' ) );
	$parent_subject   = ffc_get_field( 'tryout_parent_email_subject', $tryout_page_id, __( 'F.F.C. Tryout Registration Received', 'ffc-academy' ) );
	$parent_intro     = ffc_get_field( 'tryout_parent_email_intro', $tryout_page_id, __( 'Thank you for registering with F.F.C. Our staff will review the submission and follow up with next steps.', 'ffc-academy' ) );
	$subject          = ffc_tryout_replace_tokens( $subject_template, $data );
	$message          = ffc_tryout_summary( $data );

	wp_mail( $admin_email, $subject, $message );
	wp_mail(
		$data['parent_email'],
		ffc_tryout_replace_tokens( $parent_subject, $data ),
		ffc_tryout_replace_tokens( $parent_intro, $data ) . "\n\n" . $message
	);

	wp_safe_redirect( add_query_arg( 'tryout', 'success', wp_get_referer() ?: home_url( '/' ) ) );
	exit;
}

function ffc_tryout_replace_tokens( string $text, array $data ): string {
	$tokens = array();

	foreach ( $data as $key => $value ) {
		$tokens[ '{' . $key . '}' ] = $value;
	}

	return strtr( $text, $tokens );
}

function ffc_tryout_summary( array $data ): string {
	$tryout_page_id = ffc_tryout_page_id();
	$labels = array(
		'player_first_name'     => __( 'Player First Name', 'ffc-academy' ),
		'player_last_name'      => __( 'Player Last Name', 'ffc-academy' ),
		'date_of_birth'         => __( 'Date of Birth', 'ffc-academy' ),
		'age_group'             => __( 'Age Group', 'ffc-academy' ),
		'preferred_position'    => __( 'Preferred Position', 'ffc-academy' ),
		'previous_experience'   => __( 'Previous Experience', 'ffc-academy' ),
		'parent_name'           => __( 'Parent/Guardian Name', 'ffc-academy' ),
		'parent_email'          => __( 'Parent/Guardian Email', 'ffc-academy' ),
		'parent_phone'          => __( 'Parent/Guardian Phone', 'ffc-academy' ),
		'emergency_contact'     => __( 'Emergency Contact', 'ffc-academy' ),
		'medical_notes'         => __( 'Medical Notes', 'ffc-academy' ),
		'preferred_tryout_date' => __( 'Preferred Tryout Date', 'ffc-academy' ),
		'additional_comments'   => __( 'Additional Comments', 'ffc-academy' ),
	);

	$lines = array();
	foreach ( $labels as $key => $label ) {
		$editable_label = ffc_get_field( 'tryout_label_' . $key, $tryout_page_id, $label );
		$lines[]        = $editable_label . ': ' . ( $data[ $key ] ?? '' );
	}

	return implode( "\n", $lines );
}
