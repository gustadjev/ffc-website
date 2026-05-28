<?php
/**
 * TeamSnap integration helpers.
 *
 * @package FFCAcademy
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ffc_teamsnap_button( string $label = '' ): string {
	$url = ffc_option( 'teamsnap_public_url' ) ?: ffc_option( 'teamsnap_schedule_url' );
	$label = $label ?: ffc_option( 'teamsnap_default_button_label', __( 'Open TeamSnap', 'ffc-academy' ) );

	return $url ? ffc_button( $label, $url, 'secondary' ) : '';
}

function ffc_teamsnap_links(): array {
	return array_filter(
		array(
			'schedule'     => array(
				'label'       => ffc_option( 'teamsnap_schedule_label', __( 'Schedule', 'ffc-academy' ) ),
				'description' => ffc_option( 'teamsnap_schedule_description', __( 'Practices, matches, fields, and calendar updates.', 'ffc-academy' ) ),
				'url'         => ffc_option( 'teamsnap_schedule_url' ) ?: ffc_option( 'teamsnap_public_url' ),
			),
			'roster'       => array(
				'label'       => ffc_option( 'teamsnap_roster_label', __( 'Roster', 'ffc-academy' ) ),
				'description' => ffc_option( 'teamsnap_roster_description', __( 'Team contacts, player details, and family communication.', 'ffc-academy' ) ),
				'url'         => ffc_option( 'teamsnap_roster_url' ),
			),
			'registration' => array(
				'label'       => ffc_option( 'teamsnap_registration_label', __( 'Registration', 'ffc-academy' ) ),
				'description' => ffc_option( 'teamsnap_registration_description', __( 'TeamSnap forms, dues, waivers, and season signups.', 'ffc-academy' ) ),
				'url'         => ffc_option( 'teamsnap_registration_url' ),
			),
			'app'          => array(
				'label'       => ffc_option( 'teamsnap_app_label', __( 'TeamSnap App', 'ffc-academy' ) ),
				'description' => ffc_option( 'teamsnap_app_description', __( 'Open the mobile app or TeamSnap login.', 'ffc-academy' ) ),
				'url'         => ffc_option( 'teamsnap_app_url' ) ?: ffc_option( 'teamsnap_public_url' ),
			),
		),
		static function ( array $link ): bool {
			return ! empty( $link['url'] );
		}
	);
}

function ffc_teamsnap_embed(): string {
	$embed = ffc_option( 'teamsnap_embed_code' );
	if ( empty( $embed ) ) {
		return '';
	}

	$allowed = array(
		'iframe' => array(
			'src'             => true,
			'title'           => true,
			'width'           => true,
			'height'          => true,
			'style'           => true,
			'loading'         => true,
			'allow'           => true,
			'allowfullscreen' => true,
			'frameborder'     => true,
			'referrerpolicy'  => true,
		),
		'a'      => array(
			'href'   => true,
			'target' => true,
			'rel'    => true,
			'class'  => true,
		),
		'div'    => array(
			'class' => true,
			'id'    => true,
			'style' => true,
		),
		'script' => array(
			'src'   => true,
			'async' => true,
			'defer' => true,
		),
	);

	return wp_kses( $embed, $allowed );
}

function ffc_teamsnap_links_markup(): string {
	$links = ffc_teamsnap_links();

	if ( empty( $links ) ) {
		return '<p class="teamsnap-empty">' . esc_html( ffc_option( 'teamsnap_empty_message', __( 'Add TeamSnap links in F.F.C. Settings to connect families directly to schedules, rosters, registration, and the TeamSnap app.', 'ffc-academy' ) ) ) . '</p>';
	}

	$output = '<div class="teamsnap-link-grid">';
	foreach ( $links as $key => $link ) {
		$output .= sprintf(
			'<a class="teamsnap-link-card" href="%1$s" target="_blank" rel="noopener"><span>%2$s</span><strong>%3$s</strong><em>%4$s</em></a>',
			esc_url( $link['url'] ),
			esc_html( strtoupper( $key ) ),
			esc_html( $link['label'] ),
			esc_html( $link['description'] )
		);
	}
	$output .= '</div>';

	return $output;
}

add_shortcode( 'ffc_teamsnap', 'ffc_teamsnap_shortcode' );
function ffc_teamsnap_shortcode(): string {
	$embed = ffc_teamsnap_embed();

	if ( $embed ) {
		return '<div class="teamsnap-embed">' . $embed . '</div>';
	}

	return ffc_teamsnap_links_markup();
}
