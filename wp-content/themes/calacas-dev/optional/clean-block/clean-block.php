<?php
/**
 * Block Name: Clean Block
 *
 * This is the template that displays the clean block.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

// Set up Block ID.
$block_id = wp_rig()->get_block_id( $block );

// Set up Block classes fields.
$alignment = wp_rig()->get_block_alignment( $block );
$classes   = wp_rig()->get_block_classes( $block );

// Variables for Current Block.
$field        = get_field( 'field' );
$block_height = get_field( 'block_height' ) ? get_field( 'block_height' ) : 'half-height';

// Start a block <container> with possible block options.
wp_rig()->display_block_options(
	array(
		'block'     => $block,
		'container' => 'section', // Any HTML5 container: section, div, etc...
		'class'     => 'l-block block-clean' . esc_attr( $alignment . $classes ), // Block Container class.
		'height'    => $block_height,
	)
);
?>

	<?php wp_rig()->display_block_custom_styles( $block ); ?>

</section>
<!-- / end block-clean container -->
