<?php
/**
 * Template part for displaying a pagination
 *
 * @package calacas_theme
 */

namespace WP_Calacas\WP_Calacas;

the_posts_pagination(
	[
		'mid_size'           => 2,
		'prev_text'          => _x( 'Previous', 'previous set of search results', 'calacas-theme' ),
		'next_text'          => _x( 'Next', 'next set of search results', 'calacas-theme' ),
		'screen_reader_text' => __( 'Page navigation', 'calacas-theme' ),
	]
);
