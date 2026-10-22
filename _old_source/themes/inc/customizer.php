<?php
/**
 * xMag Plus Customizer functionality
 *
 * @package xMag
 * @since xMag 1.0
 */


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function xmag_customize_preview_js() {
	wp_enqueue_script( 'xmag_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20171003', true );
}
add_action( 'customize_preview_init', 'xmag_customize_preview_js' );


/**
 * Loads Custom js
 */
function xmag_customize_js() {
    wp_enqueue_script( 'xmag-customize-js', get_template_directory_uri() . '/js/customize-controls.js', array( 'jquery' ), '20170409', true );
}
add_action( 'customize_controls_enqueue_scripts', 'xmag_customize_js' );


/**
 * Loads custom stylesheet
 */
function xmag_customizer_style() {
	wp_enqueue_style('xmag-customizer-style', get_template_directory_uri() . '/inc/css/customizer-style.css', array(), '1.0.0' );
}
add_action( 'customize_controls_enqueue_scripts', 'xmag_customizer_style' );


/**
 * Custom Classes
 */
if ( class_exists( 'WP_Customize_Control' ) ) {
	
	class Xmag_Custom_Content extends WP_Customize_Control {
    	public $type = 'xmag-custom-content';
		
		function render_content() {
        	if ( ! empty( $this->label ) ) {
        	echo '<span class="customize-control-title xmag-custom-title">' . esc_html( $this->label ) . '</span>';
        	}
			if ( ! empty( $this->description ) ) {
            echo '<div class="description customize-control-description xmag-custom-description">' . $this->description . '</div>';
			}
		}
	}

}


/**
 * Theme Settings
 */
