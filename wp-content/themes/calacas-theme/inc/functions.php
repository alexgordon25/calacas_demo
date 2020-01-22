<?php
/**
 * The `calacas_theme()` function.
 *
 * @package calacas_theme
 */

namespace WP_Calacas\WP_Calacas;

/**
 * Provides access to all available template tags of the theme.
 *
 * When called for the first time, the function will initialize the theme.
 *
 * @return Template_Tags Template tags instance exposing template tag methods.
 */
function calacas_theme() : Template_Tags {
	static $theme = null;

	if ( null === $theme ) {
		$theme = new Theme();
		$theme->initialize();
	}

	return $theme->template_tags();
}
