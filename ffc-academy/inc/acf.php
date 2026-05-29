<?php
/**
 * ACF field groups and options.
 *
 * @package FFCAcademy
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_notices', 'ffc_acf_required_admin_notice' );
function ffc_acf_required_admin_notice(): void {
	if ( function_exists( 'acf_add_local_field_group' ) || ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	?>
	<div class="notice notice-error">
		<p><?php esc_html_e( 'F.F.C. Academy requires Advanced Custom Fields for editable page, post, and taxonomy content fields. Please install and activate Advanced Custom Fields before handoff.', 'ffc-academy' ); ?></p>
	</div>
	<?php
}

add_action( 'acf/include_fields', 'ffc_register_acf_fields' );
function ffc_register_acf_fields(): void {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$homepage_locations = array(
		array(
			array(
				'param'    => 'page_type',
				'operator' => '==',
				'value'    => 'front_page',
			),
		),
	);
	$home_page = get_page_by_path( 'home' );
	if ( $home_page instanceof WP_Post ) {
		$homepage_locations[] = array(
			array(
				'param'    => 'page',
				'operator' => '==',
				'value'    => (string) $home_page->ID,
			),
		);
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
			'key'      => 'group_ffc_tryout_registration_details',
			'title'    => __( 'Tryout Registration Details', 'ffc-academy' ),
			'fields'   => ffc_tryout_registration_fields(),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'ffc_tryout',
					),
				),
			),
		)
	);

	acf_add_local_field_group(
		array(
			'key'      => 'group_ffc_tryout_session_details',
			'title'    => __( 'Tryout Session Details', 'ffc-academy' ),
			'fields'   => array(
				ffc_acf_date_time( 'field_ffc_tryout_session_datetime', 'tryout_session_datetime', __( 'Session Date/Time', 'ffc-academy' ) ),
				ffc_acf_date_time( 'field_ffc_tryout_registration_opens_at', 'tryout_registration_opens_at', __( 'Registration Opens At', 'ffc-academy' ) ),
				ffc_acf_date_time( 'field_ffc_tryout_registration_closes_at', 'tryout_registration_closes_at', __( 'Registration Closes At', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_tryout_session_location', 'tryout_session_location', __( 'Location', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_tryout_session_field', 'tryout_session_field', __( 'Field', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_tryout_session_age_group', 'tryout_session_age_group', __( 'Age Group', 'ffc-academy' ) ),
				array(
					'key'           => 'field_ffc_tryout_session_status',
					'label'         => __( 'Registration Status', 'ffc-academy' ),
					'name'          => 'tryout_session_status',
					'type'          => 'select',
					'choices'       => array(
						'open'   => __( 'Open', 'ffc-academy' ),
						'closed' => __( 'Closed', 'ffc-academy' ),
						'full'   => __( 'Full', 'ffc-academy' ),
					),
					'default_value' => 'open',
					'ui'            => 1,
				),
				ffc_acf_number( 'field_ffc_tryout_session_capacity', 'tryout_session_capacity', __( 'Capacity', 'ffc-academy' ) ),
				ffc_acf_url( 'field_ffc_tryout_session_teamsnap_url', 'tryout_session_teamsnap_url', __( 'TeamSnap Event URL', 'ffc-academy' ) ),
				ffc_acf_textarea( 'field_ffc_tryout_session_notes', 'tryout_session_notes', __( 'Session Notes', 'ffc-academy' ) ),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'ffc_tryout_session',
					),
				),
			),
		)
	);

	acf_add_local_field_group(
		array(
			'key'      => 'group_ffc_team_term_details',
			'title'    => __( 'Team Details', 'ffc-academy' ),
			'fields'   => array(
				ffc_acf_text( 'field_ffc_team_age_group', 'team_age_group', __( 'Age Group', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_team_level', 'team_level', __( 'Competition Level', 'ffc-academy' ) ),
				ffc_acf_text( 'field_ffc_team_coach_name', 'team_coach_name', __( 'Lead Coach Name', 'ffc-academy' ) ),
				ffc_acf_url( 'field_ffc_team_teamsnap_url', 'team_teamsnap_url', __( 'TeamSnap Team URL', 'ffc-academy' ) ),
				ffc_acf_textarea( 'field_ffc_team_notes', 'team_notes', __( 'Team Notes', 'ffc-academy' ) ),
			),
			'location' => array(
				array(
					array(
						'param'    => 'taxonomy',
						'operator' => '==',
						'value'    => 'ffc_team',
					),
				),
			),
		)
	);

	acf_add_local_field_group(
		array(
			'key'      => 'group_ffc_season_term_details',
			'title'    => __( 'Season Details', 'ffc-academy' ),
			'fields'   => array(
				ffc_acf_text( 'field_ffc_season_display_label', 'season_display_label', __( 'Display Label', 'ffc-academy' ) ),
				ffc_acf_date( 'field_ffc_season_start_date', 'season_start_date', __( 'Start Date', 'ffc-academy' ) ),
				ffc_acf_date( 'field_ffc_season_end_date', 'season_end_date', __( 'End Date', 'ffc-academy' ) ),
				ffc_acf_true_false( 'field_ffc_season_is_current', 'season_is_current', __( 'Current Season', 'ffc-academy' ) ),
				ffc_acf_textarea( 'field_ffc_season_notes', 'season_notes', __( 'Season Notes', 'ffc-academy' ) ),
			),
			'location' => array(
				array(
					array(
						'param'    => 'taxonomy',
						'operator' => '==',
						'value'    => 'ffc_season',
					),
				),
			),
		)
	);

	acf_add_local_field_group(
		array(
			'key'      => 'group_ffc_sponsor_tier_term_details',
			'title'    => __( 'Sponsor Tier Details', 'ffc-academy' ),
			'fields'   => array(
				ffc_acf_number( 'field_ffc_sponsor_tier_order', 'sponsor_tier_order', __( 'Display Order', 'ffc-academy' ) ),
				ffc_acf_textarea( 'field_ffc_sponsor_tier_description', 'sponsor_tier_description', __( 'Tier Description', 'ffc-academy' ) ),
			),
			'location' => array(
				array(
					array(
						'param'    => 'taxonomy',
						'operator' => '==',
						'value'    => 'ffc_sponsor_tier',
					),
				),
			),
		)
	);

	acf_add_local_field_group(
		array(
			'key'      => 'group_ffc_homepage',
			'title'    => __( 'F.F.C. Homepage Sections', 'ffc-academy' ),
			'fields'   => ffc_homepage_section_fields(),
			'location' => $homepage_locations,
			'position' => 'acf_after_title',
		)
	);

	acf_add_local_field_group(
		array(
			'key'      => 'group_ffc_homepage_slider_basic',
			'title'    => __( 'F.F.C. Homepage Slider', 'ffc-academy' ),
			'fields'   => ffc_homepage_basic_slide_fields(),
			'location' => $homepage_locations,
			'position' => 'acf_after_title',
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
				'position' => 'acf_after_title',
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
				'position' => 'acf_after_title',
			)
		);
	}

	$tryout_page = get_page_by_path( 'tryouts' );
	if ( $tryout_page instanceof WP_Post ) {
		acf_add_local_field_group(
			array(
				'key'      => 'group_ffc_tryout_page',
				'title'    => __( 'F.F.C. Tryout Page Content', 'ffc-academy' ),
				'fields'   => ffc_tryout_page_fields(),
				'location' => array(
					array(
						array(
							'param'    => 'page',
							'operator' => '==',
							'value'    => (string) $tryout_page->ID,
						),
					),
					array(
						array(
							'param'    => 'page_template',
							'operator' => '==',
							'value'    => 'templates/page-tryouts.php',
						),
					),
				),
				'position' => 'acf_after_title',
			)
		);
	}
}

function ffc_homepage_section_fields(): array {
	$fields = array(
		ffc_acf_text( 'field_ffc_home_intro_kicker', 'home_intro_kicker', __( 'Intro Kicker', 'ffc-academy' ), __( 'Academy Pathway', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_home_intro_title', 'home_intro_title', __( 'Intro Title', 'ffc-academy' ), __( 'Built for Families. Serious About Player Growth.', 'ffc-academy' ) ),
		ffc_acf_textarea( 'field_ffc_home_intro_copy', 'home_intro_copy', __( 'Intro Copy', 'ffc-academy' ), __( 'F.F.C. keeps the experience organized for parents and ambitious for players: clear communication, thoughtful coaching, match preparation, and a culture that rewards effort.', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_home_pillar_one_title', 'home_pillar_one_title', __( 'Pillar 1 Title', 'ffc-academy' ), __( 'Develop', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_home_pillar_one_copy', 'home_pillar_one_copy', __( 'Pillar 1 Copy', 'ffc-academy' ), __( 'Technical habits and game intelligence.', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_home_pillar_two_title', 'home_pillar_two_title', __( 'Pillar 2 Title', 'ffc-academy' ), __( 'Compete', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_home_pillar_two_copy', 'home_pillar_two_copy', __( 'Pillar 2 Copy', 'ffc-academy' ), __( 'Purposeful matches and tournament readiness.', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_home_pillar_three_title', 'home_pillar_three_title', __( 'Pillar 3 Title', 'ffc-academy' ), __( 'Belong', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_home_pillar_three_copy', 'home_pillar_three_copy', __( 'Pillar 3 Copy', 'ffc-academy' ), __( 'A family-friendly club culture.', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_home_matches_kicker', 'home_matches_kicker', __( 'Matches Kicker', 'ffc-academy' ), __( 'Next Up', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_home_matches_title', 'home_matches_title', __( 'Matches Title', 'ffc-academy' ), __( 'Upcoming Matches', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_home_matches_link_label', 'home_matches_link_label', __( 'Matches Link Label', 'ffc-academy' ), __( 'Full Schedule', 'ffc-academy' ) ),
		ffc_acf_textarea( 'field_ffc_home_matches_empty_message', 'home_matches_empty_message', __( 'Matches Empty Message', 'ffc-academy' ), __( 'Upcoming match details will be posted soon.', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_home_scores_kicker', 'home_scores_kicker', __( 'Scores Kicker', 'ffc-academy' ), __( 'Matchday', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_home_scores_title', 'home_scores_title', __( 'Scores Title', 'ffc-academy' ), __( 'Latest Scores', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_home_scores_link_label', 'home_scores_link_label', __( 'Scores Link Label', 'ffc-academy' ), __( 'View Results', 'ffc-academy' ) ),
		ffc_acf_textarea( 'field_ffc_home_scores_empty_message', 'home_scores_empty_message', __( 'Scores Empty Message', 'ffc-academy' ), __( 'Recent results and match recaps will be posted after games.', 'ffc-academy' ) ),
		ffc_acf_image( 'field_ffc_home_development_image', 'home_development_image', __( 'Development Image', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_home_development_image_alt', 'home_development_image_alt', __( 'Development Image Alt Text', 'ffc-academy' ), __( 'Youth soccer training session', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_home_development_kicker', 'home_development_kicker', __( 'Development Kicker', 'ffc-academy' ), __( 'Player Development Model', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_home_development_title', 'home_development_title', __( 'Development Title', 'ffc-academy' ), __( 'Training With Standards, Care, and Competitive Intent.', 'ffc-academy' ) ),
	);

	$development_items = array(
		array(
			'title' => __( 'Technical Identity', 'ffc-academy' ),
			'copy'  => __( 'First touch, passing detail, finishing, defending habits.', 'ffc-academy' ),
		),
		array(
			'title' => __( 'Game Intelligence', 'ffc-academy' ),
			'copy'  => __( 'Scanning, spacing, decision speed, and pressure recognition.', 'ffc-academy' ),
		),
		array(
			'title' => __( 'Character Growth', 'ffc-academy' ),
			'copy'  => __( 'Resilience, leadership, accountability, and team responsibility.', 'ffc-academy' ),
		),
	);

	for ( $i = 1; $i <= 3; $i++ ) {
		$fields[] = ffc_acf_text( "field_ffc_home_development_item_{$i}_title", "home_development_item_{$i}_title", sprintf( __( 'Development Item %d Title', 'ffc-academy' ), $i ), $development_items[ $i - 1 ]['title'] );
		$fields[] = ffc_acf_text( "field_ffc_home_development_item_{$i}_copy", "home_development_item_{$i}_copy", sprintf( __( 'Development Item %d Copy', 'ffc-academy' ), $i ), $development_items[ $i - 1 ]['copy'] );
	}

	$fields = array_merge(
		$fields,
		array(
			ffc_acf_text( 'field_ffc_home_gallery_kicker', 'home_gallery_kicker', __( 'Gallery Kicker', 'ffc-academy' ), __( 'Club Culture', 'ffc-academy' ) ),
			ffc_acf_text( 'field_ffc_home_gallery_title', 'home_gallery_title', __( 'Gallery Title', 'ffc-academy' ), __( 'Featured Gallery', 'ffc-academy' ) ),
			ffc_acf_text( 'field_ffc_home_gallery_link_label', 'home_gallery_link_label', __( 'Gallery Link Label', 'ffc-academy' ), __( 'Open Gallery', 'ffc-academy' ) ),
		)
	);

	$gallery_labels = array(
		__( 'Training Intensity', 'ffc-academy' ),
		__( 'Matchday Focus', 'ffc-academy' ),
		__( 'Team Standards', 'ffc-academy' ),
		__( 'Player Growth', 'ffc-academy' ),
	);
	foreach ( $gallery_labels as $index => $label ) {
		$number   = $index + 1;
		$fields[] = ffc_acf_text( "field_ffc_home_gallery_fallback_{$number}_label", "home_gallery_fallback_{$number}_label", sprintf( __( 'Fallback Gallery Item %d Label', 'ffc-academy' ), $number ), $label );
	}

	$fields = array_merge(
		$fields,
		array(
			ffc_acf_text( 'field_ffc_home_teamsnap_kicker', 'home_teamsnap_kicker', __( 'TeamSnap Kicker', 'ffc-academy' ), __( 'TeamSnap Hub', 'ffc-academy' ) ),
			ffc_acf_text( 'field_ffc_home_teamsnap_title', 'home_teamsnap_title', __( 'TeamSnap Title', 'ffc-academy' ), __( 'Family Logistics Stay in TeamSnap.', 'ffc-academy' ) ),
			ffc_acf_textarea( 'field_ffc_home_teamsnap_copy', 'home_teamsnap_copy', __( 'TeamSnap Copy', 'ffc-academy' ), __( 'The website promotes the academy while TeamSnap handles the live operational details families already use: schedules, rosters, messages, and registration links.', 'ffc-academy' ) ),
			ffc_acf_text( 'field_ffc_home_teamsnap_button_label', 'home_teamsnap_button_label', __( 'TeamSnap Button Label', 'ffc-academy' ), __( 'Open TeamSnap', 'ffc-academy' ) ),
			ffc_acf_text( 'field_ffc_home_teamsnap_schedule_label', 'home_teamsnap_schedule_label', __( 'TeamSnap Schedule Button Label', 'ffc-academy' ), __( 'Website Schedule', 'ffc-academy' ) ),
			ffc_acf_text( 'field_ffc_home_announcements_kicker', 'home_announcements_kicker', __( 'Announcements Kicker', 'ffc-academy' ), __( 'Academy Desk', 'ffc-academy' ) ),
			ffc_acf_text( 'field_ffc_home_announcements_title', 'home_announcements_title', __( 'Announcements Title', 'ffc-academy' ), __( 'Announcements', 'ffc-academy' ) ),
			ffc_acf_text( 'field_ffc_home_announcements_link_label', 'home_announcements_link_label', __( 'Announcements Link Label', 'ffc-academy' ), __( 'All Updates', 'ffc-academy' ) ),
			ffc_acf_textarea( 'field_ffc_home_announcements_empty_message', 'home_announcements_empty_message', __( 'Announcements Empty Message', 'ffc-academy' ), __( 'Club updates, weather notices, and tournament announcements will appear here.', 'ffc-academy' ) ),
			ffc_acf_text( 'field_ffc_home_sponsors_kicker', 'home_sponsors_kicker', __( 'Sponsors Kicker', 'ffc-academy' ), __( 'Community Partners', 'ffc-academy' ) ),
			ffc_acf_text( 'field_ffc_home_sponsors_title', 'home_sponsors_title', __( 'Sponsors Title', 'ffc-academy' ), __( 'Sponsors Fuel Player Growth', 'ffc-academy' ) ),
			ffc_acf_text( 'field_ffc_home_sponsors_link_label', 'home_sponsors_link_label', __( 'Sponsors Link Label', 'ffc-academy' ), __( 'Partner With F.F.C.', 'ffc-academy' ) ),
			ffc_acf_text( 'field_ffc_home_sponsors_placeholder_tier', 'home_sponsors_placeholder_tier', __( 'Sponsor Placeholder Tier', 'ffc-academy' ), __( 'Partnership Opportunity', 'ffc-academy' ) ),
			ffc_acf_text( 'field_ffc_home_sponsors_placeholder_title', 'home_sponsors_placeholder_title', __( 'Sponsor Placeholder Title', 'ffc-academy' ), __( 'Partner With F.F.C.', 'ffc-academy' ) ),
			ffc_acf_textarea( 'field_ffc_home_sponsors_placeholder_copy', 'home_sponsors_placeholder_copy', __( 'Sponsor Placeholder Copy', 'ffc-academy' ), __( 'Support youth development, tournament access, and a professional academy environment.', 'ffc-academy' ) ),
			ffc_acf_text( 'field_ffc_home_sponsors_placeholder_cta_label', 'home_sponsors_placeholder_cta_label', __( 'Sponsor Placeholder CTA Label', 'ffc-academy' ), __( 'Start a Conversation', 'ffc-academy' ) ),
			ffc_acf_url( 'field_ffc_home_sponsors_placeholder_cta_url', 'home_sponsors_placeholder_cta_url', __( 'Sponsor Placeholder CTA URL', 'ffc-academy' ), home_url( '/contact/' ) ),
			ffc_acf_text( 'field_ffc_home_social_kicker', 'home_social_kicker', __( 'Social Kicker', 'ffc-academy' ), __( 'Follow the Phoenix', 'ffc-academy' ) ),
			ffc_acf_text( 'field_ffc_home_social_title', 'home_social_title', __( 'Social Title', 'ffc-academy' ), __( 'Matchday Moments, Training Clips, and Club Updates', 'ffc-academy' ) ),
			ffc_acf_image( 'field_ffc_home_tryout_image', 'home_tryout_image', __( 'Tryout CTA Image', 'ffc-academy' ) ),
			ffc_acf_text( 'field_ffc_home_tryout_kicker', 'home_tryout_kicker', __( 'Tryout CTA Kicker', 'ffc-academy' ), __( 'Player Evaluations', 'ffc-academy' ) ),
			ffc_acf_text( 'field_ffc_home_tryout_title', 'home_tryout_title', __( 'Tryout CTA Title', 'ffc-academy' ), __( 'Ready to Compete for a Place at F.F.C.?', 'ffc-academy' ) ),
			ffc_acf_textarea( 'field_ffc_home_tryout_copy', 'home_tryout_copy', __( 'Tryout CTA Copy', 'ffc-academy' ), __( 'Register for tryouts and our staff will follow up with age-group placement, evaluation timing, and next steps.', 'ffc-academy' ) ),
			ffc_acf_text( 'field_ffc_home_tryout_button_label', 'home_tryout_button_label', __( 'Tryout CTA Button Label', 'ffc-academy' ), __( 'Start Registration', 'ffc-academy' ) ),
		)
	);

	return $fields;
}

function ffc_homepage_basic_slide_fields(): array {
	$fields = array();
	$slides = array(
		array(
			'kicker'          => __( 'Freedom Futbol Club', 'ffc-academy' ),
			'title'           => __( 'A Serious Soccer Home for Growing Players.', 'ffc-academy' ),
			'copy'            => __( 'Elite standards, family communication, and a clear development pathway for young athletes ready to train, compete, and belong.', 'ffc-academy' ),
			'card_label'      => __( 'Academy Pathway', 'ffc-academy' ),
			'card_meta'       => __( 'U8-U18 player development', 'ffc-academy' ),
			'primary_label'   => __( 'Register for Tryouts', 'ffc-academy' ),
			'primary_url'     => home_url( '/tryouts/' ),
			'secondary_label' => __( 'View Schedule', 'ffc-academy' ),
			'secondary_url'   => get_post_type_archive_link( 'ffc_game' ) ?: home_url( '/games/' ),
		),
		array(
			'kicker'          => __( 'Matchday Ready', 'ffc-academy' ),
			'title'           => __( 'Train With Purpose. Compete With Confidence.', 'ffc-academy' ),
			'copy'            => __( 'Structured sessions prepare players for the pace, pressure, and decision-making of real match environments.', 'ffc-academy' ),
			'card_label'      => __( 'Next Match', 'ffc-academy' ),
			'card_meta'       => __( 'Schedules managed through TeamSnap', 'ffc-academy' ),
			'primary_label'   => __( 'Open TeamSnap', 'ffc-academy' ),
			'primary_url'     => home_url( '/games/' ),
			'secondary_label' => __( 'Latest Scores', 'ffc-academy' ),
			'secondary_url'   => get_post_type_archive_link( 'ffc_score' ) ?: home_url( '/scores/' ),
		),
		array(
			'kicker'          => __( 'Player Development', 'ffc-academy' ),
			'title'           => __( 'Build the Habits That Last Beyond the Field.', 'ffc-academy' ),
			'copy'            => __( 'F.F.C. emphasizes teamwork, sportsmanship, dedication, and excellence in every training block.', 'ffc-academy' ),
			'card_label'      => __( 'Club Culture', 'ffc-academy' ),
			'card_meta'       => __( 'Discipline, unity, leadership', 'ffc-academy' ),
			'primary_label'   => __( 'About F.F.C.', 'ffc-academy' ),
			'primary_url'     => home_url( '/about/' ),
			'secondary_label' => __( 'Contact Us', 'ffc-academy' ),
			'secondary_url'   => home_url( '/contact/' ),
		),
	);

	for ( $i = 1; $i <= 3; $i++ ) {
		$slide    = $slides[ $i - 1 ];
		$fields[] = ffc_acf_image( "field_ffc_home_slide_{$i}_image", "home_slide_{$i}_image", sprintf( __( 'Slide %d Image', 'ffc-academy' ), $i ) );
		$fields[] = ffc_acf_text( "field_ffc_home_slide_{$i}_kicker", "home_slide_{$i}_kicker", sprintf( __( 'Slide %d Kicker', 'ffc-academy' ), $i ), $slide['kicker'] );
		$fields[] = ffc_acf_text( "field_ffc_home_slide_{$i}_title", "home_slide_{$i}_title", sprintf( __( 'Slide %d Title', 'ffc-academy' ), $i ), $slide['title'] );
		$fields[] = ffc_acf_textarea( "field_ffc_home_slide_{$i}_copy", "home_slide_{$i}_copy", sprintf( __( 'Slide %d Copy', 'ffc-academy' ), $i ), $slide['copy'] );
		$fields[] = ffc_acf_text( "field_ffc_home_slide_{$i}_card_label", "home_slide_{$i}_card_label", sprintf( __( 'Slide %d Side Card Label', 'ffc-academy' ), $i ), $slide['card_label'] );
		$fields[] = ffc_acf_text( "field_ffc_home_slide_{$i}_card_meta", "home_slide_{$i}_card_meta", sprintf( __( 'Slide %d Side Card Text', 'ffc-academy' ), $i ), $slide['card_meta'] );
		$fields[] = ffc_acf_text( "field_ffc_home_slide_{$i}_primary_label", "home_slide_{$i}_primary_label", sprintf( __( 'Slide %d Primary Button Label', 'ffc-academy' ), $i ), $slide['primary_label'] );
		$fields[] = ffc_acf_url( "field_ffc_home_slide_{$i}_primary_url", "home_slide_{$i}_primary_url", sprintf( __( 'Slide %d Primary Button URL', 'ffc-academy' ), $i ), $slide['primary_url'] );
		$fields[] = ffc_acf_text( "field_ffc_home_slide_{$i}_secondary_label", "home_slide_{$i}_secondary_label", sprintf( __( 'Slide %d Secondary Button Label', 'ffc-academy' ), $i ), $slide['secondary_label'] );
		$fields[] = ffc_acf_url( "field_ffc_home_slide_{$i}_secondary_url", "home_slide_{$i}_secondary_url", sprintf( __( 'Slide %d Secondary Button URL', 'ffc-academy' ), $i ), $slide['secondary_url'] );
	}

	return $fields;
}

function ffc_about_page_fields(): array {
	$fields = array(
		ffc_acf_text( 'field_ffc_about_hero_kicker', 'about_hero_kicker', __( 'Hero Kicker', 'ffc-academy' ), __( 'About F.F.C.', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_about_hero_title', 'about_hero_title', __( 'Hero Title', 'ffc-academy' ), __( 'Freedom Futbol Club', 'ffc-academy' ) ),
		ffc_acf_textarea( 'field_ffc_about_hero_copy', 'about_hero_copy', __( 'Hero Copy', 'ffc-academy' ), __( 'F.F.C. is a youth soccer academy built around player growth, positive team culture, and clear communication for families. We create an environment where young athletes can train with purpose, compete with confidence, and learn values that carry beyond the field.', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_about_intro_title', 'about_intro_title', __( 'Intro Title', 'ffc-academy' ), __( 'A Club Environment for Ambitious Young Players', 'ffc-academy' ) ),
		ffc_acf_textarea( 'field_ffc_about_intro_copy_one', 'about_intro_copy_one', __( 'Intro Copy 1', 'ffc-academy' ), __( 'Our academy model balances high standards with a family-friendly experience. Players are challenged technically and tactically, while coaches emphasize teamwork, sportsmanship, dedication, and resilience.', 'ffc-academy' ) ),
		ffc_acf_textarea( 'field_ffc_about_intro_copy_two', 'about_intro_copy_two', __( 'Intro Copy 2', 'ffc-academy' ), __( 'From foundational age groups through competitive teams, F.F.C. provides structured training, match preparation, and a shared identity rooted in discipline, unity, and continuous improvement.', 'ffc-academy' ) ),
		ffc_acf_image( 'field_ffc_about_intro_image', 'about_intro_image', __( 'Intro Image', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_about_intro_image_alt', 'about_intro_image_alt', __( 'Intro Image Alt Text', 'ffc-academy' ), __( 'F.F.C. players and families at a soccer field', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_about_values_kicker', 'about_values_kicker', __( 'Values Kicker', 'ffc-academy' ), __( 'What We Value', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_about_values_title', 'about_values_title', __( 'Values Title', 'ffc-academy' ), __( 'The Standards Behind the Crest', 'ffc-academy' ) ),
	);
	$values = array(
		array(
			'title' => __( 'Teamwork', 'ffc-academy' ),
			'copy'  => __( 'We build inclusive teams that pursue common goals with trust and accountability.', 'ffc-academy' ),
		),
		array(
			'title' => __( 'Sportsmanship', 'ffc-academy' ),
			'copy'  => __( 'Players, coaches, and families represent the club with respect on every touchline.', 'ffc-academy' ),
		),
		array(
			'title' => __( 'Dedication', 'ffc-academy' ),
			'copy'  => __( 'Consistent effort, preparation, and coachability drive long-term player development.', 'ffc-academy' ),
		),
		array(
			'title' => __( 'Excellence', 'ffc-academy' ),
			'copy'  => __( 'We aim to deliver a quality soccer experience for every player and family.', 'ffc-academy' ),
		),
	);

	for ( $i = 1; $i <= 4; $i++ ) {
		$fields[] = ffc_acf_image( "field_ffc_about_value_{$i}_image", "about_value_{$i}_image", sprintf( __( 'Value %d Image', 'ffc-academy' ), $i ) );
		$fields[] = ffc_acf_text( "field_ffc_about_value_{$i}_title", "about_value_{$i}_title", sprintf( __( 'Value %d Title', 'ffc-academy' ), $i ), $values[ $i - 1 ]['title'] );
		$fields[] = ffc_acf_textarea( "field_ffc_about_value_{$i}_copy", "about_value_{$i}_copy", sprintf( __( 'Value %d Copy', 'ffc-academy' ), $i ), $values[ $i - 1 ]['copy'] );
	}

	$fields[] = ffc_acf_text( 'field_ffc_about_story_kicker', 'about_story_kicker', __( 'Story Kicker', 'ffc-academy' ), __( 'Our Story', 'ffc-academy' ) );
	$fields[] = ffc_acf_text( 'field_ffc_about_story_title', 'about_story_title', __( 'Story Title', 'ffc-academy' ), __( 'Growing the Game With Community at the Center', 'ffc-academy' ) );
	$timeline = array(
		array(
			'label' => __( 'Foundation', 'ffc-academy' ),
			'title' => __( 'A Place to Belong', 'ffc-academy' ),
			'copy'  => __( 'F.F.C. gives players a structured club home where training, communication, and team culture all work together.', 'ffc-academy' ),
		),
		array(
			'label' => __( 'Development', 'ffc-academy' ),
			'title' => __( 'A Path to Improve', 'ffc-academy' ),
			'copy'  => __( 'Age-appropriate coaching helps players grow in confidence, skill, decision-making, and love for the game.', 'ffc-academy' ),
		),
		array(
			'label' => __( 'Competition', 'ffc-academy' ),
			'title' => __( 'A Standard to Chase', 'ffc-academy' ),
			'copy'  => __( 'Matchdays and tournaments become opportunities to test progress, learn resilience, and represent the club well.', 'ffc-academy' ),
		),
	);

	for ( $i = 1; $i <= 3; $i++ ) {
		$fields[] = ffc_acf_text( "field_ffc_about_timeline_{$i}_label", "about_timeline_{$i}_label", sprintf( __( 'Timeline %d Label', 'ffc-academy' ), $i ), $timeline[ $i - 1 ]['label'] );
		$fields[] = ffc_acf_text( "field_ffc_about_timeline_{$i}_title", "about_timeline_{$i}_title", sprintf( __( 'Timeline %d Title', 'ffc-academy' ), $i ), $timeline[ $i - 1 ]['title'] );
		$fields[] = ffc_acf_textarea( "field_ffc_about_timeline_{$i}_copy", "about_timeline_{$i}_copy", sprintf( __( 'Timeline %d Copy', 'ffc-academy' ), $i ), $timeline[ $i - 1 ]['copy'] );
	}

	$fields[] = ffc_acf_text( 'field_ffc_about_cta_title', 'about_cta_title', __( 'CTA Title', 'ffc-academy' ), __( 'Ready to Learn More?', 'ffc-academy' ) );
	$fields[] = ffc_acf_text( 'field_ffc_about_cta_primary_label', 'about_cta_primary_label', __( 'Primary CTA Label', 'ffc-academy' ), __( 'Register for Tryouts', 'ffc-academy' ) );
	$fields[] = ffc_acf_url( 'field_ffc_about_cta_primary_url', 'about_cta_primary_url', __( 'Primary CTA URL', 'ffc-academy' ), home_url( '/tryouts/' ) );
	$fields[] = ffc_acf_text( 'field_ffc_about_cta_secondary_label', 'about_cta_secondary_label', __( 'Secondary CTA Label', 'ffc-academy' ), __( 'Contact F.F.C.', 'ffc-academy' ) );
	$fields[] = ffc_acf_url( 'field_ffc_about_cta_secondary_url', 'about_cta_secondary_url', __( 'Secondary CTA URL', 'ffc-academy' ), home_url( '/contact/' ) );

	return $fields;
}

function ffc_contact_page_fields(): array {
	$fields = array(
		ffc_acf_text( 'field_ffc_contact_hero_kicker', 'contact_hero_kicker', __( 'Hero Kicker', 'ffc-academy' ), __( 'Contact F.F.C.', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_contact_hero_title', 'contact_hero_title', __( 'Hero Title', 'ffc-academy' ), __( 'Let\'s Talk Soccer.', 'ffc-academy' ) ),
		ffc_acf_textarea( 'field_ffc_contact_hero_copy', 'contact_hero_copy', __( 'Hero Copy', 'ffc-academy' ), __( 'Reach out about tryouts, schedules, sponsorship, coaching questions, or community partnerships.', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_contact_card_label', 'contact_card_label', __( 'Hero Card Label', 'ffc-academy' ), __( 'Fastest Path', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_contact_card_title', 'contact_card_title', __( 'Hero Card Title', 'ffc-academy' ), __( 'Register for tryouts online.', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_contact_card_button_label', 'contact_card_button_label', __( 'Hero Card Button Label', 'ffc-academy' ), __( 'Tryout Form', 'ffc-academy' ) ),
		ffc_acf_url( 'field_ffc_contact_card_button_url', 'contact_card_button_url', __( 'Hero Card Button URL', 'ffc-academy' ), home_url( '/tryouts/' ) ),
		ffc_acf_text( 'field_ffc_contact_panel_kicker', 'contact_panel_kicker', __( 'Panel Kicker', 'ffc-academy' ), __( 'Club Office', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_contact_panel_title', 'contact_panel_title', __( 'Panel Title', 'ffc-academy' ), __( 'How Can We Help?', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_contact_form_shortcode', 'contact_form_shortcode', __( 'Contact Form Shortcode', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_contact_fallback_name_label', 'contact_fallback_name_label', __( 'Fallback Form Name Label', 'ffc-academy' ), __( 'Name', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_contact_fallback_email_label', 'contact_fallback_email_label', __( 'Fallback Form Email Label', 'ffc-academy' ), __( 'Email', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_contact_fallback_message_label', 'contact_fallback_message_label', __( 'Fallback Form Message Label', 'ffc-academy' ), __( 'Message', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_contact_fallback_button_label', 'contact_fallback_button_label', __( 'Fallback Form Button Label', 'ffc-academy' ), __( 'Send Message', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_contact_success_message', 'contact_success_message', __( 'Success Message', 'ffc-academy' ), __( 'Message received. Our staff will follow up soon.', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_contact_error_message', 'contact_error_message', __( 'Error Message', 'ffc-academy' ), __( 'Please check the required fields and try again.', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_contact_email_subject', 'contact_email_subject', __( 'Admin Email Subject', 'ffc-academy' ), __( 'New F.F.C. Contact Message: {name}', 'ffc-academy' ) ),
	);
	$methods = array(
		array(
			'title' => __( 'Tryouts', 'ffc-academy' ),
			'copy'  => __( 'Player evaluations and age-group placement.', 'ffc-academy' ),
		),
		array(
			'title' => __( 'TeamSnap', 'ffc-academy' ),
			'copy'  => __( 'Schedules, rosters, and family logistics.', 'ffc-academy' ),
		),
		array(
			'title' => __( 'Sponsors', 'ffc-academy' ),
			'copy'  => __( 'Partnerships supporting youth development.', 'ffc-academy' ),
		),
	);

	for ( $i = 1; $i <= 3; $i++ ) {
		$fields[] = ffc_acf_text( "field_ffc_contact_method_{$i}_title", "contact_method_{$i}_title", sprintf( __( 'Contact Method %d Title', 'ffc-academy' ), $i ), $methods[ $i - 1 ]['title'] );
		$fields[] = ffc_acf_textarea( "field_ffc_contact_method_{$i}_copy", "contact_method_{$i}_copy", sprintf( __( 'Contact Method %d Copy', 'ffc-academy' ), $i ), $methods[ $i - 1 ]['copy'] );
	}

	return $fields;
}

function ffc_tryout_page_fields(): array {
	$fields = array(
		ffc_acf_text( 'field_ffc_tryout_hero_kicker', 'tryout_hero_kicker', __( 'Hero Kicker', 'ffc-academy' ), __( 'Join F.F.C.', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_tryout_hero_title', 'tryout_hero_title', __( 'Hero Title', 'ffc-academy' ), __( 'Tryout Registration', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_tryout_intro_title', 'tryout_intro_title', __( 'Intro Title', 'ffc-academy' ), __( 'Start the Player Evaluation Process', 'ffc-academy' ) ),
		ffc_acf_textarea( 'field_ffc_tryout_intro_copy', 'tryout_intro_copy', __( 'Intro Copy', 'ffc-academy' ), __( 'Submit player and guardian details so academy staff can place athletes in the correct evaluation group and follow up with next steps.', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_tryout_success_message', 'tryout_success_message', __( 'Success Message', 'ffc-academy' ), __( 'Registration received. Our staff will follow up soon.', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_tryout_error_message', 'tryout_error_message', __( 'Error Message', 'ffc-academy' ), __( 'Please check the required fields and try again.', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_tryout_unavailable_message', 'tryout_unavailable_message', __( 'Unavailable Session Message', 'ffc-academy' ), __( 'The selected tryout session is no longer available. Please choose another open session.', 'ffc-academy' ) ),
		ffc_acf_textarea( 'field_ffc_tryout_no_sessions_message', 'tryout_no_sessions_message', __( 'No Open Sessions Message', 'ffc-academy' ), __( 'No tryout sessions are currently open. Please check back soon or contact us for the next evaluation window.', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_tryout_no_sessions_button_label', 'tryout_no_sessions_button_label', __( 'No Sessions CTA Label', 'ffc-academy' ), __( 'Contact Us', 'ffc-academy' ) ),
		ffc_acf_url( 'field_ffc_tryout_no_sessions_button_url', 'tryout_no_sessions_button_url', __( 'No Sessions CTA URL', 'ffc-academy' ), home_url( '/contact/' ) ),
		ffc_acf_text( 'field_ffc_tryout_session_placeholder', 'tryout_session_placeholder', __( 'Tryout Session Placeholder', 'ffc-academy' ), __( 'Select an open tryout session', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_tryout_submit_label', 'tryout_submit_label', __( 'Submit Button Label', 'ffc-academy' ), __( 'Submit Registration', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_tryout_age_group_placeholder', 'tryout_age_group_placeholder', __( 'Age Group Placeholder', 'ffc-academy' ), __( 'U10, U12, U14', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_tryout_admin_email_subject', 'tryout_admin_email_subject', __( 'Admin Email Subject', 'ffc-academy' ), __( 'New F.F.C. Tryout Registration: {player_first_name} {player_last_name}', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_tryout_parent_email_subject', 'tryout_parent_email_subject', __( 'Parent Confirmation Email Subject', 'ffc-academy' ), __( 'F.F.C. Tryout Registration Received', 'ffc-academy' ) ),
		ffc_acf_textarea( 'field_ffc_tryout_parent_email_intro', 'tryout_parent_email_intro', __( 'Parent Confirmation Email Intro', 'ffc-academy' ), __( 'Thank you for registering with F.F.C. Our staff will review the submission and follow up with next steps.', 'ffc-academy' ) ),
	);

	$labels = array(
		'player_first_name'     => __( 'Player First Name', 'ffc-academy' ),
		'player_last_name'      => __( 'Player Last Name', 'ffc-academy' ),
		'date_of_birth'         => __( 'Date of Birth', 'ffc-academy' ),
		'age_group'             => __( 'Age Group', 'ffc-academy' ),
		'preferred_position'    => __( 'Preferred Position', 'ffc-academy' ),
		'preferred_tryout_date' => __( 'Preferred Tryout Session', 'ffc-academy' ),
		'previous_experience'   => __( 'Previous Experience', 'ffc-academy' ),
		'parent_name'           => __( 'Parent/Guardian Name', 'ffc-academy' ),
		'parent_email'          => __( 'Parent/Guardian Email', 'ffc-academy' ),
		'parent_phone'          => __( 'Parent/Guardian Phone', 'ffc-academy' ),
		'emergency_contact'     => __( 'Emergency Contact', 'ffc-academy' ),
		'medical_notes'         => __( 'Medical Notes', 'ffc-academy' ),
		'additional_comments'   => __( 'Additional Comments', 'ffc-academy' ),
	);

	foreach ( $labels as $name => $default ) {
		$fields[] = ffc_acf_text(
			'field_ffc_tryout_label_' . $name,
			'tryout_label_' . $name,
			sprintf(
				/* translators: %s: form field label. */
				__( 'Form Label: %s', 'ffc-academy' ),
				$default
			),
			$default
		);
	}

	return $fields;
}

