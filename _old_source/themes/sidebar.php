<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package xMag
 * @since xMag 1.0
 */

?>

<div id="secondary" class="sidebar widget-area <?php xmag_widget_style(); ?>" role="complementary">
	
	<?php if( xmag_is_woocommerce_active() && is_woocommerce() ) : ?>
		
		<?php if ( is_active_sidebar( 'sidebar-shop' ) ) { dynamic_sidebar( 'sidebar-shop' ); } ?>
	
	<?php else : ?>
	
		<?php if ( has_nav_menu( 'social_navigation' ) ) {
			wp_nav_menu(
				array(
					'theme_location'  => 'social_navigation',
					'container'       => false,
					'menu_id'         => 'social-links',
					'menu_class'      => 'social-links',
					'depth'           => 1,
					'link_before'     => '<span class="screen-reader-text">',
					'link_after'      => '</span>',
					'fallback_cb'     => '',
				)
			);
		} // Social Links ?>
		
		<?php if ( get_theme_mod( 'xmag_ads_sidebar' ) ) { ?>
			<aside class="widget widget_ads">
				<?php echo get_theme_mod( 'xmag_ads_sidebar' ); ?>
			</aside>
		<?php } // Ads ?>
		
		<?php if ( is_active_sidebar( 'sidebar-1' ) ) { dynamic_sidebar( 'sidebar-1' ); } ?>
	
	<?php endif; ?>
	
</div><!-- #secondary .widget-area -->
