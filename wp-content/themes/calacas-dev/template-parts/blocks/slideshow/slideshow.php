<?php
/**
 * Block Name: Slideshow
 *
 * This is the template that displays the slideshow block.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

// Set up Block Identifiers.
$block_id   = wp_rig()->get_block_id( $block );
$block_slug = str_replace( 'acf/', '', $block['name'] );


// Set up Block classes fields.
$alignment = wp_rig()->get_block_alignment( $block );
$classes   = wp_rig()->get_block_classes( $block );

// Variables for Current Block.
$slides       = get_field( 'slides' );
$block_height = get_field( 'block_height' ) ? get_field( 'block_height' ) : 'full-height';
$options      = get_field( 'slideshow_options' );

// Default slide when no slides entered.
$default_slide = array(
	array(
		'acf_fc_layout'              => 'slide',
		'headline'                   => 'Headline here...',
		'headline_level'             => 'h2',
		'tagline'                    => 'tagline here...',
		'caption'                    => '<p>Some content here...</p>',
		'rich_content'               => '',
		'caption_wysiwyg'            => '',
		'button'                     => array(),
		'second_button'              => array(),
		'image'                      => '',
		'text_color'                 => '',
		'heading_color'              => '',
		'tagline_color'              => '',
		'link_color'                 => '',
		'link_hover_color'           => '',
		'background_type'            => '',
		'background_color'           => '',
		'background_image'           => '',
		'first_gradient_color'       => '',
		'first_gradient_location'    => 0,
		'second_gradient_color'      => '',
		'second_gradient_location'   => 100,
		'gradient_type'              => 'linear',
		'gradient_angle'             => 180,
		'gradient_position'          => array(),
		'background_video'           => '',
		'background_video_webm'      => '',
		'background_video_title'     => '',
		'video_placeholder'          => '',
		'background_object_fit'      => array(),
		'background_object_position' => array(),
		'overlay_type'               => '',
		'overlay_color'              => '',
		'overlay_1st_color'          => '',
		'overlay_1st_color_location' => 0,
		'overlay_2nd_color'          => '',
		'overlay_2nd_color_location' => 100,
		'overlay_gradient_type'      => 'linear',
		'overlay_gradient_angle'     => 180,
		'overlay_gradient_position'  => array(),
		'overlay_opacity'            => 40,
		'overlay_blend_mode'         => array(),
		'content_container'          => 'fluid-container',
		'content_width'              => 0,
		'content_align'              => '',
		'content_vertical_align'     => '',
		'padding_top'                => '',
		'padding_bottom'             => '',
		'add_foreground_video'       => '',
		'foreground_video'           => '',
		'foreground_video_trigger'   => array(),
		'add_foreground_elements'    => '',
		'elements'                   => '',
		'animations'                 => '',
	),
);

if ( empty( $slides ) ) :
	// slide .
	$slides = $default_slide;
endif;

// Set empty variables for custom styles from slides.
$slide_custom_styles    = '';
$elements_custom_styles = '';

// Add thumbnail panel class to block class array.
$has_thumbnails = '';

if ( $options['add_thumbnails'] ) {
	$has_thumbnails = ' has-thumbnails';
}


// Start a block <container> with possible block options.
wp_rig()->display_block_options(
	array(
		'block'     => $block,
		'container' => 'section', // Any HTML5 container: section, div, etc...
		'class'     => 'l-block block-slideshow' . esc_attr( $alignment . $classes . $has_thumbnails ), // Block Container class.
		'height'    => $block_height,
	)
);
?>
	<?php
	if ( ! empty( $slides ) ) :
		?>
		<div class="slideshow-container" id="<?php echo esc_attr( $block_id . '-slideshow' ); ?>">
		<?php
		foreach ( $slides as $slide_key => $slide ) :
			// Variables for each slide.
			$headline                 = $slide['headline'];
			$headline_level           = $slide['headline_level'];
			$tagline                  = $slide['tagline'];
			$caption                  = $slide['caption'];
			$rich_content             = $slide['rich_content'];
			$caption_wysiwyg          = $slide['caption_wysiwyg'];
			$button                   = $slide['button'];
			$second_button            = $slide['second_button'];
			$image                    = $slide['image'];
			$add_foreground_video     = $slide['add_foreground_video'];
			$foreground_video         = $slide['foreground_video'];
			$foreground_video_trigger = $slide['foreground_video_trigger'];
			$add_foreground_elements  = $slide['add_foreground_elements'];
			$elements                 = $slide['elements'];
			$animations               = $slide['animations'];

			// Add Foreground Video player class to slide class array.
			$foreground_video_id = '';
			$player_class        = '';

			if ( $add_foreground_video && $foreground_video ) {
				$foreground_video_id = wp_rig()->get_video_id( $foreground_video );
				$player_class        = ' has-video-foreground';
			}

			// Add Foreground Element class to slide class array.
			$element_class = '';

			if ( $add_foreground_elements && ! empty( $elements ) ) {
				$element_class = ' has-elements';
			}
			?>
			<div class="slide-wrapper">
				<?php
				// Start a block <container> with possible block options.
				$slide['slide_class'] = $block_id . '-slide-' . $slide_key;
				wp_rig()->display_slide_options(
					array(
						'class' => 'slide ' . esc_attr( $slide['slide_class'] . $player_class . $element_class ),
						'slide' => $slide,
					)
				);

				// Display Foreground Elements.
				if ( $add_foreground_elements && ! empty( $elements ) ) :
					wp_rig()->display_foreground_elements( $elements, $animations, false );
					$elements_custom_styles .= '
					' . wp_rig()->get_elements_custom_styles( $elements, $animations ) . '
					';
				endif;

				// Display Foreground video.
				if ( $add_foreground_video && $foreground_video ) :
					wp_rig()->print_styles( 'wp-foreground-video', 'wp-ytplayer' );
					wp_rig()->display_foreground_video( $foreground_video_id );
				endif;
				?>
					<?php
					$content_container_options = array(
						'content_container' => $slide['content_container'],
						'container'         => 'div',
						'class'             => 'l-content-container',
						'content_align'     => $slide['content_align'],
					);
					wp_rig()->display_content_container_options( $content_container_options );
					?>
						<div class="block-content">
							<?php
							if ( $headline || $tagline || $caption || $caption_wysiwyg ) :
								$heading_animation = wp_rig()->get_scroll_animation( 'heading', $animations );

								?>
								<div class="block-heading">
									<?php
									// Get Animation wrapper.
									wp_rig()->set_scroll_animation( $heading_animation );
									?>

										<?php
										// Print Tagline.
										wp_rig()->get_tagline( $tagline, 'block-tagline text-uppercase letter-space-2 mb-0' );

										// Print Headline.
										wp_rig()->get_headline( $headline, 'block-headline sup-h2 mb-2', $headline_level );

										// Print Caption.
										wp_rig()->get_caption( $caption, $rich_content, $caption_wysiwyg, 'block-caption h5' );

										// Print Buttons.
										if ( $button || $second_button ) :
											?>
											<div class="block-buttons mt-3">
												<?php
												if ( $button ) :
													$button_style = wp_rig()->arr2str( $button['button_style'] );
													$button_style = $button_style ? $button_style : 'btn-primary';
													$button_size  = wp_rig()->arr2str( $button['button_size'] );
													wp_rig()->get_button( $button['button_link'], $button_style, $button_size );
												endif;

												if ( $second_button ) :
													$second_button_style = wp_rig()->arr2str( $second_button['button_style'] );
													$second_button_style = $second_button_style ? $second_button_style : 'btn-outline-primary';
													$second_button_size  = wp_rig()->arr2str( $second_button['button_size'] );
													wp_rig()->get_button( $second_button['button_link'], $second_button_style, $second_button_size );
												endif;
												?>
											</div>
											<?php
										endif;
										?>

									<?php
									// Closing animation wrapper.
									if ( ! empty( $heading_animation ) ) {
										echo '</div>';
									}
									?>
								</div>
								<?php
							endif; // Ends if has headings.
							?>

							<?php
							// Display Foreground video trigger.
							if ( $add_foreground_video && $foreground_video ) :
								$trigger_animation = wp_rig()->get_scroll_animation( 'foreground_video_trigger', $animations );
								wp_rig()->display_foreground_video_trigger( $foreground_video_id, $foreground_video_trigger, $block_id, $trigger_animation );
							endif;
							?>
						</div>
					</div>
				</div><?php // end inner slide container. ?>
				<?php
				// Unique class for thumbnails and adding it to slide custom styles.
				$slide['slide_thumb_class'] = $block_id . '-slide-thumb-' . $slide_key;

				// Get each slide style.
				$slide_custom_styles .= '
				' . wp_rig()->get_slide_custom_styles( $slide ) . '
				';
				?>
			</div><?php // end slide container. ?>
			<?php
		endforeach;
		?>
		</div>

		<?php
		if ( $options['add_thumbnails'] ) :
			$slideshow_thumbs_id = $block_id . '-slideshow-thumbs';
			?>
			<div class="slideshow-thumbs" id="<?php echo esc_attr( $slideshow_thumbs_id ); ?>">
				<div class="slideshow-thumbs-container">
				<?php
				foreach ( $slides as $slide_key => $slide ) :
					// Variables for each slide.
					$headline             = $slide['headline'];
					$tagline              = $slide['tagline'];
					$background_image     = $slide['background_image'];
					$background_video     = $slide['background_video'];
					$add_foreground_video = $slide['add_foreground_video'];
					$slide_thumb_class    = $block_id . '-slide-thumb-' . $slide_key;
					?>
					<div class="slide-thumb">
						<div class="slide-thumb-wrapper <?php echo esc_attr( $slide_thumb_class ); ?>">
							<?php
							// Start a slide <container> with some slide options.
							wp_rig()->display_slide_options(
								array(
									'class' => 'slide-thumb-media',
									'slide' => $slide,
								)
							);
							?>
								<?php
								if ( ! $background_image && ! $background_video ) :
									?>
									<i class="fad fa-photo-video fa-2x"></i>
									<?php
								endif;

								// Display video trigger.
								if ( $add_foreground_video ) :
									?>
									<i class="fad fa-play-circle fa-3x"></i>
									<?php
								endif;
								?>
							</div>
							<div class="slide-thumb-content">
							<?php
							if ( $headline || $tagline ) :
								// Print Tagline.
								wp_rig()->get_tagline( $tagline, 'fs8 text-uppercase letter-space-2 my-2 block' );
								wp_rig()->get_headline( $headline, 'h6', 'div' );
							endif; // Ends if has headings.
							?>
							</div>
						</div>
					</div>
					<!-- / end slide-thumb-wrapper -->
					<?php
				endforeach;
				?>
				</div>
			</div>
			<?php
		endif; // End slideshow-thumbs.
		?>

		<?php
	endif;
	?>

	<?php
	// Get all slideshow options.
	$carousel_target = '.slideshow-container';
	$thumbs_target   = '';
	if ( ! empty( $slides ) && $options['add_thumbnails'] ) {
		$thumbs_target = '.slideshow-thumbs-container';
	}
	wp_rig()->initiate_carousel_script( $block_id, $block_slug, $carousel_target, $options, $thumbs_target );

	if ( ! empty( $slides ) && $options['add_thumbnails'] ) :

		// Thumbnail carousel settings are hardcoded for now.
		$thumbs_options = array(
			'slidestoshow'      => 4,
			'slidestoscroll'    => 1,
			'autoplay'          => false,
			'infinite'          => true,
			'dots'              => false,
			'arrows'            => true,
			'speed'             => 300,
			'autoplayspeed'     => 3000,
			'adaptiveheight'    => false,
			'swipe'             => true,
			'draggable'         => true,
			'centermode'        => false,
			'centerpadding'     => 50,
			'fade'              => false,
			'initialslide'      => 0,
			'lazyload'          => 'ondemand',
			'pauseonfocus'      => true,
			'pauseonhover'      => true,
			'rows'              => true,
			'slidesperrow'      => true,
			'color_overall'     => '',
			'color_arrows'      => '',
			'color_dots'        => '',
			'md_responsive'     => true,
			'md_breakpoint'     => 1200,
			'md_slidestoshow'   => 3,
			'md_slidestoscroll' => 1,
			'md_autoplay'       => false,
			'md_infinite'       => true,
			'md_dots'           => false,
			'md_arrows'         => true,
			'sm_responsive'     => true,
			'sm_breakpoint'     => 580,
			'sm_slidestoshow'   => 4,
			'sm_slidestoscroll' => 1,
			'sm_autoplay'       => false,
			'sm_infinite'       => true,
			'sm_dots'           => false,
			'sm_arrows'         => false,
		);

		wp_rig()->initiate_carousel_script( $block_id, $block_slug, $thumbs_target, $thumbs_options, $carousel_target );
	endif;
	?>

	<?php
	$color_overall = '';
	$color_arrows  = '';
	$color_dots    = '';

	if ( $options['color_overall'] ) {
		$color_overall = '
			#' . esc_attr( $block_id ) . '-slideshow .slick-arrow,
			#' . esc_attr( $block_id ) . '-slideshow .slick-dots li button {
				color: ' . $options['color_overall'] . ';
			}
		';
	}

	if ( $options['color_arrows'] ) {
		$color_arrows = '
			#' . esc_attr( $block_id ) . '-slideshow .slick-arrow  {
				color: ' . $options['color_arrows'] . ';
			}
		';
	}

	if ( $options['color_dots'] ) {
		$color_dots = '
			#' . esc_attr( $block_id ) . '-slideshow .slick-dots li button {
				color: ' . $options['color_dots'] . ';
			}
		';
	}

	$slideshow_thumbs = '';

	if ( ! empty( $slides ) && $options['add_thumbnails'] ) {
		$slideshow_thumbs       = '';
		$thumb_background_color = '';

		if ( $options['thumb_text_color'] ) {
			$thumb_text_color = 'color: ' . esc_attr( $options['thumb_text_color'] ) . ';';
		}

		if ( $options['thumb_background_color'] ) {
			$thumb_background_color = 'background-color: ' . wp_rig()->hex2rgba( esc_attr( $options['thumb_background_color'] ), '0.25' ) . ';';
		}

		if ( $options['thumb_text_color'] || $options['thumb_background_color'] ) {
			$slideshow_thumbs = '
				#' . esc_attr( $block_id ) . '-slideshow-thumbs {
					' . $thumb_text_color . '
					' . $thumb_background_color . '
				}
			';
		}
	}

	$carousel_custom_styles = '
		' . $color_overall . '
		' . $color_arrows . '
		' . $color_dots . '
		' . $slideshow_thumbs . '
		' . $slide_custom_styles . '
		' . $elements_custom_styles . '
	';

	wp_rig()->display_block_custom_styles( $block, $carousel_custom_styles );
	?>

</section>
<!-- / end block-slideshow container -->
