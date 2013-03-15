<?php
/************************************************
 * Functions page for Global Perspectives website
 * UCF College of Sciences Web and Marketing Services
 * v.1.0
 ************************************************/

function gp_events() {
	$labels = array(
		'name' => _x('Events', 'post type general name'),
		'singular_name' => _x('Event', 'post type singular name'),
		'add_new' => _x('Add New', 'slider'),
		'add_new_item' => __('Add New Event'),
		'edit_item' => __('Edit Event'),
		'new_item' => __('New Event'),
		'all_items' => __('All Events'),
		'view_item' => __('View Event'),
		'search_items' => __('Search All Events'),
		'not_found'  => __('No events found.'),
		'not_found_in_trash'  => __('No events found in Trash.'),
		'parent_item_colon' => '',
		'menu_name'  => __('Events'),
	);

	$args = array(
		'labels' => $labels,
		'singular_label' => __('Event'),
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => true,
		'supports' => array('custom-fields'),
	);

	register_post_type( 'events', $args );
}
add_action('init', 'gp_events');

// Support for multiple dates - automatically fills in end_date field
// function add_gp_event_end_date( $post_id ){

// 	update_post_meta( $post_id, 'location', $_REQUEST['date'] );
// 	// If it's not an event, skip
// 	if( 'events' != $_POST['post_type'] ) return;

// 	// If the 'end_date' field is empty, fill it in with the current date
// 	// This is important. Even if the end_date field isn't filled in, it is required.
// 	if( !isset($_REQUEST['end_date']) ){
// 		update_post_meta( $post_id, 'end_date', $_REQUEST['date'] );
// 	}
// }
// add_action( 'save_post', 'add_gp_event_end_date' );
// add_action( 'publish_post', 'add_gp_event_end_date' );

function show_gp_events_sidebar( ) {

	  	$num_events = (is_home()) ? '2' : '3';

		$temp = $wp_query; 
	  	$wp_query = null; 
	  	$wp_query_args = array(
		  		'post_type' => 'events',
				'showposts' => $num_events,
				'meta_key' => 'date',
				'meta_value' => date("Y/m/d"),
				'meta_compare' => '>=',
				'orderby' => 'meta_value',
				'order' => 'ASC',
				'paged' => $paged,
	  	);
	  	$wp_query = new WP_Query( $wp_query_args ); 


	echo '<ul>';

	while ($wp_query->have_posts()) : $wp_query->the_post(); 

		// Grab the Post ID for the Custom Fields Function			
		$thisID = get_the_ID();

		$event = array(
			'title' => strlen(get_field('title')) < 1 ? get_the_title() : get_field('title'),
			'date' => strlen(get_field('date')) < 1 ? get_post_custom_values('date') : get_field('date'),
			'date_long' => strlen(get_field('date_long')) < 1 ? get_post_custom_values('date_long') : get_field('date_long'),
			'location' => strlen(get_field('location')) > 1 ? get_field('location') : "",
			// 'info' => strlen(get_field('info')) < 1 ? get_post_custom_values('info') : get_field('info'),
			// 'photo' => strlen(get_field('photo')) < 1 ? get_post_custom_values('photo') : get_field('photo'),
			'topic' => strlen(get_field('topic')) < 1 ? get_post_custom_values('topic') : get_field('topic'),
			// 'sponsors' => strlen(get_field('sponsors')) < 1 ? get_post_custom_values('sponsors') : get_field('sponsors'),
			'excerpt' => get_the_excerpt(),
			'text' => strlen(get_field('text')) < 1 ? get_the_excerpt() : get_field('text'),
			'link' => get_permalink(),
		);

		foreach( $event as &$value ){
			// Force values as strings, not array remnants
			$value = is_array($value) ? $value[0] : $value;
			$value = strip_tags( $value );
		}
		$date = strtotime( $event['date'] );

		$date = date("F jS, Y", $date );


		// display person if person is in category, or category is 'all'
		echo <<<GP_EVENT
			<li>
				<h4><a href="{$event['link']}" title="{$event['title']}">{$event['title']}</a></h4>
				<p>{$event['topic']}</p>
				<p>{$event['excerpt']}</p>
				<p><strong>{$date} at {$event['date_long']}</strong></p>
				<p><strong>{$location}</strong></p>
			</li>
GP_EVENT;

	endwhile; 

	echo '</ul>';
	echo '<a class="moreEvents" href="'.get_bloginfo('url').'/gp-events" title="See All Events">See All Events</a>';

	wp_reset_query();
}
remove_shortcode('events');

