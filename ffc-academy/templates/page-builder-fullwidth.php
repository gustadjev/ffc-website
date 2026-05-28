<?php
/**
 * Template Name: Builder Full Width
 * Template Post Type: page
 *
 * @package FFCAcademy
 */

get_header();
while ( have_posts() ) :
	the_post();
	ffc_render_builder_page( get_the_ID() );
endwhile;
get_footer();
