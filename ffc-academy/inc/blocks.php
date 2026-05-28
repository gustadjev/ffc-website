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
		'core/button',
		array(
			'name'  => 'ffc-rose-gold',
			'label' => __( 'F.F.C. Rose Gold', 'ffc-academy' ),
		)
	);
}
