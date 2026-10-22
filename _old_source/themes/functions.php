<?php
/**
 * xMag Plus functions and definitions
 *
 * @package xMag
 * @since xMag 1.0
 */


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function xmag_setup() {

	// Make theme available for translation. Translations can be filed in the /languages/ directory.
	load_theme_textdomain( 'xmag-plus', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnail.
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'xmag-thumb', 1200, 520, true );
	add_image_size( 'xmag-medium', 460, 300, true );
	add_image_size( 'xmag-main', 740, 480, true );

	// Set the default content width.
	$GLOBALS['content_width'] = 740;

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'main_navigation' => __( 'Main Menu', 'xmag-plus' ),
		'top_navigation' => __( 'Top Menu', 'xmag-plus' ),
		'footer_navigation' => __( 'Footer Menu', 'xmag-plus' ),
		'social_navigation' => __( 'Social Menu', 'xmag-plus' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array( 'comment-form', 'comment-list', 'gallery', 'caption' ) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'audio', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );

	// Set up the WordPress Custom Background Feature.
	$defaults = array(
    'default-color'	=> 'ffffff',
    'default-image'	=> '',
	);
	add_theme_support( 'custom-background', $defaults );

	// Set up the WordPress Custom Header Feature.
	$header_image_height = get_theme_mod( 'xmag_header_image_height', 360 );
	$header_image_width = get_theme_mod( 'xmag_header_image_width', 1920 );

	add_theme_support( 'custom-header', apply_filters( 'xmag_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '000000',
		'width'                  => $header_image_width,
		'height'                 => $header_image_height,
		'flex-height'            => false,
		'wp-head-callback'       => 'xmag_header_style',
	) ) );

	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( array( 'inc/css/editor-style.css', xmag_fonts_url() ) );

	// Load regular editor styles into the new block-based editor.
	add_theme_support( 'editor-styles' );

	// Add custom editor font sizes.
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name'      => __( 'Small', 'xmag-plus' ),
				'shortName' => __( 'S', 'xmag-plus' ),
				'size'      => 14,
				'slug'      => 'small',
			),
			array(
				'name'      => __( 'Normal', 'xmag-plus' ),
				'shortName' => __( 'M', 'xmag-plus' ),
				'size'      => 16,
				'slug'      => 'normal',
			),
			array(
				'name'      => __( 'Large', 'xmag-plus' ),
				'shortName' => __( 'L', 'xmag-plus' ),
				'size'      => 24,
				'slug'      => 'large',
			),
			array(
				'name'      => __( 'Huge', 'xmag-plus' ),
				'shortName' => __( 'XL', 'xmag-plus' ),
				'size'      => 32,
				'slug'      => 'huge',
			),
		)
	);

	// Add support for custom color scheme.
	add_theme_support( 'editor-color-palette', array(
		array(
			'name'  => __( 'Dark Gray', 'xmag-plus' ),
			'slug'  => 'dark-gray',
			'color' => '#222222',
		),
		array(
			'name'  => __( 'Medium Gray', 'xmag-plus' ),
			'slug'  => 'medium-gray',
			'color' => '#333333',
		),
		array(
			'name'  => __( 'Gray', 'xmag-plus' ),
			'slug'  => 'gray',
			'color' => '#555555',
		),
		array(
			'name'  => __( 'Light Gray', 'xmag-plus' ),
			'slug'  => 'light-gray',
			'color' => '#999999',
		),
		array(
			'name'  => __( 'White', 'xmag-plus' ),
			'slug'  => 'white',
			'color' => '#ffffff',
		),
		array(
			'name'  => __( 'Accent Color', 'xmag-plus' ),
			'slug'  => 'accent',
			'color' => esc_attr( get_option( 'accent_color', '#e54e53' ) ),
		),
	) );

}
add_action( 'after_setup_theme', 'xmag_setup' );


if ( ! function_exists( 'xmag_fonts_url' ) ) :
/**
 * Register Google fonts.
 *
 * @return string Google fonts URL for the theme.
 */
