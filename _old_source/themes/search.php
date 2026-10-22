<?php
/**
 * The template for displaying search results pages.
 *
 * @package xMag
 * @since xMag 1.0
 */

get_header(); ?>

	<?php
	/* Archive Options */
	$archive_layout = get_theme_mod( 'xmag_archive', 'layout2' );
	$post_template = xmag_archive_post_template();
	$post_column = xmag_archive_post_column();
	?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<header class="page-header">
				<?php if ( have_posts() ) : ?>
					<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'xmag-plus' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				<?php else : ?>
					<h1 class="page-title"><?php _e( 'Nothing Found', 'xmag-plus' ); ?></h1>
				<?php endif; ?>
				<br>
				<p style="background-color:#f0f8ff; padding: 10px;border: 2px dashed #ddd;">
					Trường hợp không tìm thấy thông tin (giai thoại, sheet nhạc) mong muốn,
					Quý Cô Bác, Anh Chị vui lòng tham khảo thêm tại <a href="/sheet"><b>Thư viện giai thoại</b></a>
					hoặc <a href="/chua-tim-duoc-thong-tin"><b>Danh sách nhạc phẩm chưa tìm được thông tin</b></a>.
					Vàng Son xin chân thành cảm ơn!
				</p>
			</header><!-- .page-header -->

			<?php if ( have_posts() ) : ?>

				<?php
				if ( $archive_layout == 'layout7' || $archive_layout == 'layout8' ) :
					/* Archive Layout 7 and 8 */
					get_template_part('template-parts/archive-first-large');

				else : ?>

				<?php /* Start the Loop */ ?>
				<div class="posts-loop" <?php if( $archive_layout == 'layout6' ) { ?>data-masonry='{ "itemSelector": ".masonry-item", "percentPosition": true}'<?php } ?>>
				<?php while ( have_posts() ) : the_post(); ?>

					<div class="<?php echo $post_column; ?>">
					<?php
					/**
					 * Run the loop for the search to output the results.
					 * If you want to overload this in a child theme then include a file
					 * called content-search.php and that will be used instead.
					 */
					get_template_part( 'template-parts/' . $post_template );
					?>
					</div>

				<?php endwhile; ?>
				</div><!-- / .posts-loop -->

				<?php
				endif; ?>

				<?php the_posts_pagination( array(
					'mid_size' => 2,
					'prev_text' => esc_html( '&larr;' ),
					'next_text' => esc_html( '&rarr;' ),
				) ); ?>

			<?php else : ?>

				<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'xmag-plus' ); ?></p>
				<?php get_search_form(); ?>

			<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php if ( $archive_layout != 'layout5' && $archive_layout != 'layout6' && $archive_layout != 'layout12' ) {
	get_sidebar();
} // Sidebar ?>

<?php get_footer(); ?>
