<?php
/**
 * WP_Rig\WP_Rig\Custom_Block_Template\Component class
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\Custom_Block_Template;

use WP_Rig\WP_Rig\Component_Interface;
use WP_Post;
use function add_action;
use function get_post_type_object;

/**
 * Class for Custom_Block_Templates.
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'custom_block_template';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {

		add_action( 'init', array( $this, 'product_page_block_template' ) );
	}

	/**
	 * Asign block template to Product Page Template.
	 *
	 * @access public
	 * @return void
	 */
	public function product_page_block_template() {

		// $post_id = get_the_ID();
		// if( 'templates/products.php' === get_page_template_slug( $post_id ) ) {

		// }

		// echo '<pre>';
		// print_r( $ID );
		// echo '</pre>';

		// if ( is_page_template( 'templates/products.php' ) ) {
		// 	$page_type_object = get_post_type_object( 'page' );

		// 	$page_type_object->template = [
		// 		[ 'core/group',
		// 			[
		// 				'backgroundColor' => 'theme-primary'
		// 			],
		// 			[
		// 				[
		// 					'core/paragraph'
		// 				],
		// 			]
		// 		],
		// 	];

		// }
	}
}
