<?php
/**
 * Gutenberg enhancements.
 *
 * @package FFCAcademy
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'ffc_register_block_styles' );
function ffc_register_block_styles(): void {
	register_block_style(
		'core/group',
		array(
			'name'  => 'ffc-navy-band',
			'label' => __( 'F.F.C. Navy Band', 'ffc-academy' ),
		)
	);

	register_block_style(
		'core/group',
		array(
			'name'  => 'ffc-ivory-band',
			'label' => __( 'F.F.C. Ivory Band', 'ffc-academy' ),
		)
	);

	register_block_style(
		'core/button',
		array(
			'name'  => 'ffc-rose-gold',
			'label' => __( 'F.F.C. Rose Gold', 'ffc-academy' ),
		)
	);

	register_block_style(
		'core/button',
		array(
			'name'  => 'ffc-outline',
			'label' => __( 'F.F.C. Outline', 'ffc-academy' ),
		)
	);

	register_block_style(
		'core/quote',
		array(
			'name'  => 'ffc-touchline-quote',
			'label' => __( 'F.F.C. Touchline Quote', 'ffc-academy' ),
		)
	);
}

add_action( 'init', 'ffc_register_block_patterns' );
function ffc_register_block_patterns(): void {
	if ( ! function_exists( 'register_block_pattern' ) || ! function_exists( 'register_block_pattern_category' ) ) {
		return;
	}

	register_block_pattern_category(
		'ffc-academy',
		array(
			'label' => __( 'F.F.C. Academy', 'ffc-academy' ),
		)
	);

	register_block_pattern(
		'ffc-academy/academy-callout',
		array(
			'title'       => __( 'Academy Callout', 'ffc-academy' ),
			'description' => __( 'A branded navy callout with heading, copy, and two buttons.', 'ffc-academy' ),
			'categories'  => array( 'ffc-academy' ),
			'content'     => '<!-- wp:group {"className":"is-style-ffc-navy-band","layout":{"type":"constrained"}} --><div class="wp-block-group is-style-ffc-navy-band"><!-- wp:heading {"level":2} --><h2>' . esc_html__( 'Train With Purpose', 'ffc-academy' ) . '</h2><!-- /wp:heading --><!-- wp:paragraph {"fontSize":"lead"} --><p class="has-lead-font-size">' . esc_html__( 'Give families a concise update, program highlight, or seasonal call to action in the F.F.C. voice.', 'ffc-academy' ) . '</p><!-- /wp:paragraph --><!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button {"className":"is-style-ffc-rose-gold"} --><div class="wp-block-button is-style-ffc-rose-gold"><a class="wp-block-button__link wp-element-button">' . esc_html__( 'Register Now', 'ffc-academy' ) . '</a></div><!-- /wp:button --><!-- wp:button {"className":"is-style-ffc-outline"} --><div class="wp-block-button is-style-ffc-outline"><a class="wp-block-button__link wp-element-button">' . esc_html__( 'View Schedule', 'ffc-academy' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div><!-- /wp:group -->',
		)
	);

	register_block_pattern(
		'ffc-academy/announcement-panel',
		array(
			'title'       => __( 'Announcement Panel', 'ffc-academy' ),
			'description' => __( 'A soft ivory announcement block for updates, reminders, and community notes.', 'ffc-academy' ),
			'categories'  => array( 'ffc-academy' ),
			'content'     => '<!-- wp:group {"className":"is-style-ffc-ivory-band","layout":{"type":"constrained"}} --><div class="wp-block-group is-style-ffc-ivory-band"><!-- wp:paragraph {"className":"eyebrow"} --><p class="eyebrow">' . esc_html__( 'Academy Desk', 'ffc-academy' ) . '</p><!-- /wp:paragraph --><!-- wp:heading {"level":3} --><h3>' . esc_html__( 'Practice Update', 'ffc-academy' ) . '</h3><!-- /wp:heading --><!-- wp:paragraph --><p>' . esc_html__( 'Use this pattern for weather notices, tournament reminders, sponsor notes, and family updates.', 'ffc-academy' ) . '</p><!-- /wp:paragraph --></div><!-- /wp:group -->',
		)
	);
}