function xmag_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	// Add Text Font
	$text_font = get_theme_mod( 'xmag_text_font', 'Open Sans' );
	if ( 'off' !== _x( 'on', 'Text Font: on or off', 'xmag-plus' ) ) {
		$fonts[] = $text_font . ':400,700,400italic,700italic';
	}

	// Add Title Font
	$title_font = get_theme_mod( 'xmag_headings_font', 'Roboto' );
	if ( 'off' !== _x( 'on', 'Title Font: on or off', 'xmag-plus' ) ) {
		$fonts[] = $title_font . ':400,700,300';
	}

	// Add Site Title Font
	$site_title_font = get_theme_mod( 'xmag_site_title_font' );
	if ( $site_title_font != '' && $site_title_font != $title_font ) {
		if ( 'off' !== _x( 'on', 'Site Title Font: on or off', 'xmag-plus' ) ) {
			$fonts[] = $site_title_font . ':400,700,300';
		}
	}

	/* translators: To add an additional character subset specific to your language, translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language. */
	$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'xmag-plus' );

	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' == $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' == $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' == $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), '//fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;


/**
 * Enqueues scripts and styles.
 */
function xmag_scripts() {

	// Add Google Fonts.
	if ( get_theme_mod( 'google_fonts', 1 ) ) {
	wp_enqueue_style( 'xmag-fonts', xmag_fonts_url(), array(), null );
	}

	// Add Icons font, used in the main stylesheet.
	wp_enqueue_style( 'xmag-icons', get_template_directory_uri() . '/fonts/simple-line-icons.min.css', array(), '2.3.3' );

	// Theme stylesheet.
	wp_enqueue_style( 'xmag-style', get_stylesheet_uri(), array(), '1.3.8' );

	// Blocks stylesheet.
	wp_enqueue_style( 'xmag-blocks-style', get_template_directory_uri() . '/inc/css/blocks.css', array( 'xmag-style' ), '20190115' );

	// Main js.
	wp_enqueue_script( 'xmag-js', get_template_directory_uri() . '/js/main.js', array( 'jquery' ), '20190716', true );

	// Add Sticky Menu.
	if ( get_theme_mod('xmag_sticky_menu', 0) == 1 ) {
		wp_enqueue_script( 'xmag-sticky-menu', get_template_directory_uri() . '/js/jquery.sticky.min.js', array( 'jquery' ), '1.0.2', true );
		wp_add_inline_script(
		'xmag-sticky-menu',
		'jQuery(document).ready(function(){
		   var wpAdminBar = jQuery("#wpadminbar");
		   if (wpAdminBar.length) {
		      jQuery("#main-navbar").sticky({topSpacing:wpAdminBar.height()});
		   } else {
		      jQuery("#main-navbar").sticky({topSpacing:0});
		   }
		});'
		);
	}

	// Add Masonry js.
	if ( get_theme_mod('xmag_blog', 'layout2') == 'layout6' || get_theme_mod('xmag_archive', 'layout2') == 'layout6') {
		wp_enqueue_script( 'masonry' );
	}

	// Add Slick Slider.
	if ( get_theme_mod('show_slider') ) {
		wp_enqueue_script( 'xmag-slider-js', get_template_directory_uri() . '/inc/slick/slick.min.js', array( 'jquery' ), '1.6.0', true );
		wp_enqueue_style( 'xmag-slider-css', get_template_directory_uri() . '/inc/slick/slick.min.css', array(), '1.6.0' );
		wp_add_inline_script( 'xmag-slider-js', xmag_initialize_slick() );
	}

	// Comment reply script.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'xmag_scripts' );


/**
 * Enqueue styles for the block-based editor.
 */
function xmag_block_editor_styles() {
	// Add Block styles.
	wp_enqueue_style( 'xmag-block-editor-style', get_theme_file_uri( '/inc/css/editor-blocks.css' ) );
	// Add Google fonts.
	if ( get_theme_mod( 'google_fonts', 1 ) ) {
	wp_enqueue_style( 'xmag-fonts', xmag_fonts_url(), array(), null );
	}
	// Add editor styles.
	wp_add_inline_style( 'xmag-block-editor-style', xmag_custom_style() );
}
add_action( 'enqueue_block_editor_assets', 'xmag_block_editor_styles' );


/**
 * Add styles dynamically for classic TinyMCE editor.
 */
