<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package calacas_theme
 */

namespace WP_Calacas\WP_Calacas;

if ( ! calacas_theme()->is_primary_sidebar_active() ) {
	return;
}

calacas_theme()->print_styles( 'calacas-theme-sidebar', 'calacas-theme-widgets' );

?>
<aside id="secondary" class="primary-sidebar widget-area">
	<?php calacas_theme()->display_primary_sidebar(); ?>
</aside><!-- #secondary -->
