<?php
/**
 * WP_Calacas\WP_Calacas\Custom_Logo\Component class
 *
 * @package calacas_theme
 */

namespace WP_Calacas\WP_Calacas\Custom_Logo;

use WP_Calacas\WP_Calacas\Component_Interface;
use function add_action;
use function add_theme_support;
use function apply_filters;

/**
 * Class for adding custom logo support.
 *
 * @link https://codex.wordpress.org/Theme_Logo
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'custom_logo';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_action( 'after_setup_theme', array( $this, 'action_add_custom_logo_support' ) );
	}

	/**
	 * Adds support for the Custom Logo feature.
	 */
	public function action_add_custom_logo_support() {
		add_theme_support(
			'custom-logo',
			apply_filters(
				'calacas_theme_custom_logo_args',
				array(
					'height'      => 100,
					'width'       => false,
					'flex-width'  => true,
					'flex-height' => true,
				)
			)
		);
	}
}
