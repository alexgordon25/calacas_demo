<?php
/**
 * Template part for displaying the footer info
 *
 * @package calacas_theme
 */

namespace WP_Calacas\WP_Calacas;

?>

<div class="site-info">
	<div class="copyright position-relative">
		<small class="mb-0">Copyright © 2020 Calacas - All Right Reserved</small>
	</div>

	<?php
	if ( function_exists( 'the_privacy_policy_link' ) ) {
		the_privacy_policy_link( '<span class="sep"> | </span>' );
	}
	?>
</div><!-- .site-info -->
