<?php
/**
 * The default template for displaying content
 *
 * @package xMag
 * @since xMag 1.0
 */
?>
	
	<?php
	$thumb_size = xmag_thumb_size();
	?>
	
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'list-post' ); ?>>	
		<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
			<figure class="entry-thumbnail">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">				
					<?php the_post_thumbnail($thumb_size); ?>
					<span class="format-icon"></span>
				</a>
			</figure>
		<?php endif; // if has_post_thumbnail ?>
	
		<header class="entry-header">
			<?php if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta">
					<?php if ( get_theme_mod( 'show_blog_date', 1 ) ) {
						xmag_time_link();
					} ?>
					<?php if ( get_theme_mod( 'show_blog_author' ) ) {
						xmag_author_link();
					} ?>
					<?php if ( get_theme_mod( 'show_blog_categories', 1 ) ) { ?>
						<span class="category"><?php the_category(' '); ?></span>
					<?php } ?>
				</div>
			<?php endif; ?>
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		</header><!-- .entry-header -->
		
		<div class="entry-summary">
			<p>
				<?php echo get_the_excerpt(); ?>
				<?php if ( get_theme_mod( 'xmag_read_more' ) ) { ?>
					<a class="more-link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<?php _e( 'Read more', 'xmag-plus' ); ?>
					</a>
				<?php } ?>
			</p>
		</div><!-- .entry-summary -->
	</article><!-- #post-## -->
