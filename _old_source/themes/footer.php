<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package xMag
 * @since xMag 1.0
 */
?>

		</div><!-- .container -->
	</div><!-- #content -->

	<footer id="colophon" class="site-footer">

		<?php if (!is_front_page()) { ?>
		<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>
			<div class="footer widget-area" role="complementary">
				<div class="container">
					<div class="row">
						<div class="col-4" id="footer-area-left">
							<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
								<?php dynamic_sidebar( 'footer-1' ); ?>
							<?php endif; // end footer widget area left ?>
						</div>
						<div class="col-4" id="footer-area-center">
							<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
								<?php dynamic_sidebar( 'footer-2' ); ?>
							<?php endif; // end footer widget area center ?>
						</div>
						<div class="col-4" id="footer-area-right">
							<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
								<?php dynamic_sidebar( 'footer-3' ); ?>
							<?php endif; // end footer widget area right ?>
						</div>
					</div><!-- .row -->
				</div>
			</div>
		<?php endif; // end footer widget area ?>
		<?php } ?>

		<div class="footer-copy">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="site-info" style="text-align: center">
							<?php if ( get_theme_mod( 'xmag_footer_copy' ) ) : ?>
								<?php echo wp_kses_post( get_theme_mod( 'xmag_footer_copy' ) ); ?>
							<?php else: ?>
								<?php xmag_credits(); ?>
							<?php endif; ?>
						</div>
					</div>
				</div><!-- .row -->
			</div>
		</div>
	</footer><!-- #colophon -->

	<?php if ( get_theme_mod('xmag_scroll_up') ) { ?>
		<a href="#masthead" id="scroll-up"><span class="icon-arrow-up"></span></a>
	<?php } ?>

</div><!-- #page -->

<?php wp_footer(); ?>

<?php if ( get_theme_mod( 'xmag_google_analytics' ) ) : ?>
	<!-- Google Analytics -->
	<?php echo get_theme_mod( 'xmag_google_analytics' ); ?>
<?php endif; ?>

</body>
</html>
