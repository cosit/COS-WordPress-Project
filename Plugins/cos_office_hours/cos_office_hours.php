<?php
/*
Plugin Name: COS Office Hours
Plugin URI: http://cos.ucf.edu
Description: Displays office hours of professors in department based on current day and time
Version: 1.0.0
Author: David Khourshid
Author URI: http://www.theoryforte.net
License: GPL2
*/

add_action( 'widgets_init', 'cos_office_hours_widget_load' );

// Register widget
function cos_office_hours_widget_load() {
	register_widget( 'cos_office_hours_widget' );
}

class cos_office_hours_widget extends WP_Widget {
	function cos_office_hours_widget() {
		// Widget settings
		$widget_ops = array(
			'classname' => 'COS Office Hours', 
			'description' => 'Shows faculty office hours based on day of week',
		);

		// Widget control settings
		$control_ops = array(
			'id_base' => 'cos_office_hours_widget',
		);

		$this->WP_Widget(
			'cos_office_hours_widget', 
			'COS Office Hours',
			$widget_ops,
			$control_ops
		);
	}

	function widget( $args, $instance ){
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']); // widget title

		// Before Widget
		echo $before_widget;

		// Title of Widget
		if( $title ){
			echo $before_title . $title . $after_title;
		}

		// Widget Output
		do_action( 'office_hours', true );

		// After Widget
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
			$instance['title'] = strip_tags($new_instance['title']);
			return $instance;
	}

		// Widget Control Panel //
	function form( $instance ) {
 		$defaults = array( 'title' => 'Office Hours' );
 		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

 		<p>
 			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
 			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>'" type="text" value="<?php echo $instance['title']; ?>" />
 		</p>
 		<?php 
 	}

}
