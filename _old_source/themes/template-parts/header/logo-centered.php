<?php
/**
 * The template used for displaying Site branding
 *
 * @package xMag
 * @since xMag 1.0
 */
?>

<div class="logo-center clear">
	<div class="row">
		<div class="col-4 collapse">
			<nav id="top-navigation" class="top-navigation">
				<?php if ( has_nav_menu( 'top_navigation' ) ) { ?>
					<?php wp_nav_menu( array(
						'theme_location' => 'top_navigation',
						'menu_class' => 'top-menu',
						'container' => false,
						'fallback_cb' => false
						) );
					?>
				<?php } ?>
			</nav><!-- .top-navigation -->
		</div>
		<div class="col-4 col-sm-12">
			<?php $description = get_bloginfo( 'description', 'display' ); ?>

			<?php if ( get_theme_mod('xmag_logo') ) : ?>
				<div class="site-logo">
					<?php xmag_site_logo(); ?>
					<?php if ( get_theme_mod('xmag_logo_tagline') ) { ?>
						<?php if ( $description || is_customize_preview() ) { ?>
						<p class="site-description text-center"><?php echo $description; ?></p>
						<?php } ?>
					<?php } ?>
				</div><!-- .site-logo -->
			<?php else : ?>
				<div class="site-branding collapse">
					<?php if ( is_front_page() && is_home() ) : ?>
							<h1 class="site-title text-center"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php else : ?>
							<p class="site-title text-center"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php endif; ?>
					<?php if ( $description || is_customize_preview() ) { ?>
						<p class="site-description text-center"><?php echo $description; ?></p>
					<?php } ?>
				</div><!-- .site-branding -->
			<?php endif; ?>
		</div>
		<div class="col-4 collapse">
			<?php if (!is_front_page()) { ?>
			<?php if ( get_theme_mod( 'xmag_show_search', 1 ) ) { ?>
				<div class="search-top">
					<?php get_search_form(); ?>
				</div>
			<?php } ?><!-- Search Form -->
			<?php } ?>
		</div>
	</div>

	<?php if ( get_theme_mod( 'xmag_ads_header' ) ) { ?>
		<div class="header-ads">
			<?php echo get_theme_mod( 'xmag_ads_header' ); ?>
		</div>
	<?php } // Ads ?>
</div>
