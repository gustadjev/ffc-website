<?php
/**
 * Admin list table columns for operational content.
 *
 * @package FFCAcademy
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'manage_ffc_tryout_session_posts_columns', 'ffc_tryout_session_admin_columns' );
function ffc_tryout_session_admin_columns( array $columns ): array {
	return array(
		'cb'                  => $columns['cb'] ?? '<input type="checkbox">',
		'title'               => $columns['title'] ?? __( 'Title', 'ffc-academy' ),
		'session_datetime'    => __( 'Session Date/Time', 'ffc-academy' ),
		'registration_window' => __( 'Registration Window', 'ffc-academy' ),
		'session_status'      => __( 'Status', 'ffc-academy' ),
		'session_capacity'    => __( 'Capacity', 'ffc-academy' ),
		'session_registered'  => __( 'Registered', 'ffc-academy' ),
		'session_accepting'   => __( 'Accepting?', 'ffc-academy' ),
		'date'                => $columns['date'] ?? __( 'Date', 'ffc-academy' ),
	);
}

add_filter( 'manage_ffc_game_posts_columns', 'ffc_game_admin_columns' );
function ffc_game_admin_columns( array $columns ): array {
	return array(
		'cb'            => $columns['cb'] ?? '<input type="checkbox">',
		'title'         => $columns['title'] ?? __( 'Game', 'ffc-academy' ),
		'game_datetime' => __( 'Game Date/Time', 'ffc-academy' ),
		'game_opponent' => __( 'Opponent', 'ffc-academy' ),
		'game_location' => __( 'Location', 'ffc-academy' ),
		'game_homeaway' => __( 'Home/Away', 'ffc-academy' ),
		'date'          => $columns['date'] ?? __( 'Published', 'ffc-academy' ),
	);
}

add_filter( 'manage_ffc_score_posts_columns', 'ffc_score_admin_columns' );
function ffc_score_admin_columns( array $columns ): array {
	return array(
		'cb'             => $columns['cb'] ?? '<input type="checkbox">',
		'title'          => $columns['title'] ?? __( 'Score', 'ffc-academy' ),
		'score_datetime' => __( 'Game Date/Time', 'ffc-academy' ),
		'score_opponent' => __( 'Opponent', 'ffc-academy' ),
		'score_result'   => __( 'Result', 'ffc-academy' ),
		'score_final'    => __( 'Final Score', 'ffc-academy' ),
		'date'           => $columns['date'] ?? __( 'Published', 'ffc-academy' ),
	);
}

add_filter( 'manage_ffc_coach_posts_columns', 'ffc_coach_admin_columns' );
function ffc_coach_admin_columns( array $columns ): array {
	return array(
		'cb'          => $columns['cb'] ?? '<input type="checkbox">',
		'title'       => $columns['title'] ?? __( 'Coach', 'ffc-academy' ),
		'coach_role'  => __( 'Role / Title', 'ffc-academy' ),
		'coach_email' => __( 'Contact Email', 'ffc-academy' ),
		'date'        => $columns['date'] ?? __( 'Published', 'ffc-academy' ),
	);
}

add_filter( 'manage_ffc_sponsor_posts_columns', 'ffc_sponsor_admin_columns' );
function ffc_sponsor_admin_columns( array $columns ): array {
	return array(
		'cb'               => $columns['cb'] ?? '<input type="checkbox">',
		'title'            => $columns['title'] ?? __( 'Sponsor', 'ffc-academy' ),
		'sponsor_featured' => __( 'Featured?', 'ffc-academy' ),
		'sponsor_url'      => __( 'Website', 'ffc-academy' ),
		'taxonomy-ffc_sponsor_tier' => $columns['taxonomy-ffc_sponsor_tier'] ?? __( 'Sponsor Tiers', 'ffc-academy' ),
		'date'             => $columns['date'] ?? __( 'Published', 'ffc-academy' ),
	);
}

add_filter( 'manage_ffc_gallery_posts_columns', 'ffc_gallery_admin_columns' );
function ffc_gallery_admin_columns( array $columns ): array {
	return array(
		'cb'                            => $columns['cb'] ?? '<input type="checkbox">',
		'title'                         => $columns['title'] ?? __( 'Gallery Item', 'ffc-academy' ),
		'gallery_media_type'            => __( 'Media Type', 'ffc-academy' ),
		'gallery_event'                 => __( 'Event', 'ffc-academy' ),
		'taxonomy-ffc_gallery_category' => $columns['taxonomy-ffc_gallery_category'] ?? __( 'Gallery Categories', 'ffc-academy' ),
		'date'                          => $columns['date'] ?? __( 'Published', 'ffc-academy' ),
	);
}

add_filter( 'manage_ffc_announcement_posts_columns', 'ffc_announcement_admin_columns' );
function ffc_announcement_admin_columns( array $columns ): array {
	return array(
		'cb'           => $columns['cb'] ?? '<input type="checkbox">',
		'title'        => $columns['title'] ?? __( 'Announcement', 'ffc-academy' ),
		'announcement' => __( 'Summary', 'ffc-academy' ),
		'date'         => $columns['date'] ?? __( 'Published', 'ffc-academy' ),
	);
}

add_action( 'manage_ffc_game_posts_custom_column', 'ffc_render_game_admin_column', 10, 2 );
function ffc_render_game_admin_column( string $column, int $post_id ): void {
	switch ( $column ) {
		case 'game_datetime':
			echo esc_html( ffc_admin_columns_format_datetime_field( 'game_datetime', $post_id ) );
			break;

		case 'game_opponent':
			echo esc_html( (string) ffc_get_field( 'opponent', $post_id, '' ) );
			break;

		case 'game_location':
			echo esc_html( (string) ffc_get_field( 'location', $post_id, '' ) );
			break;

		case 'game_homeaway':
			echo esc_html( ucfirst( (string) ffc_get_field( 'home_away', $post_id, '' ) ) );
			break;
	}
}

add_action( 'manage_ffc_score_posts_custom_column', 'ffc_render_score_admin_column', 10, 2 );
function ffc_render_score_admin_column( string $column, int $post_id ): void {
	switch ( $column ) {
		case 'score_datetime':
			echo esc_html( ffc_admin_columns_format_datetime_field( 'game_datetime', $post_id ) );
			break;

		case 'score_opponent':
			echo esc_html( (string) ffc_get_field( 'opponent', $post_id, '' ) );
			break;

		case 'score_result':
			echo esc_html( ucfirst( (string) ffc_get_field( 'result', $post_id, '' ) ) );
			break;

		case 'score_final':
			echo esc_html( ffc_score_admin_final_score( $post_id ) );
			break;
	}
}

add_action( 'manage_ffc_coach_posts_custom_column', 'ffc_render_coach_admin_column', 10, 2 );
function ffc_render_coach_admin_column( string $column, int $post_id ): void {
	switch ( $column ) {
		case 'coach_role':
			echo esc_html( (string) ffc_get_field( 'role_title', $post_id, '' ) );
			break;

		case 'coach_email':
			ffc_admin_columns_email_link( (string) ffc_get_field( 'contact_email', $post_id, '' ) );
			break;
	}
}

add_action( 'manage_ffc_sponsor_posts_custom_column', 'ffc_render_sponsor_admin_column', 10, 2 );
function ffc_render_sponsor_admin_column( string $column, int $post_id ): void {
	switch ( $column ) {
		case 'sponsor_featured':
			echo esc_html( ffc_get_field( 'featured_sponsor', $post_id, false ) ? __( 'Yes', 'ffc-academy' ) : __( 'No', 'ffc-academy' ) );
			break;

		case 'sponsor_url':
			ffc_admin_columns_url_link( (string) ffc_get_field( 'sponsor_url', $post_id, '' ) );
			break;
	}
}

add_action( 'manage_ffc_gallery_posts_custom_column', 'ffc_render_gallery_admin_column', 10, 2 );
function ffc_render_gallery_admin_column( string $column, int $post_id ): void {
	switch ( $column ) {
		case 'gallery_media_type':
			echo esc_html( ucfirst( (string) ffc_get_field( 'media_type', $post_id, '' ) ) );
			break;

		case 'gallery_event':
			echo esc_html( (string) ffc_get_field( 'event_name', $post_id, '' ) );
			break;
	}
}

add_action( 'manage_ffc_announcement_posts_custom_column', 'ffc_render_announcement_admin_column', 10, 2 );
function ffc_render_announcement_admin_column( string $column, int $post_id ): void {
	if ( 'announcement' !== $column ) {
		return;
	}

	echo esc_html( wp_trim_words( get_the_excerpt( $post_id ) ?: get_post_field( 'post_content', $post_id ), 18 ) );
}

add_action( 'manage_ffc_tryout_session_posts_custom_column', 'ffc_render_tryout_session_admin_column', 10, 2 );
function ffc_render_tryout_session_admin_column( string $column, int $post_id ): void {
	switch ( $column ) {
		case 'session_datetime':
			echo esc_html( ffc_admin_columns_format_timestamp( ffc_tryout_session_timestamp( $post_id ) ) );
			break;

		case 'registration_window':
			ffc_render_registration_window_column( $post_id );
			break;

		case 'session_status':
			echo esc_html( ucfirst( (string) ffc_get_field( 'tryout_session_status', $post_id, 'open' ) ) );
			break;

		case 'session_capacity':
			$capacity = absint( ffc_get_field( 'tryout_session_capacity', $post_id, 0 ) );
			echo esc_html( $capacity ? (string) $capacity : __( 'Unlimited', 'ffc-academy' ) );
			break;

		case 'session_registered':
			echo esc_html( (string) ffc_tryout_session_registration_count( $post_id ) );
			break;

		case 'session_accepting':
			echo esc_html( ffc_tryout_session_accepts_registration( $post_id ) ? __( 'Yes', 'ffc-academy' ) : __( 'No', 'ffc-academy' ) );
			break;
	}
}

add_filter( 'manage_edit-ffc_tryout_session_sortable_columns', 'ffc_tryout_session_sortable_columns' );
function ffc_tryout_session_sortable_columns( array $columns ): array {
	$columns['session_datetime'] = 'ffc_tryout_session_datetime';

	return $columns;
}

add_filter( 'manage_edit-ffc_game_sortable_columns', 'ffc_game_sortable_columns' );
function ffc_game_sortable_columns( array $columns ): array {
	$columns['game_datetime'] = 'ffc_game_datetime';

	return $columns;
}

add_filter( 'manage_edit-ffc_score_sortable_columns', 'ffc_score_sortable_columns' );
function ffc_score_sortable_columns( array $columns ): array {
	$columns['score_datetime'] = 'ffc_score_datetime';

	return $columns;
}

add_filter( 'manage_ffc_tryout_posts_columns', 'ffc_tryout_registration_admin_columns' );
function ffc_tryout_registration_admin_columns( array $columns ): array {
	return array(
		'cb'                  => $columns['cb'] ?? '<input type="checkbox">',
		'title'               => $columns['title'] ?? __( 'Player', 'ffc-academy' ),
		'registration_session' => __( 'Tryout Session', 'ffc-academy' ),
		'registration_email'   => __( 'Parent Email', 'ffc-academy' ),
		'registration_status'  => __( 'Status', 'ffc-academy' ),
		'date'                => $columns['date'] ?? __( 'Submitted', 'ffc-academy' ),
	);
}

add_action( 'manage_ffc_tryout_posts_custom_column', 'ffc_render_tryout_registration_admin_column', 10, 2 );
function ffc_render_tryout_registration_admin_column( string $column, int $post_id ): void {
	switch ( $column ) {
		case 'registration_session':
			echo esc_html( (string) get_post_meta( $post_id, 'tryout_session_label', true ) );
			break;

		case 'registration_email':
			$email = (string) get_post_meta( $post_id, 'parent_email', true );
			if ( is_email( $email ) ) {
				printf( '<a href="mailto:%1$s">%2$s</a>', esc_attr( $email ), esc_html( $email ) );
			} else {
				echo esc_html( $email );
			}
			break;

		case 'registration_status':
			echo esc_html( ucfirst( (string) get_post_meta( $post_id, 'registration_status', true ) ?: __( 'New', 'ffc-academy' ) ) );
			break;
	}
}

add_action( 'pre_get_posts', 'ffc_admin_columns_sort_queries' );
function ffc_admin_columns_sort_queries( WP_Query $query ): void {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( 'ffc_tryout_session_datetime' !== $query->get( 'orderby' ) ) {
		if ( 'ffc_game_datetime' !== $query->get( 'orderby' ) && 'ffc_score_datetime' !== $query->get( 'orderby' ) ) {
			return;
		}
	}

	$query->set( 'meta_key', 'ffc_tryout_session_datetime' === $query->get( 'orderby' ) ? 'tryout_session_datetime' : 'game_datetime' );
	$query->set( 'orderby', 'meta_value' );
	$query->set( 'meta_type', 'DATETIME' );
}

function ffc_render_registration_window_column( int $post_id ): void {
	$opens_at = ffc_tryout_registration_opens_timestamp( $post_id );
	$closes_at = ffc_tryout_registration_closes_timestamp( $post_id );
	$lines     = array();

	if ( $opens_at ) {
		$lines[] = sprintf(
			/* translators: %s: formatted date/time. */
			__( 'Opens: %s', 'ffc-academy' ),
			ffc_admin_columns_format_timestamp( $opens_at )
		);
	}

	if ( $closes_at ) {
		$lines[] = sprintf(
			/* translators: %s: formatted date/time. */
			__( 'Closes: %s', 'ffc-academy' ),
			ffc_admin_columns_format_timestamp( $closes_at )
		);
	}

	if ( empty( $lines ) ) {
		echo esc_html_x( 'None', 'registration window', 'ffc-academy' );
		return;
	}

	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo implode( '<br>', array_map( 'esc_html', $lines ) );
}

