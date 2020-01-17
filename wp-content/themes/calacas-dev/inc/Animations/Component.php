<?php
/**
 * WP_Rig\WP_Rig\Animations\Component class
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\Animations;

use WP_Rig\WP_Rig\Component_Interface;
use WP_Rig\WP_Rig\Templating_Component_Interface;
use function WP_Rig\WP_Rig\wp_rig;
use function add_action;
use function wp_enqueue_script;
use function get_theme_file_uri;
use function get_theme_file_path;
use function wp_script_add_data;

/**
 * Class for Animations.
 */
class Component implements Component_Interface, Templating_Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'animations';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_action( 'wp_enqueue_scripts', array( $this, 'action_enqueue_animations_script' ) );
	}

	/**
	 * Gets template tags to expose as methods on the Template_Tags class instance, accessible through `wp_rig()`.
	 *
	 * @return array Associative array of $method_name => $callback_info pairs. Each $callback_info must either be
	 *               a callable or an array with key 'callable'. This approach is used to reserve the possibility of
	 *               adding support for further arguments in the future.
	 */
	public function template_tags() : array {
		return array(
			'get_scroll_animation'         => array( $this, 'get_scroll_animation' ),
			'set_scroll_animation'         => array( $this, 'set_scroll_animation' ),
		);
	}

	/**
	 * Get Element Animation values.
	 *
	 * @access public
	 * @param string $element element slug to animate.
	 * @param array  $animations Block animation list.
	 * @return array Element's Animation settings.
	 */
	public function get_scroll_animation( $element, $animations ) {
		$element_animation = array();

		if ( ! empty( $animations ) ) {
			foreach ( $animations as $key => $value ) {
				if ( in_array( $element, $value, true ) ) {
					$element_animation['preset_instances'] = $animations[ $key ]['preset_instances'];
					$element_animation['custom_instances'] = $animations[ $key ]['custom_instances'];
				}
			}
		}

		return $element_animation;
	}

	/**
	 * Set Element Animation wrapper.
	 *
	 * @access public
	 * @param array $animation Block animation list.
	 * @return void
	 */
	public function set_scroll_animation( $animation ) {
		if ( ! empty( $animation ) ) :
			$lax_class  = '';
			$lax_preset = '';
			$lax_custom = '';

			global $post;

			if ( get_field( 'animations_toggle', $post->ID ) ) {
				$lax_class = 'lax';
			}

			if ( ! empty( $animation['preset_instances'] ) ) {
				foreach ( $animation['preset_instances'] as $key => $preset_instance ) {
					$preset = '';

					if ( array_key_exists( 'value', $preset_instance ) ) {
						$preset = $preset_instance['acf_fc_layout'] . '-' . $preset_instance['value'];
					} else {
						$preset = $preset_instance['acf_fc_layout'];
					}

					if ( 0 === $key ) {
						$lax_preset .= $preset;
					} else {
						$lax_preset .= ' ' . $preset;
					}
				}
			}

			if ( ! empty( $animation['custom_instances'] ) ) {
				foreach ( $animation['custom_instances'] as $key => $custom_instance ) {
					$custom        = '';
					$custom_values = '';
					$values_array  = array();

					if ( array_key_exists( 'custom_values', $custom_instance ) ) {
						$values_array = $custom_instance['custom_values'];
					}

					if ( ! empty( $values_array ) ) {
						foreach ( $values_array as $value_key => $value_block ) {
							$values = '(vh*' . ( ( 100 - $value_block['start_pos'] ) / 100 ) . ') ' . $value_block['start_value'] . ', (vh*' . ( ( 100 - $value_block['stop_pos'] ) / 100 ) . ') ' . $value_block['stop_value'];

							if ( 0 === $value_key ) {
								$custom_values .= $values;
							} else {
								$custom_values .= ', ' . $values;
							}
						}
					}

					if ( $custom_values ) {
						$custom = sprintf(
							'%s="%s"',
							esc_attr( 'data-lax-' . $custom_instance['acf_fc_layout'] . '_large' ),
							esc_attr( $custom_values )
						);
					}

					if ( 0 === $key ) {
						$lax_custom = $custom;
					} else {
						$lax_custom .= ' ' . $custom;
					}
				}
			}

			// Print animation wrapper with settings attributes.
			printf(
				'<div class="%s" data-lax-preset_large="%s" %s>',
				esc_attr( $lax_class ),
				esc_attr( $lax_preset ),
				$lax_custom // phpcs:ignore
			);
		endif;
	}

	/**
	 * Enqueues the Foreground Video script file.
	 */
	public function action_enqueue_animations_script() {

		// If the AMP plugin is active, return early.
		if ( wp_rig()->is_amp() ) {
			return;
		}

		global $post;

		if ( get_field( 'animations_toggle', $post->ID ) ) {
			// Enqueue the foreground video script.
			wp_enqueue_script(
				'wp-lax',
				get_theme_file_uri( '/assets/js/libs/lax.min.js' ),
				array(),
				wp_rig()->get_asset_version( get_theme_file_path( '/assets/js/libs/lax.min.js' ) ),
				false
			);
			wp_enqueue_script(
				'wp-animations',
				get_theme_file_uri( '/assets/js/animations.min.js' ),
				array( 'wp-lax' ),
				wp_rig()->get_asset_version( get_theme_file_path( '/assets/js/animations.min.js' ) ),
				false
			);
			wp_script_add_data( 'wp-lax', 'defer', false );
			wp_script_add_data( 'wp-animations', 'defer', false );
		}
	}
}