function show_gp_event() {
		// Grab the Post ID for the Custom Fields Function			
		$thisID = get_the_ID();

		$event = array(
			'title' => strlen(get_field('title')) < 1 ? get_the_title() : get_field('title'),
			'date' => strlen(get_field('date')) < 1 ? get_post_custom_values('date') : get_field('date'),
			'date_long' => strlen(get_field('date_long')) < 1 ? get_post_custom_values('date_long') : get_field('date_long'),
			'location' => get_field('location'),
			'info' => strlen(get_field('info')) < 1 ? get_post_custom_values('info') : get_field('info'),
			'photo' => strlen(get_field('photo')) < 1 ? get_post_custom_values('photo') : get_field('photo'),
			'found_it' => get_post_custom_values('found_it'),
			'topic' => strlen(get_field('topic')) < 1 ? get_post_custom_values('topic') : get_field('topic'),
			'sponsors' => strlen(get_field('sponsors')) < 1 ? get_post_custom_values('sponsors') : get_field('sponsors'),
			'excerpt' => get_the_excerpt(),
			'text' => strlen(get_field('text')) < 1 ? get_the_excerpt() : get_field('text'),
		);

		foreach( $event as $key => &$value ){
			// Force values as strings, not array remnants
			$value = is_array($value) ? $value[0] : $value;

			if($key != 'text' && $key != 'info'){
				$value = strip_tags( $value );
			}
		}

// DO NOT EDIT ANY OF THIS OR I WILL BUY YOU MCDONALDS AND EXPOSE YOU TO THE RISK OF OBESITY SO HELP ME GOD
		$IMG_DIR_PATH = 'http://globalperspectives.cos.ucf.edu/main/wp-content/uploads/events/';
		
		if( is_array( $event['photo'] ) && strlen($event['photo'][0]) > 0 ){
			$event['photo'] = $event['photo'][0];
		} 
		if( strlen($event['found_it']) > 0 ) {
			$event['photo'] = $event['found_it'];
		}

		preg_match('/(?:http:\/\/.*\/)?(.*\.(jpe?g|gif|png))/i', $event['photo'], $img);
		$img = $img[1];
		$img_url = $IMG_DIR_PATH . $img;
		if( preg_match( '/wp-content/i', get_field('photo')) ) {
			$img_url = get_field('photo');
		} 
		$img = strlen( $img_url ) > 0 ? '<img src="'.$img_url.'" alt="'.$event['title'].'"/>' : '';
// =============================================================================================

		// display person if person is in category, or category is 'all'
		?>
		<article class="gp_event clearfix">
			<header>
				<h1>Events <span>&raquo;</span> 
					<?php /* echo $event['title'];*/ ?></h1>
			</header>
			<div class="gp_eventDate"><?php echo $event['date']; ?></div>
			<div class="gp_eventInfo">				
				<?php echo $img; ?>
 				<h2><?php echo $event['title']; ?></h2> 
		<?php if( strlen($event['topic']) > 0 ) : ?>
				<h3><?php echo $event['topic']; ?></h3>
		<?php endif; ?>				
				<p><?php echo $event['text']; ?></p>
				<p class="gp_event_time"><span>Time:</span> <?php echo $event['date_long']; ?></p>
		<?php if( strlen($event['location']) > 0 ) : ?>
				<p><strong>Location: </strong><?php echo $event['location']; ?></p>
		<?php endif; ?>						
		<?php if( strlen($event['sponsors']) > 0 ) : ?>
				<p><strong>Sponsors: </strong><?php echo $event['sponsors']; ?></p>
		<?php endif; ?>
		<?php if( strlen($event['info']) > 0 ) : ?>
				<p><strong>More Information: </strong><?php echo $event['info']; ?></p>
		<?php endif; ?>

			</div>
			
			<div style="clear:both; height:1px; margin-bottom:-1px;">&nbsp;</div>
		<?php

		edit_post_link( 'Edit This Event', '', '' );
		echo '</article>';
}

