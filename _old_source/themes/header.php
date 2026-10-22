<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package xMag
 * @since xMag 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div id="page" class="hfeed site">

	<aside id="mobile-header" class="mobile-header">
		<?php if (!is_front_page()) { ?>
			<div class="menu-toggle" id="menu-toggle"><span class="button-toggle"></span></div>
        <?php } ?>
		<a class="mobile-title" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
		<?php if (!is_front_page()) { ?>
          <?php if ( get_theme_mod( 'xmag_show_search', 1 ) ) { ?>
              <div class="search-toggle" id="search-toggle"><span class="sli icon-magnifier"></span></div>
              <div class="search-container"><?php get_search_form(); ?></div>
          <?php } ?>
        <?php } ?>
	</aside>
	<div id="mobile-sidebar" class="mobile-sidebar">
		<nav id="mobile-navigation" class="mobile-navigation" aria-label="<?php esc_attr_e( 'Main Menu', 'xmag-plus' ); ?>"></nav>
	</div>

	<header id="masthead" class="site-header">

		<div class="header-top">
			<div class="container">
				<?php
				if( get_theme_mod('xmag_logo_position', 'logo-left') == 'logo-center' ) :
					get_template_part('template-parts/header/logo', 'centered');
				elseif( get_theme_mod('xmag_logo_position', 'logo-left') == 'logo-center-full' ) :
					get_template_part('template-parts/header/logo', 'centered-fullwidth');
				else :
					get_template_part('template-parts/header/logo', 'left');
				endif;
				?>
			</div>
		</div><!-- .header-top -->

		<?php
		// Header image
		if ( get_header_image() ) { xmag_header_image(); }
		?>

		<?php if (!is_front_page()) { ?>
		<div id="main-navbar" class="main-navbar">
			<div class="container">

				<?php if ( get_theme_mod( 'xmag_home_icon', 1 ) ) : ?>
				<div class="home-link">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><span class="icon-home"></span></a>
				</div>
				<?php endif; // if xmag_home_icon ?>

				<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Main Menu', 'xmag-plus' ); ?>">
					<?php
						wp_nav_menu( array(
							'theme_location' => 'main_navigation',
							'menu_id' => 'main-menu',
							'menu_class' => 'main-menu',
							'container' => false,
							'fallback_cb' => 'xmag_fallback_menu'
							) );
					// Main Menu ?>
				</nav>

				<?php if ( xmag_is_woocommerce_active() && get_theme_mod( 'show_cart_main_navbar' ) ) {
					$cart_url = wc_get_cart_url();
					echo '<div class="woo-cart-link"><a href="' . $cart_url . '" title="' . __( 'Checkout', 'xmag-plus' ) . '">' . '<span class="icon-basket"></span></a></div>';
				} // WooCommerce Cart Link ?>

			</div>
		</div>
		<?php } ?>
	</header><!-- .site-header -->

	<?php if ( is_home() || is_front_page() ) : ?>

		<?php
		// Slider
		if ( get_theme_mod( 'show_slider' ) ) {
		get_template_part( 'template-parts/slider' );
		}
		// Featured Posts
		if ( get_theme_mod( 'xmag_featured_posts' ) ) {
		get_template_part( 'template-parts/featured-posts' );
		} ?>
		<?php
		// Call to action
		if ( get_theme_mod( 'show_call_action' ) ) { ?>
		<section class="call-action">
			<div class="container">
				<div class="call-action-content">
					<h2><?php echo esc_html( get_theme_mod('call_action_title') ); ?></h2>
					<div class="call-action-desc"><?php echo wp_kses_post( get_theme_mod('call_action_desc') ); ?></div>
					<?php if ( get_theme_mod( 'action_button_url', '' ) ) { ?>
						<a class="call-action-button" href="<?php echo esc_url( get_theme_mod( 'action_button_url' ) ); ?>"><?php echo esc_html( get_theme_mod('action_button_text') ); ?></a>
					<?php } ?>
				</div>
			</div>
		</section>
		<?php } ?>

	<?php endif; ?>

	<div id="content" class="site-content">
		<div class="container">