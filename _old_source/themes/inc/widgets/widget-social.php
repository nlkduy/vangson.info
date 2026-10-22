<?php
/**
 * Plugin Name: Social Widget
 * Version: 1.0.5
 */

if( ! class_exists( 'DesignLab_Social' ) ) :
	class DesignLab_Social extends WP_Widget {
	
		/**
		 * Register widget with WordPress
		 */
		public function __construct() {
			//global $wid, $wname;
			parent::__construct(
				'designlab_social', // Base ID
				'Design Lab: Social Icons', // Name
				array( 'description' => __( 'Add your social icons', 'xmag-plus' ), ) // Args
			);
		}
	
		/**
		 *  Display the widget in the theme
		 */
		function widget( $args, $instance ) {
			extract( $args );
						
			$title = apply_filters( 'widget_title', $instance['title'] );
			
			if ( ! empty( $instance['googleplus_url'] ) ) {
				$googleplus_url = apply_filters( 'widget_googleplus_url', $instance['googleplus_url'] );
			}
			
			if ( ! empty( $instance['facebook_url'] ) ) {
				$facebook_url = apply_filters( 'widget_facebook_url', $instance['facebook_url'] );
			}
			
			if ( ! empty( $instance['instagram_url'] ) ) {
				$instagram_url = apply_filters( 'widget_instagram_url', $instance['instagram_url'] );
			}
			
			if ( ! empty( $instance['linkedin_url'] ) ) {
				$linkedin_url = apply_filters( 'widget_linkedin_url', $instance['linkedin_url'] );
			}
			
			if ( ! empty( $instance['pinterest_url'] ) ) {
				$pinterest_url = apply_filters( 'widget_pinterest_url', $instance['pinterest_url'] );
			}
			
			if ( ! empty( $instance['twitter_url'] ) ) {
				$twitter_url = apply_filters( 'widget_twitter_url', $instance['twitter_url'] );
			}
			
			if ( ! empty( $instance['youtube_url'] ) ) {
				$youtube_url = apply_filters( 'widget_youtube_url', $instance['youtube_url'] );
			}

			echo $before_widget;
			
			if ( ! empty( $title ) ) {
				echo $before_title . $title . $after_title;
			}
			
			echo '<ul class="designlab-social-links">';
			
			if ( ! empty( $facebook_url ) ) { echo  '<li><a href=" '. $facebook_url .'" class="facebook-link" target="_blank" rel="nofollow">'. '<span class="icon-facebook"></span>' .'</a></li>'; }
			if ( ! empty( $twitter_url ) ) { echo  '<li><a href=" '. $twitter_url .'" class="twitter-link" target="_blank" rel="nofollow">'. '<span class="icon-twitter"></span>' .'</a></li>'; }
			if ( ! empty( $googleplus_url ) ) { echo  '<li><a href=" '. $googleplus_url .'" class="googleplus-link" target="_blank" rel="nofollow">'. '<span class="icon-googleplus"></span>' .'</a></li>'; }
			if ( ! empty( $linkedin_url ) ) { echo  '<li><a href=" '. $linkedin_url .'" class="linkedin-link" target="_blank" rel="nofollow">'. '<span class="icon-linkedin"></span>' .'</a></li>'; }
			if ( ! empty( $instagram_url ) ) { echo  '<li><a href=" '. $instagram_url .'" class="instagram-link" target="_blank" rel="nofollow">'. '<span class="icon-instagram"></span>' .'</a></li>'; }
			if ( ! empty( $pinterest_url ) ) { echo  '<li><a href=" '. $pinterest_url .'" class="pinterest-link" target="_blank" rel="nofollow">'. '<span class="icon-pinterest"></span>' .'</a></li>'; }
			if ( ! empty( $youtube_url ) ) { echo  '<li><a href=" '. $youtube_url .'" class="youtube-link" target="_blank" rel="nofollow">'. '<span class="icon-youtube"></span>' .'</a></li>'; }
			echo '</ul>';
			
			echo $after_widget;
		}
		
		/**
		 *  Update the widget when new options have been entered
		 */
		function update($new_instance, $old_instance) {
	
			$instance = $old_instance;
	
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['twitter_url'] = strip_tags($new_instance['twitter_url']);
			$instance['facebook_url'] = strip_tags($new_instance['facebook_url']);
			$instance['googleplus_url'] = strip_tags($new_instance['googleplus_url']);
			$instance['linkedin_url'] = strip_tags($new_instance['linkedin_url']);
			$instance['instagram_url'] = strip_tags($new_instance['instagram_url']);
			$instance['pinterest_url'] = strip_tags($new_instance['pinterest_url']);
			$instance['youtube_url'] = strip_tags($new_instance['youtube_url']);
			
			return $instance;
		}
		
		/**
		 * Back-end widget form
		 */
		function form($instance) {
	
			$instance = wp_parse_args(
			(array) $instance, array( 
				'title'				=> '',
				'facebook_url' 		=> '',
				'twitter_url' 		=> '',
				'googleplus_url' 	=> '',
				'linkedin_url' 		=> '',
				'instagram_url' 	=> '',
				'pinterest_url' 	=> '',
				'youtube_url' 		=> ''
			) );
	
			$title = strip_tags($instance['title']);	
			$twitter_url = strip_tags($instance['twitter_url']);
			$facebook_url = strip_tags($instance['facebook_url']);
			$googleplus_url = strip_tags($instance['googleplus_url']);
			$linkedin_url = strip_tags($instance['linkedin_url']);
			$instagram_url = strip_tags($instance['instagram_url']);
			$pinterest_url = strip_tags($instance['pinterest_url']);
			$youtube_url = strip_tags($instance['youtube_url']);
	
	?>
	
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'xmag-plus' ); ?> 
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('facebook_url'); ?>"><?php _e( 'Facebook URL:', 'xmag-plus' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id('facebook_url'); ?>" name="<?php echo $this->get_field_name('facebook_url'); ?>" type="text" value="<?php echo esc_attr($facebook_url); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('twitter_url'); ?>"><?php _e( 'Twitter  URL:', 'xmag-plus' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id('twitter_url'); ?>" name="<?php echo $this->get_field_name('twitter_url'); ?>" type="text" value="<?php echo esc_attr($twitter_url); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('googleplus_url'); ?>"><?php _e( 'Google+ URL:', 'xmag-plus' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id('googleplus_url'); ?>" name="<?php echo $this->get_field_name('googleplus_url'); ?>" type="text" value="<?php echo esc_attr($googleplus_url); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('linkedin_url'); ?>"><?php _e( 'LinkedIn URL:', 'xmag-plus' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id('linkedin_url'); ?>" name="<?php echo $this->get_field_name('linkedin_url'); ?>" type="text" value="<?php echo esc_attr($linkedin_url); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('instagram_url'); ?>"><?php _e( 'Instagram URL:', 'xmag-plus' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id('instagram_url'); ?>" name="<?php echo $this->get_field_name('instagram_url'); ?>" type="text" value="<?php echo esc_attr($instagram_url); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('pinterest_url'); ?>"><?php _e( 'Pinterest URL:', 'xmag-plus' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id('pinterest_url'); ?>" name="<?php echo $this->get_field_name('pinterest_url'); ?>" type="text" value="<?php echo esc_attr($pinterest_url); ?>" />
			</label>
		</p>	
		<p>
			<label for="<?php echo $this->get_field_id('youtube_url'); ?>"><?php _e( 'YouTube URL:', 'xmag-plus' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id('youtube_url'); ?>" name="<?php echo $this->get_field_name('youtube_url'); ?>" type="text" value="<?php echo esc_attr($youtube_url); ?>" />
			</label>
		</p>	
	<?php
	
		}
	
	}
endif;


// Register the widget
function xmag_register_social_widget() {
	register_widget( 'DesignLab_Social' );
}

add_action( 'widgets_init', 'xmag_register_social_widget' );