function gp_videos() {
	$labels = array(
		'name' => _x('Videos', 'post type general name'),
		'singular_name' => _x('Video', 'post type singular name'),
		'add_new' => _x('Add New', 'slider'),
		'add_new_item' => __('Add New Video'),
		'edit_item' => __('Edit Video'),
		'new_item' => __('New Video'),
		'all_items' => __('All Videos'),
		'view_item' => __('View Video'),
		'search_items' => __('Search All Videos'),
		'not_found'  => __('No Videos found.'),
		'not_found_in_trash'  => __('No Videos found in Trash.'),
		'parent_item_colon' => '',
		'menu_name'  => __('Videos'),
	);

	$args = array(
		'labels' => $labels,
		'singular_label' => __('Video'),
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => true,
		'supports' => array('custom-fields'),
		'taxonomies' => array('video_cat'),

	);

	register_post_type( 'videos', $args );
}
add_action('init', 'gp_videos');

// Custom taxonomy for people classifications
function video_cat() {
	// create a new taxonomy
	register_taxonomy(
		'video_cat',
		'videos',
		array(
			'label' => __( 'Video Year' ),
			'sort' => true,
			'hierarchical' => true,
			'args' => array( 'orderby' => 'term_order' ),
			'query_var' => true,
			'rewrite' => false, /*array( 'slug' => 'group' )*/
		)
	);
}
add_action( 'init', 'video_cat' ); 

//Function for showing a custom Navigation with a Custom Post Type's
//Categories
function show_cats( $displayCats = true, $category ) {
	if( !$category ){
		echo "Error: category is undefined";
		return false;
	}
	$getCat = $category;
	$cats = get_terms( $getCat );
	$subCats = array();
	$has_subCats = false;

	if( !empty( $cats ) ){
		
		/* Commented out to let the Re-Order and Taxonomy Order plugins the ability to order items */
		//sort($cats);		

		foreach ($cats as $cat){
			if( $cat->parent != 0 ){
				array_push($subCats, $cat);
			}
		}
		
		foreach ($cats as $cat){
			if( $cat->parent != 0 ){
				continue;
			} else {
				$videoCatList .= '<li>';
			}

			$videoCatList .= '<a href="' . esc_attr(get_term_link($cat, $getCat )) . '" title="' . sprintf(__('View All %s Members', 'my_localization_domain'), $cat->name) . '">' . $cat->name . '</a>';
			
			// Add subcategories
			foreach ($subCats as $subCat){
				if( $subCat->parent == $cat->term_id ){
					if( $has_subCats ){
						$videoCatList .= '<li><a href="' . esc_attr(get_term_link($subCat, $getCat )) . '" title="' . sprintf(__('View All %s Members', 'my_localization_domain'), $subCat->name) . '">' . $subCat->name . '</a></li>'; 
					} else {
						$videoCatList .= '<ul class="children"><li><a href="' . esc_attr(get_term_link($subCat, $getCat )) . '" title="' . sprintf(__('View All %s Members', 'my_localization_domain'), $subCat->name) . '">' . $subCat->name . '</a></li>'; 
						$has_subCats = true;
					}
				}
			}

			if( $has_subCats ){
				$videoCatList .= '</ul>';
				$has_subCats = false;
			}

			$videoCatList .= '</li>';

		}
		if( $displayCats ){
			echo '<ul id="people_cats" class="children" style="display: none;">';
			echo $videoCatList;
			echo '</ul>';
		}
	}

	return $videoCatList;
}
function video_nav( $pageID = '' ){
	$pageID = $pageID || get_the_ID();
	$term_id = get_query_var('term_id');
	$currentPage = get_post( $pageID );

	echo '<nav class="pageNav sidebar"><h2><a href="'.get_bloginfo('url').'/videos/">Videos</a></h2><ul>';
	echo show_cats( false, 'video_cat' );
	echo '</ul></nav>';
}
add_shortcode('video_nav', 'video_nav');

