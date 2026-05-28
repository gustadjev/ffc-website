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

	$post_id = wp_insert_post( array(
		'post_type'   => 'ffc_tryout',
		'post_status' => 'private',
		'post_title'  => sprintf( '%s %s - %s', $data['player_first_name'], $data['player_last_name'], current_time( 'mysql' ) ),
		'post_content'=> ffc_tryout_summary( $data ),
	) );

	if ( is_wp_error( $post_id ) ) {
		wp_safe_redirect( add_query_arg( 'tryout', 'error', wp_get_referer() ?: home_url( '/' ) ) );
		exit;
	}

	foreach ( $data as $key => $value ) {
		update_post_meta( $post_id, $key, $value );
	}

	$admin_email = get_option( 'admin_email' );
	$subject     = sprintf( __( 'New F.F.C. Tryout Registration: %s %s', 'ffc-academy' ), $data['player_first_name'], $data['player_last_name'] );
	$message     = ffc_tryout_summary( $data );

	wp_mail( $admin_email, $subject, $message );
	wp_mail(
		$data['parent_email'],
		__( 'F.F.C. Tryout Registration Received', 'ffc-academy' ),
		__( "Thank you for registering with F.F.C. Our staff will review the submission and follow up with next steps.\n\n", 'ffc-academy' ) . $message
	);

	wp_safe_redirect( add_query_arg( 'tryout', 'success', wp_get_referer() ?: home_url( '/' ) ) );
	exit;
}

function ffc_tryout_summary( array $data ): string {
	$labels = array(
		'player_first_name'     => 'Player First Name',
		'player_last_name'      => 'Player Last Name',
		'date_of_birth'         => 'Date of Birth',
		'age_group'             => 'Age Group',
		'preferred_position'    => 'Preferred Position',
		'previous_experience'   => 'Previous Experience',
		'parent_name'           => 'Parent/Guardian',
		'parent_email'          => 'Parent Email',
		'parent_phone'          => 'Parent Phone',
		'emergency_contact'     => 'Emergency Contact',
		'medical_notes'         => 'Medical Notes',
		'preferred_tryout_date' => 'Preferred Tryout Date',
		'additional_comments'   => 'Additional Comments',
	);

	$lines = array();
	foreach ( $labels as $key => $label ) {
		$lines[] = $label . ': ' . ( $data[ $key ] ?? '' );
	}

	return implode( "\n", $lines );
}
