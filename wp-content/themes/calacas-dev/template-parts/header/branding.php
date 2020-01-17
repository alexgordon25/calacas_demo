<?php
/**
 * Template part for displaying the header branding
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

?>

<div class="site-branding">
	<?php
	the_custom_logo();

	if ( ! has_custom_logo() ) :
		?>
		<a href="<?php echo home_url( '/' ); ?>" class="custom-logo-link" rel="home">
			<img src="<?php echo get_template_directory_uri() . '/assets/images/calacas-logo.svg'; ?>" class="custom-logo" alt="<?php bloginfo( 'name' ); ?>">
		</a>
		<?php
	endif;
	?>
</div><!-- .site-branding -->
