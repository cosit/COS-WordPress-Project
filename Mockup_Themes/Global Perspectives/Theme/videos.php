<?php
/*
Template Name: Videos Template
*/
?>
<?php get_header(); ?>

<section id="main_content" class="subPage">
	<div class="wrap clearfix">
	<?php if (function_exists('breadcrumbs')) breadcrumbs(); ?>
	<?php get_search_form(); ?>	

	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>	

	<div id="sidebar" style="float: <?php echo get_option('COS_sidebar_location');?>;">
		<?php video_nav(); ?>
		<?php if(get_option('COS_show_sidebar')=='show') {
			get_sidebar();
		}?>
	</div>
		
	<div class="gp_videos innerContent">
		<article id="post-<?php the_ID(); ?>" <?php post_class('gp_event'); ?>>
			<header>
				<h1><?php the_title(); ?></h1>
				
			</header>				
			<?php the_content(); ?>
			<?php 
			  	$temp = $wp_query; 
			  	$wp_query = null; 
			  	$wp_query = new WP_Query(); 

				$wp_query->query('post_type=videos&showposts=10&orderby=date&order=DES'.'&paged='.$paged);

				echo '<div id="gp_videos">';

				while ($wp_query->have_posts()) : $wp_query->the_post(); 

					
					// Grab the Post ID for the Custom Fields Function			
					$thisID = get_the_ID();

					$video = array(
						'title' => get_field('title'),
						'url' => get_field('url'),
						'year' => get_field('year'),
					);
					
					$embedStart = strrpos($video['url'], "/")+1;					
					$video['url'] = substr($video['url'], $embedStart);		
					$imageURL = "http://i4.ytimg.com/vi/".$video['url']."/default.jpg"; 
					
					// display person if person is in category, or category is 'all'
					echo "<div>";
					echo do_shortcode("[video_lightbox_youtube video_id='".$video['url']."' width=640 height=480 anchor='".$imageURL."']"); 
					echo do_shortcode("[video_lightbox_youtube video_id='".$video['url']."' width=640 height=480 anchor='<h3>".$video['title']."</h3>']");					
					edit_post_link( 'Edit This Video', '', '' );
					echo "</div>";												
				endwhile; 		
			?>
				</div>
			<br/>
			
			<?php 	my_paginate();	?>
			
			<br style="clear: left;"/>
			<?php 
			  $wp_query = null; 
			  $wp_query = $temp;  // Reset
			?>
			
			<footer style="clear:both;">
				<?php edit_post_link( __( 'Edit', 'starkers' ), '', '' ); ?>
			</footer>
		</article>
	</div>
		

<?php endwhile; ?>
	</div> <!-- End Wrap -->
</section>

<?php get_footer(); ?>