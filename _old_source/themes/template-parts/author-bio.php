<?php
/**
 * The template for displaying Author bios
 *
 * @package xMag
 * @since xMag 1.0
 */
?>

<div class="author-info clear">
	<div class="author-avatar">
		<?php echo get_avatar( get_the_author_meta( 'user_email' ), 80 ); ?>
	</div><!-- .author-avatar -->

	<div class="author-description">
		<h3 class="author-title"><?php echo get_the_author(); ?></h3>
		<div class="author-bio">
			<?php the_author_meta( 'description' ); ?>
			<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
				<?php printf( __( 'View all posts by %s', 'xmag-plus' ), get_the_author() ); ?>
			</a>
		</div><!-- .author-bio -->
	</div><!-- .author-description -->
</div><!-- .author-info -->