function ffc_admin_columns_format_timestamp( int $timestamp ): string {
	if ( ! $timestamp ) {
		return __( 'Not set', 'ffc-academy' );
	}

	return wp_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $timestamp );
}

function ffc_admin_columns_format_datetime_field( string $field_name, int $post_id ): string {
	return ffc_admin_columns_format_timestamp( ffc_tryout_datetime_field_timestamp( $field_name, $post_id ) );
}

function ffc_score_admin_final_score( int $post_id ): string {
	$ffc_score      = ffc_get_field( 'ffc_score', $post_id, '' );
	$opponent_score = ffc_get_field( 'opponent_score', $post_id, '' );

	if ( '' === $ffc_score && '' === $opponent_score ) {
		return __( 'Not set', 'ffc-academy' );
	}

	return sprintf(
		/* translators: 1: F.F.C. score, 2: opponent score. */
		__( 'F.F.C. %1$s - %2$s', 'ffc-academy' ),
		(string) $ffc_score,
		(string) $opponent_score
	);
}

function ffc_admin_columns_email_link( string $email ): void {
	if ( is_email( $email ) ) {
		printf( '<a href="mailto:%1$s">%2$s</a>', esc_attr( $email ), esc_html( $email ) );
		return;
	}

	echo esc_html( $email );
}

function ffc_admin_columns_url_link( string $url ): void {
	if ( '' === $url ) {
		echo esc_html__( 'Not set', 'ffc-academy' );
		return;
	}

	printf(
		'<a href="%1$s" target="_blank" rel="noopener noreferrer">%2$s</a>',
		esc_url( $url ),
		esc_html( wp_parse_url( $url, PHP_URL_HOST ) ?: $url )
	);
}
