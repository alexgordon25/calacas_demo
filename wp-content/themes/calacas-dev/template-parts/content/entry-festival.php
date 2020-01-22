<?php
/**
 * Template part for displaying a Festival post.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$poster_image   = get_field( 'poster_image' );
$logo           = get_field( 'logo' );
$start_date     = get_field( 'start_date' );
$end_date       = get_field( 'end_date' );
$location       = get_field( 'location' );
$event_festival = get_field( 'event_festival' );
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
										<?php echo wp_get_attachment_image( $logo, 'medium' ); ?>
									</div>
								</div>
							</div>
							<small class="block-tagline text-uppercase letter-space-2 mb-0"><?php echo $post_type->labels->singular_name; ?></small>
							<h1 class="block-headline h3 mb-2"><?php the_title(); ?></h1>
							<p><?php echo esc_html( $location['address'] ); ?></p>
							<div class="box-center one-fourth row my-5">
								<?php
								if ( $start_date ) :
									?>
									<div class="flex content-between my-2">
										<strong>Start Date:</strong>
										<span class="ml-3"><?php echo esc_html( $start_date ); ?></span>
									</div>
									<?php
								endif;
								?>
								<?php
								if ( $end_date ) :
									?>
									<div class="flex content-between my-2">
										<strong>End Date:</strong>
										<span class="ml-3"><?php echo esc_html( $end_date ); ?></span>
									</div>
									<?php
								endif;
								?>
							</div>
							<?php the_content(); ?>
						</div>
					</div>
				</div>
				<!-- / end content container -->
			</section>
			<div class="l-block">
				<div class="inner-container">

					<?php
					if ( $location ) :
						?>
						<h3 class="h4">Location</h3>
						<p class="text-center"><?php echo esc_html( $location['address'] ); ?></p>
						<div class="acf-map rounded-radius" data-zoom="16">
							<div class="marker" data-lat="<?php echo esc_attr( $location['lat'] ); ?>" data-lng="<?php echo esc_attr( $location['lng'] ); ?>"></div>
						</div>
						<?php
					endif;
					?>

					<?php
					if( $event_festival ) :
						?>
						<h3 class="h4">Concerts and Events</h3>
						<?php
						echo '<div class="row">';

						foreach( $event_festival as $post) :
							setup_postdata( $post );
							get_template_part( 'template-parts/content/entry', get_post_type() );
						endforeach;

						echo '</div>';

						wp_reset_postdata();
					endif;
					?>
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
									<?php echo wp_get_attachment_image( $logo, 'medium' ); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</a>

			<p class="h7 text-primary-gray text-uppercase letter-space-2"><?php echo esc_html( $location['address'] ); ?></p>
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
