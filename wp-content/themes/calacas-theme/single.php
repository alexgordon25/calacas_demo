<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package calacas_theme
 */

namespace WP_Calacas\WP_Calacas;

get_header();

calacas_theme()->print_styles( 'calacas-theme-content' );

?>
	<main id="primary" class="site-main">
		<?php

		while ( have_posts() ) {
			the_post();

			get_template_part( 'template-parts/content/entry', get_post_type() );
		}
		?>
	</main><!-- #primary -->
<?php
if ( 'post' == get_post_type() ) get_sidebar();
get_footer();
