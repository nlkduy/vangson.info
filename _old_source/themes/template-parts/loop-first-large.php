<?php 
/**
 * The Blog template used for displaying:
 * 
 * - One large post then grid
 * - One large post large then list
 * 
 * @package xMag
 * @since xMag 1.0
 */
  
?>

<?php
$blog_layout = get_theme_mod( 'xmag_blog', 'layout2' );
$i = 1;
?>

	<div class="posts-loop">
	
		<?php while ( have_posts() ) : the_post(); ?>
	
			<?php 
			if ($i == 1): // First Post ?>
				
				<div class="col-12">
					<?php get_template_part('template-parts/content-large'); ?>
				</div>
				
			<?php else : ?>
				
				<?php
				if ( $blog_layout == 'layout8' ) { ?>
					<div class="col-6">
						<?php get_template_part('template-parts/content-grid'); ?>
					</div>
				<?php } else { ?>
					<div class="col-12">
						<?php get_template_part('template-parts/content'); ?>
					</div>
				<?php } ?>
			
			<?php
			endif;
		
		$i++; endwhile; ?>
	
	</div><!-- / .posts-loop -->
	