<?php
/**
 * Block Name: Hero
 *
 * This is the template that displays the hero block.
 *
 * @package calacas_theme
 */

namespace WP_Calacas\WP_Calacas;

// Set up Block ID.
$block_id = calacas_theme()->get_block_id( $block );

// Set up Block classes fields.
$alignment = calacas_theme()->get_block_alignment( $block );
$classes   = calacas_theme()->get_block_classes( $block );

// Variables for Current Block.
$headline                 = get_field( 'headline' );
$headline_level           = get_field( 'headline_level' );
$tagline                  = get_field( 'tagline' );
$caption                  = get_field( 'caption' );
$rich_content             = get_field( 'rich_content' );
$caption_wysiwyg          = get_field( 'caption_wysiwyg' );
$button                   = get_field( 'button' );
$second_button            = get_field( 'second_button' );
$block_height             = get_field( 'block_height' ) ? get_field( 'block_height' ) : 'half-height';
$add_foreground_video     = get_field( 'add_foreground_video' );
$foreground_video         = get_field( 'foreground_video' );
$foreground_video_trigger = get_field( 'foreground_video_trigger' );
$add_foreground_elements  = get_field( 'add_foreground_elements' );
$elements                 = get_field( 'elements' );
$animations               = get_field( 'animations' );

// Add Foreground Video player class to block class array.
$foreground_video_id = '';
$player_class        = '';

if ( $add_foreground_video && $foreground_video ) {
	$foreground_video_id = calacas_theme()->get_video_id( $foreground_video );
	$player_class        = ' has-video-foreground';
}

// Add Foreground Element class to block class array.
$element_class = '';

if ( $add_foreground_elements && ! empty( $elements ) ) {
	$element_class = ' has-elements';
}

// Start a block <container> with possible block options.
calacas_theme()->display_block_options(
	array(
		'block'     => $block,
		'container' => 'section', // Any HTML5 container: section, div, etc...
		'class'     => 'l-block block-hero' . esc_attr( $alignment . $classes . $player_class . $element_class ), // Block Container class.
		'height'    => $block_height,
	)
);

// Display Foreground Elements.
if ( $add_foreground_elements && ! empty( $elements ) ) :
	calacas_theme()->display_foreground_elements( $elements, $animations );
endif;
?>

<?php
// Display Foreground video.
if ( $add_foreground_video && $foreground_video ) :
	calacas_theme()->print_styles( 'wp-foreground-video', 'wp-ytplayer' );
	calacas_theme()->display_foreground_video( $foreground_video_id );
endif;
?>

<?php
calacas_theme()->display_content_container_options();
?>
		<div class="block-content">
			<?php
			if ( $headline || $tagline || $caption || $caption_wysiwyg ) :
				$heading_animation = calacas_theme()->get_scroll_animation( 'heading', $animations );

				?>
				<div class="block-heading">
					<?php
					// Get Animation wrapper.
					calacas_theme()->set_scroll_animation( $heading_animation );
					?>

						<?php
						// Print Tagline.
						calacas_theme()->get_tagline( $tagline, 'block-tagline text-uppercase letter-space-2 mb-0' );

						// Print Headline.
						calacas_theme()->get_headline( $headline, 'block-headline sup-h2 mb-2', $headline_level );

						// Print Caption.
						calacas_theme()->get_caption( $caption, $rich_content, $caption_wysiwyg, 'block-caption h5' );

						// Print Buttons.
						if ( $button || $second_button ) :
							?>
							<div class="block-buttons mt-3">
								<?php
								if ( $button ) :
									$button['button_style'] = $button['button_style'] ? $button['button_style'] : 'btn-primary';
									calacas_theme()->get_button( $button['button_link'], $button['button_style'], $button['button_size'] );
								endif;

								if ( $second_button ) :
									$second_button['button_style'] = $second_button['button_style'] ? $second_button['button_style'] : 'btn-outline-primary';
									calacas_theme()->get_button( $second_button['button_link'], $second_button['button_style'], $second_button['button_size'] );
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
				$trigger_animation = calacas_theme()->get_scroll_animation( 'foreground_video_trigger', $animations );
				calacas_theme()->display_foreground_video_trigger( $foreground_video_id, $foreground_video_trigger, $block_id, $trigger_animation );
			endif;
			?>
		</div>
	</div>
	<!-- / end content container -->
	<?php calacas_theme()->display_block_custom_styles( $block ); ?>

</section>
<!-- / end block-hero container -->
