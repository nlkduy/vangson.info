<?php
/**
 * The template for displaying Magazine Content Section 3
 *
 * @package xMag
 * @since xMag 1.0
 */

// Block 3 Settings
$cat_block3 = get_option('block3_category', '');
$cat_block3_link = get_category_link( $cat_block3 );
$cat_block3_name = get_cat_name($cat_block3);
$posts_block3 = get_theme_mod('block3_posts_number', 4);

$query_args = array (
    'post_type'				=> 'post',
    'posts_per_page'		=> $posts_block3,
    'orderby'				=> 'date',
    'order'					=> 'DESC',
    'ignore_sticky_posts' 	=> true,
);

if( is_numeric( $cat_block3 ) && $cat_block3 != 0 ) {
	$query_args['cat'] = $cat_block3;
}

// Avoid Duplicate Posts
global $slider_postID;
if ( get_theme_mod( 'xmag_duplicate_posts' ) && $slider_postID != '') {
	$query_args['post__not_in'] = $slider_postID;
}

$block3_query = new WP_Query ($query_args);
$i = 1;
?>

<section class="magazine-posts block03">
	
	<?php if ( $cat_block3 != '' ) : ?> 
		<h3 class="category-title clear">
			<?php if ( $cat_block3 == 0 ) { ?>
				<span><?php _e( 'Most Recent Posts', 'xmag-plus' ); ?></span>
			<?php } else { ?>
				<span>
					<a href="<?php echo esc_url( $cat_block3_link ); ?>">
						<?php echo esc_html( $cat_block3_name ); ?>
					</a>
				</span>
				<?php if ( get_theme_mod( 'magazine_view_all', 1 ) ) { ?>
					<em class="view-all">
						<a href="<?php echo esc_url( $cat_block3_link ); ?>"><?php _e( 'View all', 'xmag-plus' ); ?></a>
					</em>
				<?php } ?>
			<?php } ?>
		</h3>
	<?php endif; ?>
	
	<div class="magazine-loop clear">
	<?php
    if ( $block3_query->have_posts() ) :
    
		while ( $block3_query->have_posts() ) : $block3_query->the_post(); ?>
						
			<div class="col-12 list">
				<article class="entry-magazine">
					<?php if ( has_post_thumbnail() ) : ?>
					<figure>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">				
						<?php if ($i == 1) {
							the_post_thumbnail('xmag-main'); 
						} else {
							the_post_thumbnail('xmag-medium'); 
						}	
						?>
						</a>
					</figure>
					<?php endif; ?>
					
					<div class="entry-header">
						<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="entry-meta">
							<?php if ( get_theme_mod( 'show_blog_date', 1 ) ) {
								xmag_time_link();
							} ?>
							<?php if ( get_theme_mod( 'show_blog_author', 1 ) ) { ?>
								<span class="icon-user"></span>
								<?php xmag_author_link(); ?>
							<?php } ?>
						</div>	
					</div><!-- .entry-header -->
					
			    	<div class="entry-summary">
				    	<p>
					    	<?php xmag_excerpt(20); ?>
				    		<?php if ( get_theme_mod( 'magazine_read_more', 1 ) ) { ?>
					    		<a href="<?php the_permalink(); ?>" title=""><?php _e( 'Read more', 'xmag-plus' ); ?></a>
					    	<?php } ?>
				    	</p>
					</div><!-- .entry-summary -->
				</article>
			</div>
			
		<?php $i++; endwhile;
								
	wp_reset_postdata(); endif; ?>
	</div><!-- .magazine-loop -->
</section>