function xmag_theme_editor_dynamic_styles( $mceInit ) {
	if ( get_theme_mod( 'google_fonts', 1 ) ) {
		$styles = 'body.mce-content-body {font-family: ' . get_theme_mod( 'xmag_text_font', 'Open Sans' ) . '}';
		$styles .= ' body.mce-content-body h1, body.mce-content-body h2, body.mce-content-body h3, body.mce-content-body h4 {font-family: ' . get_theme_mod( 'xmag_headings_font', 'Roboto' ) . '}';
	} else {
		$styles = 'body.mce-content-body, body.mce-content-body h1, body.mce-content-body h2, body.mce-content-body h3, body.mce-content-body h4, body.mce-content-body h5, body.mce-content-body h6 {font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica, Arial, sans-serif;}';
	}
	if ( isset( $mceInit['content_style'] ) ) {
		$mceInit['content_style'] .= ' ' . $styles . ' ';
	} else {
		$mceInit['content_style'] = $styles . ' ';
	}
	return $mceInit;
}
add_filter('tiny_mce_before_init','xmag_theme_editor_dynamic_styles');


/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function xmag_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'xmag-plus' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your Sidebar.', 'xmag-plus' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget Area - Left', 'xmag-plus' ),
		'id'            => 'footer-1',
		'description'   => __( 'Add widgets here to appear in your Footer.', 'xmag-plus' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget Area - Center', 'xmag-plus' ),
		'id'            => 'footer-2',
		'description'   => __( 'Add widgets here to appear in your Footer.', 'xmag-plus' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget Area - Right', 'xmag-plus' ),
		'id'            => 'footer-3',
		'description'   => __( 'Add widgets here to appear in your Footer.', 'xmag-plus' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );

	if ( xmag_is_woocommerce_active() ) {
	register_sidebar( array(
		'name'          => __( 'Shop Sidebar', 'xmag-plus' ),
		'id'            => 'sidebar-shop',
		'description'   => __( 'Add widgets here to appear in your Shop.', 'xmag-plus' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );
	}
}
add_action( 'widgets_init', 'xmag_widgets_init' );


/**
 * Add Google fonts.
 */
require get_template_directory() . '/inc/fonts.php';


/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';


/**
 * Custom styles handled by the Theme customizer.
 */
require get_template_directory() . '/inc/custom-styles.php';


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';


/**
 *  Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Load Resize Function.
 */
require_once('inc/aq_resizer.php');


/**
 * Main Menu Fallback.
 */
function xmag_fallback_menu() {
	echo '<ul class="main-menu">';
	wp_list_pages( 'title_li=' );
	echo '</ul>';
}


/**
 * Filter the excerpt "read more" string.
 *
 * @param string $more "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 */
function xmag_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'xmag_excerpt_more' );


/**
 * Thumb size for Layout 1 and 2
 */
function xmag_thumb_size() {
	if ( is_home() ) {
		if ( get_theme_mod( 'xmag_blog', 'layout2' ) == 'layout1' ) {
			$thumb_size = 'thumbnail';
		} else {
			$thumb_size = 'medium';
		}
	} else {
		if ( get_theme_mod( 'xmag_archive', 'layout2' ) == 'layout1' ) {
			$thumb_size = 'thumbnail';
		} else {
			$thumb_size = 'medium';
		}
	}
	return $thumb_size;
}


/**
 * Prints Credits in the Footer.
 */
function xmag_credits() {
	$website_credits = '';
	$website_author = get_bloginfo('name');
	$website_date = date_i18n(__( 'Y', 'xmag-plus' ) );
	$website_credits = '&copy; ' . $website_date . ' ' . $website_author;
	echo esc_attr( $website_credits );
}


/**
 * Add specific CSS class by filter.
 */
function xmag_custom_classes( $classes ) {
	// add 'class-name' to the $classes array
	$classes[] = esc_attr( get_option( 'xmag_layout_style', 'site-fullwidth' ) );

	// Adds a class to Blog Index Page
	if ( is_home() && ! get_theme_mod('xmag_magazine') ) {
    $classes[] = esc_attr( get_theme_mod( 'xmag_blog', 'layout2' ) );
	}

	// Adds a class to Archives and Search Pages
	if ( is_archive() || is_search() ) {
    $classes[] = esc_attr( get_theme_mod( 'xmag_archive', 'layout2' ) );
	}

	// Adds a class to Magazine Template
	if ( is_page_template( 'page-templates/magazine.php' ) || ( is_home() && get_theme_mod('xmag_magazine') ) ) {
	$classes[] = esc_attr('magazine');
	}

	// Adds a class to Single Posts
	if ( is_single() ) {
    	if ( xmag_is_woocommerce_active() && is_woocommerce() ) {
	    	$classes[] = '';
    	} else {
	    	$classes[] = esc_attr( get_theme_mod( 'xmag_post_layout' ) );
    	}
	}

	// Adds a class to WooCommerce Pages
	if ( xmag_is_woocommerce_active() ) {
		if ( is_product() ) {
			$classes[] = esc_attr( get_theme_mod( 'product_layout', 'product-sidebar' ) );
		}
		if ( is_shop() || is_product_category() ) {
			$classes[] = esc_attr( get_theme_mod( 'shop_layout', 'shop-sidebar' ) );
		}
	}

	// return the $classes array
	return $classes;
}
add_filter( 'body_class', 'xmag_custom_classes' );


/**
 * Display Header Image.
 *
 */
function xmag_header_image() {
	if ( get_theme_mod( 'xmag_show_header_image', 1 ) ) {

		if ( is_home() || is_front_page() ) { ?>
			<figure class="header-image">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
				</a>
			</figure>
		<?php }

	} else { ?>

		<figure class="header-image">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
			</a>
		</figure>

	<?php }
}


/**
 * Filter the except length.
 */
function xmag_custom_excerpt_length( $length ) {

	if ( is_home() && ! get_theme_mod( 'xmag_magazine' ) ) {
		$excerpt_length = get_theme_mod( 'xmag_excerpt_size', 25 );
	} elseif ( is_archive() || is_search() ) {
		$excerpt_length = get_theme_mod( 'xmag_archive_excerpt_size', 25 );
	} else {
		$excerpt_length = 30;
	}
    return $excerpt_length;
}
add_filter( 'excerpt_length', 'xmag_custom_excerpt_length', 999 );


/**
 * Change excerpt text.
 */
function xmag_excerpt($num) {
	global $post;
	$limit = $num+1;
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	array_pop($excerpt);
	$excerpt = implode(" ",$excerpt);
	echo $excerpt . '...';
}


/**
 * Blog: Posts Templates
 */
function xmag_blog_post_template() {

	$blog_type = get_theme_mod( 'xmag_blog', 'layout2' );

    if ( $blog_type == 'layout3' || $blog_type == 'layout11' ) {
	// Layout 3,11
	$blog_template = 'content-large';
	} elseif ( $blog_type == 'layout4' || $blog_type == 'layout5' || $blog_type == 'layout12' ) {
	// Layout 4,5,12
	$blog_template = 'content-grid';
	} elseif ( $blog_type == 'layout6' ) {
	// Layout 6
	$blog_template = 'content-masonry';
	} else {
	// Layout 1,2
	$blog_template = 'content';
	}
	return sanitize_file_name($blog_template);
}


/**
 * Blog: Posts Columns
 */
function xmag_blog_post_column() {

	$blog_type = get_theme_mod( 'xmag_blog', 'layout2' );

	if ( $blog_type == 'layout4' || $blog_type == 'layout5' ) {
	// Layout 4 and 5
	$blog_column = 'col-6';
	} elseif ( $blog_type == 'layout6' ) {
	// Layout 6
	$blog_column = 'col-4 masonry-item';
	} elseif ( $blog_type == 'layout12' ) {
	// Layout 12
	$blog_column = 'col-4 col-sm-6';
	} else {
	// Layout 1,2,3,7,8,9,10,11
	$blog_column = 'col-12';
	}
	return esc_attr($blog_column);
}


/**
 * Archives: Posts Templates
 */
function xmag_archive_post_template() {

	$archive_type = get_theme_mod( 'xmag_archive', 'layout2' );

	if ( $archive_type == 'layout3' ) {
	// Layout 3
	$archive_template = 'content-large';
	} elseif ( $archive_type == 'layout4' || $archive_type == 'layout5' || $archive_type == 'layout12' ) {
	// Layout 4,5,12
	$archive_template = 'content-grid';
	} elseif ( $archive_type == 'layout6' ) {
	// Layout 6
	$archive_template = 'content-masonry';
	} else {
	// Layout 1,2
	$archive_template = 'content';
	}
	return sanitize_file_name($archive_template);
}


/**
 * Archives: Posts Columns
 */
function xmag_archive_post_column() {

	$archive_type = get_theme_mod( 'xmag_archive', 'layout2' );

	if ( $archive_type == 'layout4' || $archive_type == 'layout5' ) {
	// Layout 4 and 5
	$archive_column = 'col-6';
	} elseif ( $archive_type == 'layout6' ) {
	// Layout 6
	$archive_column = 'col-4 masonry-item';
	} elseif ( $archive_type == 'layout12' ) {
	// Layout 12
	$archive_column = 'col-4 col-sm-6';
	} else {
	// Layout 1,2,3,11
	$archive_column = 'col-12';
	}
	return esc_attr($archive_column);
}


/*
 * Get the ID of first category
 */
function xmag_first_category_ID() {
	$category = get_the_category();
	$category_first_id = $category[0]->cat_ID;
	$category_first_name = get_cat_name( $category_first_id );
	return $category_first_name;
}


/*
 * Widgets Style
 */
function xmag_widget_style() {
	$xmag_widget = get_theme_mod( 'xmag_widget_style', 'grey' );
	echo esc_attr( 'widget-' . $xmag_widget );
}


/*
 * Site Logo
 */
function xmag_site_logo() {

	$logo_url = esc_url( get_theme_mod('xmag_logo' ) );
	$logo_height = absint ( get_theme_mod('xmag_logo_height', 40) );
	$logo_size = $logo_height . "px";

	$logo_img = sprintf(
		'<img src="%s" style="max-height:%s" alt="%s">',
		$logo_url,
		$logo_size,
		get_bloginfo('name')
	);

	$link = sprintf(
		'<a href="%s" rel="home">%s</a>',
		esc_url(home_url('/')),
		$logo_img
	);

	if (is_front_page() || is_home()) {
		$logo_title = '<h1 id="logo">' . $link . '</h1>';
	} else {
		$logo_title = '<p id="logo">' . $link . '</p>';
	}

	echo $logo_title;
}


/*
 * Resize Image
 */
function xmag_image($w, $h) {

	if ( ! has_post_thumbnail() ) {
		return '';
	}
	$thumb   = get_post_thumbnail_id();
	$img_url = wp_get_attachment_url($thumb, 'full');

	$image   = aq_resize($img_url, $w, $h, true, true, true);

	if (empty($image)) {
		return '';
	}

	return sprintf(
		'<img class="brand-img" src="%s" alt="%s" width="%s" height="%s">',
		$image,
		esc_attr(get_the_title()),
		$w,
		$h
	);

}


/*
 * Return the image attachment ID from a URL (used on Widget Profile)
 */
function get_attachment_id_from_url( $attachment_url = '' ) {

	global $wpdb;
	$attachment_id = false;

	// If there is no url, return.
	if ( '' == $attachment_url )
		return;

	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir();

	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

		// Finally, run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );

	}
	return $attachment_id;
}


/**
 * Load Custom Widgets
 */
require_once('inc/widgets/widget-banner.php');
require_once('inc/widgets/widget-image.php');
require_once('inc/widgets/widget-profile.php');
require_once('inc/widgets/widget-recent-posts.php');
require_once('inc/widgets/widget-social.php');
require_once('inc/widgets/widget-video.php');


/*
 * Display Breadcrumbs
 */
function get_breadcrumb() {
	$space = '&raquo;';
	$name = __('Home','xmag-plus'); //text for the 'Home' link
	$before = '<span class="current">';
	$after = '</span>';

	if ( ! is_home() && ! is_front_page() || is_paged() ) {
	echo '<div class="breadcrumb">';
	  global $post;
	  $home = esc_url( home_url('/') );
	echo '<a href="' . $home . '">' . $name . '</a> ' . $space . ' ';

	if ( is_category() ) {
	  global $wp_query;
	  $cat_obj = $wp_query->get_queried_object();
	  $thisCat = $cat_obj->term_id;
	  $thisCat = get_category($thisCat);
	  $parentCat = get_category($thisCat->parent);
	    if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $space . ' '));
	      echo $before . __( 'Archive by category','xmag-plus') . (' &#39;');
	        single_cat_title();
	      echo '&#39;' . $after;

	} elseif ( is_day() ) {

	  echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $space . ' ';
	  echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $space . ' ';
	  echo $before . get_the_time('d') . $after;

	} elseif ( is_month() ) {

	  echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $space . ' ';
	  echo $before . get_the_time('F') . $after;

	} elseif ( is_year() ) {

	  echo $before . get_the_time('Y') . $after;

	} elseif ( is_single() && ! is_attachment() ) {

	  if(get_post_type() != 'post') {
	    $post_type = get_post_type_object(get_post_type());
	    $slug = $post_type->rewrite;
	      echo $post_type->labels->singular_name;
	      echo '&nbsp;';
	      echo $space;
	      echo '&nbsp;';
	      echo $before;
	        the_title();
	      echo $after;
	  } else {
	    $cat = get_the_category();
	    $cat = $cat[0];
	      echo get_category_parents($cat, TRUE, ' ' . $space . ' ');
	      echo $before;
	        the_title();
	      echo $after;
	  }

	} elseif ( !is_single() && ! is_page() && get_post_type() != 'post') {

	  $post_type = get_post_type_object(get_post_type());
	    echo $before;
	    echo $post_type->labels->singular_name;
	    echo $after;
	    echo '&nbsp;';
	    echo $space;
	    echo '&nbsp;';
	    echo $before;
	      the_title();
	    echo $after;

	} elseif ( is_page() && !$post->post_parent ) {

	  echo $before;
	    the_title();
	  echo $after;

	} elseif ( is_page() && $post->post_parent ) {

	  $parent_id= $post->post_parent;
	  $breadcrumbs = array();
	    while ($parent_id) {
	      $page = get_page($parent_id);
	      $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
	      $parent_id= $page->post_parent;
	    }
	    $breadcrumbs = array_reverse($breadcrumbs);
	      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $space . ' ';
	        echo $before;
	          the_title();
	        echo $after;

	} elseif ( is_search() ) {

	  echo $before . __( 'Search results for','xmag-plus') . (' &#39;') . get_search_query() . '&#39;' . $after;

	} elseif ( is_tag() ) {

	  echo $before . __( 'Posts tagged','xmag-plus') . (' &#39;');
	    single_tag_title();
	  echo '&#39;' . $after;

	} elseif ( is_author() ) {

	  global $author;
	  $userdata = get_userdata($author);
	    echo $before . __( 'Articles posted by ','xmag-plus') . $userdata->display_name . $after;

	} elseif ( is_404() ) {

	  echo $before . 'Error 404' . $after;

	}

	if ( get_query_var('paged') ) {
	  if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
	    echo __('Page','xmag-plus') . ' ' . get_query_var('paged');
	  if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
	}
	echo '</div>';
	}

}

