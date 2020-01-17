<?php
/**
 * WP_Rig\WP_Rig\Carousel\Component class
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\Carousel;

use WP_Rig\WP_Rig\Component_Interface;
use WP_Rig\WP_Rig\Templating_Component_Interface;
use function WP_Rig\WP_Rig\wp_rig;
use function add_action;
use function add_filter;
use function wp_enqueue_script;
use function get_theme_file_uri;
use function get_theme_file_path;
use function wp_script_add_data;
use function wp_localize_script;


/**
 * Class for Carousel.
 */
class Component implements Component_Interface, Templating_Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'carousel';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {

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
			'display_slide_options'    => array( $this, 'display_slide_options' ),
			'get_slide_custom_styles'  => array( $this, 'get_slide_custom_styles' ),
			'initiate_carousel_script' => array( $this, 'initiate_carousel_script' ),
		);
	}

	/**
	 * Set the blocks options.
	 *
	 * @access public
	 * @param  array $args Some arguments.
	 * @return void
	 */
	public function display_slide_options( $args = array() ) {

		// Setup defaults.
		$defaults = array(
			'class' => 'slide',
		);

		// Parse args.
		$args = wp_parse_args( $args, $defaults );

		// Get the args variables.
		$slide_class = $args['class'];
		$slide       = $args['slide'];

		// Initiate some html variables.
		$bg_color_html    = '';
		$bg_gradient_html = '';
		$bg_video_html    = '';
		$bg_image_html    = '';
		$overlay_html     = '';

		// Get overlay type.
		$overlay_type = $slide['overlay_type'];

		// Only try to get the rest of the settings if the background type is set to anything.
		if ( $slide['background_type'] ) :
			$background_color = $slide['background_color'];
			$background_image = $slide['background_image'];
			$background_video = $slide['background_video'];
			$has_show_overlay = $overlay_type ? ' has-overlay' : ''; // Show overlay class, if it exists.

			// Get block animations.
			$bg_animations = wp_rig()->get_scroll_animation( 'background', $slide['animations'] );

			// Color Background Set.
			if ( 'classic' === $slide['background_type'] && $background_color && ! $background_image ) :

				// Construct class.
				$args['class'] .= ' has-background color-as-background';
				ob_start();
				?>
					<div class="block-background color-background" aria-hidden="true"></div>
				<?php
				$bg_color_html = ob_get_clean();
			endif;

			// Background Image Set.
			if ( 'classic' === $slide['background_type'] && $background_image ) :

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
			if ( 'gradient' === $slide['background_type'] ) {

				// Construct class.
				$args['class'] .= ' has-background gradient-as-background';
				ob_start();
				?>
					<div class="block-background gradient-background" aria-hidden="true"></div>
				<?php
				$bg_gradient_html = ob_get_clean();
			}

			if ( 'video' === $slide['background_type'] && $background_video ) :
				$background_video_webm  = $slide['background_video_webm'];
				$background_video_title = $slide['background_video_title'];
				$video_placeholder      = $slide['video_placeholder'];
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

			if ( 'none' === $slide['background_type'] ) :
				$args['class'] .= ' no-background';
			endif;
		endif;

		// Print our block container with options.
		printf( '<div class="%s">', esc_attr( $args['class'] ) );

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
	}

	/**
	 * Set slide custom styles.
	 *
	 * @access public
	 * @param  array $slide slide settings.
	 * @return string slide custom style.
	 */
	public function get_slide_custom_styles( $slide ) {

		// Variables for custom styles.
		$slide_class                = '.block-slideshow .slide.' . $slide['slide_class'];
		$slide_thumb_class          = '.block-slideshow .slide-thumb-wrapper.' . $slide['slide_thumb_class'];
		$text_color                 = $slide['text_color'];
		$heading_color              = $slide['heading_color'];
		$tagline_color              = $slide['tagline_color'];
		$link_color                 = $slide['link_color'];
		$link_hover_color           = $slide['link_hover_color'];
		$background_type            = $slide['background_type'];
		$background_color           = $slide['background_color'];
		$background_image           = $slide['background_image'];
		$background_video           = $slide['background_video'];
		$first_gradient_color       = $slide['first_gradient_color'];
		$first_gradient_location    = $slide['first_gradient_location'];
		$second_gradient_color      = $slide['second_gradient_color'];
		$second_gradient_location   = $slide['second_gradient_location'];
		$gradient_type              = $slide['gradient_type'];
		$gradient_angle             = $slide['gradient_angle'];
		$gradient_position          = wp_rig()->arr2str( $slide['gradient_position'] );
		$background_object_fit      = wp_rig()->arr2str( $slide['background_object_fit'] );
		$background_object_position = wp_rig()->arr2str( $slide['background_object_position'] );
		$overlay_type               = $slide['overlay_type'];
		$overlay_color              = $slide['overlay_color'];
		$overlay_1st_color          = $slide['overlay_1st_color'];
		$overlay_1st_color_location = $slide['overlay_1st_color_location'];
		$overlay_2nd_color          = $slide['overlay_2nd_color'];
		$overlay_2nd_color_location = $slide['overlay_2nd_color_location'];
		$overlay_gradient_type      = $slide['overlay_gradient_type'];
		$overlay_gradient_angle     = $slide['overlay_gradient_angle'];
		$overlay_gradient_position  = wp_rig()->arr2str( $slide['overlay_gradient_position'] );
		$overlay_opacity            = $slide['overlay_opacity'];
		$overlay_blend_mode         = wp_rig()->arr2str( $slide['overlay_blend_mode'] );
		$content_width              = $slide['content_width'];
		$content_vertical_align     = $slide['content_vertical_align'];
		$padding_top                = $slide['padding_top'];
		$padding_bottom             = $slide['padding_bottom'];

		// Initiate slide_custom_styles blank.
		$slide_custom_styles = '';

		// Add custom styles only if there is any.
		if (
			$background_color ||
			$text_color ||
			( $first_gradient_color && $second_gradient_color ) ||
			$overlay_type ||
			$background_object_fit ||
			$background_object_position ||
			$content_width ||
			$content_vertical_align ||
			$padding_top ||
			$padding_bottom
		) :

			// Output begins.
			ob_start();
			?>
				<?php
				if ( $text_color || $content_vertical_align || $padding_top || $padding_bottom ) :
					?>
					<?php echo esc_attr( $slide_class ); ?> {

						<?php
						if ( $text_color ) :
							?>
							color: <?php echo esc_attr( $text_color ); ?>;
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
						<?php echo esc_attr( $slide_class ); ?> .block-content {
							width: <?php echo esc_attr( $content_width ); ?>%;
							display: inline-block;
						}
					}
					<?php
				endif;

				if ( $heading_color ) :
					?>
					<?php echo esc_attr( $slide_class ); ?> .block-headline {
						color: <?php echo esc_attr( $heading_color ); ?>;
					}
					<?php
				endif;

				if ( $tagline_color ) :
					?>
					<?php echo esc_attr( $slide_class ); ?> .block-tagline {
						color: <?php echo esc_attr( $tagline_color ); ?>;
					}
					<?php
				endif;

				if ( $link_color ) :
					?>
					<?php echo esc_attr( $slide_class ); ?> a:not(.ui-btn),
					<?php echo esc_attr( $slide_class ); ?> a:not(.ui-btn):visited {
						color: <?php echo esc_attr( $link_color ); ?>;
					}
					<?php
				endif;

				if ( $link_hover_color ) :
					?>
					<?php echo esc_attr( $slide_class ); ?> a:not(.ui-btn):focus,
					<?php echo esc_attr( $slide_class ); ?> a:not(.ui-btn):hover,
					<?php echo esc_attr( $slide_class ); ?> a:not(.ui-btn):active {
						color: <?php echo esc_attr( $link_hover_color ); ?>;
					}
					<?php
				endif;

				if ( $overlay_type && ( $background_image || $background_video ) ) :
					?>
					<?php echo esc_attr( $slide_class ); ?>.has-overlay .block-overlay {
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
					<?php echo esc_attr( $slide_class ); ?> .block-background,
					<?php echo esc_attr( $slide_thumb_class ); ?> .block-background {
						background-color: <?php echo esc_attr( $background_color ); ?>;
					}
					<?php
				endif;

				if ( 'gradient' === $background_type && $first_gradient_color && $second_gradient_color ) :
					?>
					<?php echo esc_attr( $slide_class ); ?> .gradient-background,
					<?php echo esc_attr( $slide_thumb_class ); ?> .gradient-background {
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
					<?php echo esc_attr( $slide_class ); ?> .video-background,
					<?php echo esc_attr( $slide_class ); ?> .image-background,
					<?php echo esc_attr( $slide_class ); ?> .image-background img {
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
				?>
			<?php
			$slide_custom_styles = ob_get_clean();

		endif;

		if ( ! $slide_custom_styles ) {
			return;
		}

		return $slide_custom_styles; // phpcs:ignore
	}

	/**
	 * Initiate carousel script.
	 *
	 * @access public
	 * @param string $block_id The block ID.
	 * @param string $block_slug The block slug.
	 * @param string $carousel_target target container for carousel.
	 * @param array  $options slideshow settings.
	 * @param string $parent_slideshow element selector used on parent slideshow.
	 * @return void
	 */
	public function initiate_carousel_script( $block_id, $block_slug, $carousel_target, $options, $parent_slideshow = '' ) {

		// Tablet Responsive.
		$md_responsive = '';

		if ( $options['md_responsive'] ) {
			$join          = $options['sm_responsive'] ? ',' : '';
			$md_responsive = '
			{
				breakpoint: ' . $options['md_breakpoint'] . ',
				settings: {
					slidesToShow: ' . $options['md_slidestoshow'] . ',
					slidesToScroll: ' . $options['md_slidestoscroll'] . ',
					autoplay: ' . wp_rig()->bool( $options['md_autoplay'] ) . ',
					infinite: ' . wp_rig()->bool( $options['md_infinite'] ) . ',
					dots: ' . wp_rig()->bool( $options['md_dots'] ) . ',
					arrows: ' . wp_rig()->bool( $options['md_arrows'] ) . ',
				}
			} ' . $join;
		}

		// Mobile Responsive.
		$sm_responsive = '';

		if ( $options['sm_responsive'] ) {
			$sm_responsive = '
			{
				breakpoint: ' . $options['sm_breakpoint'] . ',
				settings: {
					slidesToShow: ' . $options['sm_slidestoshow'] . ',
					slidesToScroll: ' . $options['sm_slidestoscroll'] . ',
					autoplay: ' . wp_rig()->bool( $options['sm_autoplay'] ) . ',
					infinite: ' . wp_rig()->bool( $options['sm_infinite'] ) . ',
					dots: ' . wp_rig()->bool( $options['sm_dots'] ) . ',
					arrows: ' . wp_rig()->bool( $options['sm_arrows'] ) . ',
				}
			}
			';
		}

		// Concatenating Responsive settings.
		$responsive = '';
		if ( $options['md_responsive'] || $options['sm_responsive'] ) {
			$responsive = '
			responsive: [
				' . $md_responsive . '
				' . $sm_responsive . '
			]
			';
		}

		$slides_per_row = 2 < $options['rows'] ? 'slidesPerRow: ' . $options['slidesperrow'] . ',' : '';
		$initialslide   = $options['initialslide'] ? $options['initialslide'] : '0';
		$thumbnail_sync = $parent_slideshow ? 'asNavFor: "' . $parent_slideshow . '",' : '';

		// Main Slick settings.
		$var_id         = str_replace( '-', '_', $block_id );
		$slick_initiate = '
		jQuery( function( $ ) {

			/**
			 * initializeCarousel
			 *
			 * Adds slick script initializer to the block HTML.
			 *
			 * @param   object $block The block jQuery element.
			 * @param   object attributes The block attributes (only available when editing).
			 * @return  void
			 */
			var initialize_' . $var_id . ' = function( $block ) {
				$block.find( "' . $carousel_target . '" ).slick({
					slidesToShow: ' . $options['slidestoshow'] . ',
					slidesToScroll: ' . $options['slidestoscroll'] . ',
					autoplay: ' . wp_rig()->bool( $options['autoplay'] ) . ',
					infinite: ' . wp_rig()->bool( $options['infinite'] ) . ',
					dots: ' . wp_rig()->bool( $options['dots'] ) . ',
					arrows: ' . wp_rig()->bool( $options['arrows'] ) . ',
					prevArrow: \'<div class="arrows slick-prev"><i class="fad fa-chevron-double-left fa-2x"></i></div>\',
					nextArrow: \'<div class="arrows slick-next"><i class="fad fa-chevron-double-right fa-2x"></i></div>\',
					speed: ' . $options['speed'] . ',
					autoplaySpeed: ' . $options['autoplayspeed'] . ',
					adaptiveHeight: ' . wp_rig()->bool( $options['adaptiveheight'] ) . ',
					swipe: ' . wp_rig()->bool( $options['swipe'] ) . ',
					draggable: ' . wp_rig()->bool( $options['draggable'] ) . ',
					centerMode: ' . wp_rig()->bool( $options['centermode'] ) . ',
					centerPadding: "' . $options['centerpadding'] . 'px",
					fade: ' . wp_rig()->bool( $options['fade'] ) . ',
					initialSlide: ' . esc_attr( $initialslide ) . ',
					lazyLoad: "' . $options['lazyload'] . '",
					pauseOnFocus: ' . wp_rig()->bool( $options['pauseonfocus'] ) . ',
					pauseOnHover: ' . wp_rig()->bool( $options['pauseonhover'] ) . ',
					focusOnSelect: true,
					rows: ' . $options['rows'] . ',
					' . $slides_per_row . '
					' . $thumbnail_sync . '
					' . $responsive . '
				});
			}

			// Initialize each block on page load (front end).
			$(document).ready(function(){
				if ( $( "#' . $block_id . ' " ) ) {
					initialize_' . $var_id . '( $( "#' . $block_id . ' " ) );
				}
			});

			// Initialize dynamic block preview (editor).
			if ( window.acf ) {
				window.acf.addAction( "render_block_preview/type=' . $block_slug . '", initialize_' . $var_id . ' );
			}
		} );
		';

		wp_add_inline_script( 'wp-slick', $slick_initiate );
	}
}
