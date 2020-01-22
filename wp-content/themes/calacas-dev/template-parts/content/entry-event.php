<?php
/**
 * Template part for displaying an Event post.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$date           = get_field( 'date' );
$time           = get_field( 'time' );
$event_artist   = get_field( 'event_artist' );
$event_festival = get_field( 'event_festival' );
$poster_image   = get_field( 'poster_image', $event_festival );
$artist_photo   = get_field( 'artist_photo', $event_artist );
$post_class     = '';

if ( ! is_singular( get_post_type() ) ) {
	$post_class = ' block col one-third';
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' . $post_class ); ?>>
	<div class="item">

		<?php
		if ( is_singular( get_post_type() ) ) :
			$post_type = get_post_type_object( get_post_type() );
			?>
			<section class="l-block block-hero alignfull has-background image-as-background has-overlay full-height">
				<figure class="block-background image-background" aria-hidden="true">
					<?php echo wp_get_attachment_image( $poster_image, 'full' ); ?>
				</figure>
				<div class="block-overlay"></div>
				<div class="l-content-container inner-container text-center">
					<div class="block-content">
						<div class="block-heading">
							<div class="inline-block icon-200 mb-5">
								<div class="ui-img-container img-container-square circle-radius">
									<div class="inner-content">
										<?php echo wp_get_attachment_image( $artist_photo, 'medium' ); ?>
									</div>
								</div>
							</div>
							<small class="block-tagline text-uppercase letter-space-2 mb-0"><?php echo $post_type->labels->singular_name; ?></small>
							<h1 class="block-headline h3 mb-2"><?php the_title(); ?></h1>
							<h2 class="h4"><?php echo get_the_title( $event_festival ); ?></h2 class="h4">
							<div class="box-center one-fourth row my-5">
								<?php
								if ( $date ) :
									?>
									<div class="flex content-between my-2">
										<strong>Date:</strong>
										<span class="ml-3"><?php echo esc_html( $date ); ?></span>
									</div>
									<?php
								endif;
								?>
								<?php
								if ( $time ) :
									?>
									<div class="flex content-between my-2">
										<strong>Time:</strong>
										<span class="ml-3"><?php echo esc_html( $time ); ?></span>
									</div>
									<?php
								endif;
								?>
							</div>
							<div class="box-center row two-third">
								<?php the_content(); ?>
							</div>
						</div>
					</div>
				</div>
				<!-- / end content container -->
			</section>
			<div class="l-block">
				<div class="inner-container">
					<p class="h5">More from this Artist: <a href="<?php the_permalink( $event_artist ); ?>"><?php echo get_the_title( $event_artist ); ?></a></p>
					<p class="h5">More from this Festival: <a href="<?php the_permalink( $event_festival ); ?>"><?php echo get_the_title( $event_festival ); ?></a></p>
				</div>
			</div>

			<?php
		else :
			?>

			<a href="<?php the_permalink(); ?>">
				<div class="ui-img-container img-container-softlandscape rounded-radius">
					<div class="inner-content">
						<?php echo wp_get_attachment_image( $poster_image, 'medium_large' ); ?>
						<div class="festival-logo-center icon-160">
							<div class="ui-img-container img-container-square circle-radius">
								<div class="inner-content">
									<?php echo wp_get_attachment_image( $artist_photo, 'medium' ); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</a>

			<p class="h7 text-primary-gray text-uppercase letter-space-2"><?php echo esc_html( $date . ' | ' . $time ); ?></p>
			<a class="inline-block h5 text-default-medium mb-2" href="<?php the_permalink(); ?>">
				<?php the_title(); ?>
			</a>
			<p class="text-tertiary">
				<?php
				if ( has_excerpt() ) {
					the_excerpt();
				} else {
					echo esc_html( wp_trim_words( get_the_content(), 10, '...' ) );
				}
				?>
			</p>
			<a class="ui-btn btn-sm btn-primary" href="<?php the_permalink(); ?>">
				<i class="fas fa-arrow-right mr-2"></i> Read now
			</a>
			<?php
		endif;
		?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->

<?php
if ( is_singular( get_post_type() ) ) {
	// Show post navigation only when the post type is 'post' or has an archive.
	if ( 'post' === get_post_type() || get_post_type_object( get_post_type() )->has_archive ) {
		the_post_navigation(
			[
				'prev_text' => '<div class="post-navigation-sub"><span>' . esc_html__( 'Previous:', 'wp-rig' ) . '</span></div>%title',
				'next_text' => '<div class="post-navigation-sub"><span>' . esc_html__( 'Next:', 'wp-rig' ) . '</span></div>%title',
			]
		);
	}

	// Show comments only when the post type supports it and when comments are open or at least one comment exists.
	if ( post_type_supports( get_post_type(), 'comments' ) && ( comments_open() || get_comments_number() ) ) {
		comments_template();
	}
}