function xmag_theme_customizer( $wp_customize ) {
	
	// Add postMessage support for site title and description for the Theme Customizer
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';	
		
	// Change default WordPress customizer settings
	$wp_customize->get_control( 'background_color' )->section	= 'colors_general';
	$wp_customize->get_control( 'background_color' )->priority  = 1;
	$wp_customize->get_control( 'header_textcolor' )->section	= 'colors_header';
	$wp_customize->get_control( 'header_textcolor' )->priority  = 2;
	$wp_customize->get_control( 'header_textcolor' )->label = __( 'Site Title', 'xmag-plus' );
	$wp_customize->get_section( 'header_image' )->panel  = 'xmag_panel';
	$wp_customize->get_section( 'header_image' )->priority  = 25;
	$wp_customize->get_control( 'header_image' )->priority  = 1;
	$wp_customize->remove_section('colors');
	
	// Retrieve list of Categories
	$blog_categories = array();
	$blog_categories_obj = get_categories();
	foreach ($blog_categories_obj as $category) {
		$blog_categories[$category->cat_ID] = $category->cat_name;
	}
	$blog_categories[0] = __( 'All categories', 'xmag-plus' );
	
	// Retrieve list of Fonts
	$google_fonts = xmag_get_fonts_list();
	
	/* Panels */
	$wp_customize->add_panel( 'xmag_panel', array(
    	'title' => __( 'xMag Settings', 'xmag-plus' ),
		'priority' => 10,
	) );
	
	$wp_customize->add_panel( 'magazine_panel', array(
    	'title' => __( 'Magazine Template', 'xmag-plus' ),
		'priority' => 11,
	) );
	
	$wp_customize->add_panel( 'xmag_colors', array(
    	'title'		=> __( 'Colors', 'xmag-plus' ),
		'priority'	=> 21,
	) );
	
	/* Sections */
	$wp_customize->add_section( 'xmag_general_section', array(
		'title'       => __( 'General', 'xmag-plus' ),
		'description'	=> __( 'Main Settings.', 'xmag-plus' ),
		'priority'    => 5,
		'panel' => 'xmag_panel',
	) );
	
	$wp_customize->add_section( 'xmag_font_section', array(
		'title'       => __( 'Typography', 'xmag-plus' ),
		'priority'    => 10,
		'panel' => 'xmag_panel',
	) );
	
	$wp_customize->add_section('xmag_logo_section', array(
    	'title' => __('Header Logo', 'xmag-plus'),
		'priority' => 15,
		'panel' => 'xmag_panel',
	) );
	
	$wp_customize->add_section( 'xmag_header_section', array(
		'title'       => __( 'Header Options', 'xmag-plus' ),
		'priority'    => 20,
		'panel' => 'xmag_panel',
	) );
	
	$wp_customize->add_section( 'slider_section', array(
		'title'       => __( 'Post Slider', 'xmag-plus' ),
		'priority'    => 30,
		'panel' => 'xmag_panel',
	) );
	
	$wp_customize->add_section( 'xmag_featured_posts_section', array(
		'title'       => __( 'Featured Posts', 'xmag-plus' ),
		'priority'    => 35,
		'panel' => 'xmag_panel',
	) );
	
	$wp_customize->add_section( 'call_action_section', array(
		'title'       => __( 'Call to action', 'xmag-plus' ),
		'priority'    => 40,
		'panel' => 'xmag_panel',
	) );
	
	$wp_customize->add_section( 'xmag_blog_section', array(
		'title'       => __( 'Homepage', 'xmag-plus' ),
		'description'	=> __( 'Settings for Blog Index Page.', 'xmag-plus' ),
		'priority'    => 45,
		'panel' => 'xmag_panel',
	) );
	
	$wp_customize->add_section( 'xmag_archive_section', array(
		'title'       => __( 'Categories and Archives', 'xmag-plus' ),
		'description'	=> __( 'Settings for Category, Tag, Search result, Author and Archive Pages.', 'xmag-plus' ),
		'priority'    => 50,
		'panel' => 'xmag_panel',
	) );

	$wp_customize->add_section( 'xmag_post_section', array(
		'title'       => __( 'Post', 'xmag-plus' ),
		'description'	=> __( 'Settings for Single Post.', 'xmag-plus' ),
		'priority'    => 55,
		'panel' => 'xmag_panel',
	) );
	
	$wp_customize->add_section( 'xmag_page_section', array(
		'title'       => __( 'Page', 'xmag-plus' ),
		'description'	=> __( 'Settings for Static Page.', 'xmag-plus' ),
		'priority'    => 60,
		'panel' => 'xmag_panel',
	) );
	
	$wp_customize->add_section( 'woocommerce_section', array(
		'title'       => __( 'WooCommerce', 'xmag-plus' ),
		'description' => __('WooCommerce Settings. Cart, Checkout and Account are standard pages. To hide the sidebar apply the Full width Template to the page.', 'xmag-plus'),
		'priority'    => 65,
		'panel' => 'xmag_panel',
		'active_callback' => 'xmag_woocommerce',
	) );
	
	$wp_customize->add_section('xmag_ads_section', array(
		'priority' => 70,
		'title' => __('Advertisements', 'xmag-plus'),
		'panel' => 'xmag_panel',
	) );
	
	$wp_customize->add_section( 'xmag_custom_css_section', array(
		'title' => __('Custom CSS', 'xmag-plus'),
		'priority' => 85,
		'panel' =>'xmag_panel',
	) );
	
	$wp_customize->add_section( 'magazine_options', array(
		'title'       => __( 'General', 'xmag-plus' ),
		'description' => __( 'Magazine Settings.', 'xmag-plus' ),
		'priority'    => 1,
		'panel' => 'magazine_panel',
	) );
	
	$wp_customize->add_section( 'magazine_block7', array(
		'title'		=> __( 'Top Section', 'xmag-plus' ),
		'priority'	=> 1,
		'panel'		=> 'magazine_panel',
	) );
	
	for ( $count = 1; $count <= 6; $count++ ) {
		$wp_customize->add_section( 'magazine_block' . $count, array(
			'title'		=> __( 'Section ', 'xmag-plus' ) . $count,
			'priority'	=> $count,
			'panel'		=> 'magazine_panel',
		) );
	}
	
	$wp_customize->add_section( 'colors_general', array(
		'title'	=> __( 'General', 'xmag-plus' ),
		'panel'	=> 'xmag_colors',
	) );
	
	$wp_customize->add_section( 'colors_header', array(
		'title'	=> __( 'Header', 'xmag-plus' ),
		'panel'	=> 'xmag_colors',
	) );
	
	$wp_customize->add_section( 'colors_footer', array(
		'title'	=> __( 'Footer', 'xmag-plus' ),
		'panel'	=> 'xmag_colors',
	) );
	
	$wp_customize->add_section( 'colors_mobile', array(
		'title'	=> __( 'Mobile Menu', 'xmag-plus' ),
		'panel'	=> 'xmag_colors',
	) );
	
	$wp_customize->add_section('xmag_links_section', array(
		'title' => __('xMag Links', 'xmag-plus'),
		'priority' => 9,
	) );
	
	/* Controls */
	
	// General - Site Layout
	$wp_customize->add_setting( 'xmag_layout_style', array(
        'default' => 'site-fullwidth',
        'type' => 'option',
		'capability' => 'edit_theme_options',
        'sanitize_callback' => 'xmag_sanitize_choices',
    ) );
   	   	
	$wp_customize->add_control( 'xmag_layout_style', array(
	    'label'    => __( 'Site Layout', 'xmag-plus' ),
	    'section'  => 'xmag_general_section',
	    'type'     => 'select',
		'choices'  => array(
			'site-fullwidth' => __('Full width', 'xmag-plus'),
			'site-boxed' => __('Boxed', 'xmag-plus'),
	) ) );
	
	// General - Widget Style
	$wp_customize->add_setting( 'xmag_widget_style', array(
        'default' => 'grey',
        'sanitize_callback' => 'xmag_sanitize_choices',
    ) );
   	   	
	$wp_customize->add_control( 'xmag_widget_style', array(
	    'label'    => __( 'Widget Style', 'xmag-plus' ),
	    'section'  => 'xmag_general_section',
	    'type'     => 'select',
		'choices'  => array(
			'grey' => __('Grey', 'xmag-plus'),
			'white' => __('White', 'xmag-plus'),
			'minimal' => __('Minimal', 'xmag-plus'),
	) ) );
	
	// General - Site Options
	$wp_customize->add_setting( 'xmag_site_options', array(
        'sanitize_callback' => 'sanitize_text_field',
    ) );
	
	$wp_customize->add_control( new Xmag_Custom_Content( $wp_customize, 'xmag_site_options', array(
		'label'      => __( 'Site Options', 'xmag-plus' ),
		'section'  => 'xmag_general_section',
	) ) );
	
	$wp_customize->add_setting( 'xmag_scroll_up', array(
        'default' => '',
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'xmag_scroll_up', array(
	    'label'    => __( 'Display Scroll Up button', 'xmag-plus' ),
	    'section'  => 'xmag_general_section',
	    'type'     => 'checkbox',
	) );
	
	$wp_customize->add_setting( 'show_blog_date', array(
        'default' => 1,
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'show_blog_date', array(
	    'label'    => __( 'Display Date', 'xmag-plus' ),
	    'description' => __( 'Display Date in Homepage and Archive Pages.', 'xmag-plus' ),
	    'section'  => 'xmag_general_section',
	    'type'     => 'checkbox',
	) );
	
	$wp_customize->add_setting( 'show_blog_author', array(
        'default' => '',
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'show_blog_author', array(
	    'label'    => __( 'Display Author', 'xmag-plus' ),
	    'description' => __( 'Display Author in Homepage and Archive Pages.', 'xmag-plus' ),
	    'section'  => 'xmag_general_section',
	    'type'     => 'checkbox',
	) );
	
	$wp_customize->add_setting( 'show_blog_categories', array(
        'default' => 1,
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'show_blog_categories', array(
	    'label'    => __( 'Display Categories', 'xmag-plus' ),
	    'description' => __( 'Display Categories in Homepage and Archive Pages.', 'xmag-plus' ),
	    'section'  => 'xmag_general_section',
	    'type'     => 'checkbox',
	) );
	
	$wp_customize->add_setting( 'xmag_read_more', array(
        'default' => '',
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'xmag_read_more', array(
	    'label'    => __( 'Display Read More Link', 'xmag-plus' ),
	    'description' => __( 'Display Read More Link in Homepage and Archive Pages.', 'xmag-plus' ),
	    'section'  => 'xmag_general_section',
	    'type'     => 'checkbox',
	) );
	
	$wp_customize->add_setting( 'xmag_footer_copy', array(
        'default' => '',
        'sanitize_callback' => 'xmag_sanitize_html',
    ) );
	
	$wp_customize->add_control( 'xmag_footer_copy', array(
	    'label'    => __( 'Footer Tagline', 'xmag-plus' ),
	    'description' => __( 'Add a Custom Text in the Footer. HTML tags are allowed: strong, em, b, i, br, a.', 'xmag-plus' ),
	    'section'  => 'xmag_general_section',
	    'type' => 'textarea',
	) );
     
	$wp_customize->add_setting( 'xmag_google_analytics', array(
        'default' => '',
        'sanitize_callback' => 'xmag_js_sanitize',
    ) );
	
	$wp_customize->add_control( 'xmag_google_analytics', array(
		'label'    => __( 'Google Analytics', 'xmag-plus' ),
		'description' => __( 'Paste here your Google Analytics code.', 'xmag-plus' ),
	    'section'  => 'xmag_general_section',
	    'type' => 'textarea',
	) );
	
	// Typography
	$wp_customize->add_setting( 'google_fonts', array(
        'default' => 1,
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'google_fonts', array(
	    'label'    => __( 'Enable Google Fonts', 'xmag-plus' ),
	    'description' => __( 'Uncheck this option to disable Google Fonts and use System Fonts.', 'xmag-plus' ),
	    'section' => 'xmag_font_section',
	    'type'     => 'checkbox',
	) );
	
	// Site Title
	$wp_customize->add_setting( 'xmag_site_title_font', array(
        'default' => '',
        'sanitize_callback' => 'xmag_sanitize_choices',
    ) );
		
	$wp_customize->add_control( 'xmag_site_title_font', array(
	    'label'   => __('Site Title Font', 'xmag-plus'),
	    'section' => 'xmag_font_section',
	    'active_callback' => 'xmag_google_fonts_on',
	    'type'    => 'select',
	    'choices'    => $google_fonts
	) );
	
	// Title	
	$wp_customize->add_setting( 'xmag_headings_font', array(
        'default' => 'Roboto',
        'sanitize_callback' => 'xmag_sanitize_choices',
    ) );
		
	$wp_customize->add_control( 'xmag_headings_font', array(
	    'label'   => __('Title Font', 'xmag-plus'),
	    'section' => 'xmag_font_section',
	    'active_callback' => 'xmag_google_fonts_on',
	    'type'    => 'select',
	    'choices'    => $google_fonts
	) );
	
	// Text
	$wp_customize->add_setting( 'xmag_text_font', array(
        'default' => 'Open Sans',
        'sanitize_callback' => 'xmag_sanitize_choices',
    ) );
		
	$wp_customize->add_control( 'xmag_text_font', array(
	    'label'		=> __('Text Font', 'xmag-plus'),
	    'section'	=> 'xmag_font_section',
	    'active_callback' => 'xmag_google_fonts_on',
	    'type'		=> 'select',
	    'choices'   => $google_fonts
	) );
	
	// Font Size
	$wp_customize->add_setting( 'xmag_font_size', array(
		'default' => '15px',
		'sanitize_callback' => 'xmag_sanitize_choices',
	) );
	
	$wp_customize->add_control( 'xmag_font_size', array(
		'label' => __( 'Font Size', 'xmag-plus' ),
		'description' => __( 'Adjust Text font size and Title font size.', 'xmag-plus' ),
		'section' => 'xmag_font_section',
		'type' => 'select',
		'choices' => array(
		'14px' => __( '14px', 'xmag-plus' ),
		'15px' => __( '15px', 'xmag-plus' ),
		'16px' => __( '16px', 'xmag-plus' ),
		'18px' => __( '18px', 'xmag-plus' )
	) ) );
	
	// Logo
	$wp_customize->add_setting('xmag_logo', array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'xmag_logo', array(
		'label' => __('Upload your logo', 'xmag-plus'),
		'section' => 'xmag_logo_section',
		'setting' => 'xmag_logo',
	) ) );
   
	// Logo Size
	$wp_customize->add_setting( 'xmag_logo_height', array(
        'default' => 40,
        'sanitize_callback' => 'absint',
	) );
	
	$wp_customize->add_control( 'xmag_logo_height', array(	
        'label' => __( 'Logo Max Height', 'xmag-plus' ),
        'section'  => 'xmag_logo_section',
        'type'     => 'number',
    ) );
	
	// Logo Position
	$wp_customize->add_setting( 'xmag_logo_position', array(
        'default' => 'logo-left',
        'sanitize_callback' => 'xmag_sanitize_choices',
	) );
	
	$wp_customize->add_control( 'xmag_logo_position', array(	
        'label' => __( 'Logo Position', 'xmag-plus' ),
        'section'  => 'xmag_logo_section',
        'type' => 'radio',
		'choices' => array(
		'logo-left' => __( 'Left', 'xmag-plus' ),
		'logo-center' => __( 'Centered', 'xmag-plus' ),
		'logo-center-full' => __( 'Centered Full width', 'xmag-plus' ),
    ) ) );
	
	// Display Tagline under the Logo	
	$wp_customize->add_setting( 'xmag_logo_tagline', array(
        'default' => '',
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'xmag_logo_tagline', array(
	    'label'    => __( 'Display Tagline under the Logo', 'xmag-plus' ),
	    'section'  => 'xmag_logo_section',
	    'type'     => 'checkbox',
	) );
	
	// Header - Main Menu Style
	$wp_customize->add_setting( 'xmag_menu_style', array(
        'default' => 'dark',
        'sanitize_callback' => 'xmag_sanitize_choices',
    ) );
   	   	
	$wp_customize->add_control( 'xmag_menu_style', array(
	    'label'    => __( 'Main Menu Style', 'xmag-plus' ),
	    'section'  => 'xmag_header_section',
	    'type'     => 'select',
		'choices'  => array(
			'dark' => __('Dark', 'xmag-plus'),
			'light' => __('Light', 'xmag-plus'),
			'custom' => __('Custom Background', 'xmag-plus'),
	) ) );
	
	// Header - Main Menu Background
	$wp_customize->add_setting( 'main_menu_background', array(
		'default' => '#e54e53',
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'main_menu_background', array(
		'description' => __( 'Set a custom background for the Main Menu', 'xmag-plus' ),
		'section'  => 'xmag_header_section',
		'active_callback' => 'xmag_has_custom_menu',
	) ) );
	
	// Header -  Main Menu Alignment
	$wp_customize->add_setting( 'xmag_menu_alignment', array(
        'default' => 'left',
        'sanitize_callback' => 'xmag_sanitize_choices',
    ) );
   	   	
	$wp_customize->add_control( 'xmag_menu_alignment', array(
	    'label'    => __( 'Main Menu Alignment', 'xmag-plus' ),
	    'section'  => 'xmag_header_section',
	    'type'     => 'select',
		'choices'  => array(
			'left' => __('Left', 'xmag-plus'),
			'center' => __('Centered', 'xmag-plus'),
	) ) );
	
	// Header Options
	$wp_customize->add_setting( 'xmag_header_options', array(
        'sanitize_callback' => 'sanitize_text_field',
    ) );
	
	$wp_customize->add_control( new Xmag_Custom_Content( $wp_customize, 'xmag_header_options', array(
		'label'      => __( 'Header Options', 'xmag-plus' ),
		'section'  => 'xmag_header_section',
	) ) );
	
	// Header - Sticky Menu
	$wp_customize->add_setting( 'xmag_sticky_menu', array(
        'default' => '',
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'xmag_sticky_menu', array(
	    'label'    => __( 'Sticky Main Menu', 'xmag-plus' ),
	    'section'  => 'xmag_header_section',
	    'type'     => 'checkbox',
	) );
	
	// Header - Home Icon
	$wp_customize->add_setting( 'xmag_home_icon', array(
        'default' => 1,
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'xmag_home_icon', array(
	    'label'    => __( 'Display the Home icon in the Main Menu', 'xmag-plus' ),
	    'section'  => 'xmag_header_section',
	    'type'     => 'checkbox',
	) );
	
	// Header - Search Form
	$wp_customize->add_setting( 'xmag_show_search', array(
        'default' => 1,
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'xmag_show_search', array(
	    'label'    => __( 'Display Search Form in the Top Menu', 'xmag-plus' ),
	    'section'  => 'xmag_header_section',
	    'type'     => 'checkbox',
	) );
	
	// Header Image Width
	$wp_customize->add_setting( 'xmag_header_image_width', array(
        'default' => 1920,
        'sanitize_callback' => 'absint',
    ) );
	
	$wp_customize->add_control( 'xmag_header_image_width', array(
		'label' => __( 'Header Image Width', 'xmag-plus' ),
	    'description' => __( 'After changing the size save and add a new image.', 'xmag-plus' ),
	    'section'  => 'header_image',
	    'priority'    => 1,
	    'type'     => 'number',
	) );
	
	// Header Image Height
	$wp_customize->add_setting( 'xmag_header_image_height', array(
        'default' => 360,
        'sanitize_callback' => 'absint',
    ) );
	
	$wp_customize->add_control( 'xmag_header_image_height', array(
		'label' => __( 'Header Image Height', 'xmag-plus' ),
	    'description' => __( 'After changing the size save and add a new image.', 'xmag-plus' ),
	    'section'  => 'header_image',
	    'priority'    => 2,
	    'type'     => 'number',
	) );
	
	// Header Image Options
	$wp_customize->add_setting( 'xmag_header_image_options', array(
        'sanitize_callback' => 'sanitize_text_field',
    ) );
	
	$wp_customize->add_control( new Xmag_Custom_Content( $wp_customize, 'xmag_header_image_options', array(
		'label'      => __( 'Header Image Options', 'xmag-plus' ),
		'section'  => 'header_image',
		'priority'    => 3,
	) ) );
	
	$wp_customize->add_setting( 'show_header_image', array(
        'default' => '',
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'show_header_image', array(
	    'label'    => __( 'Display Header Image on Mobile', 'xmag-plus' ),
	    'section'  => 'header_image',
	    'priority'    => 4,
	    'type'     => 'checkbox',
	) );
	
	$wp_customize->add_setting( 'xmag_show_header_image', array(
        'default' => 1,
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'xmag_show_header_image', array(
	    'label'    => __( 'Display Header Image on Homepage only', 'xmag-plus' ),
	    'section'  => 'header_image',
	    'priority'    => 5,
	    'type'     => 'checkbox',
	) );

	// Homepage - Layout
	$wp_customize->add_setting( 'xmag_blog', array(
        'default' => 'layout2',
        'sanitize_callback' => 'xmag_sanitize_choices',
    ) );
   	   	
	$wp_customize->add_control( 'xmag_blog', array(
	    'label'    => __( 'Layout', 'xmag-plus' ),
	    'section'  => 'xmag_blog_section',
	    'type'     => 'select',
		'choices'  => array(
			'layout1' => __('List: Small Thumbnail + Sidebar', 'xmag-plus'),
			'layout2' => __('List: Medium Thumbnail + Sidebar', 'xmag-plus'),
			'layout3' => __('Classic: Large Posts + Sidebar', 'xmag-plus'),
			'layout4' => __('Grid: Two Columns + Sidebar', 'xmag-plus'),
			'layout5' => __('Grid: Two Columns', 'xmag-plus'),
			'layout6' => __('Grid: Three Columns Masonry', 'xmag-plus'),
			'layout12' => __('Grid: Three Columns', 'xmag-plus'),
			'layout7' => __('First Large Post then List + Sidebar', 'xmag-plus'),
			'layout8' => __('First Large Post then Grid + Sidebar', 'xmag-plus'),
			'layout9' => __('Mixed: Large Post, List + Sidebar', 'xmag-plus'),
			'layout10' => __('Mixed: Large Post, Grid + Sidebar', 'xmag-plus'),
			'layout11' => __('Full Content Post + Sidebar', 'xmag-plus'),
	) ) );
	
	// Homepage - Excerpt Length
	$wp_customize->add_setting( 'xmag_excerpt_size', array(
        'default' => 25,
        'sanitize_callback' => 'absint',
    ) );
	
	$wp_customize->add_control( 'xmag_excerpt_size', array(
	    'label'    => __( 'Excerpt length', 'xmag-plus' ),
	    'section'  => 'xmag_blog_section',
	    'type'     => 'number',
	) );
	
	// Archive - Layout
	$wp_customize->add_setting( 'xmag_archive', array(
        'default' => 'layout2',
        'sanitize_callback' => 'xmag_sanitize_choices',
    ) );
    
    $wp_customize->add_control( 'xmag_archive', array(
	    'label'    => __( 'Layout', 'xmag-plus' ),
	    'section'  => 'xmag_archive_section',
	    'type'     => 'select',
		'choices'  => array(
			'layout1' => __('List: Small Thumbnail + Sidebar', 'xmag-plus'),
			'layout2' => __('List: Medium Thumbnail + Sidebar', 'xmag-plus'),
			'layout3' => __('Classic: Large Posts + Sidebar', 'xmag-plus'),
			'layout4' => __('Grid: Two Columns + Sidebar', 'xmag-plus'),
			'layout5' => __('Grid: Two Columns', 'xmag-plus'),
			'layout6' => __('Grid: Three Columns Masonry', 'xmag-plus'),
			'layout12' => __('Grid: Three Columns', 'xmag-plus'),
			'layout7' => __('First Large Post then List + Sidebar', 'xmag-plus'),
			'layout8' => __('First Large Post then Grid + Sidebar', 'xmag-plus'),
	) ) );
	
	// Archive - Excerpt Length
	$wp_customize->add_setting( 'xmag_archive_excerpt_size', array(
        'default' => 25,
        'sanitize_callback' => 'absint',
    ) );
	
	$wp_customize->add_control( 'xmag_archive_excerpt_size', array(
	    'label'    => __( 'Excerpt length', 'xmag-plus' ),
	    'section'  => 'xmag_archive_section',
	    'type'     => 'number',
	) );
	
	// Featured Posts
	$wp_customize->add_setting( 'xmag_featured_posts', array(
        'default' => '',
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'xmag_featured_posts', array(
	    'label'    => __( 'Display Featured Posts', 'xmag-plus' ),
	    'description'	=> __( 'Use a tag to feature your posts at the top of the Homepage. If no posts match the tag, sticky posts will be displayed instead.', 'xmag-plus' ),
	    'section'  => 'xmag_featured_posts_section',
	    'type'     => 'checkbox',
	) );
	
	$wp_customize->add_setting( 'xmag_featured_posts_style', array(
        'default' => 'mosaic',
        'sanitize_callback' => 'xmag_sanitize_choices',
    ) );
   	   	
	$wp_customize->add_control( 'xmag_featured_posts_style', array(
	    'label'    => __( 'Style', 'xmag-plus' ),
	    'section'  => 'xmag_featured_posts_section',
	    'type'     => 'radio',
		'choices'  => array(
			'mosaic' => __('Mosaic', 'xmag-plus'),
			'grid' => __('Grid', 'xmag-plus'),
	) ) );
	
	$wp_customize->add_setting( 'xmag_featured_tags', array(
        'default' => 'featured',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
	
	$wp_customize->add_control( 'xmag_featured_tags', array(
	    'label'    => __( 'Tags', 'xmag-plus' ),
	    'description' => __('Add Tags separated by a comma.', 'xmag-plus'),
	    'section'  => 'xmag_featured_posts_section',
	    'type' => 'text',
	) );
	
	$wp_customize->add_setting( 'xmag_featured_title', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
	
	$wp_customize->add_control( 'xmag_featured_title', array(
	    'label'    => __( 'Title', 'xmag-plus' ),
	    'description' => __('Add a Title (optional).', 'xmag-plus'),
	    'section'  => 'xmag_featured_posts_section',
	    'type' => 'text',
	) );
	
	$wp_customize->add_setting( 'xmag_featured_desc', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
	
	$wp_customize->add_control( 'xmag_featured_desc', array(
	    'label'    => __( 'Description', 'xmag-plus' ),
	    'description' => __('Add some text below the Title.', 'xmag-plus'),
	    'section'  => 'xmag_featured_posts_section',
	    'type' => 'text',
	) );
	
	// Slider
	$wp_customize->add_setting( 'show_slider', array(
        'default' => '',
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'show_slider', array(
	    'label'    => __( 'Display Post Slider', 'xmag-plus' ),
	    'description'	=> __( 'Add a Post Slider at the top of the Homepage.', 'xmag-plus' ),
	    'section'  => 'slider_section',
	    'type'     => 'checkbox',
	) );
	
	// Slider Style
	$wp_customize->add_setting( 'slider_style', array(
        'default' => 'slider-carousel',
        'sanitize_callback' => 'xmag_sanitize_choices',
    ) );
   	   	
	$wp_customize->add_control( 'slider_style', array(
	    'label'    => __( 'Style', 'xmag-plus' ),
	    'section'  => 'slider_section',
	    'type'     => 'radio',
		'choices'  => array(
			'slider-classic' => __('Classic', 'xmag-plus'),
			'slider-carousel' => __('Carousel Centered', 'xmag-plus'),
			'slider-carousel-fullwidth' => __('Carousel Fullwidth', 'xmag-plus'),
	) ) );
	
	// Slider Autoplay 
	$wp_customize->add_setting( 'slider_autoplay', array(
        'default' => '',
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'slider_autoplay', array(
	    'label'    => __( 'Autoplay', 'xmag-plus' ),
	    'description'	=> __( 'Enables Autoplay.', 'xmag-plus' ),
	    'section'  => 'slider_section',
	    'type'     => 'checkbox',
	) );
	
	$wp_customize->add_setting( 'slider_autoplay_speed', array(
        'default' => 3000,
        'sanitize_callback' => 'absint',
	) );
	
	$wp_customize->add_control( 'slider_autoplay_speed', array(	
        'label' => __( 'Autoplay Speed', 'xmag-plus' ),
        'description'	=> __( 'Autoplay Speed in milliseconds. Default 3000.', 'xmag-plus' ),
        'section'  => 'slider_section',
        'active_callback' => 'xmag_autoplay_on',
        'type'     => 'number',
    ) );
    
	// Slider Categories
	$wp_customize->add_setting('slider_category', array(
	    'default' => '',
	    'type' => 'option',
	    'capability' => 'edit_theme_options',
	    'sanitize_callback' => 'xmag_sanitize_choices',
	) );
	$wp_customize->add_control('slider_category', array(
	    'label' => __('Select a Category', 'xmag-plus'),
	    'section'  => 'slider_section',
	    'type'    => 'select',
	    'choices'    => $blog_categories
	) );
	
	// Slider Posts Number
	$wp_customize->add_setting( 'slider_posts', array(
        'default' => 10,
        'sanitize_callback' => 'absint',
	) );
	
	$wp_customize->add_control( 'slider_posts', array(	
        'label' => __( 'Number of Posts to display', 'xmag-plus' ),
        'section'  => 'slider_section',
        'type'     => 'number',
    ) );

	// Call to action
	$wp_customize->add_setting( 'show_call_action', array(
        'default' => '',
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'show_call_action', array(
	    'label'    => __( 'Display Call to action', 'xmag-plus' ),
	    'section'  => 'call_action_section',
	    'type'     => 'checkbox',
	) );
	
	// Call to action - Title
	$wp_customize->add_setting( 'call_action_title', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
	
	$wp_customize->add_control( 'call_action_title', array(
	    'label'    => __( 'Title', 'xmag-plus' ),
	    'section'  => 'call_action_section',
	    'type' => 'text',
	) );
	
	// Call to action - Text
	$wp_customize->add_setting( 'call_action_desc', array(
        'default' => '',
        'sanitize_callback' => 'xmag_sanitize_html',
    ) );
	
	$wp_customize->add_control( 'call_action_desc', array(
	    'label'    => __( 'Text', 'xmag-plus' ),
	    'description' => __( 'HTML tags are allowed: strong, em, b, i, br, a.' , 'xmag-plus' ),
	    'section'  => 'call_action_section',
	    'type' => 'textarea',
	) );

	// Call to action - Button Label
	$wp_customize->add_setting( 'action_button_text', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
	
	$wp_customize->add_control( 'action_button_text', array(
	    'label'    => __( 'Button Text', 'xmag-plus' ),
	    'section'  => 'call_action_section',
	    'type' => 'text',
	) );
	
	// Call to action - Button Url
	$wp_customize->add_setting( 'action_button_url', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
	
	$wp_customize->add_control( 'action_button_url', array(
	    'label'    => __( 'Button Url', 'xmag-plus' ),
	    'section'  => 'call_action_section',
	    'type' => 'text',
	) );
	
	// Post - Featured Image
	$wp_customize->add_setting( 'post_featured_image', array(
        'sanitize_callback' => 'sanitize_text_field',
    ) );
	
	$wp_customize->add_control( new Xmag_Custom_Content( $wp_customize, 'post_featured_image', array(
		'label'      => __( 'Featured Image', 'xmag-plus' ),
		'section'  => 'xmag_post_section',
	) ) );
	
	$wp_customize->add_setting( 'xmag_post_featured_image', array(
        'default' => '',
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'xmag_post_featured_image', array(
	    'label'    => __( 'Display Featured Image', 'xmag-plus' ),
	    'section'  => 'xmag_post_section',
	    'type'     => 'checkbox',
	) );
	
	$wp_customize->add_setting( 'xmag_post_featured_image_size', array(
        'default' => 'default',
        'sanitize_callback' => 'xmag_sanitize_choices',
    ) );
   	   	
	$wp_customize->add_control( 'xmag_post_featured_image_size', array(
	    'description'    => __( 'Featured Image Size', 'xmag-plus' ),
	    'section'  => 'xmag_post_section',
	    'active_callback' => 'xmag_post_has_featured_image',
	    'type'     => 'radio',
		'choices'  => array(
			'default' => __('Default', 'xmag-plus'),
			'fullwidth' => __('Full width (images must be at least 1140px)', 'xmag-plus'),
	) ) );
	
	// Post - Layout
	$wp_customize->add_setting( 'xmag_post_layout', array(
        'default' => 'single-sidebar',
        'sanitize_callback' => 'xmag_sanitize_choices',
    ) );
   	   	
	$wp_customize->add_control( 'xmag_post_layout', array(
	    'label'    => __( 'Layout', 'xmag-plus' ),
	    'section'  => 'xmag_post_section',
	    'type'     => 'select',
		'choices'  => array(
			'single-sidebar' => __('Sidebar', 'xmag-plus'),
			'single-fullwidth' => __('Full width', 'xmag-plus'),
	) ) );
	
	// Post Options
	$wp_customize->add_setting( 'post_options', array(
        'sanitize_callback' => 'sanitize_text_field',
    ) );
	
	$wp_customize->add_control( new Xmag_Custom_Content( $wp_customize, 'post_options', array(
		'label'      => __( 'Post Options', 'xmag-plus' ),
		'section'  => 'xmag_post_section',
	) ) );
	
	$wp_customize->add_setting( 'xmag_enable_post_breadcrumb', array(
        'default' => '',
        'type' => 'option',
		'capability' => 'edit_theme_options',
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'xmag_enable_post_breadcrumb', array(
	    'label'    => __( 'Display Post breadcrumbs', 'xmag-plus' ),
	    'description'	=> __( 'Display Breadcrumbs Navigation at the top of the Post.', 'xmag-plus' ),
	    'section'  => 'xmag_post_section',
	    'type'     => 'checkbox',
	) );
	
	$wp_customize->add_setting( 'show_date', array(
        'default' => 1,
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'show_date', array(
	    'label'    => __( 'Display Date', 'xmag-plus' ),
	    'section'  => 'xmag_post_section',
	    'type'     => 'checkbox',
	) );
	
	$wp_customize->add_setting( 'show_last_updated_date', array(
        'default' => '',
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'show_last_updated_date', array(
	    'label'    => __( 'Display Last Updated Date', 'xmag-plus' ),
	    'section'  => 'xmag_post_section',
	    'type'     => 'checkbox',
	) );
	
	$wp_customize->add_setting( 'show_single_categories', array(
        'default' => 1,
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'show_single_categories', array(
	    'label'    => __( 'Display Categories', 'xmag-plus' ),
	    'section'  => 'xmag_post_section',
	    'type'     => 'checkbox',
	) );
	
	$wp_customize->add_setting( 'show_single_tags', array(
        'default' => 1,
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'show_single_tags', array(
	    'label'    => __( 'Display Tags', 'xmag-plus' ),
	    'section'  => 'xmag_post_section',
	    'type'     => 'checkbox',
	) );
	
	$wp_customize->add_setting( 'xmag_enable_related_posts', array(
        'default' => '',
        'type' => 'option',
		'capability' => 'edit_theme_options',
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'xmag_enable_related_posts', array(
	    'label'    => __( 'Display Related Posts', 'xmag-plus' ),
	    'description'	=> __( 'Display Related Posts at the bottom of the Post.', 'xmag-plus' ),
	    'section'  => 'xmag_post_section',
	    'type'     => 'checkbox',
	) );

	$wp_customize->add_setting( 'xmag_enable_author_bio', array(
        'default' => 1,
        'type' => 'option',
		'capability' => 'edit_theme_options',
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'xmag_enable_author_bio', array(
	    'label'    => __( 'Display Author Bio', 'xmag-plus' ),
	    'description' => __( 'Display Author Bio at the bottom of the Post.', 'xmag-plus' ),
	    'section'  => 'xmag_post_section',
	    'type'     => 'checkbox',
	) );
	
	// Page - Featured Image
	$wp_customize->add_setting( 'page_featured_image', array(
        'sanitize_callback' => 'sanitize_text_field',
    ) );
	
	$wp_customize->add_control( new Xmag_Custom_Content( $wp_customize, 'page_featured_image', array(
		'label'      => __( 'Featured Image', 'xmag-plus' ),
		'section'  => 'xmag_page_section',
	) ) );
	
	$wp_customize->add_setting( 'xmag_page_featured_image', array(
        'default' => '',
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'xmag_page_featured_image', array(
	    'label'    => __( 'Display Featured Image', 'xmag-plus' ),
	    'section'  => 'xmag_page_section',
	    'type'     => 'checkbox',
	) );
	
	$wp_customize->add_setting( 'xmag_page_featured_image_size', array(
        'default' => 'default',
        'sanitize_callback' => 'xmag_sanitize_choices',
    ) );
   	   	
	$wp_customize->add_control( 'xmag_page_featured_image_size', array(
	    'description'    => __( 'Featured Image Size', 'xmag-plus' ),
	    'section'  => 'xmag_page_section',
	    'active_callback' => 'xmag_page_has_featured_image',
	    'type'     => 'radio',
		'choices'  => array(
			'default' => __('Default', 'xmag-plus'),
			'fullwidth' => __('Full width (images must be at least 1140px)', 'xmag-plus'),
	) ) );
	
	// Page Options
	$wp_customize->add_setting( 'page_options', array(
        'sanitize_callback' => 'sanitize_text_field',
    ) );
	
	$wp_customize->add_control( new Xmag_Custom_Content( $wp_customize, 'page_options', array(
		'label'      => __( 'Page Options', 'xmag-plus' ),
		'section'  => 'xmag_page_section',
	) ) );
	
	$wp_customize->add_setting( 'xmag_enable_page_breadcrumb', array(
        'default' => '',
        'type' => 'option',
		'capability' => 'edit_theme_options',
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'xmag_enable_page_breadcrumb', array(
	    'label'    => __( 'Display Page breadcrumbs', 'xmag-plus' ),
	    'section'  => 'xmag_page_section',
	    'type'     => 'checkbox',
	) );
	
	// WooCommerce - Shop
	$wp_customize->add_setting( 'shop_layout', array(
		'default' => 'shop-sidebar',
		'sanitize_callback' => 'xmag_sanitize_choices',
	) );
	
	$wp_customize->add_control( 'shop_layout', array(
		'type' => 'select',
		'label' => __( 'Shop and Product Category Layout', 'xmag-plus' ),
		'section' => 'woocommerce_section',
		'choices' => array(
		'shop-sidebar' => __( 'Sidebar', 'xmag-plus' ),
		'shop-fullwidth' => __( 'Fullwidth', 'xmag-plus' )
	) ) );
	
	//  WooCommerce - Page Product
	$wp_customize->add_setting( 'product_layout', array(
		'default' => 'product-fullwidth',
		'sanitize_callback' => 'xmag_sanitize_choices',
	) );
	
	$wp_customize->add_control( 'product_layout', array(
		'type' => 'select',
		'label' => __( 'Page Product Layout', 'xmag-plus' ),
		'section' => 'woocommerce_section',
		'choices' => array(
		'product-sidebar' => __( 'Sidebar', 'xmag-plus' ),
		'product-fullwidth' => __( 'Fullwidth', 'xmag-plus' )
	) ) );
	
	//  WooCommerce - Cart Link
	$wp_customize->add_setting( 'show_cart_main_navbar', array(
        'default' => '',
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'show_cart_main_navbar', array(
	    'type'     => 'checkbox',
	    'label'    => __( 'Display Cart Link in the Main Navbar', 'xmag-plus' ),
	    'section' => 'woocommerce_section',
	) );
	
	$wp_customize->add_setting( 'woo_button_color', array(
		'default' => '#222222',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'woo_button_color', array(
		'label' => __( 'Buttons Background Color', 'xmag-plus' ),
		'description' => __( 'Add to cart and Checkout Background Color', 'xmag-plus' ),
		'section' => 'woocommerce_section',
	) ) );
	
    // AD
	$wp_customize->add_setting('xmag_ads_header', array(
		'default' => '',
		'sanitize_callback' => 'xmag_js_sanitize',
	) );
	
	$wp_customize->add_control( 'xmag_ads_header', array(
		'label' => __('Header Ad Code', 'xmag-plus'),
		'section' => 'xmag_ads_section',
		'type' => 'textarea',
	) );
	
	$wp_customize->add_setting('xmag_ads_above_content', array(
		'default' => '',
		'sanitize_callback' => 'xmag_js_sanitize',
	) );
	
	$wp_customize->add_control( 'xmag_ads_above_content', array(
		'label' => __('Above Post Content Ad Code', 'xmag-plus'),
		'section' => 'xmag_ads_section',
		'type' => 'textarea',
	) );
	
	$wp_customize->add_setting('xmag_ads_below_content', array(
		'default' => '',
		'sanitize_callback' => 'xmag_js_sanitize',
	) );
	
	$wp_customize->add_control( 'xmag_ads_below_content', array(
		'label' => __('Below Post Content Ad Code', 'xmag-plus'),
		'section' => 'xmag_ads_section',
		'type' => 'textarea',
	) );
	
	$wp_customize->add_setting('xmag_ads_sidebar', array(
		'default' => '',
		'sanitize_callback' => 'xmag_js_sanitize',
	) );
	
	$wp_customize->add_control( 'xmag_ads_sidebar', array(
		'label' => __('Sidebar Ad Code (300x250)', 'xmag-plus'),
		'section' => 'xmag_ads_section',
		'type' => 'textarea',
	) );

	// Custom Css
	$wp_customize->add_setting( 'xmag_custom_css', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	
	$wp_customize->add_control( 'xmag_custom_css', array(
		'label' => __('Custom CSS', 'xmag-plus'),
		'description' => __('Your Custom CSS was migrated to the Additional CSS (part of the WordPress core now)', 'xmag-plus'),
		'section' => 'xmag_custom_css_section',
		'type' => 'textarea',
		'readonly' => true,
	) );
	
	// Magazine - General
	$wp_customize->add_setting( 'xmag_magazine', array(
        'default' => '',
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'xmag_magazine', array(
	    'label'    => __( 'Enable Magazine Homepage', 'xmag-plus' ),
	    'description' => __( 'Check this option to display Magazine Template. You can also apply Magazine Template to a custom Page.', 'xmag-plus' ),
	    'section'  => 'magazine_options',
	    'type'     => 'checkbox',
	) );
	
	$wp_customize->add_setting( 'xmag_duplicate_posts', array(
        'default' => '',
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'xmag_duplicate_posts', array(
	    'label'    => __( 'Avoid duplicate posts', 'xmag-plus' ),
	    'description' => __( 'Enable this option to filter posts displayed in the Post Slider.', 'xmag-plus' ),
	    'section'  => 'magazine_options',
	    'type'     => 'checkbox',
	) );
	
	$wp_customize->add_setting( 'magazine_view_all', array(
        'default' => 1,
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'magazine_view_all', array(
	    'label'    => __( 'Display View All link', 'xmag-plus' ),
	    'section'  => 'magazine_options',
	    'type'     => 'checkbox',
	) );
	
	$wp_customize->add_setting( 'magazine_read_more', array(
        'default' => 1,
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'magazine_read_more', array(
	    'label'    => __( 'Display Read More link', 'xmag-plus' ),
	    'section'  => 'magazine_options',
	    'type'     => 'checkbox',
	) );
	
	// Magazine - Top Section
	$wp_customize->add_setting( 'show_block7', array(
        'default' => '',
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'show_block7', array(
	    'label'    => __( 'Display Posts at the top of the Magazine Template.', 'xmag-plus' ),
	    'section'  => 'magazine_block7',
	    'type'     => 'checkbox',
	) );
	
	$wp_customize->add_setting('block7_category', array(
	    'default' => '',
	    'type' => 'option',
	    'capability' => 'edit_theme_options',
	    'sanitize_callback' => 'xmag_sanitize_choices',
	) );
	
	$wp_customize->add_control('block7_category', array(
	    'description' => __('Select a Category', 'xmag-plus'),
	    'section'  => 'magazine_block7',
	    'type'    => 'select',
	    'choices'    => $blog_categories
	) );
	
	$wp_customize->add_setting( 'block7_posts_number', array(
		'default' => '3',
		'sanitize_callback' => 'xmag_sanitize_choices',
	) );
	
	$wp_customize->add_control( 'block7_posts_number', array(
		'description' => __( 'Select how many Posts to display', 'xmag-plus' ),
		'section'  => 'magazine_block7',
		'type' => 'select',
		'choices' => array(
			'3' => ( '3' ),
			'6' => ( '6' ),
	) ) );
	
	// Magazine - Section 1
	$wp_customize->add_setting( 'show_block1', array(
        'default' => 1,
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'show_block1', array(
	    'label'    => __( 'Display Section 1', 'xmag-plus' ),
	    'section'  => 'magazine_block1',
	    'type'     => 'checkbox',
	) );
	
	$wp_customize->add_setting('block1_category', array(
	    'default' => '',
	    'type' => 'option',
	    'capability' => 'edit_theme_options',
	    'sanitize_callback' => 'xmag_sanitize_choices',
	) );
	$wp_customize->add_control('block1_category', array(
	    'description' => __('Select a Category', 'xmag-plus'),
	    'section'  => 'magazine_block1',
	    'type'    => 'select',
	    'choices'    => $blog_categories
	) );
	
	// Magazine - Section 2
	$wp_customize->add_setting( 'show_block2', array(
        'default' => 1,
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'show_block2', array(
	    'label'    => __( 'Display Section 2', 'xmag-plus' ),
	    'section'  => 'magazine_block2',
	    'type'     => 'checkbox',
	) );
	
	$wp_customize->add_setting('block2_category', array(
	    'default' => '',
	    'type' => 'option',
	    'capability' => 'edit_theme_options',
	    'sanitize_callback' => 'xmag_sanitize_choices',
	) );
	
	$wp_customize->add_control('block2_category', array(
	    'description' => __('Select a Category', 'xmag-plus'),
	    'section'  => 'magazine_block2',
	    'type'    => 'select',
	    'choices'    => $blog_categories
	) );

	$wp_customize->add_setting( 'block2_posts_number', array(
		'default' => '4',
		'sanitize_callback' => 'xmag_sanitize_choices',
	) );
	
	$wp_customize->add_control( 'block2_posts_number', array(
		'description' => __( 'Select how many Posts to display', 'xmag-plus' ),
		'section'  => 'magazine_block2',
		'type' => 'select',
		'choices' => array(
			'2' => ( '2' ),
			'4' => ( '4' ),
			'6' => ( '6' ),
	) ) );
	
	// Magazine - Section 3
	$wp_customize->add_setting( 'show_block3', array(
        'default' => 1,
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'show_block3', array(
	    'label'    => __( 'Display Section 3', 'xmag-plus' ),
	    'section'  => 'magazine_block3',
	    'type'     => 'checkbox',
	) );
	
	$wp_customize->add_setting('block3_category', array(
	    'default' => '',
	    'type' => 'option',
	    'capability' => 'edit_theme_options',
	    'sanitize_callback' => 'xmag_sanitize_choices',
	) );
	
	$wp_customize->add_control('block3_category', array(
	    'description' => __('Select a Category', 'xmag-plus'),
	    'section'  => 'magazine_block3',
	    'type'    => 'select',
	    'choices'    => $blog_categories
	) );
	
	$wp_customize->add_setting( 'block3_posts_number', array(
		'default' => '4',
		'sanitize_callback' => 'xmag_sanitize_choices',
	) );
	
	$wp_customize->add_control( 'block3_posts_number', array(
		'description' => __( 'Select how many Posts to display', 'xmag-plus' ),
		'section'  => 'magazine_block3',
		'type' => 'select',
		'choices' => array(
			'4' => ( '4' ),
			'6' => ( '6' ),
			'8' => ( '8' ),
			'10' => ( '10' ),
	) ) );
	
	// Magazine - Section 4
	$wp_customize->add_setting( 'show_block4', array(
        'default' => '',
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'show_block4', array(
	    'label'    => __( 'Display Block 4', 'xmag-plus' ),
	    'section'  => 'magazine_block4',
	    'type'     => 'checkbox',
	) );
	
	$wp_customize->add_setting('block4_category', array(
	    'default' => '',
	    'type' => 'option',
	    'capability' => 'edit_theme_options',
	    'sanitize_callback' => 'xmag_sanitize_choices',
	) );
	
	$wp_customize->add_control('block4_category', array(
	    'description' => __('Select a Category', 'xmag-plus'),
	    'section'  => 'magazine_block4',
	    'type'    => 'select',
	    'choices'    => $blog_categories
	) );
	
	$wp_customize->add_setting( 'block4_posts_number', array(
		'default' => '4',
		'sanitize_callback' => 'xmag_sanitize_choices',
	) );
	
	$wp_customize->add_control( 'block4_posts_number', array(
		'description' => __( 'Select how many Posts to display', 'xmag-plus' ),
		'section'  => 'magazine_block4',
		'type' => 'select',
		'choices' => array(
			'4' => ( '4' ),
			'8' => ( '8' ),
	) ) );
	
	// Magazine - Section 5
	$wp_customize->add_setting( 'show_block5', array(
        'default' => '',
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'show_block5', array(
	    'label'    => __( 'Display Section 5', 'xmag-plus' ),
	    'section'  => 'magazine_block5',
	    'type'     => 'checkbox',
	) );
	
	$wp_customize->add_setting('block5_category', array(
	    'default' => '',
	    'type' => 'option',
	    'capability' => 'edit_theme_options',
	    'sanitize_callback' => 'xmag_sanitize_choices',
	) );
	
	$wp_customize->add_control('block5_category', array(
	    'description' => __('Select a Category', 'xmag-plus'),
	    'section'  => 'magazine_block5',
	    'type'    => 'select',
	    'choices'    => $blog_categories
	) );
	
	// Magazine - Section 6
	$wp_customize->add_setting( 'show_block6', array(
        'default' => '',
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'show_block6', array(
	    'label'    => __( 'Display Section 6', 'xmag-plus' ),
	    'section'  => 'magazine_block6',
	    'type'     => 'checkbox',
	) );
	
	$wp_customize->add_setting('block6_category', array(
	    'default' => '',
	    'type' => 'option',
	    'capability' => 'edit_theme_options',
	    'sanitize_callback' => 'xmag_sanitize_choices',
	) );
	
	$wp_customize->add_control('block6_category', array(
	    'description' => __('Select a Category', 'xmag-plus'),
	    'section'  => 'magazine_block6',
	    'type'    => 'select',
	    'choices'    => $blog_categories
	) );
	
	$wp_customize->add_setting( 'block6_posts_number', array(
		'default' => '2',
		'sanitize_callback' => 'xmag_sanitize_choices',
	) );
	
	$wp_customize->add_control( 'block6_posts_number', array(
		'description' => __( 'Select how many Posts to display', 'xmag-plus' ),
		'section'  => 'magazine_block6',
		'type' => 'select',
		'choices' => array(
			'2' => ( '2' ),
			'4' => ( '4' ),
			'6' => ( '6' ),
	) ) );

	// Accent Color
	$wp_customize->add_setting( 'accent_color', array(
		'default' => '#e54e53',
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_color', array(
		'label' => __( 'Accent Color', 'xmag-plus' ),
		'section' => 'colors_general',
		'priority' => 2,
	) ) );
	
	// Text
	$wp_customize->add_setting( 'text_color', array(
		'default' => '#555555',
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'text_color', array(
		'label' => __( 'Text', 'xmag-plus' ),
		'section' => 'colors_general',
		'priority' => 3,
	) ) );
	
	// Page/Post Title
	$wp_customize->add_setting( 'single_title_color', array(
		'default' => '#222222',
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'single_title_color', array(
		'label' => __( 'Page/Post Title', 'xmag-plus' ),
		'section' => 'colors_general',
		'priority' => 4,
	) ) );
	
	// Page/Post Text
	$wp_customize->add_setting( 'single_text_color', array(
		'default' => '#333333',
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'single_text_color', array(
		'label' => __( 'Page/Post Text', 'xmag-plus' ),
		'section' => 'colors_general',
		'priority' => 5,
	) ) );
	
	// Header Background
	$wp_customize->add_setting( 'header_background', array(
		'default' => '#ffffff',
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_background', array(
		'label' => __( 'Header Background', 'xmag-plus' ),
		'section' => 'colors_header',
		'priority' => 1,
	) ) );
	
	// Site Tagline Color
	$wp_customize->add_setting( 'site_tagline_color', array(
		'default' => '#777777',
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'site_tagline_color', array(
		'label' => __( 'Site Tagline', 'xmag-plus' ),
		'section' => 'colors_header',
		'priority' => 3,
	) ) );

	// Footer Background
	$wp_customize->add_setting( 'footer_background', array(
		'default' => '',
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_background', array(
		'label' => __( 'Footer Background', 'xmag-plus' ),
		'section' => 'colors_footer',
	) ) );

	// Mobile Menu Background
	$wp_customize->add_setting( 'mobile_menu_background', array(
		'default' => '#000000',
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mobile_menu_background', array(
		'label' => __( 'Mobile Menu Background', 'xmag-plus' ),
		'section' => 'colors_mobile',
	) ) );	
	
}
add_action('customize_register', 'xmag_theme_customizer');


/**
 * Sanitize Checkbox
 *
 */ 
function xmag_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}


/**
 * Sanitize Radio Buttons and Select Lists
 *
 */
function xmag_sanitize_choices( $input, $setting ) {
    global $wp_customize;
    $control = $wp_customize->get_control( $setting->id );
 
    if ( array_key_exists( $input, $control->choices ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}


/**
 * Sanitizes text: only <strong>, <em>, <b>, <i>, <br> and <a> tags.
 *
 */
function xmag_sanitize_html( $text ) {
    $args = array(
    //formatting
    'strong' => array(),
    'em'     => array(),
    'b'      => array(),
    'i'      => array(),
    'br'      => array(),
    //links
    'a'     => array(
        'href' => array()
    )
	);
    return wp_kses( $text, $args );
}


/**
 * Js Sanitize
 *
 */
function xmag_js_sanitize( $value ) {
	return $value;
}


/**
 * Checks Main Menu Style.
 */
function xmag_has_custom_menu( $control ) {
    if ( $control->manager->get_setting('xmag_menu_style')->value() == 'custom' ) {
		return true;
    } else {
        return false;
    }
}


/**
 * Checks if Post has Featured Image.
 */
function xmag_post_has_featured_image( $control ) {
    if ( $control->manager->get_setting('xmag_post_featured_image')->value() == 1 ) {
		return true;
    } else {
        return false;
    }
}


/**
 * Checks is Page has Featured Image.
 */
function xmag_page_has_featured_image( $control ) {
    if ( $control->manager->get_setting('xmag_page_featured_image')->value() == 1 ) {
		return true;
    } else {
        return false;
    }
}


/**
 * Checks if WooCommerce is active.
 */
function xmag_woocommerce( $control ) {
    if ( xmag_is_woocommerce_active() ) {
    	return true;
    } else { 
	    return false;
    }
}

/**
 * Checks if Slider Autoplay is enabled.
 */
function xmag_autoplay_on( $control ) {
    if ( $control->manager->get_setting('slider_autoplay')->value() == 1 ) {
		return true;
    } else {
        return false;
    }
}

/**
 * Checks if Google Fonts are enabled or not.
 */
function xmag_google_fonts_on( $control ) {
    if ( $control->manager->get_setting('google_fonts')->value() == 1 ) {
		return true;
    } else {
        return false;
    }
}
