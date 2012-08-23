<?php
/*
Template Name: Events - Upcoming
*/
?>
<?php get_header(); ?>

<section id="main_content" class="subPage">
	<div class="wrap clearfix">
	<?php if (function_exists('breadcrumbs')) breadcrumbs(); ?>
	<?php get_search_form(); ?>	

	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>	

	<div id="sidebar" style="float: <?php echo get_option('COS_sidebar_location');?>;">
		<?php if(get_option('COS_pagenav_type')=='custom') {
			custom_menu_nav();
		} else {
			page_nav(); 
		}?>
		<?php if(get_option('COS_show_sidebar')=='show') {
			get_sidebar();
		}?>
	</div>
		
	<div class="gp_events innerContent">
		<article id="post-<?php the_ID(); ?>" <?php post_class('gp_event'); ?>>
			<header>
				<h1>Upcoming Events</h1>

			</header>				

			<?php 
			  	$temp = $wp_query; 
			  	$wp_query = null; 
			  	$wp_query_args = array(
			  		'post_type' => 'events',
					'showposts' => 10,
					'meta_key' => 'date',
					'meta_value' => date("Y/m/d"),
					'meta_compare' => '>=',
					'orderby' => 'meta_value',
					'order' => 'ASC',
					'paged' => $paged,
			  	);
			  	$wp_query = new WP_Query( $wp_query_args ); 


				// $wp_query->query();

				echo '<div id="gp_events">';

				while ($wp_query->have_posts()) : $wp_query->the_post(); 

					
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
						'link' => get_permalink(),
					);

					foreach( $event as $key => &$value ){
						// Force values as strings, not array remnants
						$value = is_array($value) ? $value[0] : $value;

						if($key != 'text'){
							$value = strip_tags( $value );
						}
					}

// DO NOT EDIT ANY OF THIS OR I WILL BUY YOU MCDONALDS AND EXPOSE YOU TO THE RISK OF OBESITY SO HELP ME GOD
		$IMG_DIR_PATH = 'http://globalperspectives.cos.ucf.edu/app/webroot/redesign/wp-content/uploads/events/';
		
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
			
					// display event if event is in category, or category is 'all'
					?>
					<article class="gp_event clearfix">
						<div class="gp_eventDate"><?php echo $event['date']; ?></div>
						<div class="gp_eventInfo">				
							<?php echo $img; ?>
			 				<h2><a href="<?php echo $event['link'];?>" title="<?php echo $event['title'];?>"><?php echo $event['title'];?></a></h2> 
					<?php if( strlen($event['topic']) > 0 ) : ?>
							<h3><?php echo $event['topic']; ?></h3>
					<?php endif; ?>				
							<p><?php echo $event['text']; ?></p>
							<p class="gp_event_time"><strong>Time:</strong> <?php echo $event['date_long']; ?></p>
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

				endwhile; 

			?>
			<br/>
			<?php my_paginate() ?>
			<!-- <nav>
			    <span class="older"><?php next_posts_link('Older &raquo;'); ?></span>
			    <span class="newer"><?php previous_posts_link('&laquo; Newer'); ?></span>		    
			</nav> -->

			<?php 
			  $wp_query = null; 
			  $wp_query = $temp;  // Reset
			?>
						
			<footer>
				<?php edit_post_link( __( 'Edit', 'starkers' ), '', '' ); ?>
			</footer>
		</article>
	</div>
		

<?php endwhile; ?>
	</div> <!-- End Wrap -->
</section>

<?php get_footer(); ?>