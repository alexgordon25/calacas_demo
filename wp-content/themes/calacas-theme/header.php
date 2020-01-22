<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package calacas_theme
 */

namespace WP_Calacas\WP_Calacas;

?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php
	if ( ! calacas_theme()->is_amp() ) {
		?>
		<script>document.documentElement.classList.remove( 'no-js' );</script>
		<?php
	}
	?>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'calacas-theme' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="fluid-container">
			<div class="flex content-between align-center">
				<div class="flex content-start align-center">
					<!-- <button class="ui-menu-toggle mr-3" data-modal-target="modal-nav">
						<div class="icon-toggle">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</div>
					</button> -->
					<?php get_template_part( 'template-parts/header/branding' ); ?>
				</div>
				<div class="flex content-center align-center">

				</div>
				<div class="flex content-end align-center">
					<?php get_template_part( 'template-parts/header/navigation' ); ?>
				</div>
			</div>
		</div>
	</header><!-- #masthead -->
