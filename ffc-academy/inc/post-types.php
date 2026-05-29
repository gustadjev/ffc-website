<?php
/**
 * Custom post types and taxonomies.
 *
 * @package FFCAcademy
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'ffc_register_content_types' );
function ffc_register_content_types(): void {
	$types = array(
		'ffc_game'         => array(
			'singular' => __( 'Game', 'ffc-academy' ),
			'plural'   => __( 'Games', 'ffc-academy' ),
			'icon'     => 'dashicons-calendar-alt',
			'slug'     => 'games',
			'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
		),
		'ffc_score'        => array(
			'singular' => __( 'Score', 'ffc-academy' ),
			'plural'   => __( 'Scores', 'ffc-academy' ),
			'icon'     => 'dashicons-awards',
			'slug'     => 'scores',
			'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
		),
		'ffc_coach'        => array(
			'singular' => __( 'Coach', 'ffc-academy' ),
			'plural'   => __( 'Coaches', 'ffc-academy' ),
			'icon'     => 'dashicons-groups',
			'slug'     => 'coaches',
			'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
		),
		'ffc_announcement' => array(
			'singular' => __( 'Announcement', 'ffc-academy' ),
			'plural'   => __( 'Announcements', 'ffc-academy' ),
			'icon'     => 'dashicons-megaphone',
			'slug'     => 'announcements',
			'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
		),
		'ffc_sponsor'      => array(
			'singular' => __( 'Sponsor', 'ffc-academy' ),
			'plural'   => __( 'Sponsors', 'ffc-academy' ),
			'icon'     => 'dashicons-businessperson',
			'slug'     => 'sponsors',
			'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
		),
		'ffc_gallery'      => array(
			'singular' => __( 'Gallery Item', 'ffc-academy' ),
			'plural'   => __( 'Gallery Items', 'ffc-academy' ),
			'icon'     => 'dashicons-format-gallery',
			'slug'     => 'gallery',
			'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
		),
		'ffc_tryout_session' => array(
			'singular' => __( 'Tryout Session', 'ffc-academy' ),
			'plural'   => __( 'Tryout Sessions', 'ffc-academy' ),
			'icon'     => 'dashicons-calendar',
			'slug'     => 'tryout-sessions',
			'supports' => array( 'title', 'editor', 'revisions' ),
			'public'   => false,
		),
		'ffc_tryout'       => array(
			'singular' => __( 'Tryout Registration', 'ffc-academy' ),
			'plural'   => __( 'Tryout Registrations', 'ffc-academy' ),
			'icon'     => 'dashicons-clipboard',
			'slug'     => 'tryout-registrations',
			'supports' => array( 'title', 'editor', 'custom-fields' ),
			'public'   => false,
		),
	);

	foreach ( $types as $post_type => $args ) {
		$public = array_key_exists( 'public', $args ) ? (bool) $args['public'] : true;

		register_post_type(
			$post_type,
			array(
				'labels'          => ffc_post_type_labels( $args['singular'], $args['plural'] ),
				'public'          => $public,
				'show_ui'         => true,
				'show_in_rest'    => true,
				'menu_icon'       => $args['icon'],
				'has_archive'     => $public,
				'rewrite'         => $public ? array( 'slug' => $args['slug'] ) : false,
				'supports'        => $args['supports'],
				'capability_type' => 'post',
			)
		);
	}

	register_taxonomy(
		'ffc_team',
		array( 'ffc_game', 'ffc_score', 'ffc_coach' ),
		array(
			'labels'            => ffc_taxonomy_labels( __( 'Team', 'ffc-academy' ), __( 'Teams', 'ffc-academy' ) ),
			'public'            => true,
			'show_admin_column' => true,
			'show_in_quick_edit' => true,
			'show_in_rest'      => true,
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => 'team' ),
		)
	);

	register_taxonomy(
		'ffc_season',
		array( 'ffc_game', 'ffc_score' ),
		array(
			'labels'            => ffc_taxonomy_labels( __( 'Season', 'ffc-academy' ), __( 'Seasons', 'ffc-academy' ) ),
			'public'            => true,
			'show_admin_column' => true,
			'show_in_quick_edit' => true,
			'show_in_rest'      => true,
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => 'season' ),
		)
	);

	register_taxonomy(
		'ffc_gallery_category',
		'ffc_gallery',
		array(
			'labels'            => ffc_taxonomy_labels( __( 'Gallery Category', 'ffc-academy' ), __( 'Gallery Categories', 'ffc-academy' ) ),
			'public'            => true,
			'show_admin_column' => true,
			'show_in_quick_edit' => true,
			'show_in_rest'      => true,
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => 'gallery-category' ),
		)
	);

	register_taxonomy(
		'ffc_sponsor_tier',
		'ffc_sponsor',
		array(
			'labels'            => ffc_taxonomy_labels( __( 'Sponsor Tier', 'ffc-academy' ), __( 'Sponsor Tiers', 'ffc-academy' ) ),
			'public'            => true,
			'show_admin_column' => true,
			'show_in_quick_edit' => true,
			'show_in_rest'      => true,
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => 'sponsor-tier' ),
		)
	);
}

function ffc_post_type_labels( string $singular, string $plural ): array {
	return array(
		'name'               => $plural,
		'singular_name'      => $singular,
		'add_new'            => __( 'Add New', 'ffc-academy' ),
		'add_new_item'       => sprintf(
			/* translators: %s: singular post type label. */
			__( 'Add New %s', 'ffc-academy' ),
			$singular
		),
		'edit_item'          => sprintf(
			/* translators: %s: singular post type label. */
			__( 'Edit %s', 'ffc-academy' ),
			$singular
		),
		'new_item'           => sprintf(
			/* translators: %s: singular post type label. */
			__( 'New %s', 'ffc-academy' ),
			$singular
		),
		'view_item'          => sprintf(
			/* translators: %s: singular post type label. */
			__( 'View %s', 'ffc-academy' ),
			$singular
		),
		'search_items'       => sprintf(
			/* translators: %s: plural post type label. */
			__( 'Search %s', 'ffc-academy' ),
			$plural
		),
		'not_found'          => sprintf(
			/* translators: %s: plural post type label. */
			__( 'No %s found', 'ffc-academy' ),
			strtolower( $plural )
		),
		'not_found_in_trash' => sprintf(
			/* translators: %s: plural post type label. */
			__( 'No %s found in Trash', 'ffc-academy' ),
			strtolower( $plural )
		),
		'all_items'          => sprintf(
			/* translators: %s: plural post type label. */
			__( 'All %s', 'ffc-academy' ),
			$plural
		),
		'menu_name'          => $plural,
	);
}

