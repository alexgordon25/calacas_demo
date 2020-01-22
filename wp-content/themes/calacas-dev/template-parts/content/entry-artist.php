<?php
/**
 * Template part for displaying a Artist post.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$artist_photo    = get_field( 'artist_photo' );
$contact_info    = get_field( 'contact_info' );
$additional_info = get_field( 'additional_info' );
$event_artist    = get_field( 'event_artist' );
$post_class      = '';

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
			<div class="inner-container">
				<section class="l-block block-hero alignfull has-background image-as-background has-overlay half-height">
					<figure class="block-background image-background" aria-hidden="true">
						<?php echo wp_get_attachment_image( $artist_photo, 'full' ); ?>
					</figure>
					<div class="block-overlay"></div>
					<div class="l-content-container fluid-container text-center">
						<div class="block-content">
							<div class="block-heading">
								<small class="block-tagline text-uppercase letter-space-2 mb-0"><?php echo $post_type->labels->singular_name; ?></small>
								<h1 class="block-headline h3 mb-2"><?php the_title(); ?></h1>
								<div class="box-center one-third row">
									<?php
									if ( $contact_info['email'] ) :
										?>
										<div class="flex content-between my-2">
											<strong>Email:</strong>
											<span class="ml-3"><?php echo esc_html( $contact_info['email'] ); ?></span>
										</div>
										<?php
									endif;
									?>
									<?php
									if ( $contact_info['phone'] ) :
										?>
										<div class="flex content-between my-2">
											<strong>Phone:</strong>
											<span class="ml-3"><?php echo esc_html( $contact_info['phone'] ); ?></span>
										</div>
										<?php
									endif;
									?>
								</div>
							</div>
						</div>
					</div>
					<!-- / end content container -->
				</section>
			</div>
			<div class="l-block">
				<div class="inner-container">
					<?php echo wp_kses_post( $additional_info ); ?>

					<?php
					if( $event_artist ) :
						?>
						<h3 class="h4">Concerts and Events</h3>
						<?php
						echo '<div class="row">';

						foreach( $event_artist as $post) :
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
						<?php echo wp_get_attachment_image( $artist_photo, 'medium_large' ); ?>
					</div>
				</div>
			</a>

			<p class="h7 text-primary-gray text-uppercase letter-space-2"><?php echo esc_html__( 'Artist profile', 'wp-rig' ); ?></p>
			<a class="inline-block h5 text-default-medium mb-2" href="<?php the_permalink(); ?>">
				<?php the_title(); ?>
			</a>
			<p class="text-tertiary">
				<?php
				if ( has_excerpt() ) {
					the_excerpt();
				} else {
					echo esc_html( wp_trim_words( $additional_info, 10, '...' ) );
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
