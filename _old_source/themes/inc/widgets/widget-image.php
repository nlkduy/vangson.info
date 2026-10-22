<?php
/**
 * Plugin Name: Image and Text Widget
 * Version: 1.0.4
 */

if( ! class_exists( 'DesignLab_Image' ) ) :
	class DesignLab_Image extends WP_Widget {
		
		/**
		 * Register widget with WordPress
		 */
		public function __construct() {
			//global $wid, $wname;
			parent::__construct(
		 		'designlab_image', // Base ID
				'Design Lab: Image', // Name
				array( 'description' => __( 'Deprecated. Please use WordPress Image Widget.', 'xmag-plus' ), ) // Args
			);
			add_action('admin_enqueue_scripts', array($this, 'dlab_upload_scripts'));
		}
		
		public function dlab_upload_scripts() {
		wp_enqueue_media();
		}
	
		/**
		 *  Update the widget when new options have been entered
		 */
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['widget_title'] = strip_tags( $new_instance['widget_title'] );
			
			if( $instance['image_url'] != strip_tags( $new_instance['image_url'] ) && $instance['image_id'] == strip_tags( $new_instance['image_id'] ) ) {
				$instance['image_id'] = "";
			} else {
				$instance['image_id'] = strip_tags( $new_instance['image_id'] );
			}
			$instance['image_url'] = strip_tags( $new_instance['image_url'] );
			$instance['image_link'] = strip_tags( $new_instance['image_link'] );
			$instance['image_link_label'] = strip_tags( $new_instance['image_link_label'] );
			
			if ( current_user_can('unfiltered_html') )
				$instance['text'] =  $new_instance['text'];
			else
				$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
			
			$instance['filter'] = isset($new_instance['filter']);
			
			return $instance;
		}
		
		/**
		 * Back-end widget form.
		 */
		function form($instance) {
			
			$defaults = array( 
					'widget_title' 		=> '',
					'text' 				=> '',
					'image_url'			=> '',
					'image_id'			=> '',
					'image_link' 		=> '',
					'image_link_label' 	=> ''
				);
			
			$instance = wp_parse_args( (array) $instance, $defaults );
			
			$text = esc_textarea($instance['text']);	
			$image_url = esc_url($instance['image_url']);	
			$image_link = esc_url($instance['image_link']);			
			?>
		
			<p>
				<label><?php _e( 'Title', 'xmag-plus' ); ?></label>	
				<input class="widefat" id="<?php echo $this->get_field_id('widget_title'); ?>" name="<?php echo $this->get_field_name('widget_title'); ?>" type="text" value="<?php echo $instance['widget_title']; ?>" />
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
				<label><?php _e( 'Image URL', 'xmag-plus' ); ?></label>
				<input class="custom_media_id" id="<?php echo $this->get_field_id('image_id'); ?>" name="<?php echo $this->get_field_name('image_id'); ?>" type="hidden" value="<?php echo $instance['image_id']; ?>" />
				<input class="widefat custom_media_url" id="<?php echo $this->get_field_id('image_url'); ?>" name="<?php echo $this->get_field_name('image_url'); ?>" type="text" value="<?php echo $instance['image_url']; ?>" />
				<input type="button" value="<?php _e( 'Upload Image', 'xmag-plus' ); ?>" class="button custom_media_upload" id="custom_image_uploader"/>
			</p>
				
			<p>
				<label><?php _e( 'Link', 'xmag-plus' ); ?></label>	
				<input class="widefat" id="<?php echo $this->get_field_id('image_link'); ?>" name="<?php echo $this->get_field_name('image_link'); ?>" type="text" value="<?php echo $instance['image_link']; ?>" />
				<small><?php _e( 'http:// is required', 'xmag-plus' ); ?></small>
			</p>
			<p>
				<label><?php _e( 'Link Text', 'xmag-plus' ); ?></label>	
				<input class="widefat" id="<?php echo $this->get_field_id('image_link_label'); ?>" name="<?php echo $this->get_field_name('image_link_label'); ?>" type="text" value="<?php echo $instance['image_link_label']; ?>" />
			</p>
			<p>
				<label><?php _e( 'Text', 'xmag-plus' ); ?></label>
				<textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
			</p>
			<p>
				<input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php checked(isset($instance['filter']) ? $instance['filter'] : 0); ?> />
				<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e( 'Automatically add paragraphs', 'xmag-plus' ); ?></label>
			</p>
			
			<?php
		}
		
		/**
		 *  Display the widget in the theme
		 */
		function widget( $args, $instance ) {
		extract( $args );
		
		$text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
		
		echo $before_widget."\n";
		
		if ( isset( $instance['widget_title'] ) && $instance['widget_title'] != "" ) {
			echo $before_title . $instance['widget_title'] . $after_title."\n";
		}
		?>
		<p>
			<?php
			if( $instance['image_link'] != "" ) {
				
				echo '<a target="_blank" ' . 'href="' . $instance['image_link'] . '">';
			}
			if( $instance['image_url'] != "" ) {
				$image_linked = wp_get_attachment_image_src( $instance['image_id'], 'medium' );
				if( $image_linked === false ) {
					echo '<img src="' . $instance['image_url'] . '">';
				} else {
					echo '<img src="' . $image_linked[0] . '">';
				}
			}
			if( $instance['image_link'] != "" ) {
				echo '</a>';
			}
			?>			
		</p>
		<?php echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?>
		<?php if( $instance['image_link'] != "" && $instance['image_link_label'] != "" ) {
			echo '<p><a target="_blank" ' . 'href="' . $instance['image_link'] . '">';
			echo '<span>' . $instance['image_link_label'] . '</span>';
			echo '</a></p>';
			}
		?>
	<?php
		echo $after_widget."\n";
		}
		
	}
endif;


// Register the widget
function xmag_register_image_widget() {
	register_widget( 'DesignLab_Image' );
}

add_action( 'widgets_init', 'xmag_register_image_widget' );
