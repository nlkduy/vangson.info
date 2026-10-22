<?php
	if ( get_theme_mod( 'xmag_magazine' ) ) :
	/* Magazine Template */
	get_template_part('page-templates/magazine');
	else :
?>

<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package xMag
 * @since xMag 1.0
 */

get_header(); ?>

	<?php
	/* Blog Options */
	$blog_layout = get_theme_mod( 'xmag_blog', 'layout2' );
	$post_template = xmag_blog_post_template();
	$post_column = xmag_blog_post_column();
	?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php if ( have_posts() ) : ?>

					<?php

					if ( $blog_layout == 'layout7' || $blog_layout == 'layout8' ) :
						/* Blog Layout 7 and 8 */
						get_template_part('template-parts/loop-first-large');

					elseif ( $blog_layout == 'layout9' || $blog_layout == 'layout10' ) :
						/* Blog Layout 9 and 10 */
						get_template_part('template-parts/loop-mixed');

					else : ?>

						<?php /* Start the  Default Loop */ ?>
							<div class="posts-loop <?php if( $blog_layout == 'layout6' ) { ?>js-masonry<?php } ?>" <?php if( $blog_layout == 'layout6' ) { ?>data-masonry-options='{ "itemSelector": ".masonry-item", "percentPosition": true}'<?php } ?>>

							<?php while ( have_posts() ) : the_post(); ?>
								<div class="<?php echo $post_column; ?>">
								<?php
									/* Include the Post-Format-specific template for the content.
									 * If you want to override this in a child theme, then include a file
									 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
									 */
									get_template_part( 'template-parts/' . $post_template );
								?>
								</div>
							<?php endwhile; ?>
						</div><!-- .posts-loop -->

					<?php
					endif; ?>

					<?php the_posts_pagination( array(
						'mid_size' => 2,
						'prev_text' => esc_html( '&larr;' ),
						'next_text' => esc_html( '&rarr;' ),
					) ); ?>

			<?php else : ?>

				<?php get_template_part( 'template-parts/content', 'none' ); ?>

			<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php if ( $blog_layout != 'layout5' && $blog_layout != 'layout6' && $blog_layout != 'layout12' ) {
		get_sidebar();
	} // Sidebar ?>

	<?php get_footer(); ?>

<?php
	endif; // if Magazine Template
?>
