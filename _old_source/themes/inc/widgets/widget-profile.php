<?php
/**
 * Plugin Name: Profile Widget
 * Version: 1.0.7
 */

if( ! class_exists( 'DesignLab_Profile' ) ) :
	class DesignLab_Profile extends WP_Widget {
	
		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			parent::__construct(
		 		'designlab_profile', // Base ID
				'Design Lab: Profile', // Name
				array( 'description' => __( 'Display your Profile', 'xmag-plus' ), ) // Args
			);
	
			add_action('admin_enqueue_scripts', array($this, 'dlab_upload_scripts'));
		}
		
		public function dlab_upload_scripts() {
		wp_enqueue_media();
		}
			
		/**
		 *  Update the widget when new options have been entered
		 */
		public function update( $new_instance, $old_instance ) {
			
			$instance = wp_parse_args(
			(array) $instance, array( 
				'link_url'			=> '',
				'facebook_url' 		=> '',
				'twitter_url' 		=> '',
				'googleplus_url' 	=> '',
				'linkedin_url' 		=> '',
				'instagram_url' 	=> '',
				'pinterest_url' 	=> '',
				'youtube_url' 		=> ''
			) );
			
			$instance['title'] = strip_tags( $new_instance['title'] );
			if( $instance['image'] != strip_tags( $new_instance['image'] ) && $instance['image_id'] == strip_tags( $new_instance['image_id'] ) ) {
				$instance['image_id'] = "";
			} else {
				$instance['image_id'] = strip_tags( $new_instance['image_id'] );
			}
			$instance['image'] = strip_tags( $new_instance['image'] );
			$instance['image_size'] = strip_tags($new_instance['image_size']);
			$instance['link_url'] = esc_url( $new_instance['link_url'] );
			$instance['facebook_url'] = esc_url( $new_instance['facebook_url'] );
			$instance['googleplus_url'] = esc_url( $new_instance['googleplus_url'] );
			$instance['instagram_url'] = esc_url( $new_instance['instagram_url'] );
			$instance['linkedin_url'] = esc_url( $new_instance['linkedin_url'] );
			$instance['pinterest_url'] = esc_url( $new_instance['pinterest_url'] );
			$instance['twitter_url'] = esc_url( $new_instance['twitter_url'] );
			$instance['youtube_url'] = esc_url( $new_instance['youtube_url'] );
			
			if ( current_user_can('unfiltered_html') )
				$instance['text'] =  $new_instance['text'];
			else
				$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
			
			$instance['filter'] = isset($new_instance['filter']);
	
			return $instance;
		}
		
			
		/**
		 *  Display the widget in the Theme
		 */
		public function widget( $args, $instance ) {
			extract( $args );
			$title = apply_filters( 'widget_title', $instance['title'] );
			$text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
			
			if ( isset($instance['image'] ) && ($instance['image'] != '') ) {
				$image = $instance['image'];
			}
			$image_id = $instance['image_id'];
			$image_size = $instance['image_size'];
			
			$link_url = $instance['link_url'];
			
			if ( ! empty( $instance['facebook_url'] ) ) {
				$facebook_url = $instance['facebook_url'];
			}
			
			if ( ! empty( $instance['googleplus_url'] ) ) {
				$googleplus_url = $instance['googleplus_url'];
			}
			
			if ( ! empty( $instance['instagram_url'] ) ) {
				$instagram_url = $instance['instagram_url'];
			}
			
			if ( ! empty( $instance['linkedin_url'] ) ) {
				$linkedin_url = $instance['linkedin_url'];
			}
			
			if ( ! empty( $instance['pinterest_url'] ) ) {
				$pinterest_url = $instance['pinterest_url'];
			}
			
			if ( ! empty( $instance['twitter_url'] ) ) {
				$twitter_url = $instance['twitter_url'];
			}
			
			if ( ! empty( $instance['youtube_url'] ) ) {
				$youtube_url = $instance['youtube_url'];
			}

			echo $before_widget; ?>
			
			<div class="widget-profile clear">
			
				<?php if ( !empty( $title ) ) { 
				
					echo $before_title . $title . $after_title; 
					
				} ?>
							
				<?php if ( isset($image) ) {  
									
					if ( !empty( $link_url ) ) { 
						echo '<a href="' . $link_url . '">'; 
					}
					
					if ( $image_id != "" ) {
						echo wp_get_attachment_image( $image_id, $image_size );	
					} else {
						$id_from_url = get_attachment_id_from_url( $image );
						echo wp_get_attachment_image( $id_from_url, $image_size );
					}
					
					if ( !empty( $link_url ) ) { 
						echo '</a>'; 
					} 
					
				} ?>
	
				<div class="widget-profile-content">
					<?php echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?>
					<?php if ( !empty( $link_url ) ) { 
						echo '<a class="more-link" href="' . $link_url . '">' .__('Read more', 'xmag-plus') . '&raquo;' . '</a>'; 
					} ?>
				</div>
				
				<div class="widget-profile-social">
					<?php if ( !empty( $facebook_url ) ) { 
						echo '<a class="profile-facebook" href="' . $facebook_url . '" rel="nofollow">'; 
						echo '<span class="icon-facebook"></span>'; 
						echo '</a>'; 
					} ?>
					
					<?php if ( !empty( $twitter_url ) ) { 
						echo '<a class="profile-twitter" href="' . $twitter_url . '" rel="nofollow">'; 
						echo '<span class="icon-twitter"></span>'; 
						echo '</a>'; 
					} ?>
					
					<?php if ( !empty( $googleplus_url ) ) { 
						echo '<a class="profile-googleplus" href="' . $googleplus_url . '" rel="nofollow">'; 
						echo '<span class="icon-googleplus"></span>'; 
						echo '</a>'; 
					} ?>
					
					<?php if ( !empty( $linkedin_url ) ) { 
						echo '<a class="profile-linkedin" href="' . $linkedin_url . '" rel="nofollow">'; 
						echo '<span class="icon-linkedin"></span>'; 
						echo '</a>'; 
					} ?>
					
					<?php if ( !empty( $instagram_url ) ) { 
						echo '<a class="profile-instagram" href="' . $instagram_url . '" rel="nofollow">'; 
						echo '<span class="icon-instagram"></span>'; 
						echo '</a>'; 
					} ?>
					
					<?php if ( !empty( $pinterest_url ) ) { 
						echo '<a class="profile-pinterest" href="' . $pinterest_url . '" rel="nofollow">'; 
						echo '<span class="icon-pinterest"></span>'; 
						echo '</a>'; 
					} ?>
					
					<?php if ( !empty( $youtube_url ) ) { 
						echo '<a class="profile-youtube" href="' . $youtube_url . '" rel="nofollow">'; 
						echo '<span class="icon-youtube"></span>'; 
						echo '</a>'; 
					} ?>
				</div>
				
			</div>
	
			<?php
			echo $after_widget;
		}

		/**
		 * Back-end widget form.
		 */
		public function form( $instance ) {
	
			//Defaults
			$defaults = array( 
					'image' 			=> '',
					'image_id'			=> '',
					'image_size' 		=> 'medium',
					'title' 			=> get_bloginfo('name'),
					'text' 				=> '',
					'link_url' 			=> '',
					'facebook_url'		=> '',
					'googleplus_url'	=> '',
					'instagram_url'		=> '',
					'linkedin_url'		=> '',
					'pinterest_url'		=> '',
					'twitter_url'		=> '',
					'youtube_url'		=> ''
				);
			
			$instance = wp_parse_args( (array) $instance, $defaults );
			
			$image = esc_url($instance['image']);
			$text = esc_textarea($instance['text']);
			$link_url = esc_url($instance['link_url']);
			$facebook_url = esc_url($instance['facebook_url']);
			$googleplus_url = esc_url($instance['googleplus_url']);
			$instagram_url = esc_url($instance['instagram_url']);
			$linkedin_url = esc_url($instance['linkedin_url']);
			$pinterest_url = esc_url($instance['pinterest_url']);
			$twitter_url = esc_url($instance['twitter_url']);
			$youtube_url = esc_url($instance['youtube_url']);
			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'xmag-plus' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" />
			</p>
	
			<textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
	
			<p>
				<input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php checked(isset($instance['filter']) ? $instance['filter'] : 0); ?> />
				<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e( 'Automatically add paragraphs', 'xmag-plus' ); ?></label>
			</p>
	
			<script>
			// jQuery for image upload window
			jQuery(document).ready( function(){
			 function media_upload( button_class) {
				var _custom_media = true,
				_orig_send_attachment = wp.media.editor.send.attachment;
				jQuery('body').on('click',button_class, function(e) {
					var button_id ='#'+jQuery(this).attr('id');
					/* console.log(button_id); */
					var self = jQuery(button_id);
					var send_attachment_bkp = wp.media.editor.send.attachment;
					var button = jQuery(button_id);
					var id = button.attr('id').replace('_button', '');
					_custom_media = true;
					wp.media.editor.send.attachment = function(props, attachment){
						if ( _custom_media  ) {
						   jQuery('.custom_media_id').val(attachment.id); 
						   jQuery('.custom_media_url').val(attachment.url);
						   //jQuery('.custom_media_image').attr('src',attachment.url).css('display','block');   
						} else {
							return _orig_send_attachment.apply( button_id, [props, attachment] );
						}
					}
					wp.media.editor.open(button);
					return false;
				});
			}
			media_upload( '.custom_media_upload');
			});
			</script>
	
			<p>
				<label for="<?php echo $this->get_field_id( 'image' ); ?>"><?php _e( 'Image:', 'xmag-plus' ); ?></label> 
				<input class="custom_media_id" id="<?php echo $this->get_field_id('image_id'); ?>" name="<?php echo $this->get_field_name('image_id'); ?>" type="hidden" value="<?php echo $instance['image_id']; ?>" />
				<input class="widefat custom_media_url" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('image'); ?>" type="text" value="<?php echo $instance['image']; ?>" />
				<input type="button" value="<?php _e( 'Upload Image', 'xmag-plus' ); ?>" class="button custom_media_upload" id="custom_image_uploader"/>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('image_size'); ?>"><?php _e('Select Image Size:', 'xmag-plus'); ?></label><br>
				<select id="<?php echo $this->get_field_id('image_size'); ?>" name="<?php echo $this->get_field_name('image_size'); ?>" >
					<option value="medium" <?php if($instance['image_size'] == 'medium') { echo 'selected="selected"'; }?> ><?php _e( 'Medium', 'xmag-plus' ); ?></option>
					<option value="thumbnail" <?php if($instance['image_size'] == 'thumbnail') { echo 'selected="selected"'; }?> ><?php _e( 'Thumbnail', 'xmag-plus' ); ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'link_url' ); ?>"><?php _e( 'Link URL: (Optional)', 'xmag-plus' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'link_url' ); ?>" name="<?php echo $this->get_field_name( 'link_url' ); ?>" type="text" value="<?php echo $link_url; ?>" />
				<small><?php _e( 'http:// is required', 'xmag-plus' ); ?></small>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'facebook_url' ); ?>"><?php _e( 'Facebook URL:', 'xmag-plus' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'facebook_url' ); ?>" name="<?php echo $this->get_field_name( 'facebook_url' ); ?>" type="text" value="<?php echo $facebook_url; ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'twitter_url' ); ?>"><?php _e( 'Twitter URL:', 'xmag-plus' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'twitter_url' ); ?>" name="<?php echo $this->get_field_name( 'twitter_url' ); ?>" type="text" value="<?php echo $twitter_url; ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'googleplus_url' ); ?>"><?php _e( 'Google + URL:', 'xmag-plus' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'googleplus_url' ); ?>" name="<?php echo $this->get_field_name( 'googleplus_url' ); ?>" type="text" value="<?php echo $googleplus_url; ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'linkedin_url' ); ?>"><?php _e( 'LinkedIn URL:', 'xmag-plus' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'linkedin_url' ); ?>" name="<?php echo $this->get_field_name( 'linkedin_url' ); ?>" type="text" value="<?php echo $linkedin_url; ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'instagram_url' ); ?>"><?php _e( 'Instagram URL:', 'xmag-plus' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'instagram_url' ); ?>" name="<?php echo $this->get_field_name( 'instagram_url' ); ?>" type="text" value="<?php echo $instagram_url; ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'pinterest_url' ); ?>"><?php _e( 'Pinterest URL:', 'xmag-plus' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'pinterest_url' ); ?>" name="<?php echo $this->get_field_name( 'pinterest_url' ); ?>" type="text" value="<?php echo $pinterest_url; ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'youtube_url' ); ?>"><?php _e( 'Youtube URL:', 'xmag-plus' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'youtube_url' ); ?>" name="<?php echo $this->get_field_name( 'youtube_url' ); ?>" type="text" value="<?php echo $youtube_url; ?>" />
			</p>
			<?php 
		}
	
	}
endif;


// Register the widget
function xmag_register_profile_widget() {
	register_widget( 'DesignLab_Profile' );
}

add_action( 'widgets_init', 'xmag_register_profile_widget' );
