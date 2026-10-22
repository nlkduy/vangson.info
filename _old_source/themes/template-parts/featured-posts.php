<?php
/**
 * The template used for displaying Featured Posts
 *
 * @package xMag
 * @since xMag 1.0
 */
?>

<?php
$fp_style = get_theme_mod('xmag_featured_posts_style', 'mosaic');

$featured_tags = explode(',', get_theme_mod('xmag_featured_tags', 'featured'));
$tags          = array();
$have_posts    = false;

foreach ((array)$featured_tags as $tag) {
	$tags[] = trim($tag);
}

if (!empty($tags)) {
	$featured = new WP_Query(array(
		'posts_per_page'      => 5,
		'tag_slug__in'        => $tags,
		'ignore_sticky_posts' => 1,
	));
	if ($featured->have_posts()) {
		$have_posts = true;
	}
}

if (!$have_posts) {
	$featured = new WP_Query(array(
		'posts_per_page'      => 5,
		'post__in'            => get_option('sticky_posts'),
		'ignore_sticky_posts' => 1,
	));
	if ($featured->have_posts()) {
		$have_posts = true;
	}
}

$image_w1 = 700;
$image_h1 = 504;
$image_w2 = 350;
$image_h2 = 250;

$i = 1;
?>

<?php if ($have_posts) : ?>
		
	<section class="featured-posts <?php echo esc_attr( $fp_style ); ?>">
		<div class="container">
			
			<?php
			if( get_theme_mod('xmag_featured_title') ) {
				echo '<div class="featured-posts-title">';
				echo '<h2>' . esc_html( get_theme_mod('xmag_featured_title') ) . '</h2>';
				if( get_theme_mod('xmag_featured_desc') ) {
					echo '<p>' . esc_html( get_theme_mod('xmag_featured_desc') ) . '</p>';
				}
				echo '</div>'; 
			} ?>
		
			<div class="row">
				
				<?php while ($featured->have_posts()) : $featured->the_post(); ?>
					
					<?php if ($fp_style == 'grid') : ?>
						
						<?php if ($i == 1) { ?>
						
							<div class="col-6 column-middle">
								<article id="post-<?php the_ID(); ?>">
									<figure class="entry-thumbnail">
										<a href="<?php the_permalink(); ?>">
											<?php echo xmag_image($image_w1, $image_h1); ?>
										</a>
									</figure>
									<header class="entry-header">
										<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
										<?php if ( 'post' === get_post_type() ) : ?>
											<div class="entry-meta">
												<?php if ( get_theme_mod( 'show_blog_date', 1 ) ) {
													xmag_time_link();
												} ?>
											</div>
										<?php endif; ?>
										<div class="entry-summary">
											<p><?php echo get_the_excerpt(); ?></p>
										</div>
									</header>
								</article>
							</div>
						
						<?php } else { ?>
							
							<?php
								if ($i == 2) {
									echo '<div class="col-3 column-secondary column-left">'; 
								} elseif ($i == 4) {
									echo '<div class="col-3 column-secondary column-right">';	
								}
							?>
							
							<article id="post-<?php the_ID(); ?>">
								<figure class="entry-thumbnail">
									<a href="<?php the_permalink(); ?>">
										<?php echo xmag_image($image_w2, $image_h2); ?>
									</a>
								</figure>
								<header class="entry-header">
									<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
									<?php if ( 'post' === get_post_type() ) : ?>
										<div class="entry-meta">
											<?php if ( get_theme_mod( 'show_blog_date', 1 ) ) {
												xmag_time_link();
											} ?>
										</div>
									<?php endif; ?>
								</header>
							</article>
							
							<?php
								if ($i == 3) {
									echo '</div>'; 
								} elseif ($i == 5) {
									echo '</div>';	
								}
							?>	
								
						<?php } ?>
													
					<?php else : ?>
						
						<?php if ($i == 1) { ?>
						<div class="col-6">
							<article id="post-<?php the_ID(); ?>">
								<a href="<?php the_permalink(); ?>">
									<?php echo xmag_image($image_w1, $image_h1); ?>
								</a>
								<header>
									<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								</header>
							</article>
						</div>
						<?php } else { ?>
						<div class="col-3">
							<article id="post-<?php the_ID(); ?>">
								<a href="<?php the_permalink(); ?>">
									<?php echo xmag_image($image_w2, $image_h2); ?>
								</a>
								<header>
									<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								</header>
							</article>
						</div>
						<?php } ?>
						
					<?php endif; ?>
					
				<?php $i++; endwhile; ?>
				
			</div>
		</div>
	</section>

<?php wp_reset_postdata(); endif; ?>
