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

function ffc_tryout_session_timestamp( int $session_id ): int {
	return ffc_tryout_datetime_field_timestamp( 'tryout_session_datetime', $session_id );
}

function ffc_tryout_datetime_field_timestamp( string $field_name, int $post_id ): int {
	$date_time = (string) ffc_get_field( $field_name, $post_id, '' );
	if ( '' === $date_time ) {
		return 0;
	}

	$date = DateTimeImmutable::createFromFormat( 'Y-m-d H:i:s', $date_time, wp_timezone() );

	return $date instanceof DateTimeImmutable ? $date->getTimestamp() : 0;
}

function ffc_tryout_registration_opens_timestamp( int $session_id ): int {
	return ffc_tryout_datetime_field_timestamp( 'tryout_registration_opens_at', $session_id );
}

function ffc_tryout_registration_closes_timestamp( int $session_id ): int {
	$closes_at = ffc_tryout_datetime_field_timestamp( 'tryout_registration_closes_at', $session_id );

	return $closes_at ?: ffc_tryout_session_timestamp( $session_id );
}

function ffc_tryout_session_registration_count( int $session_id ): int {
	$registrations = get_posts(
		array(
			'post_type'      => 'ffc_tryout',
			'post_status'    => array( 'private', 'publish', 'pending', 'draft' ),
			'posts_per_page' => -1,
			'fields'         => 'ids',
			'meta_query'     => array(
				array(
					'key'   => 'tryout_session_id',
					'value' => (string) $session_id,
				),
			),
		)
	);

	return count( $registrations );
}

function ffc_tryout_session_has_capacity( int $session_id ): bool {
	$capacity = absint( ffc_get_field( 'tryout_session_capacity', $session_id, 0 ) );

	return 0 === $capacity || ffc_tryout_session_registration_count( $session_id ) < $capacity;
}

function ffc_tryout_session_accepts_registration( int $session_id ): bool {
	$session = get_post( $session_id );
	if ( ! $session instanceof WP_Post || 'ffc_tryout_session' !== $session->post_type || 'publish' !== $session->post_status ) {
		return false;
	}

	$status = (string) ffc_get_field( 'tryout_session_status', $session_id, 'open' );
	if ( 'open' !== $status ) {
		return false;
	}

	$now               = current_datetime()->getTimestamp();
	$session_timestamp = ffc_tryout_session_timestamp( $session_id );
	if ( ! $session_timestamp || $session_timestamp < $now ) {
		return false;
	}

	$opens_at = ffc_tryout_registration_opens_timestamp( $session_id );
	if ( $opens_at && $now < $opens_at ) {
		return false;
	}

	$closes_at = ffc_tryout_registration_closes_timestamp( $session_id );
	if ( $closes_at && $now > $closes_at ) {
		return false;
	}

	return ffc_tryout_session_has_capacity( $session_id );
}

function ffc_tryout_session_label( int $session_id ): string {
	$parts     = array();
	$title     = get_the_title( $session_id );
	$timestamp = ffc_tryout_session_timestamp( $session_id );
	$age_group = (string) ffc_get_field( 'tryout_session_age_group', $session_id, '' );
	$location  = (string) ffc_get_field( 'tryout_session_location', $session_id, '' );

	if ( $title ) {
		$parts[] = $title;
	}
	if ( $timestamp ) {
		$parts[] = wp_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $timestamp );
	}
	if ( $age_group ) {
		$parts[] = $age_group;
	}
	if ( $location ) {
		$parts[] = $location;
	}

	return implode( ' - ', $parts );
}

function ffc_get_open_tryout_sessions(): array {
	$query = new WP_Query(
		array(
			'post_type'      => 'ffc_tryout_session',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'meta_key'       => 'tryout_session_datetime',
			'orderby'        => 'meta_value',
			'order'          => 'ASC',
			'meta_query'     => array(
				array(
					'key'     => 'tryout_session_datetime',
					'value'   => current_datetime()->format( 'Y-m-d H:i:s' ),
					'compare' => '>=',
					'type'    => 'DATETIME',
				),
				array(
					'relation' => 'OR',
					array(
						'key'     => 'tryout_session_status',
						'value'   => 'open',
						'compare' => '=',
					),
					array(
						'key'     => 'tryout_session_status',
						'compare' => 'NOT EXISTS',
					),
				),
			),
		)
	);

	return array_values(
		array_filter(
			$query->posts,
			static function ( WP_Post $session ): bool {
				return ffc_tryout_session_accepts_registration( (int) $session->ID );
			}
		)
	);
}

function ffc_handle_tryout_registration(): void {
	if ( ! isset( $_POST['ffc_tryout_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ffc_tryout_nonce'] ) ), 'ffc_tryout_register' ) ) {
		wp_die( esc_html__( 'Security check failed.', 'ffc-academy' ), esc_html__( 'Forbidden', 'ffc-academy' ), array( 'response' => 403 ) );
	}

	$honeypot = isset( $_POST['website'] ) ? sanitize_text_field( wp_unslash( $_POST['website'] ) ) : '';
	if ( '' !== $honeypot ) {
		wp_safe_redirect( add_query_arg( 'tryout', 'success', wp_get_referer() ?: home_url( '/' ) ) );
		exit;
	}

	$session_id = isset( $_POST['tryout_session_id'] ) ? absint( wp_unslash( $_POST['tryout_session_id'] ) ) : 0;
	if ( ! $session_id || ! ffc_tryout_session_accepts_registration( $session_id ) ) {
		wp_safe_redirect( add_query_arg( 'tryout', 'unavailable', wp_get_referer() ?: home_url( '/tryouts/' ) ) );
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
		'additional_comments',
	);

	$data = array();
	foreach ( $fields as $field ) {
		$value          = isset( $_POST[ $field ] ) ? wp_unslash( $_POST[ $field ] ) : '';
		$data[ $field ] = is_array( $value ) ? '' : sanitize_textarea_field( $value );
	}

	$data['parent_email'] = sanitize_email( $data['parent_email'] );
	$data['tryout_session_id']    = (string) $session_id;
	$data['tryout_session_label'] = ffc_tryout_session_label( $session_id );
	$data['preferred_tryout_date'] = (string) ffc_get_field( 'tryout_session_datetime', $session_id, '' );

	if ( empty( $data['player_first_name'] ) || empty( $data['player_last_name'] ) || empty( $data['parent_email'] ) || ! is_email( $data['parent_email'] ) ) {
		wp_safe_redirect( add_query_arg( 'tryout', 'error', wp_get_referer() ?: home_url( '/' ) ) );
		exit;
	}

	$post_id = wp_insert_post(
		array(
			'post_type'    => 'ffc_tryout',
			'post_status'  => 'private',
			'post_title'   => sprintf( '%s %s - %s', $data['player_first_name'], $data['player_last_name'], $data['tryout_session_label'] ),
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
		'tryout_session_label'  => __( 'Tryout Session', 'ffc-academy' ),
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
		'preferred_tryout_date' => __( 'Session Date/Time', 'ffc-academy' ),
		'additional_comments'   => __( 'Additional Comments', 'ffc-academy' ),
	);

	$lines = array();
	foreach ( $labels as $key => $label ) {
		$editable_label = ffc_get_field( 'tryout_label_' . $key, $tryout_page_id, $label );
		$lines[]        = $editable_label . ': ' . ( $data[ $key ] ?? '' );
	}

	return implode( "\n", $lines );
}