// Enable Breadcrumbs
function xmag_breadcrumb() {
	echo get_breadcrumb();
}


// Initialize Slick Slider
function xmag_initialize_slick() {
	$slick = '
	jQuery(document).ready(function(){

		jQuery("#slider-carousel").slick({
		infinite: true,
		centerMode: true,';
		if ( get_theme_mod('slider_autoplay') ) {
			$autoplay_speed = get_theme_mod('slider_autoplay_speed', 3000);
			$slick .= 'autoplay: true,';
			$slick .= 'autoplaySpeed: ' . $autoplay_speed . ',';
		}
	$slick .= '
		slidesToShow: 1,
		slidesToScroll: 1,
		centerPadding: "200px",
		responsive: [
	    {
	      breakpoint: 1024,
	      settings: {
	        slidesToShow: 1,
	        slidesToScroll: 1,
	        centerPadding: "160px"
	      }
	    },
	    {
	      breakpoint: 768,
	      settings: {
	        slidesToShow: 1,
	        slidesToScroll: 1,
	        centerPadding: "100px"
	      }
	    },
	    {
	      breakpoint: 640,
	      settings: {
		    arrows: false,
		    slidesToShow: 1,
	        slidesToScroll: 1,
	        centerPadding: "0",
	        dots: true
	      }
	    }]
		});

		jQuery("#slider-carousel-fullwidth").slick({
		infinite: true,
		centerMode: true,
		centerPadding: "140px",';
		if ( get_theme_mod('slider_autoplay') ) {
			$autoplay_speed = get_theme_mod('slider_autoplay_speed', 3000);
			$slick .= 'autoplay: true,';
			$slick .= 'autoplaySpeed: ' . $autoplay_speed . ',';
		}
		$slick .= '
		slidesToShow: 2,
		slidesToScroll: 1,
		responsive: [
	    {
	      breakpoint: 1024,
	      settings: {
	        slidesToShow: 2,
	        slidesToScroll: 1,
	        centerPadding: "0"
	      }
	    },
	    {
	      breakpoint: 640,
	      settings: {
	        slidesToShow: 1,
	        slidesToScroll: 1,
			centerPadding: "20px"
	      }
	    }]
		});

		jQuery("#slider-classic").slick({
		dots: true,
		infinite: true,
		speed: 500,
		fade: true,';
		if ( get_theme_mod('slider_autoplay') ) {
			$autoplay_speed = get_theme_mod('slider_autoplay_speed', 3000);
			$slick .= 'autoplay: true,';
			$slick .= 'autoplaySpeed: ' . $autoplay_speed . ',';
		}
		$slick .= '
		cssEase: "ease-in",
		responsive: [
		{
	      breakpoint: 640,
	      settings: {
		    arrows: false,
	        dots: false
	      }
	    }]
		});
	});';

	return $slick;
}


