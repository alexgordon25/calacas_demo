<?php
/**
 * Template part for displaying the header navigation menu
 *
 * @package calacas_theme
 */

namespace WP_Calacas\WP_Calacas;

if ( ! calacas_theme()->is_primary_nav_menu_active() ) {
	return;
}

?>

<nav id="site-navigation" class="hide main-navigation nav--toggle-sub nav--toggle-small" aria-label="<?php esc_attr_e( 'Main menu', 'calacas-theme' ); ?>"
	<?php
	if ( calacas_theme()->is_amp() ) {
		?>
		[class]=" siteNavigationMenu.expanded ? 'main-navigation nav--toggle-sub nav--toggle-small nav--toggled-on' : 'main-navigation nav--toggle-sub nav--toggle-small' "
		<?php
	}
	?>
>
	<?php
	if ( calacas_theme()->is_amp() ) {
		?>
		<amp-state id="siteNavigationMenu">
			<script type="application/json">
				{
					"expanded": false
				}
			</script>
		</amp-state>
		<?php
	}
	?>

	<button class="menu-toggle" aria-label="<?php esc_attr_e( 'Open menu', 'calacas-theme' ); ?>" aria-controls="primary-menu" aria-expanded="false"
		<?php
		if ( calacas_theme()->is_amp() ) {
			?>
			on="tap:AMP.setState( { siteNavigationMenu: { expanded: ! siteNavigationMenu.expanded } } )"
			[aria-expanded]="siteNavigationMenu.expanded ? 'true' : 'false'"
			<?php
		}
		?>
	>
		<?php esc_html_e( 'Menu', 'calacas-theme' ); ?>
	</button>

	<div class="primary-menu-container">
		<?php calacas_theme()->display_primary_nav_menu( [ 'menu_id' => 'primary-menu' ] ); ?>
	</div>
</nav><!-- #site-navigation -->
