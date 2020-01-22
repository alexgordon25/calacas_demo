<?php
/**
 * WP_Calacas\WP_Calacas\Editor\Component class
 *
 * @package calacas_theme
 */

namespace WP_Calacas\WP_Calacas\Editor;

use WP_Calacas\WP_Calacas\Component_Interface;
use function add_action;
use function add_theme_support;

/**
 * Class for integrating with the block editor.
 *
 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'editor';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_action( 'after_setup_theme', array( $this, 'action_add_editor_support' ) );
	}

	/**
	 * Adds support for various editor features.
	 */
	public function action_add_editor_support() {
		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Add support for default block styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for wide-aligned images.
		add_theme_support( 'align-wide' );

		/**
		 * Add support for color palettes.
		 *
		 * To preserve color behavior across themes, use these naming conventions:
		 * - Use primary and secondary color for main variations.
		 * - Use `theme-[color-name]` naming standard for standard colors (red, blue, etc).
		 * - Use `custom-[color-name]` for non-standard colors.
		 *
		 * Add the line below to disable the custom color picker in the editor.
		 * add_theme_support( 'disable-custom-colors' );
		 */
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => __( 'Primary', 'calacas-theme' ),
					'slug'  => 'theme-primary',
					'color' => '#00d7c8',
				),
				array(
					'name'  => __( 'Primary Light', 'calacas-theme' ),
					'slug'  => 'theme-primary-light',
					'color' => '#73f3ea',
				),
				array(
					'name'  => __( 'Primary Dark', 'calacas-theme' ),
					'slug'  => 'theme-primary-dark',
					'color' => '#00a79b',
				),
				array(
					'name'  => __( 'Secondary', 'calacas-theme' ),
					'slug'  => 'theme-secondary',
					'color' => '#1c1c2a',
				),
				array(
					'name'  => __( 'Secondary Light', 'calacas-theme' ),
					'slug'  => 'theme-secondary-light',
					'color' => '#3e3e55',
				),
				array(
					'name'  => __( 'Secondary Dark', 'calacas-theme' ),
					'slug'  => 'theme-secondary-dark',
					'color' => '#14141d',
				),
				array(
					'name'  => __( 'Black', 'calacas-theme' ),
					'slug'  => 'theme-black',
					'color' => '#1C2833',
				),
				array(
					'name'  => __( 'Gray Dark', 'calacas-theme' ),
					'slug'  => 'theme-gray-dark',
					'color' => '#545454',
				),
				array(
					'name'  => __( 'Gray', 'calacas-theme' ),
					'slug'  => 'theme-gray',
					'color' => '#9e9e9e',
				),
				array(
					'name'  => __( 'Gray-Light', 'calacas-theme' ),
					'slug'  => 'theme-gray-light',
					'color' => '#e9e9e9',
				),
				array(
					'name'  => __( 'Light', 'calacas-theme' ),
					'slug'  => 'theme-light',
					'color' => '#f8f8f8',
				),
				array(
					'name'  => __( 'White', 'calacas-theme' ),
					'slug'  => 'theme-white',
					'color' => '#ECF0F1',
				),
			)
		);

		/*
		 * Add support custom font sizes.
		 *
		 * Add the line below to disable the custom color picker in the editor.
		 * add_theme_support( 'disable-custom-font-sizes' );
		 */
		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => __( 'Small', 'calacas-theme' ),
					'shortName' => __( 'S', 'calacas-theme' ),
					'size'      => 16,
					'slug'      => 'small',
				),
				array(
					'name'      => __( 'Medium', 'calacas-theme' ),
					'shortName' => __( 'M', 'calacas-theme' ),
					'size'      => 25,
					'slug'      => 'medium',
				),
				array(
					'name'      => __( 'Large', 'calacas-theme' ),
					'shortName' => __( 'L', 'calacas-theme' ),
					'size'      => 31,
					'slug'      => 'large',
				),
				array(
					'name'      => __( 'Larger', 'calacas-theme' ),
					'shortName' => __( 'XL', 'calacas-theme' ),
					'size'      => 39,
					'slug'      => 'larger',
				),
			)
		);
	}
}
