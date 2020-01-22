<?php
/**
 * WP_Calacas\WP_Calacas\Custom_Post_Type\Component class
 *
 * @package calacas_theme
 */

namespace WP_Calacas\WP_Calacas\Custom_Post_Type;

use WP_Calacas\WP_Calacas\Component_Interface;
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
			'name'                  => _x( 'Festivals', 'Post Type General Name', 'calacas-theme' ),
			'singular_name'         => _x( 'Festival', 'Post Type Singular Name', 'calacas-theme' ),
			'menu_name'             => __( 'Festivals', 'calacas-theme' ),
			'name_admin_bar'        => __( 'Festivals', 'calacas-theme' ),
			'archives'              => __( 'Festivals', 'calacas-theme' ),
			'attributes'            => __( 'Festivals Attributes', 'calacas-theme' ),
			'parent_item_colon'     => __( 'Parent Item:', 'calacas-theme' ),
			'all_items'             => __( 'All Festivals', 'calacas-theme' ),
			'add_new_item'          => __( 'Add New Festival', 'calacas-theme' ),
			'add_new'               => __( 'Add New', 'calacas-theme' ),
			'new_item'              => __( 'New Festival', 'calacas-theme' ),
			'edit_item'             => __( 'Edit Festival', 'calacas-theme' ),
			'update_item'           => __( 'Update Festival', 'calacas-theme' ),
			'view_item'             => __( 'View Festival', 'calacas-theme' ),
			'view_items'            => __( 'View Festivals', 'calacas-theme' ),
			'search_items'          => __( 'Search Festival', 'calacas-theme' ),
			'not_found'             => __( 'Not found', 'calacas-theme' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'calacas-theme' ),
			'featured_image'        => __( 'Festival Featured Image', 'calacas-theme' ),
			'set_featured_image'    => __( 'Set festival featured image', 'calacas-theme' ),
			'remove_featured_image' => __( 'Remove festival featured image', 'calacas-theme' ),
			'use_featured_image'    => __( 'Use as festival featured image', 'calacas-theme' ),
			'insert_into_item'      => __( 'Insert into festival', 'calacas-theme' ),
			'uploaded_to_this_item' => __( 'Uploaded to this festival', 'calacas-theme' ),
			'items_list'            => __( 'Festival list', 'calacas-theme' ),
			'items_list_navigation' => __( 'Festivals list navigation', 'calacas-theme' ),
			'filter_items_list'     => __( 'Filter Festivals list', 'calacas-theme' ),
		);
		$rewrite = array(
			'slug'                  => 'festival',
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
		);
		$args = array(
			'label'                 => __( 'Festival', 'calacas-theme' ),
			'description'           => __( 'List of Music Festivals.', 'calacas-theme' ),
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
			'name'                  => _x( 'Events', 'Post Type General Name', 'calacas-theme' ),
			'singular_name'         => _x( 'Event', 'Post Type Singular Name', 'calacas-theme' ),
			'menu_name'             => __( 'Events', 'calacas-theme' ),
			'name_admin_bar'        => __( 'Events', 'calacas-theme' ),
			'archives'              => __( 'Events', 'calacas-theme' ),
			'attributes'            => __( 'Events Attributes', 'calacas-theme' ),
			'parent_item_colon'     => __( 'Parent Item:', 'calacas-theme' ),
			'all_items'             => __( 'All Events', 'calacas-theme' ),
			'add_new_item'          => __( 'Add New Event', 'calacas-theme' ),
			'add_new'               => __( 'Add New', 'calacas-theme' ),
			'new_item'              => __( 'New Event', 'calacas-theme' ),
			'edit_item'             => __( 'Edit Event', 'calacas-theme' ),
			'update_item'           => __( 'Update Event', 'calacas-theme' ),
			'view_item'             => __( 'View Event', 'calacas-theme' ),
			'view_items'            => __( 'View Events', 'calacas-theme' ),
			'search_items'          => __( 'Search Event', 'calacas-theme' ),
			'not_found'             => __( 'Not found', 'calacas-theme' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'calacas-theme' ),
			'featured_image'        => __( 'Event Featured Image', 'calacas-theme' ),
			'set_featured_image'    => __( 'Set event featured image', 'calacas-theme' ),
			'remove_featured_image' => __( 'Remove event featured image', 'calacas-theme' ),
			'use_featured_image'    => __( 'Use as event featured image', 'calacas-theme' ),
			'insert_into_item'      => __( 'Insert into event', 'calacas-theme' ),
			'uploaded_to_this_item' => __( 'Uploaded to this event', 'calacas-theme' ),
			'items_list'            => __( 'Event list', 'calacas-theme' ),
			'items_list_navigation' => __( 'Events list navigation', 'calacas-theme' ),
			'filter_items_list'     => __( 'Filter Events list', 'calacas-theme' ),
		);
		$rewrite = array(
			'slug'                  => 'event',
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
		);
		$args = array(
			'label'                 => __( 'Event', 'calacas-theme' ),
			'description'           => __( 'List of Concerts and Events.', 'calacas-theme' ),
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
			'name'                  => _x( 'Artists', 'Post Type General Name', 'calacas-theme' ),
			'singular_name'         => _x( 'Artist', 'Post Type Singular Name', 'calacas-theme' ),
			'menu_name'             => __( 'Artists', 'calacas-theme' ),
			'name_admin_bar'        => __( 'Artists', 'calacas-theme' ),
			'archives'              => __( 'Artists', 'calacas-theme' ),
			'attributes'            => __( 'Artists Attributes', 'calacas-theme' ),
			'parent_item_colon'     => __( 'Parent Item:', 'calacas-theme' ),
			'all_items'             => __( 'All Artists', 'calacas-theme' ),
			'add_new_item'          => __( 'Add New Artist', 'calacas-theme' ),
			'add_new'               => __( 'Add New', 'calacas-theme' ),
			'new_item'              => __( 'New Artist', 'calacas-theme' ),
			'edit_item'             => __( 'Edit Artist', 'calacas-theme' ),
			'update_item'           => __( 'Update Artist', 'calacas-theme' ),
			'view_item'             => __( 'View Artist', 'calacas-theme' ),
			'view_items'            => __( 'View Artists', 'calacas-theme' ),
			'search_items'          => __( 'Search Artist', 'calacas-theme' ),
			'not_found'             => __( 'Not found', 'calacas-theme' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'calacas-theme' ),
			'featured_image'        => __( 'Artist Featured Image', 'calacas-theme' ),
			'set_featured_image'    => __( 'Set artist featured image', 'calacas-theme' ),
			'remove_featured_image' => __( 'Remove artist featured image', 'calacas-theme' ),
			'use_featured_image'    => __( 'Use as artist featured image', 'calacas-theme' ),
			'insert_into_item'      => __( 'Insert into artist', 'calacas-theme' ),
			'uploaded_to_this_item' => __( 'Uploaded to this artist', 'calacas-theme' ),
			'items_list'            => __( 'Artist list', 'calacas-theme' ),
			'items_list_navigation' => __( 'Artists list navigation', 'calacas-theme' ),
			'filter_items_list'     => __( 'Filter Artists list', 'calacas-theme' ),
		);
		$rewrite = array(
			'slug'                  => 'artist',
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
		);
		$args = array(
			'label'                 => __( 'Artist', 'calacas-theme' ),
			'description'           => __( 'List of Artists', 'calacas-theme' ),
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
