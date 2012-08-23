<?php
/*
Plugin Name: COS Events Feed
Plugin URI: http://cos.ucf.edu
Description: Shows events feed from events.ucf.edu
Version: 1.0.0
Author: David Khourshid
Author URI: http://www.theoryforte.net
License: GPL2
*/

add_action( 'widgets_init', 'cos_events_widget_load' );

// Register widget
function cos_events_widget_load() {
	register_widget( 'cos_events_widget' );
}

class cos_events_widget extends WP_Widget {
	function cos_events_widget() {
		// Widget settings
		$widget_ops = array(
			'classname' => 'COS Events Feed', 
			'description' => 'Shows events feed of specific COS Department',
		);

		// Widget control settings
		$control_ops = array(
			'id_base' => 'cos_events_widget',
		);

		$this->WP_Widget(
			'cos_events_widget', 
			'COS Events Feed',
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
			echo '<div class="events"><h2><span class="event_title">' . $title .'</span></h2>' ;
		}

		// Widget Output
		do_action( 'show_events', true );

		// After Widget
		echo '</div>' . $after_widget;
	}

	function update($new_instance, $old_instance) {
			$instance['title'] = strip_tags($new_instance['title']);
			return $instance;
	}

		// Widget Control Panel //
	function form( $instance ) {
 		$defaults = array( 'title' => 'Events' );
 		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

 		<p>
 			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
 			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>'" type="text" value="<?php echo $instance['title']; ?>" />
 		</p>
 		<?php 
 	}

}
