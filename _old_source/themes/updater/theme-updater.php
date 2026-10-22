<?php
/**
 * Easy Digital Downloads Theme Updater
 *
 * @package EDD Sample Theme
 */

// Includes the files needed for the theme updater
if ( !class_exists( 'EDD_Theme_Updater_Admin' ) ) {
	include( dirname( __FILE__ ) . '/theme-updater-admin.php' );
}

// Loads the updater classes
$updater = new EDD_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => 'https://www.designlabthemes.com', // Site where EDD is hosted
		'item_name'      => 'xMag Plus', // Name of theme
		'theme_slug'     => 'xmag-plus', // Theme slug
		'version'        => '1.3.8', // The current version of this theme
		'author'         => 'Design Lab Themes', // The author of this theme
		'download_id'    => '5621', // Optional, used for generating a license renewal link
		'renew_url'      => '', // Optional, allows for a custom license renewal link
		'beta'           => false, // Optional, set to true to opt into beta versions
	),

	// Strings
	$strings = array(
		'theme-license'             => __( 'Theme License', 'xmag-plus' ),
		'enter-key'                 => __( 'Enter your theme license key.', 'xmag-plus' ),
		'license-key'               => __( 'License Key', 'xmag-plus' ),
		'license-action'            => __( 'License Action', 'xmag-plus' ),
		'deactivate-license'        => __( 'Deactivate License', 'xmag-plus' ),
		'activate-license'          => __( 'Activate License', 'xmag-plus' ),
		'status-unknown'            => __( 'License status is unknown.', 'xmag-plus' ),
		'renew'                     => __( 'Renew?', 'xmag-plus' ),
		'unlimited'                 => __( 'unlimited', 'xmag-plus' ),
		'license-key-is-active'     => __( 'License key is active.', 'xmag-plus' ),
		'expires%s'                 => __( 'Expires %s.', 'xmag-plus' ),
		'expires-never'             => __( 'Lifetime License.', 'xmag-plus' ),
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'xmag-plus' ),
		'license-key-expired-%s'    => __( 'License key expired %s.', 'xmag-plus' ),
		'license-key-expired'       => __( 'License key has expired.', 'xmag-plus' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'xmag-plus' ),
		'license-is-inactive'       => __( 'License is inactive.', 'xmag-plus' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'xmag-plus' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'xmag-plus' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'xmag-plus' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'xmag-plus' ),
		'update-available'          => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'xmag-plus' ),
	)

);
