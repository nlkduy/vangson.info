<?php
/**
 * Create Getting Started Page Menu Item.
 */
function xmag_admin_menu() {
	add_theme_page( 'Getting Started', 'Getting Started', 'manage_options', 'getting_started.php', 'xmag_started', 100  );
}
add_action( 'admin_menu', 'xmag_admin_menu' );

/**
 * Register and enqueue a custom stylesheet in the WordPress admin.
 */
function xmag_admin_style($hook) {
	if ( 'appearance_page_getting_started' !== $hook ) {
	return;
    }
	wp_enqueue_style( 'xmag-dashboard-style', get_template_directory_uri() . '/inc/css/dashboard-style.css' );
}
add_action('admin_enqueue_scripts', 'xmag_admin_style');


function xmag_started() { ?>

	<div class="wrap about-wrap full-width-layout">
		<section class="dl-getting-started">

			<h1><?php _e('Getting started', 'xmag-plus'); ?></h1>
			<p class="about-text">
				<?php
				$my_theme = wp_get_theme();
				printf(
				__( 'Thanks for purchasing %s Theme!', 'xmag-plus' ),
				$my_theme->get( 'Name' )
				); ?>
			</p>

			<div class="dl-row">
				<div class="dl-column dl-col-sm-6 dl-col-4">
					<div class="dl-content">
						<span class="dashicons dashicons-admin-network large-icon"></span>
						<h3><?php _e('Theme License', 'xmag-plus'); ?></h3>
						<p>
							<?php _e('Activate your license key to get one-click theme updates and premium support.', 'xmag-plus'); ?>
						</p>
						<p>
							<?php printf(
							__( 'You can find your Theme license in the Purchase Receipt or you can <a href="%s" target="_blank">log in to your Design Lab account</a> and go to "My Account &raquo; License Keys" page.', 'xmag-plus' ),
							esc_url( 'https://www.designlabthemes.com/wp-login.php' )
							); ?>
						</p>
						<p><a class="button" href="<?php echo admin_url( 'themes.php?page=xmag-plus-license' ); ?>"><?php _e('Activate Theme License', 'xmag-plus'); ?></a></p>
					</div>
				</div>
				<div class="dl-column dl-col-sm-6 dl-col-4">
					<div class="dl-content">
						<span class="dashicons dashicons-book large-icon"></span>
						<h3><?php _e('Documentation', 'xmag-plus'); ?></h3>
						<p>
							<?php printf(
							__( 'Follow our <a href="%s" target="_blank">documentation</a> to get your new theme set up.', 'xmag-plus' ),
							esc_url( 'https://designlabthemes.com/xmag-documentation/?utm_source=getting_started_page&utm_medium=wordpress_dashboard&utm_campaign=xmag_plus_getting_started' )
							); ?>
						</p>
						<p>
							<?php printf(
							__( 'Optionally, you may <a href="%s" target="_blank">install our demo content</a> to give you a head start in setting up your site.', 'xmag-plus' ),
							esc_url( 'https://www.designlabthemes.com/import-demo-content-wordpress/?utm_source=getting_started_page&utm_medium=wordpress_dashboard&utm_campaign=xmag_plus_getting_started' )
							); ?>
						<p>
							<a class="button" href="<?php echo esc_url( 'https://designlabthemes.com/xmag-documentation/?utm_source=getting_started_page&utm_medium=wordpress_dashboard&utm_campaign=xmag_plus_getting_started' ); ?>" target="_blank"><?php _e('Theme Documentation', 'xmag-plus'); ?></a>
						</p>
					</div>
				</div>
				<div class="dl-column dl-col-sm-6 dl-col-4">
					<div class="dl-content">
						<span class="dashicons dashicons-sos large-icon"></span>
						<h3><?php _e('Support Ticket', 'xmag-plus'); ?></h3>
						<p><?php _e('Have a problem? We are here to help with direct and personal support!', 'xmag-plus'); ?></p>
						<p>
							<?php printf(
							__( 'Perhaps you have encountered a common issue or have a quick question: please <a href="%s" target="_blank">visit our FAQs</a>', 'xmag-plus' ),
							esc_url( 'https://www.designlabthemes.com/faq/?utm_source=getting_started_page&utm_medium=wordpress_dashboard&utm_campaign=the_box_plus_getting_started' )
							); ?>
						<p>
						<p>
							<a class="button" href="<?php echo esc_url( 'https://designlabthemes.com/support/?utm_source=getting_started_page&utm_medium=wordpress_dashboard&utm_campaign=xmag_plus_getting_started' ); ?>" target="_blank"><?php _e('Submit a Support Ticket', 'xmag-plus'); ?></a>
						</p>
					</div>
				</div>
			</div>

		</section>
	</div>

<?php }