function ffc_tryout_registration_fields(): array {
	return array(
		ffc_acf_select(
			'field_ffc_tryout_registration_status',
			'registration_status',
			__( 'Registration Status', 'ffc-academy' ),
			array(
				'new'       => __( 'New', 'ffc-academy' ),
				'contacted' => __( 'Contacted', 'ffc-academy' ),
				'scheduled' => __( 'Scheduled', 'ffc-academy' ),
				'completed' => __( 'Completed', 'ffc-academy' ),
			)
		),
		ffc_acf_text( 'field_ffc_tryout_reg_session_id', 'tryout_session_id', __( 'Tryout Session ID', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_tryout_reg_session_label', 'tryout_session_label', __( 'Tryout Session', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_tryout_reg_player_first_name', 'player_first_name', __( 'Player First Name', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_tryout_reg_player_last_name', 'player_last_name', __( 'Player Last Name', 'ffc-academy' ) ),
		ffc_acf_date( 'field_ffc_tryout_reg_date_of_birth', 'date_of_birth', __( 'Date of Birth', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_tryout_reg_age_group', 'age_group', __( 'Age Group', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_tryout_reg_preferred_position', 'preferred_position', __( 'Preferred Position', 'ffc-academy' ) ),
		ffc_acf_date( 'field_ffc_tryout_reg_preferred_tryout_date', 'preferred_tryout_date', __( 'Preferred Tryout Date', 'ffc-academy' ) ),
		ffc_acf_textarea( 'field_ffc_tryout_reg_previous_experience', 'previous_experience', __( 'Previous Experience', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_tryout_reg_parent_name', 'parent_name', __( 'Parent/Guardian Name', 'ffc-academy' ) ),
		ffc_acf_email( 'field_ffc_tryout_reg_parent_email', 'parent_email', __( 'Parent/Guardian Email', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_tryout_reg_parent_phone', 'parent_phone', __( 'Parent/Guardian Phone', 'ffc-academy' ) ),
		ffc_acf_text( 'field_ffc_tryout_reg_emergency_contact', 'emergency_contact', __( 'Emergency Contact', 'ffc-academy' ) ),
		ffc_acf_textarea( 'field_ffc_tryout_reg_medical_notes', 'medical_notes', __( 'Medical Notes', 'ffc-academy' ) ),
		ffc_acf_textarea( 'field_ffc_tryout_reg_additional_comments', 'additional_comments', __( 'Additional Comments', 'ffc-academy' ) ),
		ffc_acf_textarea( 'field_ffc_tryout_reg_staff_notes', 'staff_notes', __( 'Staff Notes', 'ffc-academy' ) ),
	);
}

function ffc_acf_text( string $key, string $name, string $label, string $default = '' ): array {
	$field = array(
		'key'   => $key,
		'label' => $label,
		'name'  => $name,
		'type'  => 'text',
	);

	if ( '' !== $default ) {
		$field['default_value'] = $default;
	}

	return $field;
}

function ffc_acf_url( string $key, string $name, string $label, string $default = '' ): array {
	$field = array(
		'key'   => $key,
		'label' => $label,
		'name'  => $name,
		'type'  => 'url',
	);

	if ( '' !== $default ) {
		$field['default_value'] = $default;
	}

	return $field;
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

function ffc_acf_date( string $key, string $name, string $label ): array {
	return array(
		'key'            => $key,
		'label'          => $label,
		'name'           => $name,
		'type'           => 'date_picker',
		'display_format' => 'M j, Y',
		'return_format'  => 'Y-m-d',
	);
}

function ffc_acf_true_false( string $key, string $name, string $label ): array {
	return array(
		'key'           => $key,
		'label'         => $label,
		'name'          => $name,
		'type'          => 'true_false',
		'ui'            => 1,
		'default_value' => 0,
	);
}

function ffc_acf_textarea( string $key, string $name, string $label, string $default = '' ): array {
	$field = array(
		'key'   => $key,
		'label' => $label,
		'name'  => $name,
		'type'  => 'textarea',
		'rows'  => 4,
	);

	if ( '' !== $default ) {
		$field['default_value'] = $default;
	}

	return $field;
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
