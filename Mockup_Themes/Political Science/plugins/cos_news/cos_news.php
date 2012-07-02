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
		do_action( 'show_news', $instance['news_cat'], $instance['news_items'] );

		// After Widget
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['news_cat'] = strip_tags($new_instance['news_cat']);
			$instance['news_items'] = strip_tags($new_instance['news_items']);
			return $instance;
	}

		// Widget Control Panel //
	function form( $instance ) {
 		$defaults = array( 
 			'title' => 'News',
 			'news_cat' => '',
 			'news_items' => 5,
 		);
 		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

 		<p>
 			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
 			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>'" type="text" value="<?php echo $instance['title']; ?>" />
 		</p>

 		<p>
 			<label for="<?php echo $this->get_field_id('news_cat'); ?>">News Category:</label>
            <select name="<?php echo $this->get_field_name('news_cat'); ?>'" id="<?php echo $this->get_field_id('news_cat'); ?>" value="<?php echo $instance['title']; ?>" >
            	<option value="anthropology">Anthropology</option>
            	<option value="biology-departments">Biology</option>
            	<option value="chemistry-departments">Chemistry</option>
            	<option value="communication">Communication, Nicholson School of</option>
            	<option value="forensic-science">Forensic Science, National Center of</option>
            	<option value="global-perspectives">Global Perspectives</option>
            	<option value="lou-frey-institute">Lou Frey Institute</option>
            	<option value="mathematics">Mathematics</option>
            	<option value="physics-departments">Physics</option>
            	<option value="political-science-departments">Political Science</option>
            	<option value="psychology-departments">Psychology</option>
            	<option value="sociology">Sociology</option>
            	<option value="statistics">Statistics</option>
            </select>
 		</p>

 		<p>
 			<label for="<?php echo $this->get_field_id('news_items'); ?>">Articles to show:</label>
 			<select name="<?php echo $this->get_field_name('news_items'); ?>'" id="<?php echo $this->get_field_id('news_items'); ?>" value="<?php echo $instance['news_items']; ?>" >
 				<option value="1">1</option>
 				<option value="2">2</option>
 				<option value="3">3</option>
 				<option value="4">4</option>
 				<option value="5">5</option>
 				<option value="6">6</option>
 				<option value="7">7</option>
 				<option value="8">8</option>
 				<option value="9">9</option>
 				<option value="10">10</option>
 			</select>
 		</p>
 		<?php 
 	}

}
