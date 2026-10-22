<?php
/**
 * xMag Plus: Custom styles handled by the Theme customizer
 *
 * @package xMag
 * @since xMag 1.0
 */


if ( ! function_exists( 'xmag_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 */
function xmag_header_style() {
	$header_text_color = get_header_textcolor();

	/*
	 * If no custom options for text are set, let's bail.
	 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
	 */
	if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
		return;
	}

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
		.site-header .site-title,
		.site-header .site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		.site-header .site-title a {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif;


/**
 * Get Contrast
 */
function xmag_get_brightness($hex) {
	// returns brightness value from 0 to 255
	// strip off any leading #
	$hex = str_replace('#', '', $hex);
	
	$c_r = hexdec(substr($hex, 0, 2));
	$c_g = hexdec(substr($hex, 2, 2));
	$c_b = hexdec(substr($hex, 4, 2));

	return (($c_r * 299) + ($c_g * 587) + ($c_b * 114)) / 1000;
}


/**
 * xMag Plus custom style
 */
function xmag_custom_style() {
	
	$site_title_font = esc_attr( get_theme_mod( 'xmag_site_title_font' ) );
	$title_font = esc_attr( get_theme_mod( 'xmag_headings_font', 'Roboto' ) );
	$text_font = esc_attr( get_theme_mod( 'xmag_text_font', 'Open Sans' ) );
	$font_size = esc_attr( get_theme_mod( 'xmag_font_size' ) );
	
	$accent_color = esc_attr( get_option( 'accent_color' ) ); 
	$site_tagline_color = esc_attr( get_option( 'site_tagline_color' ) );
	$text_color = esc_attr( get_option( 'text_color') );
	$single_title_color = esc_attr( get_option( 'single_title_color' ) );
	$single_text_color = esc_attr( get_option( 'single_text_color' ) );
	
	$header_background = esc_attr( get_option( 'header_background' ) );
	$footer_background = esc_attr( get_option( 'footer_background' ) );
	
	$main_menu_background = esc_attr( get_option( 'main_menu_background' ) );
	$main_menu_style = esc_attr( get_theme_mod( 'xmag_menu_style' ) );
	$mobile_menu_background = esc_attr( get_option( 'mobile_menu_background' ) );
	
	$woo_button_color = esc_attr( get_theme_mod( 'woo_button_color', '#222222' ) );
	
	
	$theme_css = "";

	// Fonts
	if ( get_theme_mod( 'google_fonts', 1 ) ) {
		if ( ! empty($text_font) ) {
			$theme_css .= "body, button, input, select, textarea {font-family: {$text_font}, sans-serif;}";
		}
		if ( ! empty($title_font) ) {
			$theme_css .= "h1, h2, h3, h4, h5, h6, .entry-title {font-family: {$title_font}, sans-serif;}";
		}
		if ( ! empty($site_title_font) ) {
			$theme_css .= ".site-title {font-family: {$site_title_font}, sans-serif;}";
		} else {
			$theme_css .= ".site-title {font-family: {$title_font}, sans-serif;}";
		}
	}
	
	// Font Size
	if ( ! empty($font_size) ) {
		$theme_css .= "html, body {font-size: {$font_size};}";
	}

	// Show Header Image on Mobile
	if ( get_theme_mod( 'show_header_image' ) ) {
		$theme_css .= ".header-image {display: block;}";
	}
	
	// Accent Color
	if ( ! empty($accent_color) ) {
		$theme_css .= "
		a, .site-title a:hover, .entry-title a:hover, .entry-content .has-accent-color,
		.post-navigation .nav-previous a:hover, .post-navigation .nav-previous a:hover span,
		.post-navigation .nav-next a:hover, .post-navigation .nav-next a:hover span,
		.widget a:hover, .block-heading a:hover, .widget_calendar a, .author-social a:hover,
		.top-menu a:hover, .top-menu .current_page_item a, .top-menu .current-menu-item a,
		.nav-previous a:hover span, .nav-next a:hover span, .more-link,
		.magazine .category-title a:hover, .layout9 .large-post .category a:hover, .layout10 .large-post .category a:hover { 
	    color: {$accent_color};
	    }
	    button, input[type='button'], input[type='reset'], input[type='submit'], .entry-content .has-accent-background-color,
	    .pagination .nav-links .current, .pagination .nav-links .current:hover, .pagination .nav-links a:hover,
	    .entry-meta .category a, .grid-post .category, .featured-image .category a,
	    #scroll-up, .slider-overlay .cat-links a, .slick-dots li.slick-active button:before, .call-action-button,
	    .woocommerce .widget_price_filter .ui-slider .ui-slider-range, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle {
		background-color: {$accent_color};
	    }
	    blockquote {
		border-left-color: {$accent_color};
	    }
	    .sidebar .widget-title span:before, .magazine .magazine-posts .category-title span:before {
		border-bottom-color: {$accent_color};    
		}";
		if ( xmag_get_brightness($accent_color) > 150) {
		$theme_css .= "
			.entry-meta .category a, .grid-post .category, .featured-image .category a,
			button, input[type='button'], input[type='reset'], input[type='submit'],
			#scroll-up, .search-submit, .call-action-button {
			color: rgba(0,0,0,.7);
			}
			.entry-meta .category a:before {
			background-color: rgba(0,0,0,.7);
			}";
		}
	}
	
	// Site Tagline Color
	if ( ! empty($site_tagline_color) ) {
		$theme_css .= ".site-header .site-description {color: {$site_tagline_color};}";
	}
	
	// Text Color
	if ( ! empty($text_color) ) {
		$theme_css .= "body, .entry-summary {color: {$text_color};}";
	}
	
	// Page/Post Title Color
	if ( ! empty($single_title_color) ) {
		$theme_css .= ".entry-title {color: {$single_title_color};}";
	}
	
	// Page/Post Text Color
	if ( ! empty($single_text_color) ) {
		$theme_css .= ".entry-content {color: {$single_text_color};}";
	}
	
	// Footer Background
	if ( ! empty($footer_background) ) {
		$theme_css .= ".site-footer, .site-boxed .site-footer {background-color: {$footer_background};}";
		if ( xmag_get_brightness($footer_background) > 150) {
			$theme_css .= "
			.site-footer .footer-copy, .site-footer .widget, .site-footer .comment-author-link {
			color: rgba(0,0,0,.4);
			}
			.site-footer .footer-copy a, .site-footer .footer-copy a:hover,
			.site-footer .widget a, .site-footer .widget a:hover,
			.site-footer .comment-author-link a, .site-footer .comment-author-link a:hover {
			color: rgba(0,0,0,.5);
			}
			.site-footer .widget-title, .site-footer .widget caption {
			color: rgba(0,0,0,.6);
			}";
		} else {
		$theme_css .= "
			.site-footer .footer-copy, .site-footer .widget, .site-footer .comment-author-link {
			color: rgba(255,255,255,0.5);
			}
			.site-footer .footer-copy a, .site-footer .footer-copy a:hover,
			.site-footer .widget a, .site-footer .widget a:hover,
			.site-footer .comment-author-link a, .site-footer .comment-author-link a:hover {
			color: rgba(255,255,255,0.7);
			}
			.site-footer .widget-title, .site-footer .widget caption {
			color: #fff;
			}
			.site-footer .widget .tagcloud a {
			background-color: transparent;
			border-color: rgba(255,255,255,.1);
			}
			.footer-copy {
			border-top-color: rgba(255,255,255,.1);
			}";
		}
	}
	
	// Header Background
	if ( ! empty($header_background) && $header_background != '#ffffff' ) {
		$theme_css .= ".site-header {background-color: {$header_background};}";
		if ( xmag_get_brightness($header_background) > 150) {
			$theme_css .= "
			.site-title a, .site-description, .top-navigation > ul > li > a {
			color: rgba(0,0,0,.8);
			}
			.site-title a:hover, .top-navigation > ul > li > a:hover {
			color: rgba(0,0,0,.6);
			}";
		} else {
			$theme_css .= "
			.site-title a, .site-description, .top-navigation > ul > li > a {
			color: #fff;
			}
			.site-title a:hover, .top-navigation > ul > li > a:hover {
			color: rgba(255,255,255,0.8);
			}
			.site-header .search-field {
			border: 0;
			}
			.site-header .search-field:focus {
			border: 0;
			background-color: rgba(255,255,255,0.9);
			}";
		}
	}
		
	// Main Menu Custom Background
	if ( ! empty($main_menu_background) && $main_menu_style == 'custom' ) {
		$theme_css .= "
		.main-navbar {
		background-color: {$main_menu_background};
		position: relative;
		}
		.mobile-header {
		background-color: {$main_menu_background};
		}
		.main-menu ul {
		background-color: {$main_menu_background};
		}
		.main-navbar:before {
	    background-color: rgba(0, 0, 0, 0.15);
	    content: '';
	    display: block;
	    height: 4px;
	    position: absolute;
	    top: 0;
	    width: 100%;
		}
		.main-menu > li > a, .home-link a {
		line-height: 24px;
		padding: 12px 12px 10px;
		}";
		if ( xmag_get_brightness($main_menu_background) > 150) {
			$theme_css .= "
			.main-menu > li > a, .main-menu ul a, .home-link a,
			.mobile-header .mobile-title, .mobile-header .menu-toggle, .main-navbar .woo-cart-link a {
			color: rgba(0,0,0,.9);
			}
			.home-link a:hover, .main-menu > li > a:hover,
			.main-menu > li.current-menu-item > a, .main-menu > li.current_page_item > a, .main-navbar .woo-cart-link a:hover {
			color: rgba(0,0,0,0.6);
			}
			.main-menu ul a:hover,
			.main-menu ul .current-menu-item a,
			.main-menu ul .current_page_item a {
			color: rgba(0,0,0,.9);
			background-color: rgba(0,0,0,.05);
			}
			.mobile-header a, .mobile-header .search-toggle {
			color: rgba(0,0,0,.9);
			}
			.button-toggle, .button-toggle:before, .button-toggle:after {
			background-color: rgba(0,0,0,.9);
			}";
		}
	}
	
	// Main Menu Light
	if ( $main_menu_style == 'light' ) {
		$theme_css .= "
		.main-navbar {
		background-color: #fff;
		border-top: 1px solid #eee;
		border-bottom: 1px solid #eee;
		-webkit-box-shadow: 0 3px 2px 0 rgba(0, 0, 0, 0.03);
		box-shadow: 0 3px 2px 0 rgba(0, 0, 0, 0.03);
		}
		.main-menu > li > a, .home-link a {
		color: #333;
		border-left: 1px solid #f2f2f2;
		}
		.main-menu > li:last-child > a {
		border-right: 1px solid #f2f2f2;
		}
		.home-link a:hover, .main-menu > li > a:hover,
		.main-menu > li.current-menu-item > a,
		.main-menu > li.current_page_item > a {
		background-color: #fff;
		color: {$accent_color};
		}
		.home-link a:hover:before, .main-menu > li:hover:before, .main-menu > li:active:before,
		.main-menu > li.current_page_item:before, .main-menu > li.current-menu-item:before {
		content: '';
		position: absolute;
		bottom: 0;
		left: 0;
		display: block;
		width: 100%;
		height: 2px;
		z-index: 2;
		background-color: {$accent_color};	
		}
		.main-menu ul {
		background-color: #fff;
		border: 1px solid #eee;
		}
		.main-menu ul a {
		border-top: 1px solid #f2f2f2;
		color: #555;
		}
		.main-menu ul a:hover {
		color: {$accent_color};
		}
		.mobile-header {
		background-color: #fff;
		border-bottom: 1px solid #eee;
		-webkit-box-shadow: 0 3px 2px 0 rgba(0, 0, 0, 0.03);
		box-shadow: 0 3px 2px 0 rgba(0, 0, 0, 0.03);
		}
		.mobile-header .mobile-title, .mobile-header .menu-toggle, .mobile-header .search-toggle {
		color: #333;
		}
		.button-toggle, .button-toggle:before, .button-toggle:after {
		background-color: #333;
		}
		.main-navbar .woo-cart-link a {
		color: #333;
		}
		.main-navbar .woo-cart-link a:hover {
		color: {$accent_color};
		}";
	}
	
	// Main Menu Alignment
	if ( get_theme_mod('xmag_menu_alignment', 'left') == 'center' ) {
		$theme_css .= "
		.main-navbar {text-align: center;}
		.main-navigation, .main-menu, .main-menu > li, .home-link, .main-navbar .woo-cart-link {float: none; display: inline-block;}
		";
	}
	
	// Mobile Menu Background
	if ( ! empty($mobile_menu_background) ) {
		$theme_css .= ".mobile-sidebar {background-color: {$mobile_menu_background};}";
		if ( xmag_get_brightness($mobile_menu_background) > 150 ) {
			$theme_css .= "
			.mobile-navigation .home-link a, .mobile-navigation ul a, .mobile-navigation ul ul a, .mobile-navigation .woo-cart-link a, .dropdown-toggle {color: rgba(0,0,0,.9);}
			.mobile-navigation a {border-bottom-color: rgba(0,0,0,.07);}
			.mobile-navigation ul ul, .dropdown-toggle:focus:after {background-color: rgba(0,0,0,.07);}
			";
		}
	}
	
	// WooCommerce
	if ( ! empty($woo_button_color ) ) {
		$theme_css .= "
		.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,
		.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover {background-color: {$woo_button_color};}
		";
		
		if ( xmag_get_brightness($woo_button_color) > 155) {
			$theme_css .= ".woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt {color: rgba(0,0,0,.7);}";
		}
	}
	
	$editor_css = "";
	
	// Accent Color
	if ( ! empty($accent_color) ) {
		$editor_css .= "
		.edit-post-visual-editor .editor-block-list__block a,
		.edit-post-visual-editor .editor-block-list__block a:hover,
		.wp-block-freeform.block-library-rich-text__tinymce a
		.wp-block-freeform.block-library-rich-text__tinymce a:hover {
		color: {$accent_color};}
		.editor-styles-wrapper .wp-block-quote, .editor-styles-wrapper .wp-block-quote:not(.is-large):not(.is-style-large),
		.wp-block-freeform.block-library-rich-text__tinymce blockquote {
		border-left-color: {$accent_color};}
		";
	}
	
	// Fonts
	if ( get_theme_mod( 'google_fonts', 1 ) ) {
		if ( ! empty($text_font) ) {
			$editor_css .= "
			.edit-post-visual-editor .editor-block-list__block,
			.editor-default-block-appender textarea.editor-default-block-appender__content {
			font-family: {$text_font}, sans-serif;}
			";
		}
		if ( ! empty($title_font) ) {
			$editor_css .= "
			.editor-post-title__block .editor-post-title__input,
			.edit-post-visual-editor h1,
			.edit-post-visual-editor h2,
			.edit-post-visual-editor h3,
			.edit-post-visual-editor h4,
			.edit-post-visual-editor h5,
			.edit-post-visual-editor h6 {
			font-family: {$title_font}, sans-serif;}
			";
		}
	}
	
	// Page/Post Title Color
	if ( ! empty($single_title_color) ) {
		$editor_css .= ".editor-post-title__block .editor-post-title__input {color: {$single_title_color};}";
	}
	
	// Page/Post Text Color
	if ( ! empty($single_text_color) ) {
		$editor_css .= ".edit-post-visual-editor .editor-block-list__block {color: {$single_text_color};}";
	} elseif ( ! empty($text_color) ) {
		$editor_css .= ".edit-post-visual-editor .editor-block-list__block {color: {$text_color};}";
	}
	
	if ( function_exists( 'register_block_type' ) && is_admin() ) {
		$theme_css = $editor_css;
	}
 
	return $theme_css;
}


/**
 * Enqueues front-end CSS for styles handled by the Theme customizer
 */
function xmag_add_inline_style() {
	
	$custom_css = xmag_custom_style();
	if ( ! empty($custom_css) ) { 
		wp_add_inline_style( 'xmag-style', $custom_css );
	}
	
}
add_action( 'wp_enqueue_scripts', 'xmag_add_inline_style' );
