<?php
/**
 * Template for displaying search forms in xMag
 *
 * @package xMag
 * @since xMag 1.0
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php _ex( 'Search for:', 'label', 'xmag-plus' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'xmag-plus' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	</label>
	<button type="submit" class="search-submit"><span class="sli icon-magnifier"></span> <span class="screen-reader-text"><?php _ex( 'Search', 'submit button', 'xmag-plus' ); ?></span></button>
</form>