/**
 * WooCommerce
 */

// Query WooCommerce activation
function xmag_is_woocommerce_active() {
	return class_exists( 'woocommerce' ) ? true : false;
}

if ( xmag_is_woocommerce_active() ) {

	// Declare WooCommerce support.
	function woocommerce_support() {
    add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	}
	add_action( 'after_setup_theme', 'woocommerce_support' );

	// WooCommerce Hooks.
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

	add_action('woocommerce_before_main_content', 'xmag_wrapper_start', 10);
	add_action('woocommerce_after_main_content', 'xmag_wrapper_end', 10);

	function xmag_wrapper_start() {
	echo '<div id="primary" class="content-area"><main id="main" class="site-main"><div class="woocommerce-content">';
	}

	function xmag_wrapper_end() {
	echo '</div></main></div>';
	}

	function xmag_remove_woocommerce_sidebar() {
    	if ( get_theme_mod( 'product_layout', 'product-fullwidth' ) == 'product-fullwidth' && is_product() ) {
        	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
    	} elseif ( get_theme_mod( 'shop_layout', 'shop-sidebar' ) == 'shop-fullwidth' && ( is_shop() || is_product_category() ) ) {
	    	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
    	} else {
	    	return;
	    }
	}
	add_action('woocommerce_before_main_content', 'xmag_remove_woocommerce_sidebar' );
}


/**
 * Migrate Custom CSS code from Theme options to Additional CSS
 */
function xmag_custom_css_migrate() {
	if ( function_exists( 'wp_update_custom_css_post' ) ) {
		$custom_css = get_theme_mod( 'xmag_custom_css' );
		if ( $custom_css ) {
			$core_css = wp_get_custom_css(); // Preserve any CSS already added to the core option.
			$return = wp_update_custom_css_post( $core_css . $custom_css );
			if ( ! is_wp_error( $return ) ) {
				// Remove the old theme_mod, so that the CSS is stored in only one place moving forward.
				remove_theme_mod( 'xmag_custom_css' );
			}
		}
	}
}
add_action( 'after_setup_theme', 'xmag_custom_css_migrate' );


/**
 * Getting started Page
 */
require_once( get_template_directory() . '/inc/getting_started.php' );
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == "themes.php" ) wp_redirect( 'themes.php?page=getting_started.php' );


/**
 * Load theme updater functions.
 * Action is used so that child themes can easily disable.
 */

function xmag_theme_updater() {
    require( get_template_directory() . '/updater/theme-updater.php' );
}
add_action( 'after_setup_theme', 'xmag_theme_updater' );
