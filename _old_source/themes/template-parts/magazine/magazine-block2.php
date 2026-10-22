<?php
/**
 * The template for displaying Magazine Content Section 2
 *
 * @package xMag
 * @since xMag 1.0
 */

// Block 2 Settings
$cat_block2 = get_option('block2_category', '');
$cat_block2_link = get_category_link( $cat_block2 );
$cat_block2_name = get_cat_name($cat_block2);
$posts_block2 = get_theme_mod('block2_posts_number', 4);

$query_args = array (
    'post_type'				=> 'post',
    'posts_per_page'		=> $posts_block2,
    'orderby'				=> 'date',
    'order'					=> 'DESC',
    'ignore_sticky_posts' 	=> true,
);

if( is_numeric( $cat_block2 ) && $cat_block2 != 0 ) {
	$query_args['cat'] = $cat_block2;
}

// Avoid Duplicate Posts
global $slider_postID;
if ( get_theme_mod( 'xmag_duplicate_posts' ) && $slider_postID != '') {
	$query_args['post__not_in'] = $slider_postID;
}

$block2_query = new WP_Query ($query_args);
$i = 1;
?>

<section class="magazine-posts block02">
	
	<?php if ( $cat_block2 != '' ) : ?> 
		<h3 class="category-title clear">
			<?php if ( $cat_block2 == 0 ) { ?>
				<span><?php _e( 'Most Recent Posts', 'xmag-plus' ); ?></span>
			<?php } else { ?>
				<span>
					<a href="<?php echo esc_url( $cat_block2_link ); ?>">
						<?php echo esc_html( $cat_block2_name ); ?>
					</a>
				</span>
				<?php if ( get_theme_mod( 'magazine_view_all', 1 ) ) { ?>
					<em class="view-all">
						<a href="<?php echo esc_url( $cat_block2_link ); ?>"><?php _e( 'View all', 'xmag-plus' ); ?></a>
					</em>
				<?php } ?>
			<?php } ?>
		</h3>
	<?php endif; ?>
	
	<div class="magazine-loop clear">
	<?php
    if ( $block2_query->have_posts() ) :
    
		while ( $block2_query->have_posts() ) : $block2_query->the_post(); ?>
						
			<?php if ($i == 1 || $i == 2) : ?>
				<div class="col-6 col-sm-6 half">
					<article class="entry-magazine">
						<?php if ( has_post_thumbnail() ) : ?>
						<figure>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">				
								<?php the_post_thumbnail('xmag-main');  ?>
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
						    	<?php xmag_excerpt(15); ?>
					    		<?php if ( get_theme_mod( 'magazine_read_more', 1 ) ) { ?>
					    			<a href="<?php the_permalink(); ?>" title=""><?php _e( 'Read more', 'xmag-plus' ); ?></a>
					    		<?php } ?>
					    	</p>
						</div><!-- .entry-summary -->
					</article>
				</div>
				
				<?php if ( $i == 2) { ?>
				<div class="col-12 list-small">
					<ul>
				<?php } ?>
				
			<?php else : ?>
			
						<li>
							<article class="entry-magazine">
								<?php if ( has_post_thumbnail() ) : ?>
								<figure>
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">				
										<?php the_post_thumbnail('thumbnail');  ?>
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
						</li>
						
			<?php endif; ?>
	
		<?php $i++; endwhile; ?>
		
				<?php if ( $i > 2 ) { ?>
					</ul>
				</div><!-- .col-12 -->
				<?php } ?>

	<?php wp_reset_postdata(); endif; ?>
	</div><!-- .magazine-loop -->
</section>
