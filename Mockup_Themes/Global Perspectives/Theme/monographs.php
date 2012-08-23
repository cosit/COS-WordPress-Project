<?php
/*
Template Name: Monographs Template
*/
?>
<?php get_header(); ?>

<section id="main_content" class="subPage">
	<div class="wrap clearfix">
	<?php if (function_exists('breadcrumbs')) breadcrumbs(); ?>
	<?php get_search_form(); ?>	

	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>	

	<div id="sidebar" style="float: <?php echo get_option('COS_sidebar_location');?>;">
		<?php monograph_nav(); ?>
		<?php if(get_option('COS_show_sidebar')=='show') {
			get_sidebar();
		}?>
	</div>
		
	<div class="gp_monographs innerContent">
		<article id="post-<?php the_ID(); ?>" <?php post_class('gp_event'); ?>>
			<header>
				<h1><?php the_title(); ?></h1>
				
			</header>				
			<?php the_content(); ?>
		</article>
						
			<?php 
			  	$temp = $wp_query; 
			  	$wp_query = null; 
			  	$wp_query = new WP_Query(); 

				$wp_query->query('post_type=monographs&showposts=10&orderby=date&order=ASC'.'&paged='.$paged);
			

				while ($wp_query->have_posts()) : $wp_query->the_post(); 

					
					// Grab the Post ID for the Custom Fields Function			
					$thisID = get_the_ID();

					$monograph = array(
						'title' => get_field('title'),
						'author' => get_field('author'),
						'cover_thumb' => get_field('cover_thumbnail'),
						'file' => get_field('monograph_file'),
					);
											
					// display person if person is in category, or category is 'all'
					echo <<<END
						<article class="gp_monograph clearfix">
						<a href="{$monograph['file']}" target="_blank">
						<img src="{$monograph['cover_thumb']}" alt="{$monograph['title']}" align="left" style="margin-right: 20px;">
						<h2>{$monograph['author']}</h2>
						<h3>{$monograph['title']}</h3>
						</a>
						<br/>
						<p><a href="{$monograph['file']}" target="_blank">View the Monograph</a></p>
						
						<div style="clear:both; height:1px; margin-bottom:-1px;">&nbsp;</div>
						
					
END;
				
					edit_post_link( 'Edit This Monograph', '', '' );
					echo "</article>";												
				endwhile; 

			?>
			<br/>
						
			<?php 	my_paginate();	?>
			
			<br style="clear: left;"/>

			<?php 
			  $wp_query = null; 
			  $wp_query = $temp;  // Reset
			?>
						
			<footer>
				<?php edit_post_link( __( 'Edit', 'starkers' ), '', '' ); ?>
			</footer>
	</div>
		

<?php endwhile; ?>
	</div> <!-- End Wrap -->
</section>

<?php get_footer(); ?>