<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package calacas_theme
 */

namespace WP_Calacas\WP_Calacas;

get_header();

calacas_theme()->print_styles( 'calacas-theme-content' );

?>
	<main id="primary" class="site-main">
		<div class="inner-container">
			<?php
			if ( have_posts() ) {

				get_template_part( 'template-parts/content/page_header' );

				echo '<div class="row">';

				while ( have_posts() ) {
					the_post();

					get_template_part( 'template-parts/content/entry', get_post_type() );
				}

				echo '</div>';

				get_template_part( 'template-parts/content/pagination' );
			} else {
				get_template_part( 'template-parts/content/error' );
			}
			?>
		</div>
	</main><!-- #primary -->
<?php
get_footer();
