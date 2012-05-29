<?php

/*

	Plugin Name: Mini twitter feed
	Plugin URI: http://minitwitter.webdevdesigner.com
	Description: This plugin displays tweets from your feed, from the Twitter Search, from a list or from your favorite users. 
	Author: Web Dev Designer
	Version: 1.4
	Author URI: http://www.webdevdesigner.com
	
	
    Copyright 2012  Web Dev Designer (email : olivier@webdevdesigner.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
    
*/

function mtf_create_shortcode( $atts, $content=null ) {
	shortcode_atts(array('id'=>null,'username'=>null, 'list'=>null, 'query' => null, 'limit' => null), $atts);
	$options = (($atts['username'])?'username:"'.$atts['username'].'",':'username:"webdevdesigner",');
	$options .= (($atts['limit'])?'limit:'.$atts['limit'].',':'');
	$options .= (($atts['query'])?'query:"'.$atts['query'].'",':'');
	$options .= (($atts['list'])?'list:"'.$atts['list'].'",':'');
	
	return '<div class="tweets"> 
				<div class="tweets_header">Mini <a href="http://minitwitter.webdevdesigner.com">Tweets</a></div> 
				<div class="content_tweets'.$atts['id'].'"> </div> 
				<div class="tweets_footer">
					<span id="bird"></span>
				</div> 
			</div>
			<script type="text/javascript">
				jQuery(".content_tweets'.$atts['id'].'").miniTwitter({
					'.$options.'
					retweet:true
				});
			</script>';
}

function mtf_scripts() {
	wp_deregister_script('jquery');
	wp_register_script('jquery','http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js', false, '');
	wp_enqueue_script('jquery');
	wp_enqueue_script( "mtf_minitwitter", path_join(WP_PLUGIN_URL, basename( dirname( __FILE__ ) )."/jquery.minitwitter.js"), array( 'jquery' ) );
	wp_enqueue_style( "mtf_css", path_join(WP_PLUGIN_URL, basename( dirname( __FILE__ ) )."/jquery.minitwitter.css"));
}    
 
add_action('wp_enqueue_scripts', 'mtf_scripts');
add_shortcode('minitwitter', mtf_create_shortcode);

// widget

class MinitwitterWidget extends WP_Widget {
	
	function MinitwitterWidget() {
		$widget_options = array(
		'classname'		=>		'minitwitter-widget',
		'description' 	=>		'Widget which puts the twitter feed on your website.'
		);
		
		parent::WP_Widget('minitwitter-widget', 'miniTwitter', $widget_options);
	}
	
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		$options = (($instance['username'])?'username:"'.$instance['username'].'",':'username:"webdevdesigner",');
		$options .= (($instance['limit'])?'limit:'.$instance['limit'].',':'');
		$options .= (($instance['query'])?'query:"'.$instance['query'].'",':'');
		$options .= (($instance['list'])?'list:"'.$instance['list'].'",':'');
		?>
		<?php echo $before_widget; ?>
		<?php echo '<div class="tweets"> 
				<div class="tweets_header">Mini <a href="http://minitwitter.webdevdesigner.com">Tweets</a></div> 
				<div class="content_tweets_'.$this->get_field_id('id').'"> </div> 
				<div class="tweets_footer">
				</div> 
			</div>
			<script type="text/javascript">
				jQuery(".content_tweets_'.$this->get_field_id('id').'").miniTwitter({
					'.$options.'
					retweet:true
				});
			</script>';?>
		<?php echo $after_widget; ?>
		<?php 
	}

	function update($new, $old) {
		return $new;
	}
	
	function form($instance) {
		?>
		<p><label for="<?php echo $this->get_field_id('username')?>">
		Username
		<input id="<?php echo $this->get_field_id('username')?>" 
		name="<?php echo $this->get_field_name('username')?>"
		value="<?php echo $instance['username'];?>" size=10 />
		</label></p>
		<p><label for="<?php echo $this->get_field_id('limit')?>">
		Limit
		<input id="<?php echo $this->get_field_id('limit')?>" 
		name="<?php echo $this->get_field_name('limit')?>"
		value="<?php echo $instance['limit'];?>" size=10 />
		</label></p>
		<p><label for="<?php echo $this->get_field_id('list')?>">
		List
		<input id="<?php echo $this->get_field_id('list')?>" 
		name="<?php echo $this->get_field_name('list')?>"
		value="<?php echo $instance['list'];?>" size=10 />
		</label></p>
		<p><label for="<?php echo $this->get_field_id('query')?>">
		Query
		<input id="<?php echo $this->get_field_id('query')?>" 
		name="<?php echo $this->get_field_name('query')?>"
		value="<?php echo $instance['query'];?>" size=10 />
		</label></p>
		<?php 
	}
}

function minitwitter_widget_init() {
	register_widget('MinitwitterWidget');
}
add_action('widgets_init', 'minitwitter_widget_init');
