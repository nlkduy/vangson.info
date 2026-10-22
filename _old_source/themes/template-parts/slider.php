<?php
/**
 * The template for displaying Slick Slider.
 *
 * @package xMag
 * @since xMag 1.0
 */

// Slick Settings

$slider_catID = get_option( 'slider_category', '');
$slider_type = get_theme_mod( 'slider_style', 'slider-carousel' );

if ( $slider_type == "slider-carousel-fullwidth" ) {
	$slider_class = 'slider-carousel fullwidth';
} elseif ( $slider_type == "slider-carousel" ) {
	$slider_class = 'slider-carousel';
} else {
	$slider_class = 'slider-classic';
}

if ( $slider_type == 'slider-carousel' || $slider_type == 'slider-carousel-fullwidth' ) { 
	$slider_image = 'xmag-main';
} else {
	$slider_image = 'xmag-thumb';
}

$slider_posts = get_theme_mod('slider_posts', 10);

global $slider_postID;
$slider_postID = array();

$query_args = array (
	'post_type'			=> 'post',
	'posts_per_page'	=> $slider_posts,
	'orderby'			=> 'date',
	'order'				=> 'DESC',
	'ignore_sticky_posts' => 1,
);

if( is_numeric( $slider_catID ) && $slider_catID != 0 ) {
	$query_args['cat'] = $slider_catID;
}

$slider_query = new WP_Query ($query_args);
?>

	<div class="slider-area">
		<?php if ( $slider_type != 'slider-carousel-fullwidth' ) { echo '<div class="container">'; } ?>
		
			<div class="slider <?php echo esc_attr( $slider_class ); ?>" id="<?php echo esc_attr( $slider_type ); ?>">
			<?php
			    if ( $slider_query->have_posts() ) :
		            while ( $slider_query->have_posts() ) : $slider_query->the_post(); 			
		                    
						$slider_postID[] = $post->ID;
	                    
	                    if ( has_post_thumbnail() ) { ?>
						<div class="slider-item">
						    <a href="<?php the_permalink(); ?>">
							    <?php the_post_thumbnail( $slider_image ); ?>
						    </a>
						    <div class="slider-overlay">
							    <?php if( $slider_catID == 0 && get_theme_mod( 'show_blog_categories', 1 ) ) { ?>  
								    <div class="entry-meta">
										<span class="cat-links"><?php the_category( ' ' ); ?></span>
									</div>
								<?php } ?>
								<h3 class="slider-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<?php if( $slider_type == 'slider-carousel') { ?>  
								<div class="entry-meta"><?php xmag_time_link(); ?></div>
								<?php } ?>
								<?php if ( $slider_type == 'slider-classic' ) { ?>
									<p><a class="read-more" href="<?php the_permalink(); ?>"><?php _e('Read more', 'xmag-plus'); ?></a></p>
								<?php } ?>
							</div>
						</div>
						<?php }
														
		            endwhile;
				endif;
				wp_reset_postdata();
			?>
			</div>
			
		<?php if ( $slider_type != 'slider-carousel-fullwidth' ) { echo '</div>'; } ?>
	</div>
