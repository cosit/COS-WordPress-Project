<?php
/*
Plugin Name: COS News Feed
Plugin URI: http://cos.ucf.edu
Description: Shows news feed from <a href="http://news.cos.ucf.edu">the COS News site</a> of selected department
Version: 1.0.0
Author: David Khourshid
Author URI: http://www.theoryforte.net
License: GPL2
*/

add_action( 'widgets_init', 'cos_news_widget_load' );

// Register widget
function cos_news_widget_load() {
	register_widget( 'cos_news_widget' );
}

class cos_news_widget extends WP_Widget {
	function cos_news_widget() {
		// Widget settings
		$widget_ops = array(
			'classname' => 'COS News Feed', 
			'description' => 'Shows news feed of specific COS Department',
		);

		// Widget control settings
		$control_ops = array(
			'id_base' => 'cos_news_widget',
		);

		$this->WP_Widget(
			'cos_news_widget', 
			'COS News Feed',
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
		do_action( 'show_news', true );

		// After Widget
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
			$instance['title'] = strip_tags($new_instance['title']);
			return $instance;
	}

		// Widget Control Panel //
	function form( $instance ) {
 		$defaults = array( 'title' => 'News' );
 		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

 		<p>
 			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
 			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>'" type="text" value="<?php echo $instance['title']; ?>" />
 		</p>
 		<?php 
 	}

}
