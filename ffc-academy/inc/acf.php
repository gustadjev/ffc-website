<?php
/**
 * ACF field groups and options.
 *
 * @package FFCAcademy
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', 'ffc_register_acf_options' );
function ffc_register_acf_options(): void {
	if ( function_exists( 'acf_add_options_page' ) ) {
		acf_add_options_page(
			array(
				'page_title' => __( 'F.F.C. Theme Settings', 'ffc-academy' ),
				'menu_title' => __( 'F.F.C. Settings', 'ffc-academy' ),
				'menu_slug'  => 'ffc-theme-settings',
				'capability' => 'manage_options',
				'redirect'   => false,
				'position'   => 59,
			)
		);
	}
}

add_action( 'acf/include_fields', 'ffc_register_acf_fields' );
function ffc_register_acf_fields(): void {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_ffc_game_details',
			'title'    => __( 'Game Details', 'ffc-academy' ),
			'fields'   => array(
				ffc_acf_text( 'field_ffc_opponent', 'opponent', __( 'Opponent', 'ffc-academy' ) ),
				ffc_acf_date_time( 'field_ffc_game_datetime', 'game_datetime', __( 'Game Date/Time', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_location', 'location', __( 'Location', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_field', 'field', __( 'Field', 'ffc-academy' ) ),
				ffc_acf_select(
					'field_ffc_home_away',
					'home_away',
					__( 'Home/Away', 'ffc-academy' ),
					array(
						'home' => 'Home',
						'away' => 'Away',
					)
				),
				ffc_acf_url( 'field_ffc_maps_url', 'maps_url', __( 'Google Maps URL', 'ffc-academy' ) ),
				ffc_acf_url( 'field_ffc_teamsnap_event_url', 'teamsnap_event_url', __( 'TeamSnap Event URL', 'ffc-academy' ) ),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'ffc_game',
					),
				),
			),
		)
	);

	acf_add_local_field_group(
		array(
			'key'      => 'group_ffc_score_details',
			'title'    => __( 'Score Details', 'ffc-academy' ),
			'fields'   => array(
				ffc_acf_text( 'field_ffc_score_opponent', 'opponent', __( 'Opponent', 'ffc-academy' ) ),
				ffc_acf_date_time( 'field_ffc_score_datetime', 'game_datetime', __( 'Game Date/Time', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_score_location', 'location', __( 'Location', 'ffc-academy' ) ),
				ffc_acf_select(
					'field_ffc_score_home_away',
					'home_away',
					__( 'Home/Away', 'ffc-academy' ),
					array(
						'home' => 'Home',
						'away' => 'Away',
					)
				),
				ffc_acf_number( 'field_ffc_ffc_score', 'ffc_score', __( 'F.F.C. Score', 'ffc-academy' ) ),
				ffc_acf_number( 'field_ffc_opponent_score', 'opponent_score', __( 'Opponent Score', 'ffc-academy' ) ),
				ffc_acf_select(
					'field_ffc_result',
					'result',
					__( 'Result', 'ffc-academy' ),
					array(
						'win'  => 'Win',
						'loss' => 'Loss',
						'draw' => 'Draw',
					)
				),
				ffc_acf_url( 'field_ffc_highlights_url', 'highlights_url', __( 'Highlights URL', 'ffc-academy' ) ),
				ffc_acf_textarea( 'field_ffc_coach_notes', 'coach_notes', __( 'Coach Notes', 'ffc-academy' ) ),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'ffc_score',
					),
				),
			),
		)
	);

	acf_add_local_field_group(
		array(
			'key'      => 'group_ffc_people_media',
			'title'    => __( 'Profile & Media Details', 'ffc-academy' ),
			'fields'   => array(
				ffc_acf_text( 'field_ffc_role_title', 'role_title', __( 'Role / Title', 'ffc-academy' ) ),
				ffc_acf_textarea( 'field_ffc_certifications', 'certifications', __( 'Certifications', 'ffc-academy' ) ),
				ffc_acf_textarea( 'field_ffc_philosophy', 'coaching_philosophy', __( 'Coaching Philosophy', 'ffc-academy' ) ),
				ffc_acf_email( 'field_ffc_contact_email', 'contact_email', __( 'Contact Email', 'ffc-academy' ) ),
				ffc_acf_url( 'field_ffc_social_url', 'social_url', __( 'Social/Profile URL', 'ffc-academy' ) ),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'ffc_coach',
					),
				),
			),
		)
	);

	acf_add_local_field_group(
		array(
			'key'      => 'group_ffc_gallery_details',
			'title'    => __( 'Gallery Details', 'ffc-academy' ),
			'fields'   => array(
				ffc_acf_select(
					'field_ffc_media_type',
					'media_type',
					__( 'Media Type', 'ffc-academy' ),
					array(
						'photo'   => 'Photo',
						'youtube' => 'YouTube',
						'vimeo'   => 'Vimeo',
					)
				),
				ffc_acf_url( 'field_ffc_video_url', 'video_url', __( 'Video URL', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_gallery_event', 'event_name', __( 'Event Name', 'ffc-academy' ) ),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'ffc_gallery',
					),
				),
			),
		)
	);

	acf_add_local_field_group(
		array(
			'key'      => 'group_ffc_sponsor_details',
			'title'    => __( 'Sponsor Details', 'ffc-academy' ),
			'fields'   => array(
				ffc_acf_url( 'field_ffc_sponsor_url', 'sponsor_url', __( 'Sponsor Website', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_sponsor_cta', 'sponsor_cta', __( 'CTA Label', 'ffc-academy' ) ),
				array(
					'key'           => 'field_ffc_sponsor_featured',
					'label'         => __( 'Featured Sponsor', 'ffc-academy' ),
					'name'          => 'featured_sponsor',
					'type'          => 'true_false',
					'ui'            => 1,
					'default_value' => 0,
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'ffc_sponsor',
					),
				),
			),
		)
	);

	acf_add_local_field_group(
		array(
			'key'      => 'group_ffc_theme_options',
			'title'    => __( 'F.F.C. Integration Settings', 'ffc-academy' ),
			'fields'   => array(
				ffc_acf_url( 'field_ffc_tryout_page_url', 'tryout_page_url', __( 'Tryout Page URL', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_utility_bar_text', 'utility_bar_text', __( 'Top Bar Text', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_utility_tryouts_label', 'utility_tryouts_label', __( 'Top Bar Tryouts Label', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_utility_schedule_label', 'utility_schedule_label', __( 'Top Bar Schedule Label', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_utility_teamsnap_label', 'utility_teamsnap_label', __( 'Top Bar TeamSnap Label', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_header_cta_label', 'header_cta_label', __( 'Header CTA Label', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_footer_cta_one_label', 'footer_cta_one_label', __( 'Footer CTA 1 Label', 'ffc-academy' ) ),
				ffc_acf_url( 'field_ffc_footer_cta_one_url', 'footer_cta_one_url', __( 'Footer CTA 1 URL', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_footer_cta_two_label', 'footer_cta_two_label', __( 'Footer CTA 2 Label', 'ffc-academy' ) ),
				ffc_acf_url( 'field_ffc_footer_cta_two_url', 'footer_cta_two_url', __( 'Footer CTA 2 URL', 'ffc-academy' ) ),
				ffc_acf_textarea( 'field_ffc_footer_brand_copy', 'footer_brand_copy', __( 'Footer Brand Copy', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_footer_teamsnap_label', 'footer_teamsnap_label', __( 'Footer TeamSnap Label', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_footer_contact_heading', 'footer_contact_heading', __( 'Footer Contact Heading', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_footer_mailing_label', 'footer_mailing_label', __( 'Footer Mailing Label', 'ffc-academy' ) ),
				ffc_acf_textarea( 'field_ffc_footer_mailing_address', 'footer_mailing_address', __( 'Footer Mailing Address', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_footer_training_label', 'footer_training_label', __( 'Footer Training Label', 'ffc-academy' ) ),
				ffc_acf_textarea( 'field_ffc_footer_training_text', 'footer_training_text', __( 'Footer Training Text', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_footer_copyright_note', 'footer_copyright_note', __( 'Footer Copyright Note', 'ffc-academy' ) ),
				ffc_acf_url( 'field_ffc_teamsnap_public_url', 'teamsnap_public_url', __( 'TeamSnap Main Team URL', 'ffc-academy' ) ),
				ffc_acf_url( 'field_ffc_teamsnap_schedule_url', 'teamsnap_schedule_url', __( 'TeamSnap Schedule URL', 'ffc-academy' ) ),
				ffc_acf_url( 'field_ffc_teamsnap_roster_url', 'teamsnap_roster_url', __( 'TeamSnap Roster URL', 'ffc-academy' ) ),
				ffc_acf_url( 'field_ffc_teamsnap_registration_url', 'teamsnap_registration_url', __( 'TeamSnap Registration URL', 'ffc-academy' ) ),
				ffc_acf_url( 'field_ffc_teamsnap_app_url', 'teamsnap_app_url', __( 'TeamSnap App / Login URL', 'ffc-academy' ) ),
				array(
					'key'          => 'field_ffc_teamsnap_embed_code',
					'label'        => __( 'TeamSnap Embed Code', 'ffc-academy' ),
					'name'         => 'teamsnap_embed_code',
					'type'         => 'textarea',
					'instructions' => __( 'Paste a TeamSnap iframe/widget embed code here. If left blank, the site shows polished TeamSnap link cards instead.', 'ffc-academy' ),
					'rows'         => 6,
					'new_lines'    => '',
				),
				ffc_acf_url( 'field_ffc_instagram_url', 'instagram_url', __( 'Instagram URL', 'ffc-academy' ) ),
				ffc_acf_url( 'field_ffc_facebook_url', 'facebook_url', __( 'Facebook URL', 'ffc-academy' ) ),
				ffc_acf_url( 'field_ffc_youtube_url', 'youtube_url', __( 'YouTube URL', 'ffc-academy' ) ),
				ffc_acf_url( 'field_ffc_tiktok_url', 'tiktok_url', __( 'TikTok URL', 'ffc-academy' ) ),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'ffc-theme-settings',
					),
				),
			),
		)
	);

	acf_add_local_field_group(
		array(
			'key'      => 'group_ffc_homepage',
			'title'    => __( 'F.F.C. Homepage Content', 'ffc-academy' ),
			'fields'   => array(
				array(
					'key'          => 'field_ffc_home_slides',
					'label'        => __( 'Hero Slider', 'ffc-academy' ),
					'name'         => 'home_slides',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => __( 'Add Slide', 'ffc-academy' ),
					'sub_fields'   => array(
						ffc_acf_image( 'field_ffc_slide_image', 'image', __( 'Slide Image', 'ffc-academy' ) ),
						ffc_acf_text( 'field_ffc_slide_kicker', 'kicker', __( 'Kicker', 'ffc-academy' ) ),
						ffc_acf_text( 'field_ffc_slide_title', 'title', __( 'Title', 'ffc-academy' ) ),
						ffc_acf_textarea( 'field_ffc_slide_copy', 'copy', __( 'Copy', 'ffc-academy' ) ),
						ffc_acf_text( 'field_ffc_slide_card_label', 'card_label', __( 'Side Card Label', 'ffc-academy' ) ),
						ffc_acf_text( 'field_ffc_slide_card_meta', 'card_meta', __( 'Side Card Text', 'ffc-academy' ) ),
						ffc_acf_text( 'field_ffc_slide_primary_label', 'primary_label', __( 'Primary Button Label', 'ffc-academy' ) ),
						ffc_acf_url( 'field_ffc_slide_primary_url', 'primary_url', __( 'Primary Button URL', 'ffc-academy' ) ),
						ffc_acf_text( 'field_ffc_slide_secondary_label', 'secondary_label', __( 'Secondary Button Label', 'ffc-academy' ) ),
						ffc_acf_url( 'field_ffc_slide_secondary_url', 'secondary_url', __( 'Secondary Button URL', 'ffc-academy' ) ),
					),
				),
				ffc_acf_text( 'field_ffc_home_intro_kicker', 'home_intro_kicker', __( 'Intro Kicker', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_home_intro_title', 'home_intro_title', __( 'Intro Title', 'ffc-academy' ) ),
				ffc_acf_textarea( 'field_ffc_home_intro_copy', 'home_intro_copy', __( 'Intro Copy', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_home_pillar_one_title', 'home_pillar_one_title', __( 'Pillar 1 Title', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_home_pillar_one_copy', 'home_pillar_one_copy', __( 'Pillar 1 Copy', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_home_pillar_two_title', 'home_pillar_two_title', __( 'Pillar 2 Title', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_home_pillar_two_copy', 'home_pillar_two_copy', __( 'Pillar 2 Copy', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_home_pillar_three_title', 'home_pillar_three_title', __( 'Pillar 3 Title', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_home_pillar_three_copy', 'home_pillar_three_copy', __( 'Pillar 3 Copy', 'ffc-academy' ) ),
				ffc_acf_image( 'field_ffc_home_development_image', 'home_development_image', __( 'Development Image', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_home_development_kicker', 'home_development_kicker', __( 'Development Kicker', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_home_development_title', 'home_development_title', __( 'Development Title', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_home_tryout_kicker', 'home_tryout_kicker', __( 'Tryout CTA Kicker', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_home_tryout_title', 'home_tryout_title', __( 'Tryout CTA Title', 'ffc-academy' ) ),
				ffc_acf_textarea( 'field_ffc_home_tryout_copy', 'home_tryout_copy', __( 'Tryout CTA Copy', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_home_tryout_button_label', 'home_tryout_button_label', __( 'Tryout CTA Button Label', 'ffc-academy' ) ),
			),
			'location' => array(
				array(
					array(
						'param'    => 'page_type',
						'operator' => '==',
						'value'    => 'front_page',
					),
				),
			),
		)
	);

	acf_add_local_field_group(
		array(
			'key'      => 'group_ffc_homepage_slider_basic',
			'title'    => __( 'F.F.C. Homepage Slider Slides', 'ffc-academy' ),
			'fields'   => ffc_homepage_basic_slide_fields(),
			'location' => array(
				array(
					array(
						'param'    => 'page_type',
						'operator' => '==',
						'value'    => 'front_page',
					),
				),
			),
		)
	);

	$about_page = get_page_by_path( 'about' );
	if ( $about_page instanceof WP_Post ) {
		acf_add_local_field_group(
			array(
				'key'      => 'group_ffc_about_page',
				'title'    => __( 'F.F.C. About Page Content', 'ffc-academy' ),
				'fields'   => ffc_about_page_fields(),
				'location' => array(
					array(
						array(
							'param'    => 'page',
							'operator' => '==',
							'value'    => (string) $about_page->ID,
						),
					),
				),
			)
		);
	}

	$contact_page = get_page_by_path( 'contact' );
	if ( $contact_page instanceof WP_Post ) {
		acf_add_local_field_group(
			array(
				'key'      => 'group_ffc_contact_page',
				'title'    => __( 'F.F.C. Contact Page Content', 'ffc-academy' ),
				'fields'   => ffc_contact_page_fields(),
				'location' => array(
					array(
						array(
							'param'    => 'page',
							'operator' => '==',
							'value'    => (string) $contact_page->ID,
						),
					),
				),
			)
		);
	}
}

function ffc_homepage_basic_slide_fields(): array {
	$fields = array();

	for ( $i = 1; $i <= 3; $i++ ) {
		$fields[] = ffc_acf_image( "field_ffc_home_slide_{$i}_image", "home_slide_{$i}_image", sprintf( __( 'Slide %d Image', 'ffc-academy' ), $i ) );
		$fields[] = ffc_acf_text( "field_ffc_home_slide_{$i}_kicker", "home_slide_{$i}_kicker", sprintf( __( 'Slide %d Kicker', 'ffc-academy' ), $i ) );
		$fields[] = ffc_acf_text( "field_ffc_home_slide_{$i}_title", "home_slide_{$i}_title", sprintf( __( 'Slide %d Title', 'ffc-academy' ), $i ) );
		$fields[] = ffc_acf_textarea( "field_ffc_home_slide_{$i}_copy", "home_slide_{$i}_copy", sprintf( __( 'Slide %d Copy', 'ffc-academy' ), $i ) );
		$fields[] = ffc_acf_text( "field_ffc_home_slide_{$i}_card_label", "home_slide_{$i}_card_label", sprintf( __( 'Slide %d Side Card Label', 'ffc-academy' ), $i ) );
		$fields[] = ffc_acf_text( "field_ffc_home_slide_{$i}_card_meta", "home_slide_{$i}_card_meta", sprintf( __( 'Slide %d Side Card Text', 'ffc-academy' ), $i ) );
		$fields[] = ffc_acf_text( "field_ffc_home_slide_{$i}_primary_label", "home_slide_{$i}_primary_label", sprintf( __( 'Slide %d Primary Button Label', 'ffc-academy' ), $i ) );
		$fields[] = ffc_acf_url( "field_ffc_home_slide_{$i}_primary_url", "home_slide_{$i}_primary_url", sprintf( __( 'Slide %d Primary Button URL', 'ffc-academy' ), $i ) );
		$fields[] = ffc_acf_text( "field_ffc_home_slide_{$i}_secondary_label", "home_slide_{$i}_secondary_label", sprintf( __( 'Slide %d Secondary Button Label', 'ffc-academy' ), $i ) );
		$fields[] = ffc_acf_url( "field_ffc_home_slide_{$i}_secondary_url", "home_slide_{$i}_secondary_url", sprintf( __( 'Slide %d Secondary Button URL', 'ffc-academy' ), $i ) );
	}

	return $fields;
}

function ffc_about_page_fields(): array {
	$fields = array(
		ffc_acf_text( 'field_ffc_about_hero_kicker', 'about_hero_kicker', __( 'Hero Kicker', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_about_hero_title', 'about_hero_title', __( 'Hero Title', 'ffc-academy' ) ),
		ffc_acf_textarea( 'field_ffc_about_hero_copy', 'about_hero_copy', __( 'Hero Copy', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_about_intro_title', 'about_intro_title', __( 'Intro Title', 'ffc-academy' ) ),
		ffc_acf_textarea( 'field_ffc_about_intro_copy_one', 'about_intro_copy_one', __( 'Intro Copy 1', 'ffc-academy' ) ),
		ffc_acf_textarea( 'field_ffc_about_intro_copy_two', 'about_intro_copy_two', __( 'Intro Copy 2', 'ffc-academy' ) ),
		ffc_acf_image( 'field_ffc_about_intro_image', 'about_intro_image', __( 'Intro Image', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_about_values_kicker', 'about_values_kicker', __( 'Values Kicker', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_about_values_title', 'about_values_title', __( 'Values Title', 'ffc-academy' ) ),
	);

	for ( $i = 1; $i <= 4; $i++ ) {
		$fields[] = ffc_acf_image( "field_ffc_about_value_{$i}_image", "about_value_{$i}_image", sprintf( __( 'Value %d Image', 'ffc-academy' ), $i ) );
		$fields[] = ffc_acf_text( "field_ffc_about_value_{$i}_title", "about_value_{$i}_title", sprintf( __( 'Value %d Title', 'ffc-academy' ), $i ) );
		$fields[] = ffc_acf_textarea( "field_ffc_about_value_{$i}_copy", "about_value_{$i}_copy", sprintf( __( 'Value %d Copy', 'ffc-academy' ), $i ) );
	}

	$fields[] = ffc_acf_text( 'field_ffc_about_story_kicker', 'about_story_kicker', __( 'Story Kicker', 'ffc-academy' ) );
	$fields[] = ffc_acf_text( 'field_ffc_about_story_title', 'about_story_title', __( 'Story Title', 'ffc-academy' ) );

	for ( $i = 1; $i <= 3; $i++ ) {
		$fields[] = ffc_acf_text( "field_ffc_about_timeline_{$i}_label", "about_timeline_{$i}_label", sprintf( __( 'Timeline %d Label', 'ffc-academy' ), $i ) );
		$fields[] = ffc_acf_text( "field_ffc_about_timeline_{$i}_title", "about_timeline_{$i}_title", sprintf( __( 'Timeline %d Title', 'ffc-academy' ), $i ) );
		$fields[] = ffc_acf_textarea( "field_ffc_about_timeline_{$i}_copy", "about_timeline_{$i}_copy", sprintf( __( 'Timeline %d Copy', 'ffc-academy' ), $i ) );
	}

	$fields[] = ffc_acf_text( 'field_ffc_about_cta_title', 'about_cta_title', __( 'CTA Title', 'ffc-academy' ) );
	$fields[] = ffc_acf_text( 'field_ffc_about_cta_primary_label', 'about_cta_primary_label', __( 'Primary CTA Label', 'ffc-academy' ) );
	$fields[] = ffc_acf_url( 'field_ffc_about_cta_primary_url', 'about_cta_primary_url', __( 'Primary CTA URL', 'ffc-academy' ) );
	$fields[] = ffc_acf_text( 'field_ffc_about_cta_secondary_label', 'about_cta_secondary_label', __( 'Secondary CTA Label', 'ffc-academy' ) );
	$fields[] = ffc_acf_url( 'field_ffc_about_cta_secondary_url', 'about_cta_secondary_url', __( 'Secondary CTA URL', 'ffc-academy' ) );

	return $fields;
}

function ffc_contact_page_fields(): array {
	$fields = array(
		ffc_acf_text( 'field_ffc_contact_hero_kicker', 'contact_hero_kicker', __( 'Hero Kicker', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_contact_hero_title', 'contact_hero_title', __( 'Hero Title', 'ffc-academy' ) ),
		ffc_acf_textarea( 'field_ffc_contact_hero_copy', 'contact_hero_copy', __( 'Hero Copy', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_contact_card_label', 'contact_card_label', __( 'Hero Card Label', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_contact_card_title', 'contact_card_title', __( 'Hero Card Title', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_contact_card_button_label', 'contact_card_button_label', __( 'Hero Card Button Label', 'ffc-academy' ) ),
		ffc_acf_url( 'field_ffc_contact_card_button_url', 'contact_card_button_url', __( 'Hero Card Button URL', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_contact_panel_kicker', 'contact_panel_kicker', __( 'Panel Kicker', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_contact_panel_title', 'contact_panel_title', __( 'Panel Title', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_contact_form_shortcode', 'contact_form_shortcode', __( 'Contact Form Shortcode', 'ffc-academy' ) ),
	);

	for ( $i = 1; $i <= 3; $i++ ) {
		$fields[] = ffc_acf_text( "field_ffc_contact_method_{$i}_title", "contact_method_{$i}_title", sprintf( __( 'Contact Method %d Title', 'ffc-academy' ), $i ) );
		$fields[] = ffc_acf_textarea( "field_ffc_contact_method_{$i}_copy", "contact_method_{$i}_copy", sprintf( __( 'Contact Method %d Copy', 'ffc-academy' ), $i ) );
	}

	return $fields;
}

function ffc_acf_text( string $key, string $name, string $label ): array {
	return array(
		'key'   => $key,
		'label' => $label,
		'name'  => $name,
		'type'  => 'text',
	);
}

function ffc_acf_url( string $key, string $name, string $label ): array {
	return array(
		'key'   => $key,
		'label' => $label,
		'name'  => $name,
		'type'  => 'url',
	);
}

function ffc_acf_email( string $key, string $name, string $label ): array {
	return array(
		'key'   => $key,
		'label' => $label,
		'name'  => $name,
		'type'  => 'email',
	);
}

function ffc_acf_number( string $key, string $name, string $label ): array {
	return array(
		'key'   => $key,
		'label' => $label,
		'name'  => $name,
		'type'  => 'number',
	);
}

function ffc_acf_textarea( string $key, string $name, string $label ): array {
	return array(
		'key'   => $key,
		'label' => $label,
		'name'  => $name,
		'type'  => 'textarea',
		'rows'  => 4,
	);
}

function ffc_acf_image( string $key, string $name, string $label ): array {
	return array(
		'key'           => $key,
		'label'         => $label,
		'name'          => $name,
		'type'          => 'image',
		'return_format' => 'array',
		'preview_size'  => 'medium',
		'library'       => 'all',
	);
}

function ffc_acf_date_time( string $key, string $name, string $label ): array {
	return array(
		'key'            => $key,
		'label'          => $label,
		'name'           => $name,
		'type'           => 'date_time_picker',
		'display_format' => 'M j, Y g:i a',
		'return_format'  => 'Y-m-d H:i:s',
	);
}

function ffc_acf_select( string $key, string $name, string $label, array $choices ): array {
	return array(
		'key'     => $key,
		'label'   => $label,
		'name'    => $name,
		'type'    => 'select',
		'choices' => $choices,
		'ui'      => 1,
	);
}
