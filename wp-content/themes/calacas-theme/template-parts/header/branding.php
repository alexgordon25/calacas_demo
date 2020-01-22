<?php
/**
 * Template part for displaying the header branding
 *
 * @package calacas_theme
 */

namespace WP_Calacas\WP_Calacas;

?>

<div class="site-branding">
	<?php
	the_custom_logo();

	if ( ! has_custom_logo() ) :
		?>
		<a href="<?php echo home_url( '/' ); ?>" class="custom-logo-link" rel="home">
			<img src="<?php echo get_template_directory_uri() . '/assets/images/calacas-logo-alt.svg'; ?>" class="custom-logo" alt="<?php bloginfo( 'name' ); ?>">
		</a>
		<?php
	endif;
	?>
</div><!-- .site-branding -->
