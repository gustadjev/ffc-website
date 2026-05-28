<?php
/**
 * Theme customizer controls.
 *
 * @package FFCAcademy
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'customize_register', 'ffc_register_customizer_controls' );
function ffc_register_customizer_controls( WP_Customize_Manager $wp_customize ): void {
	$wp_customize->add_section(
		'ffc_social_links',
		array(
			'title'       => __( 'F.F.C. Social Links', 'ffc-academy' ),
			'description' => __( 'Add the club social media URLs used by the footer and contact page icons.', 'ffc-academy' ),
			'priority'    => 62,
		)
	);

	$channels = array(
		'instagram_url' => __( 'Instagram URL', 'ffc-academy' ),
		'facebook_url'  => __( 'Facebook URL', 'ffc-academy' ),
		'youtube_url'   => __( 'YouTube URL', 'ffc-academy' ),
		'tiktok_url'    => __( 'TikTok URL', 'ffc-academy' ),
	);

	foreach ( $channels as $key => $label ) {
		$option_name = 'ffc_' . $key;

		$wp_customize->add_setting(
			$option_name,
			array(
				'type'              => 'option',
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
				'transport'         => 'refresh',
			)
		);

		$wp_customize->add_control(
			$option_name,
			array(
				'label'       => $label,
				'description' => __( 'Paste the full social media profile URL.', 'ffc-academy' ),
				'section'     => 'ffc_social_links',
				'type'        => 'url',
			)
		);
	}
}
