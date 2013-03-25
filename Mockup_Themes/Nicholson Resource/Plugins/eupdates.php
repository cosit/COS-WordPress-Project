<?php
/*
Plugin Name: eUpdates
Plugin URI: http://cos.ucf.edu
Description: Shows a number of recent eUpdates from the eUpdates Custom Post Type
Version: 1.0.0
Author: Jonathan Hendricker
License: GPL2
*/

add_action( 'widgets_init', 'eupdate_widget_load' );

// Register widget
function eupdate_widget_load() {
	register_widget( 'eupdate_widget' );
}

class eupdate_widget extends WP_Widget {
	function eupdate_widget() {
		// Widget settings
		$widget_ops = array(
			'classname' => 'eUpdate', 
			'description' => 'Shows a number of recent eUpdates in a widget area.',
		);

		// Widget control settings
		$control_ops = array(
			'id_base' => 'eupdate_widget',
		);

		$this->WP_Widget('eupdate_widget', 
			'eUpdate',
			$widget_ops
		);
	}

	function widget( $args, $instance ){
		extract( $args, EXTR_SKIP );

		$title = apply_filters('widget_title', $instance['title']); // widget title

		// Before Widget
		echo $before_widget;

		// Title of Widget
		if( $title ){
			echo $before_title . $title . $after_title;
		}

		// Widget Output
		$args = array(
			'post_type' => 'eupdate',		
			'meta_key' => 'date',
			'orderby' => 'meta_value',
			'order' => 'DESC',
			'posts_per_page' => $instance['num_eupdates'],		
		);

		query_posts($args); 

		if ( have_posts() ){

			echo "<ul class='menu-forms-footer-menu'>";
			while ( have_posts() ) : the_post(); 

			echo '<li><a href="'. get_field("url").'" target="_blank">'. get_the_title().'</a></li>';
				
			endwhile;
			echo "</ul>";
		} else {
			echo "<ul><li>There are no eUpdates at this time</li></ul>";
		}

		// After Widget
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
			$instance['title'] = strip_tags($new_instance['title']);			
			$instance['num_eupdates'] = strip_tags($new_instance['num_eupdates']);
			return $instance;
	}

		// Widget Control Panel //
	function form( $instance ) {
 		$defaults = array( 
 			'title' => 'eUpdates', 			
 			'num_eupdates' => $instance['num_eupdates'],
 		);
 		$instance = wp_parse_args( (array) $instance, $defaults ); 
		$title = $instance['title'];
 		?>


		<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>

 		<p>
 			<label for="<?php echo $this->get_field_id('num_eupdates'); ?>">Number of eUpdates to show:</label>
 			<input class="widefat" name="<?php echo $this->get_field_name('num_eupdates'); ?>'" id="<?php echo $this->get_field_id('num_eupdates'); ?>" value="<?php echo $instance['num_eupdates']; ?>" type="text" />
 				
 		</p>
 		<?php 
 	}
}