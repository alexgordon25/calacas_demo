<?php
/**
 * WP_Calacas\WP_Calacas\Custom_Block_Category\Component class
 *
 * @package calacas_theme
 */

namespace WP_Calacas\WP_Calacas\Custom_Block_Category;

use WP_Calacas\WP_Calacas\Component_Interface;
use function WP_Calacas\WP_Calacas\calacas_theme;
use function add_filter;
use function add_action;
use function wp_enqueue_script;

/**
 * Class for Custom_Block_Category.
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'custom_block_category';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_filter( 'block_categories', array( $this, 'filter_acf_block_categories' ), 10, 2 );
		add_action( 'enqueue_block_editor_assets', array( $this, 'svg_gws_icon_scripts' ) );
	}

	/**
	 * Filters the `block categories` values.
	 *
	 * @param array  $categories List of existing block categories.
	 * @param object $post The post object.
	 * @return array The filtered array of block categories.
	 */
	public function filter_acf_block_categories( $categories, $post ) {

		// if ( $post->post_type !== 'post' ) {
		//	 return $categories;
		// }

		array_unshift(
			$categories,
			array(
				'slug'  => 'calacas-blocks',
				'title' => __( 'Calacas Blocks', 'calacas-theme' ),
			)
		);

		return $categories;
	}

	/**
	 * Enqueue frontend and editor JavaScript and CSS
	 */
	public function svg_gws_icon_scripts() {

		// Enqueue block JS.
		wp_enqueue_script(
			'svg-gws-icon-js',
			get_theme_file_uri( '/assets/js/svg-gws-icon.min.js' ),
			array( 'wp-blocks' ),
			calacas_theme()->get_asset_version( get_theme_file_path( '/assets/js/svg-gws-icon.min.js' ) ),
			true
		);
	}
}
