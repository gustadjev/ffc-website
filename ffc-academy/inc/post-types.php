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
			'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
		),
		'ffc_gallery'      => array(
			'singular' => __( 'Gallery Item', 'ffc-academy' ),
			'plural'   => __( 'Gallery Items', 'ffc-academy' ),
			'icon'     => 'dashicons-format-gallery',
			'slug'     => 'gallery',
			'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
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
				'labels'          => array(
					'name'          => $args['plural'],
					'singular_name' => $args['singular'],
					'add_new_item'  => sprintf( __( 'Add New %s', 'ffc-academy' ), $args['singular'] ),
					'edit_item'     => sprintf( __( 'Edit %s', 'ffc-academy' ), $args['singular'] ),
				),
				'public'          => $public,
				'show_ui'         => true,
				'show_in_rest'    => true,
				'menu_icon'       => $args['icon'],
				'has_archive'     => $public,
				'rewrite'         => array( 'slug' => $args['slug'] ),
				'supports'        => $args['supports'],
				'capability_type' => 'post',
			)
		);
	}

	register_taxonomy(
		'ffc_team',
		array( 'ffc_game', 'ffc_score', 'ffc_coach' ),
		array(
			'labels'       => array( 'name' => __( 'Teams', 'ffc-academy' ) ),
			'public'       => true,
			'show_in_rest' => true,
			'hierarchical' => true,
			'rewrite'      => array( 'slug' => 'team' ),
		)
	);

	register_taxonomy(
		'ffc_season',
		array( 'ffc_game', 'ffc_score' ),
		array(
			'labels'       => array( 'name' => __( 'Seasons', 'ffc-academy' ) ),
			'public'       => true,
			'show_in_rest' => true,
			'hierarchical' => false,
			'rewrite'      => array( 'slug' => 'season' ),
		)
	);

	register_taxonomy(
		'ffc_gallery_category',
		'ffc_gallery',
		array(
			'labels'       => array( 'name' => __( 'Gallery Categories', 'ffc-academy' ) ),
			'public'       => true,
			'show_in_rest' => true,
			'hierarchical' => true,
			'rewrite'      => array( 'slug' => 'gallery-category' ),
		)
	);

	register_taxonomy(
		'ffc_sponsor_tier',
		'ffc_sponsor',
		array(
			'labels'       => array( 'name' => __( 'Sponsor Tiers', 'ffc-academy' ) ),
			'public'       => true,
			'show_in_rest' => true,
			'hierarchical' => true,
			'rewrite'      => array( 'slug' => 'sponsor-tier' ),
		)
	);
}
