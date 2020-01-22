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
				'category'          => 'calacas-blocks',
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
				'category'          => 'calacas-blocks',
				'icon'              => '<svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="projector" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><g class="fa-group"><path class="fa-secondary" fill="#22222e" d="M592 192h-95.41C543.47 215.77 576 263.93 576 320c0 61.88-39.44 114.31-94.34 134.64L493 499.88A16 16 0 0 0 508.49 512h39A16 16 0 0 0 563 499.88L576 448h16a48 48 0 0 0 48-48V240a48 48 0 0 0-48-48zm-224.59 0H48a48 48 0 0 0-48 48v160a48 48 0 0 0 48 48h16l13 51.88A16 16 0 0 0 92.49 512h39A16 16 0 0 0 147 499.88L160 448h207.41C320.53 424.23 288 376.07 288 320s32.53-104.23 79.41-128zM96 352a32 32 0 1 1 32-32 32 32 0 0 1-32 32zm96 0a32 32 0 1 1 32-32 32 32 0 0 1-32 32zm325.66-218.35a16 16 0 0 0 22.62 0l67.88-67.88a16 16 0 0 0 0-22.63l-11.32-11.31a16 16 0 0 0-22.62 0l-67.88 67.89a16 16 0 0 0 0 22.62zM440 0h-16a16 16 0 0 0-16 16v96a16 16 0 0 0 16 16h16a16 16 0 0 0 16-16V16a16 16 0 0 0-16-16zM323.72 133.65a16 16 0 0 0 22.62 0l11.32-11.31a16 16 0 0 0 0-22.62l-67.88-67.89a16 16 0 0 0-22.62 0l-11.32 11.31a16 16 0 0 0 0 22.63z" opacity="1"></path><path class="fa-primary" fill="#38d6c7" d="M96 288a32 32 0 1 0 32 32 32 32 0 0 0-32-32zm336-112a144 144 0 1 0 144 144 144 144 0 0 0-144-144zm0 240a96 96 0 1 1 96-96 96.14 96.14 0 0 1-96 96z"></path></g></svg>',
				'mode'              => 'preview', // auto, preview, edit.
				'enqueue_assets'    => array( $this, 'acf_block_assets' ),
				'align'             => 'full', // left, center, right, wide, full.
				'keywords'          => array( 'slideshow', 'hero', 'cover', 'header' ),
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
		$font_awesome_id = get_field( 'font_awesome_id', 'options' );
		wp_enqueue_script( 'font-awesome-kit', 'https://kit.fontawesome.com/' . $font_awesome_id . '.js', array(), 'latest', false );
		wp_script_add_data( 'font-awesome-kit', 'defer', true );
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
				false
			);
		}

		$js_foreground_video_path = '/assets/js/foreground-video.min.js';
		if ( file_exists( get_theme_file_path( $js_foreground_video_path ) ) ) {
			wp_enqueue_script(
				'wp-foreground-video',
				get_theme_file_uri( $js_foreground_video_path ),
				array( 'jquery', 'wp-ytplayer' ),
				wp_rig()->get_asset_version( get_theme_file_path( $js_foreground_video_path ) ),
				false
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
