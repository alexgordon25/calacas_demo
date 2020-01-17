<?php
/**
 * WP_Rig\WP_Rig\Custom_Post_Type\Component class
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\Custom_Post_Type;

use WP_Rig\WP_Rig\Component_Interface;
use function add_action;
use function register_post_type;

/**
 * Class for Custom Post Type.
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'custom_post_type';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_action( 'init', array( $this, 'custom_post_type_product' ), 0 );
	}

	/**
	 * Custom post type cpt_products
	 *
	 * @access public
	 * @return void
	 */
	public function custom_post_type_product() {
		$labels  = array(
			'name'                  => _x( 'Products', 'Post Type General Name', 'wp-rig' ),
			'singular_name'         => _x( 'Product', 'Post Type Singular Name', 'wp-rig' ),
			'menu_name'             => __( 'Products', 'wp-rig' ),
			'name_admin_bar'        => __( 'Products', 'wp-rig' ),
			'archives'              => __( 'Products Archives', 'wp-rig' ),
			'attributes'            => __( 'Products Attributes', 'wp-rig' ),
			'parent_item_colon'     => __( 'Parent Item:', 'wp-rig' ),
			'all_items'             => __( 'All Products', 'wp-rig' ),
			'add_new_item'          => __( 'Add New Product', 'wp-rig' ),
			'add_new'               => __( 'Add New', 'wp-rig' ),
			'new_item'              => __( 'New Product', 'wp-rig' ),
			'edit_item'             => __( 'Edit Product', 'wp-rig' ),
			'update_item'           => __( 'Update Product', 'wp-rig' ),
			'view_item'             => __( 'View Product', 'wp-rig' ),
			'view_items'            => __( 'View Products', 'wp-rig' ),
			'search_items'          => __( 'Search Product', 'wp-rig' ),
			'not_found'             => __( 'Not found', 'wp-rig' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'wp-rig' ),
			'featured_image'        => __( 'Product Featured Image', 'wp-rig' ),
			'set_featured_image'    => __( 'Set product featured image', 'wp-rig' ),
			'remove_featured_image' => __( 'Remove product featured image', 'wp-rig' ),
			'use_featured_image'    => __( 'Use as product featured image', 'wp-rig' ),
			'insert_into_item'      => __( 'Insert into product', 'wp-rig' ),
			'uploaded_to_this_item' => __( 'Uploaded to this product', 'wp-rig' ),
			'items_list'            => __( 'Product list', 'wp-rig' ),
			'items_list_navigation' => __( 'Products list navigation', 'wp-rig' ),
			'filter_items_list'     => __( 'Filter Products list', 'wp-rig' ),
		);
		$rewrite = array(
			'slug'                  => 'product',
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
		);
		$args = array(
			'label'                 => __( 'Product', 'wp-rig' ),
			'description'           => __( 'Product Description', 'wp-rig' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail' ),
			'taxonomies'            => array( 'category', 'post_tag' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 20,
			'menu_icon'             => 'dashicons-feedback',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'rewrite'               => $rewrite,
			'capability_type'       => 'post',
			'show_in_rest'          => true,
		);
		register_post_type( 'product', $args );
	}
}
