<?php
/**
 * WP_Rig\WP_Rig\ACF\Component class
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\ACF;

use WP_Rig\WP_Rig\Component_Interface;
use function add_filter;

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
	}

	/**
	 * Enqueue frontend and editor JavaScript and CSS
	 */
	public function acf_google_map_api() {
		$api['key'] = 'AIzaSyA50EHcLA-bScU-OY-gXdGU9Eoprh-KDD0';
    	return $api;
	}
}
