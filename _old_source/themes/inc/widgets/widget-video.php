<?php
/**
 * Plugin Name: Video Widget
 * Version: 1.0.4
 */

if( ! class_exists( 'DesignLab_Video' ) ) :
	class DesignLab_Video extends WP_Widget {

		/**
		 * Register widget with WordPress
		 */
		public function __construct() {
			//global $wid, $wname;
			parent::__construct(
				'designlab_video', // Base ID
				'Design Lab: Video', // Name
				array( 'description' => __( 'Deprecated. Please use WordPress Video Widget.', 'xmag-plus' ), ) // Args
			);
		}

		/**
		 *  Update the widget when new options have been entered
		 */
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['video_url'] = strip_tags($new_instance['video_url']);
			$instance['video_description'] = strip_tags($new_instance['video_description']);
			return $instance;
		}
		
		/**
		 * Back-end widget form.
		 */
		function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, array( 'title' => 'Video', 'id' => '', 'video_url' => '', 'video_description' => '' ) );
			$title = strip_tags($instance['title']);
			$video_url = strip_tags($instance['video_url']);
			$video_description = strip_tags($instance['video_description']); ?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>">
				<?php _e('Title:', 'xmag-plus'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('video_url'); ?>">
				<?php _e('Video URL ', 'xmag-plus'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('video_url'); ?>" name="<?php echo $this->get_field_name('video_url'); ?>" type="text" value="<?php echo esc_attr($video_url); ?>" />
				<span style="display:block;padding:5px 0" class="description"><?php _e('Enter in a video URL that is compatible with WordPress\'s built-in oEmbed feature.', 'xmag-plus'); ?> <a href="http://codex.wordpress.org/Embeds" target="_blank"><?php _e('Learn More', 'xmag-plus'); ?></a></span>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('video_description'); ?>">
				<?php _e('Description', 'xmag-plus'); ?></label>
				<textarea rows="5" class="widefat" id="<?php echo $this->get_field_id('video_description'); ?>" name="<?php echo $this->get_field_name('video_description'); ?>" type="text"><?php echo stripslashes($instance['video_description']); ?></textarea>
			</p>
			
		<?php }
		
		/**
		 *  Display the widget in the theme
		 */
		function widget($args, $instance) {
			extract( $args );
			
			//before widget hook
			echo $before_widget;
			
			//show widget title
			$title = apply_filters( 'widget_title', $instance['title'] );
			if ( $title )
				echo $before_title . $title . $after_title;
			
			// define video height and width
			$video_size = array(
				'width' => 270
			);
			
			// Show video
			if( $instance['video_url'] )  {
				echo '<div class="widget-video-embed">' . wp_oembed_get( $instance['video_url'], $video_size ) . '</div>';
			}
			// Display error message
			else { 
				_e( 'You forgot to enter a video URL.', 'xmag-plus' );
			}
			
			// show video description if field isn't empty
			if( $instance['video_description'] )
				echo '<div class="widget-video-description">'. $instance['video_description']. '</div>';
			echo $after_widget;
		}
		
	}
endif;


// Register the widget
function xmag_register_video_widget() {
	register_widget( 'DesignLab_Video' );
}

add_action( 'widgets_init', 'xmag_register_video_widget' );
