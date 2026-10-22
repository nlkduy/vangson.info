<?php 
/**
 * The Blog template used for displaying:
 * 
 * - Mixed: 1 Large Post + 2 Grid
 * - Mixed: 1 Large Post + 2 List
 * 
 * @package xMag
 * @since xMag 1.0
 */
  
?>

<?php
$blog_layout = get_theme_mod( 'xmag_blog', 'layout2' );	
$i = 0;
$number = !isset($number) ? 3 : $number;
?>

	<div class="posts-loop">
	
		<?php while ( have_posts() ) : the_post(); ?>

			<?php 
			if ($i % $number === 0): // Large Post ?>
				
				<div class="col-12">
					<?php get_template_part('template-parts/content-large2'); ?>
				</div>
				
			<?php else : ?>
				
				<?php
				if ( $blog_layout == 'layout10' ) { ?>
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
