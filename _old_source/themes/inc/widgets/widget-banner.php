<?php
/**
 * Plugin Name: Banner Widget
 * Version: 1.0.2
 */
if( ! class_exists( 'DesignLab_Banner' ) ) :
	class DesignLab_Banner extends WP_Widget {
		/**
		 * Register widget with WordPress
		 */
		public function __construct() {
			parent::__construct(
		 		'designlab_banner', // Base ID
				'Design Lab: Banner', // Name
				array( 'description' => __( 'Add a Banner (300x250) to your Sidebar', 'xmag-plus' ), ) // Args
			);
		}

		/**
		 *  Update the widget when new options have been entered
		 */
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			if ( current_user_can('unfiltered_html') )
				$instance['banner_code'] =  $new_instance['banner_code'];
			else
				$instance['banner_code'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['banner_code']) ) );
			return $instance;
		}

		/**
		 * Back-end widget form.
		 */
		function form($instance) {
			$defaults = array( 
					'banner_code' => ''
				);
			
			$instance = wp_parse_args( (array) $instance, $defaults );
			
			$banner_code = esc_textarea($instance['banner_code']);	
			?>

			<p>
				<label><?php _e( 'Banner 300x250', 'xmag-plus' ); ?></label>
				<textarea class="widefat" rows="8" cols="20" id="<?php echo $this->get_field_id('banner_code'); ?>" name="<?php echo $this->get_field_name('banner_code'); ?>"><?php echo $banner_code; ?></textarea>
			</p>
			
			<?php
			
		}

		/**
		 *  Display the widget in the theme
		 */
		function widget( $args, $instance ) {
		extract( $args );
		$banner_code = empty( $instance['banner_code'] ) ? '' : $instance['banner_code'];
		
		echo $before_widget."\n";
		
		?>
		
		<?php if( !empty( $banner_code ) ) { ?>
			<?php echo $banner_code; ?>
		<?php
		}

		echo $after_widget."\n";
		}

	}
endif;

// Register the widget
function xmag_register_banner_widget() {
	register_widget( 'DesignLab_Banner' );
}

add_action( 'widgets_init', 'xmag_register_banner_widget' );