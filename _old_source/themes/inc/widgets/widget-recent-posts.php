<?php
/**
 * Plugin Name: Recent Posts Widget
 * Version: 1.0.5
 */

if( ! class_exists( 'DesignLab_Recent_Posts' ) ) :
	class DesignLab_Recent_Posts extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			//global $wid, $wname;
			parent::__construct(
				'designlab_recent_posts', // Base ID
				'Design Lab: Recent Posts', // Name
				array( 'description' => __( 'Display a list of your most recent posts', 'xmag-plus' ), ) // Args
			);
		}

		/**
		 *  Display the widget in the theme
		 */
		public function widget( $args, $instance ) {
			extract( $args );
			$title = apply_filters( 'widget_title', $instance['title'] );
			$numposts = $instance['num_posts'];
			$post_category = $instance['post_category'];
			$excerpt = $instance['show_excerpt'];
			$thumbnail = $instance['show_thumbnail'];

			echo $before_widget;
			if ( ! empty( $title ) )
				echo $before_title . $title . $after_title;
			?>

			<ul>
			<?php

			$recentquery = new WP_Query(array ('cat' => $post_category, 'posts_per_page' => $numposts));
			$ctr = 0;
				while ($recentquery->have_posts() ) : $recentquery->the_post();
				$ctr += 1;
				?>

				<li class="widget-custom-recent-posts widget-custom-recent-post-<?php echo $ctr; ?> clear">

					<?php if( has_post_thumbnail() && $thumbnail == 'on' ) { ?>

						<div class="widget-custom-recent-post-thumb"><?php the_post_thumbnail( 'thumbnail' ); ?></div>

					<?php } ?>

					<div class="widget-custom-recent-post-date"><?php the_time( 'M j, Y' ); ?></div>

					<?php if( $excerpt == 'on' ) { ?>

						<h5 class="widget-custom-recent-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>

						<div class="widget-custom-recent-post-excerpt">
							<?php recent_post_excerpt(5); ?>
						</div>

					<?php }

						else {

							if ( $thumbnail == 'on' ) { ?> <h5 class="widget-custom-recent-post-title"> <?php } ?>

								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

							<?php if ( $thumbnail == 'on' ) { ?> </h5> <?php }

						} ?>
				</li>
				<?php endwhile; ?>

				<?php wp_reset_query(); ?>
			</ul>

			<?php echo $after_widget;
		}

		/**
		 *  Update the widget when new options have been entered
		 */
		public function update( $new_instance, $old_instance ) {
			$new_instance = (array) $new_instance;
			$instance = array( );
			foreach ( $instance as $field => $val ) {
				if ( isset($new_instance[$field]) )
					$instance[$field] = 1;
			}
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['post_category'] = strip_tags($new_instance['post_category']);
			$instance['num_posts'] = intval($new_instance['num_posts']);
			$instance['show_excerpt'] = strip_tags( $new_instance['show_excerpt'] );
			$instance['show_thumbnail'] = strip_tags($new_instance['show_thumbnail']);

			return $instance;
		}

		/**
		 * Back-end widget form
		 */
		public function form( $instance ) {

			//Defaults
			$defaults = array(
					'title' 			=> 'Recent Posts',
					'post_category' 	=> '',
					'num_posts' 		=> 3,
					'show_excerpt' 		=> 'off',
					'show_thumbnail' 	=> 'on'
				);

			$instance = wp_parse_args( (array) $instance, $defaults );

			$show_excerpt = $instance['show_excerpt'];
			$show_thumbnail = $instance['show_thumbnail'];

			?>

			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'xmag-plus'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('post_category'); ?>"><?php _e('Filter by Category:', 'xmag-plus'); ?></label>
				<select id="<?php echo $this->get_field_id('post_category'); ?>" name="<?php echo $this->get_field_name('post_category'); ?>" >
					<option <?php if($instance['post_category'] == '') { echo 'selected="selected"'; } ?> value="" ><?php _e( 'All categories', 'xmag-plus' ); ?></option>
					<?php
					  $categories = get_categories();
					  foreach ($categories as $category) {
						$option = '<option value="'.$category->cat_ID.'"';
						if($instance['post_category'] == $category->cat_ID) {
							$option .= 'selected="selected"';
						}
						$option .= '>' . $category->cat_name;
						$option .= '</option>';
						echo $option;
					  }
					 ?>
				</select>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('num_posts'); ?>"><?php _e('Number of Posts:', 'xmag-plus'); ?></label>
				<select id="num-posts" name="<?php echo $this->get_field_name('num_posts'); ?>">

				<?php
				for ($i = 1; $i <= 10; $i++) {

					echo '<option value="' . intval($i) . '"'
						. ( $i == $instance['num_posts'] ? ' selected="selected"' : '' )
						. '>' . $i . "</option>\n";
				}
				?>
				</select>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('show_excerpt'); ?>"><?php _e('Show Excerpt:', 'xmag-plus'); ?></label>
				<input id="<?php echo $this->get_field_id('show_excerpt'); ?>" name="<?php echo $this->get_field_name('show_excerpt'); ?>" type="checkbox" <?php if( $instance['show_excerpt'] == 'on' ) { checked($show_excerpt, 'on'); } ?> />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('show_thumbnail'); ?>"><?php _e('Show Thumbnail:', 'xmag-plus'); ?></label>
				<input id="<?php echo $this->get_field_id('show_thumbnail'); ?>" name="<?php echo $this->get_field_name('show_thumbnail'); ?>" type="checkbox" <?php checked($show_thumbnail, 'on'); ?> />
			</p>

		<?php
		}

	}
endif;


// Register the widget
function xmag_register_recent_posts_widget() {
	register_widget( 'DesignLab_Recent_Posts' );
}

add_action( 'widgets_init', 'xmag_register_recent_posts_widget' );


/*
 * Change excerpt text, for Recent Posts
 */
function recent_post_excerpt($num) {
	global $post;
	$limit = $num+1;
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	array_pop($excerpt);
	$excerpt = implode(" ",$excerpt);
	echo $excerpt;
}
