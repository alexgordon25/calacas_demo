<?php
/**
 * WP_Calacas\WP_Calacas\Foreground_Video\Component class
 *
 * @package calacas_theme
 */

namespace WP_Calacas\WP_Calacas\Foreground_Video;

use WP_Calacas\WP_Calacas\Component_Interface;
use WP_Calacas\WP_Calacas\Templating_Component_Interface;
use function WP_Calacas\WP_Calacas\calacas_theme;
use function add_action;
use function add_filter;
use function wp_enqueue_script;
use function get_theme_file_uri;
use function get_theme_file_path;
use function wp_script_add_data;
use function wp_localize_script;


/**
 * Class for Foreground_Video.
 */
class Component implements Component_Interface, Templating_Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'foreground_video';
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
			'display_foreground_video'         => array( $this, 'display_foreground_video' ),
			'display_foreground_video_trigger' => array( $this, 'display_foreground_video_trigger' ),
			'get_video_src'                    => array( $this, 'get_video_src' ),
			'get_video_id'                     => array( $this, 'get_video_id' ),
		);
	}

	/**
	 * Display Foreground Video.
	 *
	 * @access public
	 * @param string $foreground_video_id Video ID.
	 * @return void
	 */
	public function display_foreground_video( $foreground_video_id ) {
		$foreground_video_html = '';

		if ( $foreground_video_id ) :
			ob_start();
			?>
			<div class="block-foreground video-foreground">
				<div class="modal-video-body">
					<div class="modal-video-inner">
						<div id="v-<?php echo esc_attr( $foreground_video_id ); ?>" class="player"
							data-property="{videoURL:'<?php echo esc_attr( $foreground_video_id ); ?>',containment:'self',mute:false,autoPlay:false,loop:false,quality:'highres',opacity:1,stopMovieOnBlur:false,optimizeDisplay:false}">
							<div class="btn-icon modal-video-close"><i class="fal fa-times fa-2x"></i></div>
						</div>
					</div>
				</div>
				<div class="modal-video-overlay modal-video-close"></div>
			</div>
			<?php
			$foreground_video_html = ob_get_clean();
		endif;

		// Print a Foreground video markup.
		if ( $foreground_video_html ) :
			echo $foreground_video_html; // phpcs:ignore
		endif;
	}

	/**
	 * Display Foreground Video Trigger.
	 *
	 * @access public
	 * @param string $foreground_video_id Video ID Video.
	 * @param array  $foreground_video_trigger Trigger Settings.
	 * @param string $block_id Block ID value.
	 * @param array  $trigger_animations Animation Settings.
	 * @return void
	 */
	public function display_foreground_video_trigger( $foreground_video_id, $foreground_video_trigger, $block_id, $trigger_animations = array() ) {
		$t_icon                = calacas_theme()->arr2str( $foreground_video_trigger['icon'] );
		$t_icon_color          = $foreground_video_trigger['icon_color'];
		$t_icon_label          = $foreground_video_trigger['icon_label'];
		$t_icon_label_position = calacas_theme()->arr2str( $foreground_video_trigger['icon_label_position'] );
		$t_icon_position       = calacas_theme()->arr2str( $foreground_video_trigger['icon_position'] );
		$t_icon_position_top   = $foreground_video_trigger['icon_position_top'];
		$t_icon_position_left  = $foreground_video_trigger['icon_position_left'];

		$foreground_video_trigger_html = '';

		if ( $foreground_video_id ) :
			ob_start();
			?>
			<div class="video-trigger" data-target="<?php echo esc_attr( '#v-' . $foreground_video_id ); ?>">
				<?php
				// Get Animation wrapper.
				calacas_theme()->set_scroll_animation( $trigger_animations );
				?>
					<div class="btn-icon">
						<i class="video-trigger-loading fad fa-spinner-third fa-3x fa-spin"></i>
						<i class="video-trigger-play <?php echo esc_attr( $t_icon ); ?> fa-3x" style="display: none"></i>
						<?php
						if ( $t_icon_label ) {
							echo '<span class="video-trigger-label">' . esc_html( $t_icon_label ) . '</span>';
						}
						?>
					</div>
				<?php
				// Closing animation wrapper.
				if ( ! empty( $trigger_animations ) ) {
					echo '</div>';
				}
				?>
			</div>
			<?php
			if ( 'absolute' === $t_icon_position || 'custom' === $t_icon_position || $t_icon_color ) :
				?>
				<style type="text/css">
					#<?php echo esc_attr( $block_id ); ?> .video-trigger {
						<?php
						if ( 'absolute' === $t_icon_position ) {
							?>
							position: absolute;
							top: 50%;
							left: 50%;
							-webkit-transform: translate(-50%, -50%);
							transform: translate(-50%, -50%);
							<?php
						}

						if ( 'custom' === $t_icon_position ) {
							echo 'position: absolute;';
							if ( $t_icon_position_top > 50 ) {
								echo 'bottom: ' . esc_attr( 100 - $t_icon_position_top ) . '%;';
							} else {
								echo 'top: ' . esc_attr( $t_icon_position_top ) . '%;';
							}

							if ( $t_icon_position_left > 50 ) {
								echo 'right: ' . esc_attr( 100 - $t_icon_position_left ) . '%;';
							} else {
								echo 'left: ' . esc_attr( $t_icon_position_left ) . '%;';
							}
						}
						?>
					}

					<?php
					if ( $t_icon_label_position && 'bottom' !== $t_icon_label_position ) {
						?>
						#<?php echo esc_attr( $block_id ); ?> .video-trigger .btn-icon {
							<?php
							if ( $t_icon_label_position && 'top' === $t_icon_label_position ) {
								echo 'flex-direction: column-reverse;';
							}

							if ( $t_icon_label_position && 'left' === $t_icon_label_position ) {
								echo 'flex-direction: row-reverse;';
							}

							if ( $t_icon_label_position && 'right' === $t_icon_label_position ) {
								echo 'flex-direction: row;';
							}
							?>
						}
						<?php
					}
					?>

					<?php
					if ( $t_icon_color ) {
						?>
						#<?php echo esc_attr( $block_id ); ?> .video-trigger svg,
						#<?php echo esc_attr( $block_id ); ?> .modal-video-close,
						#<?php echo esc_attr( $block_id ); ?> .modal-video-buffering {
							color: <?php echo esc_attr( $t_icon_color ); ?>;
							fill: <?php echo esc_attr( $t_icon_color ); ?>;
						}
						<?php
					}
					?>
				</style>
				<?php
			endif;
			$foreground_video_trigger_html = ob_get_clean();
		endif;

		// Print a Foreground video trigger markup.
		if ( $foreground_video_trigger_html ) :
			echo $foreground_video_trigger_html; // phpcs:ignore
		endif;
	}

	/**
	 * Get Video Source URL.
	 *
	 * @access public
	 * @param string $video Embed HTML Video.
	 * @return string video url source
	 */
	public function get_video_src( $video ) {

		if ( ! $video ) {
			return;
		}

		$video_src = '';

		// Get video source.
		preg_match( '/src="(.+?)"/', $video, $matches_url );

		if ( empty( $matches_url ) ) {
			return;
		}

		$video_src = $matches_url[1];

		return $video_src;
	}

	/**
	 * Get Video ID.
	 *
	 * @access public
	 * @param string $video Embed HTML Video.
	 * @return string video ID
	 */
	public function get_video_id( $video ) {

		if ( ! $video ) {
			return;
		}

		$video_id  = '';
		$video_src = $this->get_video_src( $video );

		if ( ! $video_src ) {
			return;
		}

		preg_match( '/embed(.*?)?feature/', $video_src, $matches_id );

		if ( empty( $matches_id ) ) {
			return;
		}

		$video_id = str_replace( str_split( '?/' ), '', $matches_id[1] );

		return $video_id;
	}
}
