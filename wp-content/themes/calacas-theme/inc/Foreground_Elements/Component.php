<?php
/**
 * WP_Calacas\WP_Calacas\Foreground_Elements\Component class
 *
 * @package calacas_theme
 */

namespace WP_Calacas\WP_Calacas\Foreground_Elements;

use WP_Calacas\WP_Calacas\Component_Interface;
use WP_Calacas\WP_Calacas\Templating_Component_Interface;
use function WP_Calacas\WP_Calacas\calacas_theme;

/**
 * Class for Foreground_Elements.
 */
class Component implements Component_Interface, Templating_Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'foreground_elements';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {

	}

	/**
	 * Gets template tags to expose as methods on the Template_Tags class instance, accessible through `calacas_theme()`.
	 *
	 * @return array Associative array of $method_name => $callback_info pairs. Each $callback_info must either be
	 *               a callable or an array with key 'callable'. This approach is used to reserve the possibility of
	 *               adding support for further arguments in the future.
	 */
	public function template_tags() : array {
		return array(
			'display_foreground_elements' => array( $this, 'display_foreground_elements' ),
			'get_elements_custom_styles'  => array( $this, 'get_elements_custom_styles' ),
		);
	}

	/**
	 * Display Foreground Elements.
	 *
	 * @access public
	 * @param array   $elements List of elements with its settings.
	 * @param array   $animations List of block animations.
	 * @param boolean $styles List of block animations.
	 * @return void
	 */
	public function display_foreground_elements( $elements, $animations = array(), $styles = true ) {
		$foreground_elements_html   = '';
		$foreground_elements_styles = '';

		if ( $elements ) :
			ob_start();
			foreach ( $elements as $key => $element ) :
				$el_name       = $element['el_name'] ? $element['el_name'] : 'element';
				$el_id         = sanitize_title( $el_name ) . '-' . $key;
				$el_animations = calacas_theme()->get_scroll_animation( $element['el_name'], $animations );

				if ( 'image' === $element['acf_fc_layout'] ) :
					?>
					<figure id="<?php echo esc_attr( $el_id ); ?>" class="block-element image-foreground" aria-hidden="true">
						<?php
						// Get Animation wrapper.
						calacas_theme()->set_scroll_animation( $el_animations );

							echo wp_get_attachment_image( $element['el_image'], 'full' );

						// Closing animation wrapper.
						if ( ! empty( $el_animations ) ) {
							echo '</div>';
						}
						?>
					</figure>
					<?php
				endif;
			endforeach;
			$foreground_elements_html = ob_get_clean();

			if ( $styles ) :
				ob_start();
				?>
				<style>
					<?php
					echo calacas_theme()->get_elements_custom_styles( $elements ); // phpcs:ignore
					?>
				</style>
				<?php
				$foreground_elements_styles = ob_get_clean();
			endif;
		endif;

		// Print a Foreground video markup.
		if ( $foreground_elements_html ) :
			echo $foreground_elements_html; // phpcs:ignore
		endif;

		// Print a Foreground video markup.
		if ( $foreground_elements_html ) :
			echo $foreground_elements_styles; // phpcs:ignore
		endif;
	}


	/**
	 * Get Elements Custom Styles.
	 *
	 * @access public
	 * @param array $elements List of elements with its settings.
	 * @return string Elements custom styles.
	 */
	public function get_elements_custom_styles( $elements ) {
		$foreground_elements_styles = '';

		if ( $elements ) :
			ob_start();
			foreach ( $elements as $key => $element ) :
				$el_name           = $element['el_name'] ? $element['el_name'] : 'element';
				$el_id             = sanitize_title( $el_name ) . '-' . $key;
				$el_position_top   = $element['el_position_top'];
				$el_position_left  = $element['el_position_left'];
				$add_el_width      = $element['add_el_width'];
				$el_width          = $element['el_width'];
				$add_el_opacity    = $element['add_el_opacity'];
				$el_opacity        = $element['el_opacity'];
				$el_send_back      = $element['el_send_back'];
				$mobile_responsive = $element['mobile_responsive'];
				?>
				#<?php echo esc_attr( $el_id ); ?> {
					width: auto;
					max-width: 100%;
					<?php
					if ( $el_position_top > 50 ) {
						echo 'bottom: ' . esc_attr( 100 - $el_position_top ) . '%;';
					} else {
						echo 'top: ' . esc_attr( $el_position_top ) . '%;';
					}

					if ( $el_position_left > 50 ) {
						echo 'right: ' . esc_attr( 100 - $el_position_left ) . '%;';
					} else {
						echo 'left: ' . esc_attr( $el_position_left ) . '%;';
					}

					if ( $el_send_back ) {
						echo 'z-index: -2;';
					}

					if ( $add_el_opacity && isset( $el_opacity ) ) {
						echo 'opacity: ' . esc_attr( $el_opacity / 100 ) . ';';
					}
					?>
				}
				<?php
				if ( isset( $el_width ) && $add_el_width ) :
					?>
					#<?php echo esc_attr( $el_id ); ?> img {
						-webkit-transform: scale(<?php echo esc_attr( $el_width ) / 100; ?>);
						transform: scale(<?php echo esc_attr( $el_width ) / 100; ?>);
					}
					<?php
				endif;

				if ( $mobile_responsive ) :
					$el_position_top_sm  = $element['el_position_top_sm'];
					$el_position_left_sm = $element['el_position_left_sm'];
					$add_el_width_sm     = $element['add_el_width_sm'];
					$el_width_sm         = $element['el_width_sm'];
					$add_el_opacity_sm   = $element['add_el_opacity_sm'];
					$el_opacity_sm       = $element['el_opacity_sm'];
					$el_send_back_sm     = $element['el_send_back_sm'];
					?>
					@media screen and (max-width: 768px) {
						#<?php echo esc_attr( $el_id ); ?> {
							width: auto;
							max-width: 100%;
							<?php
							if ( $el_position_top_sm > 50 ) {
								echo 'bottom: ' . esc_attr( 100 - $el_position_top_sm ) . '%;';
								echo 'top: auto;';
							} else {
								echo 'top: ' . esc_attr( $el_position_top_sm ) . '%;';
								echo 'bottom: auto;';
							}

							if ( $el_position_left_sm > 50 ) {
								echo 'right: ' . esc_attr( 100 - $el_position_left_sm ) . '%;';
								echo 'left: auto;';
							} else {
								echo 'left: ' . esc_attr( $el_position_left_sm ) . '%;';
								echo 'right: auto;';
							}

							if ( $el_send_back_sm ) {
								echo 'z-index: -2;';
							}

							if ( $add_el_opacity_sm && isset( $el_opacity_sm ) ) {
								echo 'opacity: ' . esc_attr( $el_opacity_sm / 100 ) . ';';
							}
							?>
						}
						<?php
						if ( isset( $el_width_sm ) && $add_el_width_sm ) :
							?>
							#<?php echo esc_attr( $el_id ); ?> img {
								-webkit-transform: scale(<?php echo esc_attr( $el_width_sm ) / 100; ?>);
								transform: scale(<?php echo esc_attr( $el_width_sm ) / 100; ?>);
							}
							<?php
						endif;
						?>
					}
					<?php
				endif;
			endforeach;
			$foreground_elements_styles = ob_get_clean();
		endif;

		// Return a foreground elements markup.
		if ( ! $foreground_elements_styles ) :
			return;
		endif;

		return $foreground_elements_styles; // phpcs:ignore
	}
}
