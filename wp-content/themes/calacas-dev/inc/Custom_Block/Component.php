<?php
/**
 * WP_Rig\WP_Rig\Custom_Block\Component class
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\Custom_Block;

use WP_Rig\WP_Rig\Component_Interface;
use WP_Rig\WP_Rig\Templating_Component_Interface;
use function WP_Rig\WP_Rig\wp_rig;
use function add_action;
use function wp_enqueue_style;
use function wp_enqueue_script;
use function get_template_directory_uri;
use function get_theme_file_path;
use function wp_script_add_data;
use function get_theme_support;

/**
 * Class for Custom_Blocks.
 */
class Component implements Component_Interface, Templating_Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'custom_block';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		if ( function_exists( 'acf_register_block_type' ) ) {
			add_action( 'acf/init', array( $this, 'register_acf_block_types' ) );
		}

		add_action( 'acf/input/admin_footer', array( $this, 'register_acf_color_palette' ) );

		if ( ! function_exists( 'fa_custom_setup_kit' ) ) {
			foreach ( array( 'wp_enqueue_scripts', 'admin_enqueue_scripts', 'login_enqueue_scripts' ) as $action ) {
				add_action( $action, array( $this, 'fa_custom_setup_kit' ) );
			}
		}
	}

	/**
	 * Register Custom Blocks
	 *
	 * @access public
	 * @return void
	 */
	public function register_acf_block_types() {

		$supports = array(
			'align'  => array( 'wide', 'full' ),
			'anchor' => true,
		);

		// hero block.
		acf_register_block_type(
			array(
				'name'              => 'hero',
				'title'             => __( 'Hero', 'wp-rig' ),
				'description'       => __( 'Custom Hero block.', 'wp-rig' ),
				'render_callback'   => array( $this, 'acf_block_callback' ),
				'category'          => 'gws-blocks',
				'icon'              => '<svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="tv-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><g class="fa-group"><path class="fa-secondary" fill="#22222e" d="M520 448H120a24 24 0 0 0-24 24v16a24 24 0 0 0 24 24h400a24 24 0 0 0 24-24v-16a24 24 0 0 0-24-24zM592 0H48A48 48 0 0 0 0 48v320a48 48 0 0 0 48 48h544a48 48 0 0 0 48-48V48a48 48 0 0 0-48-48zm-16 352H64V64h512z" opacity="1"></path><path class="fa-primary" fill="#38d6c7" d="M576 352H64V64h512z"></path></g></svg>',
				'mode'              => 'preview', // auto, preview, edit.
				'enqueue_assets'    => array( $this, 'acf_block_assets' ),
				'align'             => 'full', // left, center, right, wide, full.
				'keywords'          => array( 'hero', 'cover', 'header' ),
				'supports'          => $supports,
			)
		);

		// hero block.
		acf_register_block_type(
			array(
				'name'              => 'Slideshow',
				'title'             => __( 'Slideshow', 'wp-rig' ),
				'description'       => __( 'Custom Slideshow block.', 'wp-rig' ),
				'render_callback'   => array( $this, 'acf_block_callback' ),
				'category'          => 'gws-blocks',
				'icon'              => '<svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="projector" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><g class="fa-group"><path class="fa-secondary" fill="#22222e" d="M592 192h-95.41C543.47 215.77 576 263.93 576 320c0 61.88-39.44 114.31-94.34 134.64L493 499.88A16 16 0 0 0 508.49 512h39A16 16 0 0 0 563 499.88L576 448h16a48 48 0 0 0 48-48V240a48 48 0 0 0-48-48zm-224.59 0H48a48 48 0 0 0-48 48v160a48 48 0 0 0 48 48h16l13 51.88A16 16 0 0 0 92.49 512h39A16 16 0 0 0 147 499.88L160 448h207.41C320.53 424.23 288 376.07 288 320s32.53-104.23 79.41-128zM96 352a32 32 0 1 1 32-32 32 32 0 0 1-32 32zm96 0a32 32 0 1 1 32-32 32 32 0 0 1-32 32zm325.66-218.35a16 16 0 0 0 22.62 0l67.88-67.88a16 16 0 0 0 0-22.63l-11.32-11.31a16 16 0 0 0-22.62 0l-67.88 67.89a16 16 0 0 0 0 22.62zM440 0h-16a16 16 0 0 0-16 16v96a16 16 0 0 0 16 16h16a16 16 0 0 0 16-16V16a16 16 0 0 0-16-16zM323.72 133.65a16 16 0 0 0 22.62 0l11.32-11.31a16 16 0 0 0 0-22.62l-67.88-67.89a16 16 0 0 0-22.62 0l-11.32 11.31a16 16 0 0 0 0 22.63z" opacity="1"></path><path class="fa-primary" fill="#38d6c7" d="M96 288a32 32 0 1 0 32 32 32 32 0 0 0-32-32zm336-112a144 144 0 1 0 144 144 144 144 0 0 0-144-144zm0 240a96 96 0 1 1 96-96 96.14 96.14 0 0 1-96 96z"></path></g></svg>',
				'mode'              => 'preview', // auto, preview, edit.
				'enqueue_assets'    => array( $this, 'acf_block_assets' ),
				'align'             => 'full', // left, center, right, wide, full.
				'keywords'          => array( 'slideshow', 'hero', 'cover', 'header' ),
				'supports'          => $supports,
			)
		);

		// navigation callout block.
		acf_register_block_type(
			array(
				'name'              => 'navigation-callout',
				'title'             => __( 'Navigation Callout', 'wp-rig' ),
				'description'       => __( 'Nice custom navigation callout block with rich content.', 'wp-rig' ),
				'render_callback'   => array( $this, 'acf_block_callback' ),
				'category'          => 'gws-blocks',
				'icon'              => '<svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="layer-group" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><g class="fa-group"><path class="fa-secondary" fill="#38d6c7" d="M12.41 236.31L70.51 210l161.63 73.27a57.64 57.64 0 0 0 47.72 0L441.5 210l58.09 26.33c16.55 7.5 16.55 32.5 0 40L266.64 381.9a25.68 25.68 0 0 1-21.29 0L12.41 276.31c-16.55-7.5-16.55-32.5 0-40z" opacity="1"></path><path class="fa-primary" fill="#22222e" d="M12.41 148l232.94 105.7a25.61 25.61 0 0 0 21.29 0L499.58 148c16.55-7.51 16.55-32.52 0-40L266.65 2.32a25.61 25.61 0 0 0-21.29 0L12.41 108c-16.55 7.5-16.55 32.52 0 40zm487.18 216.11l-57.87-26.23-161.86 73.37a57.64 57.64 0 0 1-47.72 0L70.29 337.88l-57.88 26.23c-16.55 7.5-16.55 32.5 0 40L245.35 509.7a25.68 25.68 0 0 0 21.29 0l233-105.59c16.5-7.5 16.5-32.5-.05-40z"></path></g></svg>',
				'mode'              => 'preview', // auto, preview, edit.
				'enqueue_assets'    => array( $this, 'acf_block_assets' ),
				'align'             => 'full', // left, center, right, wide, full.
				'keywords'          => array( 'navigation', 'content', 'callout' ),
				'supports'          => $supports,
			)
		);

		// brand and certification block.
		acf_register_block_type(
			array(
				'name'              => 'brands-logos',
				'title'             => __( 'Brands and Logos', 'wp-rig' ),
				'description'       => __( 'Brands and Logos Slider.', 'wp-rig' ),
				'render_callback'   => array( $this, 'acf_block_callback' ),
				'category'          => 'gws-blocks',
				'icon'              => '<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 128"><title>credit-card-front-duotone</title><path d="M96,178H32A32,32,0,0,0,0,210v64a32,32,0,0,0,32,32H96a32,32,0,0,0,32-32V210A32,32,0,0,0,96,178Zm160,0H192a32,32,0,0,0-32,32v64a32,32,0,0,0,32,32h64a32,32,0,0,0,32-32V210A32,32,0,0,0,256,178Zm160,0H352a32,32,0,0,0-32,32v64a32,32,0,0,0,32,32h64a32,32,0,0,0,32-32V210A32,32,0,0,0,416,178Z" transform="translate(0 -178)" style="fill:#22222e"/></svg>',
				'mode'              => 'preview', // auto, preview, edit.
				'enqueue_assets'    => array( $this, 'acf_block_assets' ),
				'align'             => 'full', // left, center, right, wide, full.
				'keywords'          => array( 'brand', 'logos', 'callout' ),
				'supports'          => $supports,
			)
		);

		// content media block.
		acf_register_block_type(
			array(
				'name'              => 'content-media',
				'title'             => __( 'Content Media', 'wp-rig' ),
				'description'       => __( 'Content Media Callout Block.', 'wp-rig' ),
				'render_callback'   => array( $this, 'acf_block_callback' ),
				'category'          => 'gws-blocks',
				'icon'              => '<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 448"><title>content-media-card-duotone</title><path d="M528,0H48A48,48,0,0,0,0,48V400a48,48,0,0,0,48,48H528a48,48,0,0,0,48-48V48A48,48,0,0,0,528,0Z" style="fill:#22222e"/><path d="M81,140.92V284.68a8.13,8.13,0,0,0,8.12,8.12H272.88a8.13,8.13,0,0,0,8.12-8.12V140.92a8.13,8.13,0,0,0-8.12-8.12H89.12A8.13,8.13,0,0,0,81,140.92Z" style="fill:#38d6c7"/><rect x="328" y="260.8" width="160" height="32" rx="8" style="fill:#38d6c7"/><rect x="328" y="196.8" width="160" height="32" rx="8" style="fill:#38d6c7"/><rect x="328" y="132.8" width="160" height="32" rx="8" style="fill:#38d6c7"/></svg>',
				'mode'              => 'preview', // auto, preview, edit.
				'enqueue_assets'    => array( $this, 'acf_block_assets' ),
				'align'             => 'full', // left, center, right, wide, full.
				'keywords'          => array( 'content', 'media', 'photo', 'picture', 'callout' ),
				'supports'          => $supports,
			)
		);

		// latest post block.
		acf_register_block_type(
			array(
				'name'              => 'latest-post',
				'title'             => __( 'Latest Post', 'wp-rig' ),
				'description'       => __( 'Latest Post Block.', 'wp-rig' ),
				'render_callback'   => array( $this, 'acf_block_callback' ),
				'category'          => 'gws-blocks',
				'icon'              => '<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 384.01"><title>newspaper-duotone</title><rect x="128" y="288" width="176" height="32" rx="12" style="fill:none"/><rect x="336" y="288" width="176" height="32" rx="12" style="fill:none"/><rect x="128" y="192" width="176" height="32" rx="12" style="fill:none"/><rect x="336" y="192" width="176" height="32" rx="12" style="fill:none"/><rect x="128" y="64" width="384" height="64" rx="12" style="fill:#38d6c7"/><path d="M544,64H96A32,32,0,0,0,64,96V418.21a10,10,0,0,1-.09,1.09,1.71,1.71,0,0,1-.08.63,7.23,7.23,0,0,0-.13,1c-.05.34-.08.46-.12.68s-.1.61-.16.91-.11.46-.16.69-.13.59-.21.87-.13.46-.19.69l-.24.84-.24.68c-.09.28-.18.55-.28.82s-.17.45-.26.67-.21.53-.32.79-.2.45-.3.67-.23.51-.35.76l-.33.65c-.13.25-.25.49-.39.74l-.36.63-.42.72-.39.61-.46.69-.42.6-.48.66c-.15.2-.3.39-.46.58s-.33.43-.51.64l-.48.55-.54.61-.51.53c-.18.2-.37.39-.57.59l-.53.5-.6.56-.55.48-.62.52-.58.46-.65.49-.6.43-.68.46c-.2.14-.41.27-.62.4l-.69.43-.65.37c-.23.13-.47.27-.71.39l-.67.34c-.24.13-.48.25-.73.36l-.69.31-.74.32-.71.28-.77.29-.72.24-.78.25-.75.21-.79.21-.76.17-.81.17-.77.14-.82.12-.79.1-.83.09-.81.06H528a48,48,0,0,0,48-48V96A32,32,0,0,0,544,64ZM304,372a12,12,0,0,1-12,12H140a12,12,0,0,1-12-12v-8a12,12,0,0,1,12-12H292a12,12,0,0,1,12,12Zm0-96a12,12,0,0,1-12,12H140a12,12,0,0,1-12-12v-8a12,12,0,0,1,12-12H292a12,12,0,0,1,12,12Zm208,96a12,12,0,0,1-12,12H348a12,12,0,0,1-12-12v-8a12,12,0,0,1,12-12H500a12,12,0,0,1,12,12Zm0-96a12,12,0,0,1-12,12H348a12,12,0,0,1-12-12v-8a12,12,0,0,1,12-12H500a12,12,0,0,1,12,12Zm0-96a12,12,0,0,1-12,12H140a12,12,0,0,1-12-12V140a12,12,0,0,1,12-12H500a12,12,0,0,1,12,12Z" transform="translate(0 -64)" style="fill:#22222e"/><path d="M292,352H140a12,12,0,0,0-12,12v8a12,12,0,0,0,12,12H292a12,12,0,0,0,12-12v-8A12,12,0,0,0,292,352Zm0-96H140a12,12,0,0,0-12,12v8a12,12,0,0,0,12,12H292a12,12,0,0,0,12-12v-8A12,12,0,0,0,292,256Zm208,96H348a12,12,0,0,0-12,12v8a12,12,0,0,0,12,12H500a12,12,0,0,0,12-12v-8A12,12,0,0,0,500,352Zm0-96H348a12,12,0,0,0-12,12v8a12,12,0,0,0,12,12H500a12,12,0,0,0,12-12v-8A12,12,0,0,0,500,256ZM0,128V415.33C0,432.77,13.67,447.51,31.1,448A32,32,0,0,0,64,416.91c0-.3,0-.61,0-.91V96H32A32,32,0,0,0,0,128Z" transform="translate(0 -64)" style="fill:#38d6c7"/></svg>',
				'mode'              => 'preview', // auto, preview, edit.
				'enqueue_assets'    => array( $this, 'acf_block_assets' ),
				'align'             => 'full', // left, center, right, wide, full.
				'keywords'          => array( 'post', 'latest', 'news', 'articles', 'callout' ),
				'supports'          => $supports,
			)
		);

		// gallery slider block.
		acf_register_block_type(
			array(
				'name'              => 'gallery-slider',
				'title'             => __( 'Gallery Slider', 'wp-rig' ),
				'description'       => __( 'Gallery Slider Block.', 'wp-rig' ),
				'render_callback'   => array( $this, 'acf_block_callback' ),
				'category'          => 'gws-blocks',
				'icon'              => '<svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="images" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><g class="fa-group"><path class="fa-secondary" fill="#38d6c7" d="M424.49 120.48a12 12 0 0 0-17 0L272 256l-39.51-39.52a12 12 0 0 0-17 0L160 272v48h352V208zM64 336V128H48a48 48 0 0 0-48 48v256a48 48 0 0 0 48 48h384a48 48 0 0 0 48-48v-16H144a80.09 80.09 0 0 1-80-80z" opacity="1"></path><path class="fa-primary" fill="#22222e" d="M528 32H144a48 48 0 0 0-48 48v256a48 48 0 0 0 48 48h384a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48zM208 80a48 48 0 1 1-48 48 48 48 0 0 1 48-48zm304 240H160v-48l55.52-55.52a12 12 0 0 1 17 0L272 256l135.52-135.52a12 12 0 0 1 17 0L512 208z"></path></g></svg>',
				'mode'              => 'preview', // auto, preview, edit.
				'enqueue_assets'    => array( $this, 'acf_block_assets' ),
				'align'             => 'full', // left, center, right, wide, full.
				'keywords'          => array( 'gallery', 'slider', 'carousel' ),
				'supports'          => $supports,
			)
		);

		// contact bar block.
		acf_register_block_type(
			array(
				'name'              => 'contact-info',
				'title'             => __( 'Contact Info', 'wp-rig' ),
				'description'       => __( 'Small block with contact information.', 'wp-rig' ),
				'render_callback'   => array( $this, 'acf_block_callback' ),
				'category'          => 'gws-blocks',
				'icon'              => '<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 448"><title>contact-info-duotone</title><circle cx="176" cy="224" r="64" style="fill:none"/><path d="M224,352h-8.2a103,103,0,0,1-79.6,0H128a64.09,64.09,0,0,0-60.9,44.2C63.9,406,72.3,416,82.7,416H269.3c10.4,0,18.8-9.9,15.6-19.8A64.09,64.09,0,0,0,224,352Z" transform="translate(0 -32)" style="fill:none"/><path d="M0,128V432a48,48,0,0,0,48,48H528a48,48,0,0,0,48-48V128Zm176,64a64,64,0,1,1-64,64A64,64,0,0,1,176,192Zm93.3,224H82.7c-10.4,0-18.8-10-15.6-19.8A64.09,64.09,0,0,1,128,352h8.2a103,103,0,0,0,79.6,0H224a64.09,64.09,0,0,1,60.9,44.2C288.1,406.1,279.7,416,269.3,416ZM512,344a8,8,0,0,1-8,8H360a8,8,0,0,1-8-8V328a8,8,0,0,1,8-8H504a8,8,0,0,1,8,8Zm0-64a8,8,0,0,1-8,8H360a8,8,0,0,1-8-8V264a8,8,0,0,1,8-8H504a8,8,0,0,1,8,8Zm0-64a8,8,0,0,1-8,8H360a8,8,0,0,1-8-8V200a8,8,0,0,1,8-8H504a8,8,0,0,1,8,8Z" transform="translate(0 -32)" style="fill:#22222e"/><rect x="352" y="288" width="160" height="32" rx="8" style="fill:#38d6c7"/><rect x="352" y="224" width="160" height="32" rx="8" style="fill:#38d6c7"/><rect x="352" y="160" width="160" height="32" rx="8" style="fill:#38d6c7"/><path d="M224,352h-8.2a103,103,0,0,1-79.6,0H128a64.09,64.09,0,0,0-60.9,44.2C63.9,406,72.3,416,82.7,416H269.3c10.4,0,18.8-9.9,15.6-19.8A64.09,64.09,0,0,0,224,352ZM528,32H48A48,48,0,0,0,0,80v48H576V80A48,48,0,0,0,528,32ZM176,320a64,64,0,1,0-64-64A64,64,0,0,0,176,320Z" transform="translate(0 -32)" style="fill:#38d6c7"/></svg>',
				'mode'              => 'preview', // auto, preview, edit.
				'enqueue_assets'    => array( $this, 'acf_block_assets' ),
				'align'             => 'wide', // left, center, right, wide, full.
				'keywords'          => array( 'contact', 'phone', 'email', 'map', 'callout' ),
				'supports'          => $supports,
			)
		);

		// contact callout block.
		acf_register_block_type(
			array(
				'name'              => 'contact-callout',
				'title'             => __( 'Contact Callout', 'wp-rig' ),
				'description'       => __( 'Contact Callout Block.', 'wp-rig' ),
				'render_callback'   => array( $this, 'acf_block_callback' ),
				'category'          => 'gws-blocks',
				'icon'              => '<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 448"><title>address-card-duotone</title><path d="M528,32H48A48,48,0,0,0,0,80V432a48,48,0,0,0,48,48H528a48,48,0,0,0,48-48V80A48,48,0,0,0,528,32ZM176,128a64,64,0,1,1-64,64A64.06,64.06,0,0,1,176,128ZM288,364.8c0,10.6-10,19.2-22.4,19.2H86.4C74,384,64,375.4,64,364.8V345.6c0-31.8,30.1-57.6,67.2-57.6h5a102.71,102.71,0,0,0,79.6,0h5c37.1,0,67.2,25.8,67.2,57.6Z" transform="translate(0 -32)" style="fill:#22222e;isolation:isolate"/><path d="M176,256a64,64,0,1,0-64-64A64.06,64.06,0,0,0,176,256Zm44.8,32h-5a102.71,102.71,0,0,1-79.6,0h-5C94.1,288,64,313.8,64,345.6v19.2C64,375.4,74,384,86.4,384H265.6c12.4,0,22.4-8.6,22.4-19.2V345.6C288,313.8,257.9,288,220.8,288Z" transform="translate(0 -32)" style="fill:#38d6c7"/><path d="M503.8,318H342.3c-7.9,0-14.3,5.4-14.3,12v40c0,6.6,6.4,12,14.3,12H503.8c7.9,0,14.3-5.4,14.3-12V330C518,323.4,511.6,318,503.8,318Z" transform="translate(0 -32)" style="fill:#38d6c7"/></svg>',
				'mode'              => 'preview', // auto, preview, edit.
				'enqueue_assets'    => array( $this, 'acf_block_assets' ),
				'align'             => 'wide', // left, center, right, wide, full.
				'keywords'          => array( 'contact', 'callout' ),
				'supports'          => $supports,
			)
		);

		// product page block.
		acf_register_block_type(
			array(
				'name'              => 'product-page',
				'title'             => __( 'Product', 'wp-rig' ),
				'description'       => __( 'Product Page Block Callout.', 'wp-rig' ),
				'render_callback'   => array( $this, 'acf_block_callback' ),
				'category'          => 'gws-page-blocks',
				'icon'              => '<svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="grip-horizontal" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><g class="fa-group"><path class="fa-secondary" fill="#22222e" d="M96 288H32a32 32 0 0 0-32 32v64a32 32 0 0 0 32 32h64a32 32 0 0 0 32-32v-64a32 32 0 0 0-32-32zm160 0h-64a32 32 0 0 0-32 32v64a32 32 0 0 0 32 32h64a32 32 0 0 0 32-32v-64a32 32 0 0 0-32-32zm160 0h-64a32 32 0 0 0-32 32v64a32 32 0 0 0 32 32h64a32 32 0 0 0 32-32v-64a32 32 0 0 0-32-32z" opacity="1"></path><path class="fa-primary" fill="#38d6c7" d="M416 96h-64a32 32 0 0 0-32 32v64a32 32 0 0 0 32 32h64a32 32 0 0 0 32-32v-64a32 32 0 0 0-32-32zM96 96H32a32 32 0 0 0-32 32v64a32 32 0 0 0 32 32h64a32 32 0 0 0 32-32v-64a32 32 0 0 0-32-32zm160 0h-64a32 32 0 0 0-32 32v64a32 32 0 0 0 32 32h64a32 32 0 0 0 32-32v-64a32 32 0 0 0-32-32z"></path></g></svg>',
				'post_types'        => array( 'page' ),
				'mode'              => 'preview', // auto, preview, edit.
				'enqueue_assets'    => array( $this, 'acf_block_assets' ),
				'align'             => 'wide', // left, center, right, wide, full.
				'keywords'          => array( 'product', 'component' ),
				'supports'          => $supports,
			)
		);

		// about us page block.
		acf_register_block_type(
			array(
				'name'              => 'about-us',
				'title'             => __( 'About Us', 'wp-rig' ),
				'description'       => __( 'About Us Page Block to reveal company mission, vision and values.', 'wp-rig' ),
				'render_callback'   => array( $this, 'acf_block_callback' ),
				'category'          => 'gws-page-blocks',
				'icon'              => '<svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="users" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><g class="fa-group"><path class="fa-secondary" fill="#38d6c7" d="M96 224a64 64 0 1 0-64-64 64.06 64.06 0 0 0 64 64zm480 32h-64a63.81 63.81 0 0 0-45.1 18.6A146.27 146.27 0 0 1 542 384h66a32 32 0 0 0 32-32v-32a64.06 64.06 0 0 0-64-64zm-512 0a64.06 64.06 0 0 0-64 64v32a32 32 0 0 0 32 32h65.9a146.64 146.64 0 0 1 75.2-109.4A63.81 63.81 0 0 0 128 256zm480-32a64 64 0 1 0-64-64 64.06 64.06 0 0 0 64 64z" opacity="1"></path><path class="fa-primary" fill="#22222e" d="M396.8 288h-8.3a157.53 157.53 0 0 1-68.5 16c-24.6 0-47.6-6-68.5-16h-8.3A115.23 115.23 0 0 0 128 403.2V432a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48v-28.8A115.23 115.23 0 0 0 396.8 288zM320 256a112 112 0 1 0-112-112 111.94 111.94 0 0 0 112 112z"></path></g></svg>',
				'post_types'        => array( 'page' ),
				'mode'              => 'preview', // auto, preview, edit.
				'enqueue_assets'    => array( $this, 'acf_block_assets' ),
				'align'             => 'wide', // left, center, right, wide, full.
				'keywords'          => array( 'about us', 'mission', 'vision', 'values', 'component' ),
				'supports'          => $supports,
			)
		);

		// our history page block.
		acf_register_block_type(
			array(
				'name'              => 'our-history',
				'title'             => __( 'Our History', 'wp-rig' ),
				'description'       => __( 'Our History Page Block.', 'wp-rig' ),
				'render_callback'   => array( $this, 'acf_block_callback' ),
				'category'          => 'gws-page-blocks',
				'icon'              => '<svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="landmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><g class="fa-group"><path class="fa-secondary" fill="#22222e" d="M496 448H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h480a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm-16-80a16 16 0 0 0-16-16h-16V192h-64v160h-96V192h-64v160h-96V192H64v160H48a16 16 0 0 0-16 16v48h448z" opacity="1"></path><path class="fa-primary" fill="#38d6c7" d="M10.38 92.11L244.77 2a32 32 0 0 1 22.47 0l234.38 90.11a16 16 0 0 1 10.38 15V144a16 16 0 0 1-16 16H16a16 16 0 0 1-16-16v-36.91a16 16 0 0 1 10.38-14.98z"></path></g></svg>',
				'post_types'        => array( 'page' ),
				'mode'              => 'preview', // auto, preview, edit.
				'enqueue_assets'    => array( $this, 'acf_block_assets' ),
				'align'             => 'wide', // left, center, right, wide, full.
				'keywords'          => array( 'our', 'history', 'time', 'timeline' ),
				'supports'          => $supports,
			)
		);

		// timeline page block.
		acf_register_block_type(
			array(
				'name'              => 'timeline',
				'title'             => __( 'Timeline', 'wp-rig' ),
				'description'       => __( 'Timeline Page Block.', 'wp-rig' ),
				'render_callback'   => array( $this, 'acf_block_callback' ),
				'category'          => 'gws-page-blocks',
				'icon'              => '<svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="history" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><g class="fa-group"><path class="fa-secondary" fill="#22222e" d="M141.68 400.23a184 184 0 1 0-11.75-278.3l50.76 50.76c10.08 10.08 2.94 27.31-11.32 27.31H24a16 16 0 0 1-16-16V38.63c0-14.26 17.23-21.4 27.31-11.32l49.38 49.38A247.14 247.14 0 0 1 256 8c136.81 0 247.75 110.78 248 247.53S392.82 503.9 256.18 504a247 247 0 0 1-155.82-54.91 24 24 0 0 1-1.84-35.61l11.27-11.27a24 24 0 0 1 31.89-1.98z" opacity="1"></path><path class="fa-primary" fill="#38d6c7" d="M288 152v104.35L328.7 288a24 24 0 0 1 4.21 33.68l-9.82 12.62a24 24 0 0 1-33.68 4.21L224 287.65V152a24 24 0 0 1 24-24h16a24 24 0 0 1 24 24z"></path></g></svg>',
				'post_types'        => array( 'page' ),
				'mode'              => 'preview', // auto, preview, edit.
				'enqueue_assets'    => array( $this, 'acf_block_assets' ),
				'align'             => 'wide', // left, center, right, wide, full.
				'keywords'          => array( 'our', 'history', 'time', 'timeline' ),
				'supports'          => $supports,
			)
		);

		// contact form page block.
		acf_register_block_type(
			array(
				'name'              => 'contact-form',
				'title'             => __( 'Contact Form', 'wp-rig' ),
				'description'       => __( 'Contact Form Page Block.', 'wp-rig' ),
				'render_callback'   => array( $this, 'acf_block_callback' ),
				'category'          => 'gws-page-blocks',
				'icon'              => '<svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="file-signature" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><g class="fa-group"><path class="fa-secondary" fill="#22222e" d="M64 400a16 16 0 0 0 16 16h12.39a43.17 43.17 0 0 0 41-29.53L144 354.59l16.83 50.47c4.45 13.46 23.11 14.87 29.48 2.09l7.69-15.34a10.91 10.91 0 0 1 10-6.19 11.08 11.08 0 0 1 10.17 6.52A43 43 0 0 0 256 416h101l27-27.19v99.31A23.94 23.94 0 0 1 360 512H23.88A23.94 23.94 0 0 1 0 488V23.88A23.94 23.94 0 0 1 24 0h232v112a16 16 0 0 0 16 16h112v123.67L288 347v37h-32a11.63 11.63 0 0 1-9.35-6.5c-11.94-23.86-46.25-30.35-66-14.16l-13.88-41.64a24 24 0 0 0-45.55 0L103 376.34A11.21 11.21 0 0 1 92.39 384H80a16 16 0 0 0-16 16z" opacity="1"></path><path class="fa-primary" fill="#38d6c7" d="M384 121.9a23.9 23.9 0 0 0-7-16.9L279.1 7a24 24 0 0 0-17-7H256v112a16 16 0 0 0 16 16h112zM288 347v69h69l161.67-162.78-67.88-67.88zm280.56-179.65l-31.87-31.87a25.48 25.48 0 0 0-36 0l-27.25 27.25 67.88 67.88 27.25-27.25a25.45 25.45 0 0 0-.01-36.01z"></path></g></svg>',
				'post_types'        => array( 'page' ),
				'mode'              => 'preview', // auto, preview, edit.
				'enqueue_assets'    => array( $this, 'acf_block_assets' ),
				'align'             => 'wide', // left, center, right, wide, full.
				'keywords'          => array( 'contact', 'form' ),
				'supports'          => $supports,
			)
		);

		// location page block.
		acf_register_block_type(
			array(
				'name'              => 'location',
				'title'             => __( 'Location Map', 'wp-rig' ),
				'description'       => __( 'Location Map Page Block.', 'wp-rig' ),
				'render_callback'   => array( $this, 'acf_block_callback' ),
				'category'          => 'gws-page-blocks',
				'icon'              => '<svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="map-marked-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><g class="fa-group"><path class="fa-secondary" fill="#22222e" d="M554.06 161.16L416 224v288l139.88-55.95A32 32 0 0 0 576 426.34V176a16 16 0 0 0-21.94-14.84zM20.12 216A32 32 0 0 0 0 245.66V496a16 16 0 0 0 21.94 14.86L160 448V214.92a302.84 302.84 0 0 1-21.25-46.42zM288 359.67a47.78 47.78 0 0 1-36.51-17C231.83 319.51 210.92 293.09 192 266v182l192 64V266c-18.92 27.09-39.82 53.52-59.49 76.72A47.8 47.8 0 0 1 288 359.67z" opacity="1"></path><path class="fa-primary" fill="#38d6c7" d="M288 0a126 126 0 0 0-126 126c0 56.26 82.35 158.8 113.9 196a15.77 15.77 0 0 0 24.2 0C331.65 284.8 414 182.26 414 126A126 126 0 0 0 288 0zm0 168a42 42 0 1 1 42-42 42 42 0 0 1-42 42z"></path></g></svg>',
				'post_types'        => array( 'page' ),
				'mode'              => 'preview', // auto, preview, edit.
				'enqueue_assets'    => array( $this, 'acf_block_assets' ),
				'align'             => 'wide', // left, center, right, wide, full.
				'keywords'          => array( 'google', 'map', 'contact' ),
				'supports'          => $supports,
			)
		);
	}

	/**
	 * Render callback function
	 *
	 * @access public
	 * @param array $block The block details.
	 * @return void Bail if the block has expired.
	 */
	public function acf_block_callback( $block ) {

		// Convert the block name.
		$block_slug = str_replace( 'acf/', '', $block['name'] );

		// Include block template part.
		if ( file_exists( get_theme_file_path( '/template-parts/blocks/' . $block_slug . '/' . $block_slug . '.php' ) ) ) {
			include get_theme_file_path( '/template-parts/blocks/' . $block_slug . '/' . $block_slug . '.php' );
		}
	}

	/**
	 * Enqueue block assets callback function
	 *
	 * @access public
	 * @param array $block The block details.
	 * @return void Bail if the block has expired.
	 */
	public function acf_block_assets( $block ) {

		// Convert the block name.
		$block_slug     = str_replace( 'acf/', '', $block['name'] );
		$block_css_path = get_theme_file_path( '/assets/css/blocks/' . $block_slug . '.min.css' );
		$block_css_uri  = get_template_directory_uri() . '/assets/css/blocks/' . $block_slug . '.min.css';
		$block_js_path  = get_theme_file_path( '/assets/js/blocks/' . $block_slug . '.min.js' );
		$block_js_uri   = get_template_directory_uri() . '/assets/js/blocks/' . $block_slug . '.min.js';

		if ( file_exists( $block_css_path ) ) {
			wp_enqueue_style(
				'block-' . $block_slug,
				$block_css_uri,
				array(),
				filemtime( $block_css_path )
			);
		}

		if ( file_exists( $block_js_path ) ) {
			wp_enqueue_script(
				'block-' . $block_slug,
				$block_js_uri,
				array( 'jquery' ),
				filemtime( $block_js_path ),
				true
			);
			wp_script_add_data( 'block-' . $block_slug, 'defer', true );
		}

		if (
			has_block( 'acf/hero' )
			&& array_key_exists( 'data', $block )
		) {
			if (
				array_key_exists(
					'add_foreground_video',
					$block['data']
				)
				&& $block['data']['add_foreground_video']
			) {
				$this->enqueue_foreground_video_scripts();
			}
		}

		if (
			has_block( 'acf/slideshow' )
			&& array_key_exists( 'data', $block )
		) {
			if ( ! empty( $block['data']['slides'] ) ) {
				foreach ( $block['data']['slides'] as $key => $slide ) :
					$slide_key = 'slides_' . $key . '_add_foreground_video';
					if (
						array_key_exists(
							$slide_key,
							$block['data']
						)
						&& $block['data'][ $slide_key ]
					) :
						$this->enqueue_foreground_video_scripts();
					endif;
				endforeach;

				$this->enqueue_carousel_scripts();
			}
		}
	}

	/**
	 * Gets template tags to expose as methods on the Template_Tags class instance, accessible through `wp_rig()`.
	 *
	 * @access public
	 * @return array Associative array of $method_name => $callback_info pairs. Each $callback_info must either be
	 *               a callable or an array with key 'callable'. This approach is used to reserve the possibility of
	 *               adding support for further arguments in the future.
	 */
	public function template_tags() : array {
		return array(
			'get_block_alignment'               => array( $this, 'get_block_alignment' ),
			'get_block_classes'                 => array( $this, 'get_block_classes' ),
			'get_block_id'                      => array( $this, 'get_block_id' ),
			'display_block_options'             => array( $this, 'display_block_options' ),
			'display_content_container_options' => array( $this, 'display_content_container_options' ),
			'display_block_custom_styles'       => array( $this, 'display_block_custom_styles' ),
			'get_the_colors'                    => array( $this, 'get_the_colors' ),
			'get_headline'                      => array( $this, 'get_headline' ),
			'get_tagline'                       => array( $this, 'get_tagline' ),
			'get_caption'                       => array( $this, 'get_caption' ),
			'get_button'                        => array( $this, 'get_button' ),
			'bool'                              => array( $this, 'bool' ),
			'arr2str'                           => array( $this, 'arr2str' ),
			'hex2rgba'                          => array( $this, 'hex2rgba' ),
		);
	}

	/**
	 * Returns the alignment set for a content block.
	 *
	 * @access public
	 * @param array $block The block settings.
	 * @return string The block alignment set.
	 */
	public function get_block_alignment( $block ) {

		if ( ! $block ) {
			return;
		}

		return ! empty( $block['align'] ) ? ' align' . esc_attr( $block['align'] ) : 'alignwide';
	}

	/**
	 * Returns the class names set for a content block.
	 *
	 * @access public
	 * @param array $block The block settings.
	 * @return string The block class set.
	 */
	public function get_block_classes( $block ) {

		if ( ! $block ) {
			return;
		}

		$classes  = '';
		$classes .= ! empty( $block['className'] ) ? ' ' . esc_attr( $block['className'] ) : '';

		return $classes;
	}

	/**
	 * Returns the ID or anchor link field set for a content block.
	 *
	 * @access public
	 * @param  array $block The block settings.
	 * @return string The Block ID set.
	 */
	public function get_block_id( $block ) {

		if ( ! $block ) {
			return;
		}

		return empty( $block['anchor'] ) ? str_replace( '_', '-', $block['id'] ) : esc_attr( $block['anchor'] );
	}

	/**
	 * Set the blocks options.
	 *
	 * @access public
	 * @param  array $args Some arguments.
	 * @return void
	 */
	public function display_block_options( $args = array() ) {

		// Get the block ID.
		$block_id = wp_rig()->get_block_id( $args['block'] );

		// Setup defaults.
		$defaults = array(
			'background_type'        => get_field( 'background_type' ),
			'container'              => 'section',
			'class'                  => 'l-block',
			'id'                     => $block_id,
			'height'                 => get_field( 'block_height' ),
			'top_divider'            => get_field( 'top_divider' ),
			'bottom_divider'         => get_field( 'bottom_divider' ),
		);

		// Parse args.
		$args = wp_parse_args( $args, $defaults );

		$bg_color_html       = '';
		$bg_gradient_html    = '';
		$bg_video_html       = '';
		$bg_image_html       = '';
		$overlay_html        = '';
		$top_divider_html    = '';
		$bottom_divider_html = '';

		// Get overlay type.
		$overlay_type = get_field( 'overlay_type' );

		// Only try to get the rest of the settings if the background type is set to anything.
		if ( $args['background_type'] ) :
			$background_color = get_field( 'background_color' );
			$background_image = get_field( 'background_image' );
			$background_video = get_field( 'background_video' );
			$has_show_overlay = $overlay_type ? ' has-overlay' : ''; // Show overlay class, if it exists.

			// Get block animations.
			$bg_animations = wp_rig()->get_scroll_animation( 'background', get_field( 'animations' ) );

			// Color Background Set.
			if ( 'classic' === $args['background_type'] && $background_color && ! $background_image ) :

				// Construct class.
				$args['class'] .= ' has-background color-as-background';
				ob_start();
				?>
					<div class="block-background color-background" aria-hidden="true"></div>
				<?php
				$bg_color_html = ob_get_clean();
			endif;

			// Background Image Set.
			if ( 'classic' === $args['background_type'] && $background_image ) :

				// Construct class.
				$args['class'] .= ' has-background image-as-background' . esc_attr( $has_show_overlay );
				ob_start();
				?>
					<figure class="block-background image-background" aria-hidden="true">
						<?php
						// Get Animation wrapper.
						wp_rig()->set_scroll_animation( $bg_animations );

							echo wp_get_attachment_image( $background_image['id'], 'full' );

						// Closing animation wrapper.
						if ( ! empty( $bg_animations ) ) {
							echo '</div>';
						}
						?>
					</figure>
				<?php
				$bg_image_html = ob_get_clean();
			endif;

			// Background Gradient Set.
			if ( 'gradient' === $args['background_type'] ) {

				// Construct class.
				$args['class'] .= ' has-background gradient-as-background';
				ob_start();
				?>
					<div class="block-background gradient-background" aria-hidden="true"></div>
				<?php
				$bg_gradient_html = ob_get_clean();
			}

			if ( 'video' === $args['background_type'] && $background_video ) :
				$background_video_webm  = get_field( 'background_video_webm' );
				$background_video_title = get_field( 'background_video_title' );
				$video_placeholder      = get_field( 'video_placeholder' );
				$args['class']         .= ' has-background video-as-background' . esc_attr( $has_show_overlay );

				// Translators: get the title of the video.
				$background_video_alt = $background_video_title ? sprintf( 'Video Background of %s', 'wp-rig', esc_attr( $background_video_title ) ) : __( 'Video Background', 'wp-rig' );

				ob_start();
				?>
					<video
						class="block-background video-background" autoplay muted loop playsinline preload="auto" aria-hidden="true"
						<?php echo $background_video_title ? ' title="' . esc_attr( $background_video_alt ) . '"' : ''; ?>
						<?php echo $video_placeholder ? ' poster="' . esc_url( $video_placeholder['sizes']['full'] ) . '"' : ''; ?>
					>
							<?php if ( $background_video_webm['url'] ) : ?>
								<source src="<?php echo esc_url( $background_video_webm['url'] ); ?>" type="video/webm">
							<?php endif; ?>

							<?php if ( $background_video['url'] ) : ?>
								<source src="<?php echo esc_url( $background_video['url'] ); ?>" type="video/mp4">
							<?php endif; ?>
					</video>
				<?php
				$bg_video_html = ob_get_clean();
			endif;

			if ( $overlay_type && ( $background_image || $background_video ) ) :

				ob_start();
				?>
					<div class="block-overlay"></div>
				<?php
				$overlay_html = ob_get_clean();
			endif;

			if ( 'none' === $args['background_type'] ) :
				$args['class'] .= ' no-background';
			endif;
		endif;

		// Set the block height css class.
		if ( $args['height'] ) :
			$args['class'] .= ' ' . $args['height'];
		endif;

		// Set the top or bottom shape divider css class.
		$top_divider_style    = $args['top_divider']['top_divider_style'];
		$bottom_divider_style = $args['bottom_divider']['bottom_divider_style'];
		$shape_dividers       = get_field( 'shape_dividers', 'option' );

		if ( 'none' !== $top_divider_style || 'none' !== $bottom_divider_style ) :

			// Construct class.
			$args['class'] .= ' has-divider';
		endif;

		// Set the top shape divider markup.
		if ( $shape_dividers && 'none' !== $top_divider_style ) :
			$top_divider_svg = '';

			foreach ( $shape_dividers as $key => $value ) {
				if ( in_array( $top_divider_style, $value, true ) ) {
					$top_divider_svg = $shape_dividers[ $key ]['svg_code'];
					$top_divider_svg = strtr( $top_divider_svg, array( '{$block_id}' => $block_id . '-top' ) );
				}
			}

			ob_start();
			if ( $top_divider_svg ) :
				?>
				<div class="block-divider top-divider" aria-hidden="true">
					<?php echo $top_divider_svg; // phpcs:ignore ?>
				</div>
				<?php
			endif;
			$top_divider_html = ob_get_clean();
		endif;

		// Set the bottom shape divider markup.
		if ( $shape_dividers && 'none' !== $bottom_divider_style ) :
			$bottom_divider_svg = '';

			foreach ( $shape_dividers as $key => $value ) {
				if ( in_array( $bottom_divider_style, $value, true ) ) {
					$bottom_divider_svg = $shape_dividers[ $key ]['svg_code'];
					$bottom_divider_svg = strtr( $bottom_divider_svg, array( '{$block_id}' => $block_id . '-bottom' ) );
				}
			}

			ob_start();
			if ( $bottom_divider_svg ) :
				?>
				<div class="block-divider bottom-divider" aria-hidden="true">
					<?php echo $bottom_divider_svg; // phpcs:ignore ?>
				</div>
				<?php
			endif;
			$bottom_divider_html = ob_get_clean();
		endif;

		// Print our block container with options.
		printf(
			'<%s id="%s" class="%s">',
			esc_attr( $args['container'] ),
			esc_attr( $args['id'] ),
			esc_attr( $args['class'] )
		);

		// Print a background color markup inside the block container.
		if ( $bg_color_html ) :
			echo $bg_color_html; // phpcs:ignore
		endif;

		// Print a background gradient color markup inside the block container.
		if ( $bg_gradient_html ) :
			echo $bg_gradient_html; // phpcs:ignore
		endif;

		// Print a background image markup inside the block container.
		if ( $bg_image_html ) :
			echo $bg_image_html; // phpcs:ignore
		endif;

		// Print a background video markup inside the block container.
		if ( $bg_video_html ) :
			echo $bg_video_html; // phpcs:ignore
		endif;

		// Print a overlay markup inside the block container.
		if ( $overlay_html ) :
			echo $overlay_html; // phpcs:ignore
		endif;

		// Print a top divider markup inside the block container.
		if ( $top_divider_html ) :
			echo $top_divider_html; // phpcs:ignore
		endif;

		// Print a top divider markup inside the block container.
		if ( $bottom_divider_html ) :
			echo $bottom_divider_html; // phpcs:ignore
		endif;
	}

	/**
	 * Set the inner content container options.
	 *
	 * @access public
	 * @param array $args Some arguments.
	 * @return void
	 */
	public function display_content_container_options( $args = array() ) {

		// Setup defaults.
		$defaults = array(
			'content_container' => get_field( 'content_container' ),
			'container'         => 'div',
			'class'             => 'l-content-container',
			'content_align'     => get_field( 'content_align' ),
		);

		// Parse args.
		$args = wp_parse_args( $args, $defaults );

		// Set the inner content container width css class.
		if ( $args['content_container'] ) {
			$args['class'] .= ' ' . $args['content_container'];
		}

		// Set the Content Align css class.
		if ( $args['content_align'] ) {
			$args['class'] .= ' ' . $args['content_align'];
		}

		// Print our block container with options.
		printf(
			'<%s class="%s">',
			esc_attr( $args['container'] ),
			esc_attr( $args['class'] )
		);
	}

	/**
	 * Set block custom styles.
	 *
	 * @access public
	 * @param  array  $block Some arguments.
	 * @param  string $additional_styles Push additional styles.
	 * @return void
	 */
	public function display_block_custom_styles( $block, $additional_styles = '' ) {

		// Variables for custom styles.
		$the_block_id               = wp_rig()->get_block_id( $block );
		$text_color                 = get_field( 'text_color' );
		$heading_color              = get_field( 'heading_color' );
		$tagline_color              = get_field( 'tagline_color' );
		$link_color                 = get_field( 'link_color' );
		$link_hover_color           = get_field( 'link_hover_color' );
		$background_type            = get_field( 'background_type' );
		$background_color           = get_field( 'background_color' );
		$background_image           = get_field( 'background_image' );
		$background_video           = get_field( 'background_video' );
		$first_gradient_color       = get_field( 'first_gradient_color' );
		$first_gradient_location    = get_field( 'first_gradient_location' );
		$second_gradient_color      = get_field( 'second_gradient_color' );
		$second_gradient_location   = get_field( 'second_gradient_location' );
		$gradient_type              = get_field( 'gradient_type' );
		$gradient_angle             = get_field( 'gradient_angle' );
		$gradient_position          = get_field( 'gradient_position' );
		$background_object_fit      = get_field( 'background_object_fit' );
		$background_object_position = get_field( 'background_object_position' );
		$overlay_type               = get_field( 'overlay_type' );
		$overlay_color              = get_field( 'overlay_color' );
		$overlay_1st_color          = get_field( 'overlay_1st_color' );
		$overlay_1st_color_location = get_field( 'overlay_1st_color_location' );
		$overlay_2nd_color          = get_field( 'overlay_2nd_color' );
		$overlay_2nd_color_location = get_field( 'overlay_2nd_color_location' );
		$overlay_gradient_type      = get_field( 'overlay_gradient_type' );
		$overlay_gradient_angle     = get_field( 'overlay_gradient_angle' );
		$overlay_gradient_position  = get_field( 'overlay_gradient_position' );
		$overlay_opacity            = get_field( 'overlay_opacity' );
		$overlay_blend_mode         = get_field( 'overlay_blend_mode' );
		$block_height               = get_field( 'block_height' );
		$height_unit                = get_field( 'height_unit' );
		$min_height                 = get_field( 'min_height' );
		$content_width              = get_field( 'content_width' );
		$content_vertical_align     = get_field( 'content_vertical_align' );
		$padding_top                = get_field( 'padding_top' );
		$padding_bottom             = get_field( 'padding_bottom' );
		$top_divider                = get_field( 'top_divider' );
		$bottom_divider             = get_field( 'bottom_divider' );

		// Initiate block_custom_styles blank.
		$block_custom_styles = '';

		// Add custom styles only if there is any.
		if (
			$background_color
			|| $text_color
			|| ( $first_gradient_color && $second_gradient_color )
			|| $overlay_type
			|| $background_object_fit
			|| $background_object_position
			|| ( 'min-height' === $block_height && $min_height )
			|| $content_width
			|| $content_vertical_align
			|| $padding_top
			|| $padding_bottom
			|| ( $top_divider['top_divider_style'] && 'none' !== $top_divider['top_divider_style'] )
			|| ( $bottom_divider['bottom_divider_style'] && 'none' !== $bottom_divider['bottom_divider_style'] )
			|| $additional_styles
		) :

			// Output begins.
			ob_start();
			?>
			<style type="text/css">
				<?php
				if ( $additional_styles ) {
					echo $additional_styles; // phpcs:ignore
				}
				?>
				<?php
				if ( $text_color || ( 'min-height' === $block_height && $min_height ) || $content_vertical_align || $padding_top || $padding_bottom ) :
					$height_unit = $height_unit ? $height_unit : 'px';
					?>
					#<?php echo esc_attr( $the_block_id ); ?> {

						<?php
						if ( $text_color ) :
							?>
							color: <?php echo esc_attr( $text_color ); ?>;
							<?php
						endif;
						?>

						<?php
						if ( 'min-height' === $block_height && $min_height ) :
							?>
							min-height: <?php echo esc_attr( $min_height . $height_unit ); ?>;
							<?php
						endif;
						?>

						<?php
						if ( $content_vertical_align ) :
							?>
							justify-content: <?php echo esc_attr( $content_vertical_align ); ?>;
							<?php
						endif;
						?>

						<?php
						if ( $padding_top ) :
							?>
							padding-top: <?php echo esc_attr( $padding_top ); ?>;
							<?php
						endif;
						?>

						<?php
						if ( $padding_bottom ) :
							?>
							padding-bottom: <?php echo esc_attr( $padding_bottom ); ?>;
							<?php
						endif;
						?>
					}
					<?php
				endif;

				if ( $content_width ) :
					?>
					@media screen and (min-width: 768px) {
						#<?php echo esc_attr( $the_block_id ); ?> .block-content {
							width: <?php echo esc_attr( $content_width ); ?>%;
							display: inline-block;
						}
					}
					<?php
				endif;

				if ( $heading_color ) :
					?>
					#<?php echo esc_attr( $the_block_id ); ?> .block-headline {
						color: <?php echo esc_attr( $heading_color ); ?>;
					}
					<?php
				endif;

				if ( $tagline_color ) :
					?>
					#<?php echo esc_attr( $the_block_id ); ?> .block-tagline {
						color: <?php echo esc_attr( $tagline_color ); ?>;
					}
					<?php
				endif;

				if ( $link_color ) :
					?>
					#<?php echo esc_attr( $the_block_id ); ?> a:not(.ui-btn),
					#<?php echo esc_attr( $the_block_id ); ?> a:not(.ui-btn):visited {
						color: <?php echo esc_attr( $link_color ); ?>;
					}
					<?php
				endif;

				if ( $link_hover_color ) :
					?>
					#<?php echo esc_attr( $the_block_id ); ?> a:not(.ui-btn):focus,
					#<?php echo esc_attr( $the_block_id ); ?> a:not(.ui-btn):hover,
					#<?php echo esc_attr( $the_block_id ); ?> a:not(.ui-btn):active {
						color: <?php echo esc_attr( $link_hover_color ); ?>;
					}
					<?php
				endif;

				if ( $overlay_type && ( $background_image || $background_video ) ) :
					?>
					#<?php echo esc_attr( $the_block_id ); ?>.has-overlay .block-overlay {
						<?php
						if ( 'color' === $overlay_type && $overlay_color ) :
							?>
							background-color: <?php echo esc_attr( $overlay_color ); ?>;
							<?php
						endif;

						if ( 'gradient' === $overlay_type && $overlay_1st_color && $overlay_2nd_color ) :
							if ( 'linear' === $overlay_gradient_type ) :
								?>
								background-image: linear-gradient( <?php echo esc_attr( $overlay_gradient_angle ) . 'deg, ' . esc_attr( $overlay_1st_color ) . ' ' . esc_attr( $overlay_1st_color_location ) . '%, ' . esc_attr( $overlay_2nd_color ) . ' ' . esc_attr( $overlay_2nd_color_location ) . '%'; ?>);
								<?php
							endif;
							if ( 'radial' === $overlay_gradient_type ) :
								?>
								background-image: radial-gradient( at <?php echo esc_attr( $overlay_gradient_position ) . ', ' . esc_attr( $overlay_1st_color ) . ' ' . esc_attr( $overlay_1st_color_location ) . '%, ' . esc_attr( $overlay_2nd_color ) . ' ' . esc_attr( $overlay_2nd_color_location ) . '%'; ?>);
								<?php
							endif;
						endif;

						if ( $overlay_blend_mode ) :
							?>
							mix-blend-mode: <?php echo esc_attr( $overlay_blend_mode ); ?>;
							<?php
						endif;

						if ( $overlay_opacity ) :
							?>
							opacity: calc(<?php echo esc_attr( $overlay_opacity ); ?>/100);
							<?php
						endif;
						?>
					}
					<?php
				endif;

				if ( $background_color ) :
					?>
					#<?php echo esc_attr( $the_block_id ); ?> .block-background {
						background-color: <?php echo esc_attr( $background_color ); ?>;
					}
					<?php
				endif;

				if ( 'gradient' === $background_type && $first_gradient_color && $second_gradient_color ) :
					?>
					#<?php echo esc_attr( $the_block_id ); ?> .gradient-background {
						<?php
						if ( 'linear' === $gradient_type ) :
							?>
							background-image: linear-gradient( <?php echo esc_attr( $gradient_angle ) . 'deg, ' . esc_attr( $first_gradient_color ) . ' ' . esc_attr( $first_gradient_location ) . '%, ' . esc_attr( $second_gradient_color ) . ' ' . esc_attr( $second_gradient_location ) . '%'; ?>);
							<?php
						endif;
						if ( 'radial' === $gradient_type ) :
							?>
							background-image: radial-gradient( at <?php echo esc_attr( $gradient_position ) . ', ' . esc_attr( $first_gradient_color ) . ' ' . esc_attr( $first_gradient_location ) . '%, ' . esc_attr( $second_gradient_color ) . ' ' . esc_attr( $second_gradient_location ) . '%'; ?>);
							<?php
						endif;
						?>
					}
					<?php
				endif;

				if ( $background_object_fit || $background_object_position ) :
					?>
					#<?php echo esc_attr( $the_block_id ); ?> .video-background,
					#<?php echo esc_attr( $the_block_id ); ?> .image-background,
					#<?php echo esc_attr( $the_block_id ); ?> .image-background img {
						<?php
						if ( $background_object_fit ) :
							echo 'object-fit: ' . esc_attr( $background_object_fit ) . ';';
						endif;
						if ( $background_object_position ) :
							echo 'object-position: ' . esc_attr( $background_object_position ) . ';';
						endif;
						?>
					}
					<?php
				endif;

				if ( 'none' !== $top_divider['top_divider_style'] ) :
					if ( $top_divider['top_divider_front'] || isset( $top_divider['top_divider_border'] ) || $top_divider['top_divider_color'] ) :
						?>
						#<?php echo esc_attr( $the_block_id ); ?> > .top-divider {
							<?php
							if ( $top_divider['top_divider_front'] ) :
								?>
							z-index: 2;
								<?php
							endif;

							if ( isset( $top_divider['top_divider_border'] ) ) :
								?>
							border-top-style: solid;
							border-top-width: <?php echo esc_attr( $top_divider['top_divider_border'] . 'vh' ); ?>;
								<?php
							endif;

							if ( $top_divider['top_divider_color'] ) :
								?>
							border-top-color: <?php echo esc_attr( $top_divider['top_divider_color'] ); ?>;
								<?php
							endif;
							?>
						}
						<?php
					endif;

					if ( $top_divider['top_divider_color'] ) :
						?>
						#<?php echo esc_attr( $the_block_id ); ?> > .top-divider .shape-divider {
							fill: <?php echo esc_attr( $top_divider['top_divider_color'] ); ?>;
							stop-color: <?php echo esc_attr( $top_divider['top_divider_color'] ); ?>;
						}
						<?php
					endif;

					if ( isset( $top_divider['top_divider_width'] ) ) :
						?>
						@media screen and (min-width: 768px) {
							#<?php echo esc_attr( $the_block_id ); ?> > .top-divider svg {
								width: calc(<?php echo esc_attr( $top_divider['top_divider_width'] . '%' ); ?> + 100px);
							}
						}
						<?php
					endif;

					if (
						isset( $top_divider['top_divider_height'] ) ||
						$top_divider['top_divider_flip_y'] ||
						$top_divider['top_divider_flip_x']
					) :
						?>

						#<?php echo esc_attr( $the_block_id ); ?> > .top-divider svg {
							<?php
							if ( isset( $top_divider['top_divider_height'] ) ) :
								?>
								height: <?php echo esc_attr( $top_divider['top_divider_height'] . 'px' ); ?>;
								<?php
							endif;

							if ( $top_divider['top_divider_flip_y'] || $top_divider['top_divider_flip_x'] ) :
								$top_divider_flip_y = $top_divider['top_divider_flip_y'] ? ' rotateX(180deg)' : '';
								$top_divider_flip_x = $top_divider['top_divider_flip_x'] ? ' rotateY(180deg)' : '';
								?>
								-webkit-transform: <?php echo esc_attr( 'translateX(-50%)' . $top_divider_flip_y . $top_divider_flip_x ); ?>;
								transform: <?php echo esc_attr( 'translateX(-50%)' . $top_divider_flip_y . $top_divider_flip_x ); ?>;
								<?php
							endif;
							?>
						}
						<?php
					endif;
				endif;

				if ( 'none' !== $bottom_divider['bottom_divider_style'] ) :
					if ( $bottom_divider['bottom_divider_front'] || isset( $bottom_divider['bottom_divider_border'] ) || $bottom_divider['bottom_divider_color'] ) :
						?>
						#<?php echo esc_attr( $the_block_id ); ?> > .bottom-divider {
							<?php
							if ( $bottom_divider['bottom_divider_front'] ) :
								?>
							z-index: 2;
								<?php
							endif;

							if ( isset( $bottom_divider['bottom_divider_border'] ) ) :
								?>
							border-bottom-style: solid;
							border-bottom-width: <?php echo esc_attr( $bottom_divider['bottom_divider_border'] . 'vh' ); ?>;
								<?php
							endif;

							if ( $bottom_divider['bottom_divider_color'] ) :
								?>
							border-bottom-color: <?php echo esc_attr( $bottom_divider['bottom_divider_color'] ); ?>;
								<?php
							endif;
							?>
						}
						<?php
					endif;

					if ( $bottom_divider['bottom_divider_color'] ) :
						?>
						#<?php echo esc_attr( $the_block_id ); ?> > .bottom-divider .shape-divider {
							fill: <?php echo esc_attr( $bottom_divider['bottom_divider_color'] ); ?>;
							stop-color: <?php echo esc_attr( $bottom_divider['bottom_divider_color'] ); ?>;
						}
						<?php
					endif;

					if ( isset( $bottom_divider['bottom_divider_width'] ) ) :
						?>
						@media screen and (min-width: 768px) {
							#<?php echo esc_attr( $the_block_id ); ?> > .bottom-divider svg {
								width: calc(<?php echo esc_attr( $bottom_divider['bottom_divider_width'] . '%' ); ?> + 100px);
							}
						}
						<?php
					endif;

					if (
						isset( $bottom_divider['bottom_divider_height'] ) ||
						$bottom_divider['bottom_divider_flip_y'] ||
						$bottom_divider['bottom_divider_flip_x']
					) :
						?>
						#<?php echo esc_attr( $the_block_id ); ?> > .bottom-divider svg {
							<?php
							if ( isset( $bottom_divider['bottom_divider_height'] ) ) :
								?>
								height: <?php echo esc_attr( $bottom_divider['bottom_divider_height'] . 'px' ); ?>;
								<?php
							endif;

							if ( $bottom_divider['bottom_divider_flip_y'] || $bottom_divider['bottom_divider_flip_x'] ) :
								$bottom_divider_flip_y = $bottom_divider['bottom_divider_flip_y'] ? ' rotateX(180deg)' : '';
								$bottom_divider_flip_x = $bottom_divider['bottom_divider_flip_x'] ? ' rotateY(180deg)' : '';
								?>
								-webkit-transform: <?php echo esc_attr( 'translateX(-50%)' . $bottom_divider_flip_y . $bottom_divider_flip_x ); ?>;
								transform: <?php echo esc_attr( 'translateX(-50%)' . $bottom_divider_flip_y . $bottom_divider_flip_x ); ?>;
								<?php
							endif;
							?>
						}
						<?php
					endif;
				endif;
				?>
			</style>
			<?php
			$block_custom_styles = ob_get_clean();

		endif;

		if ( $block_custom_styles ) {
			echo $block_custom_styles; // phpcs:ignore
		}
	}

	/**
	 *
	 * Get the gutenberg colors formatted for use with Iris, Automattic's color picker.
	 *
	 * @access public
	 * @return array Gutenberg color array.
	 */
	public function get_the_colors() {

		// Get the colors.
		$color_palette = current( (array) get_theme_support( 'editor-color-palette' ) );

		// Bail if there aren't any colors found.
		if ( ! $color_palette ) {
			return;
		}

		// Output begins.
		ob_start();

		// Output the names in a string.
		echo '[';
		foreach ( $color_palette as $color ) {
			echo "'" . esc_attr( $color['color'] ) . "', ";
		}
		echo ']';

		return ob_get_clean();
	}

	/**
	 *
	 * Add gutenberg colors into Iris.
	 *
	 * @access public
	 * @return void
	 */
	public function register_acf_color_palette() {

		$color_palette = wp_rig()->get_the_colors();

		if ( ! $color_palette ) {
			return;
		}
		?>
		<script type="text/javascript">
			(function( $ ) {
				acf.add_filter( 'color_picker_args', function( args, $field ){
					// add the hexadecimal codes here for the colors you want to appear as swatches
					args.palettes = <?php echo $color_palette; // phpcs:ignore ?>
					// return colors
					return args;
				});
			})(jQuery);
		</script>
		<?php
	}

	/**
	 *
	 * Convert #HEX color value too RGBA.
	 *
	 * @access public
	 * @param string $hex #HEX color value.
	 * @param string $opacity percentage of opacity in decimal.
	 * @return string rgba color value.
	 */
	public function hex2rgba( $hex, $opacity = '1' ) {

		if ( empty( $hex ) ) {
			return;
		}

		$hex = str_replace( '#', '', $hex );

		if ( strlen( $hex ) === 3 ) {
			$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
			$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
			$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
		} else {
			$r = hexdec( substr( $hex, 0, 2 ) );
			$g = hexdec( substr( $hex, 2, 2 ) );
			$b = hexdec( substr( $hex, 4, 2 ) );
		}

		$rgba = 'rgba( ' . $r . ', ' . $g . ', ' . $b . ', ' . $opacity . ')';

		return $rgba;
	}

	/**
	 * Get headline with heading tag level .
	 *
	 * @access public
	 * @param string $headline acf value.
	 * @param string $class headline css class.
	 * @param string $level acf value.
	 * @return void
	 */
	public function get_headline( $headline, $class, $level = 'h2' ) {

		// Bail if headline is empty.
		if ( empty( $headline ) ) {
			return;
		}

		echo sprintf(
			'<%1$s class="%2$s">%3$s</%1$s>',
			esc_attr( $level ),
			esc_attr( $class ),
			esc_html( $headline )
		);
	}

	/**
	 * Get tagline.
	 *
	 * @access public
	 * @param string $tagline acf value.
	 * @param string $class tagline css class.
	 * @return void
	 */
	public function get_tagline( $tagline, $class ) {

		// Bail if tagline is empty.
		if ( empty( $tagline ) ) {
			return;
		}

		echo sprintf( '<small class="%2$s">%1$s</small>', esc_html( $tagline ), esc_attr( $class ) );
	}

	/**
	 * Get caption.
	 *
	 * @access public
	 * @param string $caption acf value.
	 * @param bool   $rich_content Whether caption enable rich content.
	 * @param string $caption_wysiwyg acf value.
	 * @param string $class caption css class.
	 * @return void
	 */
	public function get_caption( $caption, $rich_content, $caption_wysiwyg, $class ) {

		// Bail if caption is empty.
		if ( empty( $caption ) && empty( $caption_wysiwyg ) ) {
			return;
		}

		$caption = $rich_content ? $caption_wysiwyg : $caption;

		echo sprintf( '<div class="%2$s">%1$s</div>', wp_kses_post( $caption ), esc_attr( $class ) );
	}

	/**
	 * Get Button.
	 *
	 * @access public
	 * @param array  $link button values.
	 * @param string $style button style css class.
	 * @param string $size button size css class.
	 * @return void
	 */
	public function get_button( $link, $style, $size ) {

		// Bail if Button is empty.
		if ( empty( $link ) ) {
			return;
		}

		$button_class = 'ui-btn';

		if ( ! empty( $size ) ) :
			$button_class .= ' ' . $size;
		endif;

		if ( ! empty( $style ) ) :
			$button_class .= ' ' . $style;
		endif;

		echo sprintf(
			'<a class="%1$s" href="%2$s" title="Button link for %3$s" target="%4$s">%5$s</a>',
			esc_attr( $button_class ),
			esc_url( $link['url'] ),
			esc_attr( $link['title'] ),
			esc_attr( $link['target'] ),
			esc_html( $link['title'] )
		);
	}

	/**
	 *
	 * Boolean to string.
	 *
	 * @param boolean $b boolean value.
	 * @return string boolean value as string.
	 */
	public function bool( $b ) {
		return $b ? 'true' : 'false';
	}

	/**
	 *
	 * Array to string.
	 *
	 * This function is a workaround to ACF Select fields that sometimes output an array instead of a string.
	 *
	 * @param array $array Array value.
	 * @return string value as string.
	 */
	public function arr2str( $array ) {

		if ( empty( $array ) ) {
			return;
		}

		if ( is_array( $array ) ) {
			$string = $array[0];
		} else {
			$string = $array;
		}

		return $string;
	}

	/**
	 * Font Awesome Kit Setup
	 *
	 * @access public
	 * @return void
	 */
	public function fa_custom_setup_kit() {

		// If the AMP plugin is active, return early.
		if ( wp_rig()->is_amp() ) {
			return;
		}

		wp_enqueue_script( 'font-awesome-kit', 'https://kit.fontawesome.com/7562c580d8.js', array(), 'latest', true );
	}

	/**
	 * Enqueue Foreground Video.
	 */
	public function enqueue_foreground_video_scripts() {
		// If the AMP plugin is active, return early.
		if ( wp_rig()->is_amp() ) {
			return;
		}

		// Enqueue the foreground video script.
		$js_ytplayer_path = '/assets/js/libs/jquery.mb.YTPlayer.min.js';
		if ( file_exists( get_theme_file_path( $js_ytplayer_path ) ) ) {
			wp_enqueue_script(
				'wp-ytplayer',
				get_theme_file_uri( $js_ytplayer_path ),
				array( 'jquery' ),
				wp_rig()->get_asset_version( get_theme_file_path( $js_ytplayer_path ) ),
				true
			);
		}

		$js_foreground_video_path = '/assets/js/foreground-video.min.js';
		if ( file_exists( get_theme_file_path( $js_foreground_video_path ) ) ) {
			wp_enqueue_script(
				'wp-foreground-video',
				get_theme_file_uri( $js_foreground_video_path ),
				array( 'jquery', 'wp-ytplayer' ),
				wp_rig()->get_asset_version( get_theme_file_path( $js_foreground_video_path ) ),
				true
			);
		}

		wp_script_add_data( 'wp-ytplayer', 'defer', true );
		wp_script_add_data( 'wp-foreground-video', 'defer', true );
	}

	/**
	 * Enqueue Carousel script.
	 */
	public function enqueue_carousel_scripts() {
		// If the AMP plugin is active, return early.
		if ( wp_rig()->is_amp() ) {
			return;
		}

		// Enqueue the slick css.
		$css_slick_path = '/assets/css/libs/slick/slick.min.css';
		if ( file_exists( get_theme_file_path( $css_slick_path ) ) ) {
			wp_enqueue_style(
				'wp-slick',
				get_template_directory_uri() . $css_slick_path,
				array(),
				filemtime( get_theme_file_path( $css_slick_path ) )
			);
		}

		// Enqueue the slick theme css.
		$css_slick_theme_path = '/assets/css/libs/slick/slick-theme.min.css';
		if ( file_exists( get_theme_file_path( $css_slick_theme_path ) ) ) {
			wp_enqueue_style(
				'wp-slick-theme',
				get_template_directory_uri() . $css_slick_theme_path,
				array(),
				filemtime( get_theme_file_path( $css_slick_theme_path ) )
			);
		}

		// Enqueue the slick script.
		$js_slick_path = '/assets/js/libs/slick.min.js';
		if ( file_exists( get_theme_file_path( $js_slick_path ) ) ) {
			wp_enqueue_script(
				'wp-slick',
				get_theme_file_uri( $js_slick_path ),
				array( 'jquery' ),
				wp_rig()->get_asset_version( get_theme_file_path( $js_slick_path ) ),
				true
			);
		}

		wp_script_add_data( 'wp-slick', 'defer', false );
	}
}