/***Monographs***/
function gp_monographs() {
	$labels = array(
		'name' => _x('Monographs', 'post type general name'),
		'singular_name' => _x('Monograph', 'post type singular name'),
		'add_new' => _x('Add New', 'slider'),
		'add_new_item' => __('Add New Monograph'),
		'edit_item' => __('Edit Monograph'),
		'new_item' => __('New Monograph'),
		'all_items' => __('All Monographs'),
		'view_item' => __('View Monograph'),
		'search_items' => __('Search All Monographs'),
		'not_found'  => __('No Monographs found.'),
		'not_found_in_trash'  => __('No Monographs found in Trash.'),
		'parent_item_colon' => '',
		'menu_name'  => __('Monographs'),
	);

	$args = array(
		'labels' => $labels,
		'singular_label' => __('Monograph'),
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => true,
		'supports' => array('custom-fields'),
		'taxonomies' => array('monograph_cat'),

	);

	register_post_type( 'monographs', $args );
}
add_action('init', 'gp_monographs');

// Custom taxonomy for Monograph classifications
function monograph_cat() {
	// create a new taxonomy
	register_taxonomy(
		'monograph_cat',
		'monographs',
		array(
			'label' => __( 'Monograph Year' ),
			'sort' => true,
			'hierarchical' => true,
			'args' => array( 'orderby' => 'term_order' ),
			'query_var' => true,
			'rewrite' => false, /*array( 'slug' => 'group' )*/
		)
	);
}
add_action( 'init', 'monograph_cat' ); 

//Function for Monograph side Navigation
function monograph_nav( $pageID = '' ){
	$pageID = $pageID || get_the_ID();
	$term_id = get_query_var('term_id');
	$currentPage = get_post( $pageID );

	echo '<nav class="pageNav sidebar"><h2><a href="'.get_bloginfo('url').'/monographs/">Monographs</a></h2><ul>';
	echo show_cats( false, 'monograph_cat' );
	echo '</ul></nav>';
}
add_shortcode('video_nav', 'video_nav');

//Functions and Shortcodes for creating Accordian lists via shortcode
function accordionButton($atts, $content = null){
	return '<div class="accordionButton" >'.$content.'</div>';
}
function accordionContent($atts, $content = null){	
	return '<div class="accordionContent"><p>'.$content.'</p></div>';
}

//Custom Style Pagination Function
function my_paginate() {
	global $wp_query, $wp_rewrite;
	$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
 
	$pagination = array(
		'base' => @add_query_arg('page','%#%'),
		'format' => '',
		'total' => $wp_query->max_num_pages,
		'current' => $current,
		'show_all' => true,
		'type' => 'list',
		// 'next_text' => '&raquo;',
		// 'prev_text' => '&laquo;'
		);
 
	if( $wp_rewrite->using_permalinks() )
		if($_GET['video_cat']){			
			$tempVal = htmlspecialchars($_GET['video_cat']);
			$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 'video_cat', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' )."?video_cat=$tempVal";
		}
		 elseif($_GET['people_cat']){			
		  	$tempVal = htmlspecialchars($_GET['people_cat']);

		  	$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 'people_cat', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' )."?people_cat=$tempVal";
		  }
		else
			$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
 
		
	if( !empty($wp_query->query_vars['s']) )
		$pagination['add_args'] = array( 'video_cat' => get_query_var( 'video_cat' ) );
 
	echo paginate_links( $pagination );
}

add_shortcode('accordion-button', 'accordionButton');
add_shortcode('accordion-content', 'accordionContent');