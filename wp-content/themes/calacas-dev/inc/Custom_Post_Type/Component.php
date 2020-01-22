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
		add_action( 'init', array( $this, 'custom_post_type_festival' ), 0 );
		add_action( 'init', array( $this, 'custom_post_type_event' ), 0 );
		add_action( 'init', array( $this, 'custom_post_type_artist' ), 0 );
	}

	/**
	 * Custom post type festival
	 *
	 * @access public
	 * @return void
	 */
	public function custom_post_type_festival() {
		$labels  = array(
			'name'                  => _x( 'Festivals', 'Post Type General Name', 'wp-rig' ),
			'singular_name'         => _x( 'Festival', 'Post Type Singular Name', 'wp-rig' ),
			'menu_name'             => __( 'Festivals', 'wp-rig' ),
			'name_admin_bar'        => __( 'Festivals', 'wp-rig' ),
			'archives'              => __( 'Festivals', 'wp-rig' ),
			'attributes'            => __( 'Festivals Attributes', 'wp-rig' ),
			'parent_item_colon'     => __( 'Parent Item:', 'wp-rig' ),
			'all_items'             => __( 'All Festivals', 'wp-rig' ),
			'add_new_item'          => __( 'Add New Festival', 'wp-rig' ),
			'add_new'               => __( 'Add New', 'wp-rig' ),
			'new_item'              => __( 'New Festival', 'wp-rig' ),
			'edit_item'             => __( 'Edit Festival', 'wp-rig' ),
			'update_item'           => __( 'Update Festival', 'wp-rig' ),
			'view_item'             => __( 'View Festival', 'wp-rig' ),
			'view_items'            => __( 'View Festivals', 'wp-rig' ),
			'search_items'          => __( 'Search Festival', 'wp-rig' ),
			'not_found'             => __( 'Not found', 'wp-rig' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'wp-rig' ),
			'featured_image'        => __( 'Festival Featured Image', 'wp-rig' ),
			'set_featured_image'    => __( 'Set festival featured image', 'wp-rig' ),
			'remove_featured_image' => __( 'Remove festival featured image', 'wp-rig' ),
			'use_featured_image'    => __( 'Use as festival featured image', 'wp-rig' ),
			'insert_into_item'      => __( 'Insert into festival', 'wp-rig' ),
			'uploaded_to_this_item' => __( 'Uploaded to this festival', 'wp-rig' ),
			'items_list'            => __( 'Festival list', 'wp-rig' ),
			'items_list_navigation' => __( 'Festivals list navigation', 'wp-rig' ),
			'filter_items_list'     => __( 'Filter Festivals list', 'wp-rig' ),
		);
		$rewrite = array(
			'slug'                  => 'festival',
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
		);
		$args = array(
			'label'                 => __( 'Festival', 'wp-rig' ),
			'description'           => __( 'List of Music Festivals.', 'wp-rig' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor' ),
			'taxonomies'            => array(),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 20,
			'menu_icon'             => 'dashicons-megaphone',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'rewrite'               => $rewrite,
			'capability_type'       => 'post',
			'show_in_rest'          => false,
		);
		register_post_type( 'festival', $args );
	}

	/**
	 * Custom post type event
	 *
	 * @access public
	 * @return void
	 */
	public function custom_post_type_event() {
		$labels  = array(
			'name'                  => _x( 'Events', 'Post Type General Name', 'wp-rig' ),
			'singular_name'         => _x( 'Event', 'Post Type Singular Name', 'wp-rig' ),
			'menu_name'             => __( 'Events', 'wp-rig' ),
			'name_admin_bar'        => __( 'Events', 'wp-rig' ),
			'archives'              => __( 'Events', 'wp-rig' ),
			'attributes'            => __( 'Events Attributes', 'wp-rig' ),
			'parent_item_colon'     => __( 'Parent Item:', 'wp-rig' ),
			'all_items'             => __( 'All Events', 'wp-rig' ),
			'add_new_item'          => __( 'Add New Event', 'wp-rig' ),
			'add_new'               => __( 'Add New', 'wp-rig' ),
			'new_item'              => __( 'New Event', 'wp-rig' ),
			'edit_item'             => __( 'Edit Event', 'wp-rig' ),
			'update_item'           => __( 'Update Event', 'wp-rig' ),
			'view_item'             => __( 'View Event', 'wp-rig' ),
			'view_items'            => __( 'View Events', 'wp-rig' ),
			'search_items'          => __( 'Search Event', 'wp-rig' ),
			'not_found'             => __( 'Not found', 'wp-rig' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'wp-rig' ),
			'featured_image'        => __( 'Event Featured Image', 'wp-rig' ),
			'set_featured_image'    => __( 'Set event featured image', 'wp-rig' ),
			'remove_featured_image' => __( 'Remove event featured image', 'wp-rig' ),
			'use_featured_image'    => __( 'Use as event featured image', 'wp-rig' ),
			'insert_into_item'      => __( 'Insert into event', 'wp-rig' ),
			'uploaded_to_this_item' => __( 'Uploaded to this event', 'wp-rig' ),
			'items_list'            => __( 'Event list', 'wp-rig' ),
			'items_list_navigation' => __( 'Events list navigation', 'wp-rig' ),
			'filter_items_list'     => __( 'Filter Events list', 'wp-rig' ),
		);
		$rewrite = array(
			'slug'                  => 'event',
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
		);
		$args = array(
			'label'                 => __( 'Event', 'wp-rig' ),
			'description'           => __( 'List of Concerts and Events.', 'wp-rig' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor' ),
			'taxonomies'            => array(),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 20,
			'menu_icon'             => 'dashicons-tickets-alt',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'rewrite'               => $rewrite,
			'capability_type'       => 'post',
			'show_in_rest'          => false,
		);
		register_post_type( 'event', $args );
	}

	/**
	 * Custom post type artist
	 *
	 * @access public
	 * @return void
	 */
	public function custom_post_type_artist() {
		$labels  = array(
			'name'                  => _x( 'Artists', 'Post Type General Name', 'wp-rig' ),
			'singular_name'         => _x( 'Artist', 'Post Type Singular Name', 'wp-rig' ),
			'menu_name'             => __( 'Artists', 'wp-rig' ),
			'name_admin_bar'        => __( 'Artists', 'wp-rig' ),
			'archives'              => __( 'Artists', 'wp-rig' ),
			'attributes'            => __( 'Artists Attributes', 'wp-rig' ),
			'parent_item_colon'     => __( 'Parent Item:', 'wp-rig' ),
			'all_items'             => __( 'All Artists', 'wp-rig' ),
			'add_new_item'          => __( 'Add New Artist', 'wp-rig' ),
			'add_new'               => __( 'Add New', 'wp-rig' ),
			'new_item'              => __( 'New Artist', 'wp-rig' ),
			'edit_item'             => __( 'Edit Artist', 'wp-rig' ),
			'update_item'           => __( 'Update Artist', 'wp-rig' ),
			'view_item'             => __( 'View Artist', 'wp-rig' ),
			'view_items'            => __( 'View Artists', 'wp-rig' ),
			'search_items'          => __( 'Search Artist', 'wp-rig' ),
			'not_found'             => __( 'Not found', 'wp-rig' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'wp-rig' ),
			'featured_image'        => __( 'Artist Featured Image', 'wp-rig' ),
			'set_featured_image'    => __( 'Set artist featured image', 'wp-rig' ),
			'remove_featured_image' => __( 'Remove artist featured image', 'wp-rig' ),
			'use_featured_image'    => __( 'Use as artist featured image', 'wp-rig' ),
			'insert_into_item'      => __( 'Insert into artist', 'wp-rig' ),
			'uploaded_to_this_item' => __( 'Uploaded to this artist', 'wp-rig' ),
			'items_list'            => __( 'Artist list', 'wp-rig' ),
			'items_list_navigation' => __( 'Artists list navigation', 'wp-rig' ),
			'filter_items_list'     => __( 'Filter Artists list', 'wp-rig' ),
		);
		$rewrite = array(
			'slug'                  => 'artist',
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
		);
		$args = array(
			'label'                 => __( 'Artist', 'wp-rig' ),
			'description'           => __( 'List of Artists', 'wp-rig' ),
			'labels'                => $labels,
			'supports'              => array( 'title' ),
			'taxonomies'            => array(),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 20,
			'menu_icon'             => 'dashicons-groups',
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
		register_post_type( 'artist', $args );
	}
}
