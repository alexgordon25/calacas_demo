<?php
/**
 * WP_Calacas\WP_Calacas\Custom_Theme_Settings\Component class
 *
 * @package calacas_theme
 */

namespace WP_Calacas\WP_Calacas\Custom_Theme_Settings;

use WP_Calacas\WP_Calacas\Component_Interface;
use function add_action;
use function add_filter;

/**
 * Class for Custom_Theme_Settings.
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'custom_theme_settings';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {

		add_action( 'acf/init', array( $this, 'register_theme_settings' ) );
		add_filter( 'acf/load_field/name=top_divider_style', array( $this, 'acf_load_shape_dividers_choices' ) );
		add_filter( 'acf/load_field/name=bottom_divider_style', array( $this, 'acf_load_shape_dividers_choices' ) );
	}

	/**
	 * Register a Theme Settings page.
	 *
	 * @access public
	 * @return void
	 */
	public function register_theme_settings() {

		if ( function_exists( 'acf_add_options_page' ) ) {

			$theme_settings = acf_add_options_page(
				array(
					'page_title' => 'Theme Settings',
					'menu_title' => 'Theme Settings',
					'menu_slug'  => 'theme-settings',
					'capability' => 'edit_posts',
					'redirect'   => true,
				)
			);

			$helpers_fields = acf_add_options_page(
				array(
					'page_title'  => 'Helpers Fields',
					'menu_title'  => 'Helpers',
					'parent_slug' => $theme_settings['menu_slug'],
				)
			);
		}
	}

	/**
	 * Populate Shape Dividers choices.
	 *
	 * @access public
	 * @param array $field The field data.
	 * @return array The field with new choices.
	 */
	public function acf_load_shape_dividers_choices( $field ) {

		// Reset choices.
		$field['choices'] = array(
			'none' => 'None',
		);

		// Get the array value from options page.
		$choices = get_field( 'shape_dividers', 'option' );

		// Loop through array and add to field 'choices'.
		if ( is_array( $choices ) ) {

			foreach ( $choices as $choice ) {

				$field['choices'][ $choice['shape_title'] ] = $choice['shape_title'];
			}
		}

		// Return the field.
		return $field;
	}
}
