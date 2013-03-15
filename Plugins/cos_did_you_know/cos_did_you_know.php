<?php
/*
Plugin Name: COS "Did You Know?" Widget
Plugin URI: http://cos.ucf.edu
Description: Displays "did you know?" posts from "DYK" category
Version: 1.0.0
Author: David Khourshid
Author URI: http://www.theoryforte.net
License: GPL2
*/

add_action( 'widgets_init', 'cos_dyk_widget_load' );

// Register widget
function cos_dyk_widget_load() {
	register_widget( 'cos_dyk_widget' );
}

class cos_dyk_widget extends WP_Widget {
	function cos_dyk_widget() {
		// Widget settings
		$widget_ops = array(
			'classname' => 'COS "Did You Know?" Widget', 
			'description' => 'Displays "did you know?" posts from "DYK" category',
		);

		// Widget control settings
		$control_ops = array(
			'id_base' => 'cos_dyk_widget',
		);

		$this->WP_Widget(
			'cos_dyk_widget', 
			'COS "Did You Know?" Widget',
			$widget_ops,
			$control_ops
		);
	}

	function widget( $args, $instance ){
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']); // widget title

 		$args = array( 
 			'title' => $instance['title'],
 			'cat' => $instance['cat'],
 		);

		// Before Widget
		echo $before_widget;

		echo $before_title . $title . $after_title;

		// Widget Output  -  SHOW CONTACT BOX
		do_action( 'show_dyk_area', $args  );

		// After Widget
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['cat'] = strip_tags($new_instance['cat']);
			return $instance;
	}

		// Widget Control Panel //
	function form( $instance ) {
 		$defaults = array( 
 			'title' => 'Did You Know?',
 			'cat' => 'dyk',
 		);
 		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

 		<!-- Title -->
 		<p>
 			<label for="<?php echo $this->get_field_id('title'); ?>">Title: (<em>e.g. <strong>"Did You Know?"</strong></em>)</label>
 			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>'" type="text" value="<?php echo $instance['title']; ?>" />
 		</p>

 		<p>
 			<label for="<?php echo $this->get_field_id('cat'); ?>"><em>(Advanced) Category to retrieve posts from (default: "dyk"):</em></label>
 			<input class="widefat" id="<?php echo $this->get_field_id('cat'); ?>" name="<?php echo $this->get_field_name('cat'); ?>'" type="text" value="<?php echo $instance['cat']; ?>" />
 		</p>
 		<?php 
 	}

}
