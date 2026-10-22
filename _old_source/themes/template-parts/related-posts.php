<?php
/**
 * The template for displaying Related Posts.
 *
 * @package xMag
 * @since xMag 1.0
 */

$post_id = get_the_ID();
$have_posts = false;
$t          = array();
$tags       = get_the_tags();
if ($tags) {
	foreach($tags as $tag) {
		$t[] = $tag->term_id;
	}
}
if (!empty($t)) {
	$related = new WP_Query(array(
		'posts_per_page' => 4,
		'post__not_in'   => array($post_id),
		'tag__in'        => $t,
	));
	if ($related->have_posts()) {
		$have_posts = true;
	}
}
if (!$have_posts) {
	$c[] = "";
	foreach(get_the_category() as $cat) {
		$c[] = $cat->cat_ID;
	}
	$related = new WP_Query(array(
		'posts_per_page' => 4,
		'post__not_in'   => array($post_id),
		'category__in'   => $c,
	));
	if ($related->have_posts()) {
		$have_posts = true;
	}
}
?>
	
	<div class="related-posts clear">
		<h3><?php _e('You may also like:', 'xmag-plus'); ?></h3>
		<?php if ($have_posts) : ?>
			<ul class="row">
				<?php while ($related->have_posts()) : $related->the_post(); ?>
				<li class="col-3 col-xs-6">
					<div class="block-thumb">
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail('xmag-medium'); ?>
							</a>
						<?php endif; ?>
					</div>
					<div class="block-content">
						<h4 class="block-heading">
							<a href="<?php the_permalink(); ?>">
								<span class="icon-music-tone-alt"></span>&nbsp;
								<?php the_title(); ?>
							</a>
						</h4>
					</div>
				</li>
				<?php endwhile; ?>
			</ul>
		<?php else: ?>
			<span class="norelated"><?php _e('No related posts found', 'xmag-plus'); ?>.</span>
		<?php endif; ?>
		
		<?php wp_reset_postdata(); ?>
		
	</div> <!-- .related-posts -->