function ffc_taxonomy_labels( string $singular, string $plural ): array {
	return array(
		'name'              => $plural,
		'singular_name'     => $singular,
		'search_items'      => sprintf(
			/* translators: %s: plural taxonomy label. */
			__( 'Search %s', 'ffc-academy' ),
			$plural
		),
		'all_items'         => sprintf(
			/* translators: %s: plural taxonomy label. */
			__( 'All %s', 'ffc-academy' ),
			$plural
		),
		'parent_item'       => sprintf(
			/* translators: %s: singular taxonomy label. */
			__( 'Parent %s', 'ffc-academy' ),
			$singular
		),
		'parent_item_colon' => sprintf(
			/* translators: %s: singular taxonomy label. */
			__( 'Parent %s:', 'ffc-academy' ),
			$singular
		),
		'edit_item'         => sprintf(
			/* translators: %s: singular taxonomy label. */
			__( 'Edit %s', 'ffc-academy' ),
			$singular
		),
		'update_item'       => sprintf(
			/* translators: %s: singular taxonomy label. */
			__( 'Update %s', 'ffc-academy' ),
			$singular
		),
		'add_new_item'      => sprintf(
			/* translators: %s: singular taxonomy label. */
			__( 'Add New %s', 'ffc-academy' ),
			$singular
		),
		'new_item_name'     => sprintf(
			/* translators: %s: singular taxonomy label. */
			__( 'New %s Name', 'ffc-academy' ),
			$singular
		),
		'menu_name'         => $plural,
	);
}
