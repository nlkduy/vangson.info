<?php
/**
 * The template for displaying Single Post content.
 *
 * @package xMag
 * @since xMag 1.0
 */
?>

<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3989658871496709"
     crossorigin="anonymous"></script>
<!-- vs2026 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-3989658871496709"
     data-ad-slot="8995907748"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
	<?php if ( has_post_thumbnail() && get_theme_mod('xmag_post_featured_image') ) : ?>
		
		<?php if ( get_theme_mod('xmag_post_featured_image_size', 'default') == 'default' ) : ?>
		
			<header class="entry-header">	
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				<div class="entry-meta">
					<?php
						xmag_posted_on();
						xmag_entry_comments();
						if( get_theme_mod( 'show_last_updated_date' ) ) {
							xmag_modified_date();
						}
					?>
				</div>
				<figure class="entry-thumbnail">
					<?php the_post_thumbnail('large'); ?>
				</figure>
			</header><!-- .entry-header -->
		
		<?php endif; ?>
		
	<?php else : ?>
	
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			<div class="entry-meta">
				<?php
					xmag_posted_on();
					// xmag_entry_comments();
					if( get_theme_mod( 'show_last_updated_date' ) ) {
						xmag_modified_date();
					}
				?>
			</div>
		</header><!-- .entry-header -->
		
	<?php endif; ?>
	
	<?php if ( get_theme_mod( 'xmag_ads_above_content' ) ) : ?>
		<div class="above-content-ads">
			<?php echo get_theme_mod( 'xmag_ads_above_content' ); ?>
		</div>
	<?php endif; // end Above Content Ads ?>
	
	<div class="entry-content">
		<?php 
			the_content();
			wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'xmag-plus' ),
			'after'  => '</div>',
			'link_before' => '<span class="page-number">',
			'link_after'  => '</span>',
			) );
		?>
	</div><!-- .entry-content -->
	
	<?php if ( get_theme_mod( 'xmag_ads_below_content' ) ) : ?>
		<div class="below-content-ads">
			<?php echo get_theme_mod( 'xmag_ads_below_content' ); ?>
		</div>
	<?php endif; // end Below Content Ads ?>
	
	<footer class="entry-footer">
		<?php xmag_entry_footer(); ?>
	</footer><!-- .entry-footer -->
	
</article><!-- #post-## -->

<?php
	// Related Posts
	if ( get_option( 'xmag_enable_related_posts' ) && ! is_attachment() ) : 
		get_template_part( 'template-parts/related-posts' );
	endif;
?>

<div style="background-color:#f0f8ff; padding: 10px;border: 2px dashed #ddd; text-align: justify;">
	<p>Cảm ơn Quý Cô Bác, Anh Chị đã ghé thăm Vàng Son!</p>
	
	<p>Tư liệu trên Vàng Son được sưu tầm và tổng hợp từ các Quý Báo, Quý Đài trong và ngoài nước. Chúng tôi đã và đang cố gắng thu thập lại thông tin xuất bản của mỗi bài viết với mong muốn tôn trọng tác quyền của các tác giả. Kính mong Quý Cô Bác, Anh Chị thứ lỗi nếu như thông tin được cập nhật chưa đầy đủ hay nội dung bài viết chưa nhận được sự cho phép của Quý Cô Bác, Anh Chị.</p>

	<p>Mọi ý kiến đóng góp thân mời Quý Cô Bác, Anh Chị để lại bình luận ở mỗi bài đăng hoặc gửi liên hệ thông qua&nbsp;<a href="https://vangson.info/lien-he">đường dẫn này</a></p>

	<p>Để tra cứu thông tin nhạc phẩm, Quý Cô Bác, Anh Chị có thể sử dụng hộp thoại tìm kiếm hoặc tham khảo trong danh mục&nbsp;<a href="https://vangson.info/sheet">Thư viện giai thoại</a></p>

	<p>Trường hợp không tìm thấy thông tin nhạc phẩm (do đã được biên tập thành một bài tổng hợp), Quý Cô Bác, Anh Chị vui lòng tìm kiếm với "Tên Nhạc Sĩ" hoặc tham khảo trong danh mục <a href="/tag/nhac-si">Tiểu Sử&nbsp;(Nhạc sĩ &amp; Những sáng tác để đời)</a></p>

	Vàng Son xin chân thành cảm ơn!
</div><br>

<script type='text/javascript' src='https://storage.ko-fi.com/cdn/widget/Widget_2.js'></script><script type='text/javascript'>kofiwidget2.init('Support me on Ko-fi', '#72a4f2', 'T6T8MDGDS');kofiwidget2.draw();</script> 