<?php
/**
 * Template part for displaying a post's content
 *
 * @package calacas_theme
 */

namespace WP_Calacas\WP_Calacas;

?>

<div class="entry-content">
	<?php
	the_content(
		sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'calacas-theme' ),
				[
					'span' => [
						'class' => [],
					],
				]
			),
			get_the_title()
		)
	);

	wp_link_pages(
		[
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'calacas-theme' ),
			'after'  => '</div>',
		]
	);
	?>
</div><!-- .entry-content -->
