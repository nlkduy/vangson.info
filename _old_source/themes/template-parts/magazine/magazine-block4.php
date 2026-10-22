<?php
/**
 * The template for displaying Magazine Content Section 4
 *
 * @package xMag
 * @since xMag 1.0
 */

// Block 4 Settings
$cat_block4 = get_option('block4_category', '');
$cat_block4_link = get_category_link( $cat_block4 );
$cat_block4_name = get_cat_name($cat_block4);
$posts_block4 = get_theme_mod('block4_posts_number', 4);

$query_args = array (
    'post_type'				=> 'post',
    'posts_per_page'		=> $posts_block4,
    'orderby'				=> 'date',
    'order'					=> 'DESC',
    'ignore_sticky_posts'	=> true,
);

if( is_numeric( $cat_block4 ) && $cat_block4 != 0 ) {
	$query_args['cat'] = $cat_block4;
}

// Avoid Duplicate Posts
global $slider_postID;
if ( get_theme_mod( 'xmag_duplicate_posts' ) && $slider_postID != '') {
	$query_args['post__not_in'] = $slider_postID;
}

$block4_query = new WP_Query ($query_args);
$i = 1;
?>

<section class="magazine-posts block04">
	
	<?php if ( $cat_block4 != '' ) : ?> 
		<h3 class="category-title clear">
			<?php if ( $cat_block4 == 0 ) { ?>
				<span><?php _e( 'Most Recent Posts', 'xmag-plus' ); ?></span>
			<?php } else { ?>
				<span>
					<a href="<?php echo esc_url( $cat_block4_link ); ?>">
						<?php echo esc_html( $cat_block4_name ); ?>
					</a>
				</span>
				<?php if ( get_theme_mod( 'magazine_view_all', 1 ) ) { ?>
					<em class="view-all">
						<a href="<?php echo esc_url( $cat_block4_link ); ?>"><?php _e( 'View all', 'xmag-plus' ); ?></a>
					</em>
				<?php } ?>
			<?php } ?>
		</h3>
	<?php endif; ?>
	
	<div class="magazine-loop clear">
	<?php
    if ( $block4_query->have_posts() ) :
    
		while ( $block4_query->have_posts() ) : $block4_query->the_post(); ?>
				
			<div class="col-3 col-sm-3 col-xs-6 list-small">
				<article class="entry-magazine">
					
					<?php if ( has_post_thumbnail() ) : ?>
					<figure>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">				
						<?php the_post_thumbnail('xmag-medium');  ?>
						</a>
					</figure>
					<?php endif; ?>
					
					<div class="entry-header">
						<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="entry-meta">
							<?php if ( get_theme_mod( 'show_blog_date', 1 ) ) {
								xmag_time_link();
							} ?>
						</div>	
					</div><!-- .entry-header -->
				</article>
			</div>
			
		<?php $i++; endwhile;
								
	wp_reset_postdata(); endif; ?>
	</div><!-- .magazine-loop -->
</section>
