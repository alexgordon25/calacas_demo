<?php
/**
 * WP_Rig\WP_Rig\ACF\Component class
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\ACF;

use WP_Rig\WP_Rig\Component_Interface;
use function WP_Rig\WP_Rig\wp_rig;
use function add_filter;
use function add_action;
use function get_post_type;

/**
 * Class for ACF.
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'acf';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_filter( 'acf/fields/google_map/api', array( $this, 'acf_google_map_api' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_google_map_scripts' ) );
	}

	/**
	 * Add Google Map API Key to ACF.
	 */
	public function acf_google_map_api() {
		$google_map_api_key = get_field( 'google_map_api_key', 'options' );
		$api['key']         = $google_map_api_key;

    	return $api;
	}

	/**
	 * Enqueue Google Map.
	 */
	public function enqueue_google_map_scripts() {
		// If the AMP plugin is active, return early.
		if ( wp_rig()->is_amp() ) {
			return;
		}

		$post_type = 'festival';

		if ( $post_type === get_post_type() ) {

			// Enqueue the google map api url script.
			$google_map_api_key = get_field( 'google_map_api_key', 'options' );
			wp_enqueue_script( 'googleapis-maps', 'https://maps.googleapis.com/maps/api/js?key=' . $google_map_api_key, array(), 'latest', false );

			// Enqueue the google map helpers scripts.
			$js_google_map_path = '/assets/js/google-map.min.js';
			if ( file_exists( get_theme_file_path( $js_google_map_path ) ) ) {
				wp_enqueue_script(
					'wp-google-map-helper',
					get_theme_file_uri( $js_google_map_path ),
					array( 'jquery', 'googleapis-maps' ),
					wp_rig()->get_asset_version( get_theme_file_path( $js_google_map_path ) ),
					false
				);
			}

			wp_script_add_data( 'googleapis-maps', 'defer', true );
			wp_script_add_data( 'wp-google-map-helper', 'defer', true );
		}
	}
}
