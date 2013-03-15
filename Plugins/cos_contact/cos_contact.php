<?php
/*
Plugin Name: COS Contact Widget
Plugin URI: http://cos.ucf.edu
Description: Displays contact information for current department
Version: 1.0.0
Author: David Khourshid
Author URI: http://www.theoryforte.net
License: GPL2
*/

add_action( 'widgets_init', 'cos_contact_widget_load' );

// Register widget
function cos_contact_widget_load() {
	register_widget( 'cos_contact_widget' );
}

class cos_contact_widget extends WP_Widget {
	function cos_contact_widget() {
		// Widget settings
		$widget_ops = array(
			'classname' => 'COS Contact Info', 
			'description' => 'Displays contact information for current department',
		);

		// Widget control settings
		$control_ops = array(
			'id_base' => 'cos_contact_widget',
		);

		$this->WP_Widget(
			'cos_contact_widget', 
			'COS Contact Info',
			$widget_ops,
			$control_ops
		);
	}

	function widget( $args, $instance ){
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']); // widget title

 		$args = array( 
 			'title' => $instance['title'],
 			'dept' => $instance['dept'],
 			'address' => $instance['address'],
 			'email' => $instance['email'],
 			'phone' => $instance['phone'], 
 			'fax' => $instance['fax'],
 		);

		// Before Widget
		echo $before_widget;

		// Widget Output  -  SHOW CONTACT BOX
		do_action( 'show_contact_area', $args  );

		// After Widget
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['dept'] = strip_tags($new_instance['dept']);
			$instance['address'] = strip_tags($new_instance['address']);
			$instance['email'] = strip_tags($new_instance['email']);
			$instance['phone'] = strip_tags($new_instance['phone']);
			$instance['fax'] = strip_tags($new_instance['fax']);
			return $instance;
	}

		// Widget Control Panel //
	function form( $instance ) {
 		$defaults = array( 
 			'title' => 'Contact asdfafsdUs',
 			'dept' => '',
 			'address' => '',
 			'email' => '',
 			'phone' => '', 
 			'fax' => '',
 		);
 		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

 		<!-- Title -->
 		<p>
 			<label for="<?php echo $this->get_field_id('title'); ?>">Title: (<em>e.g. <strong>"Contact Us"</strong></em>)</label>
 			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>'" type="text" value="<?php echo $instance['title']; ?>" />
 		</p>

 		<!-- Department -->
 		<p>
 			<label for="<?php echo $this->get_field_id('dept'); ?>">Department:</label>
 			<input class="widefat" id="<?php echo $this->get_field_id('dept'); ?>" name="<?php echo $this->get_field_name('dept'); ?>'" type="text" value="<?php echo $instance['dept']; ?>" />
 		</p>

 		<!-- Address -->
 		<p>
 			<label for="<?php echo $this->get_field_id('address'); ?>">Address:</label>
 			<textarea class="widefat" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>'" rows="5"><?php echo $instance['address']; ?></textarea>
 		</p>

 		<!-- Email -->
 		<p>
 			<label for="<?php echo $this->get_field_id('email'); ?>">Email Address(es):</label>
 			<textarea class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>'" rows="2"><?php echo $instance['email']; ?></textarea>
 		</p>

 		<!-- Phone and Fax -->
 		<p>
 			<label for="<?php echo $this->get_field_id('phone'); ?>">Phone Number:</label>
 			<input class="widefat" id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>'" type="text" value="<?php echo $instance['phone']; ?>" />
 		</p>
  		<p>
 			<label for="<?php echo $this->get_field_id('fax'); ?>">Fax Number:</label>
 			<input class="widefat" id="<?php echo $this->get_field_id('fax'); ?>" name="<?php echo $this->get_field_name('fax'); ?>'" type="text" value="<?php echo $instance['fax']; ?>" />
 		</p>
 		<?php 
 	}

}
