<?php
/**
 * The Template for displaying custom taxonomies (mostly people).
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers HTML5 3.0
 */

get_header(); ?>

<section id="main_content">
	<div class="wrap clearfix">
	<?php if (function_exists('breadcrumbs')) breadcrumbs(); ?>
	<?php get_search_form(); ?>

		<div id="sidebar" style="float: <?php echo get_option('COS_sidebar_location');?>;">
		<?php monograph_nav( get_query_var('page_id') ); ?>
		<?php get_sidebar(); ?>
		</div> 
		
		<div class="gp_events innerContent">
			<article id="post-<?php the_ID(); ?>" <?php post_class('gp_event'); ?>>
				<header>
					<h1>Monographs <span>&raquo;</span> <?php echo ucwords( $_GET['monograph_cat'] ); ?> </h1>				
				</header>		
				<br/>			
				<?php 
					$catID = $_GET['monograph_cat'];
				  	$temp = $wp_query; 
				  	$wp_query = null; 
				  	$wp_query = new WP_Query(); 

					$wp_query->query('post_type=monographs&monograph_cat='.$catID.'&showposts=25&orderby=term_order&order=ASC'.'&paged='.$paged);
				

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
							<article class="gp_event clearfix">
							<a href="{$monograph['file']}" target="_blank">
							<img src="{$monograph['cover_thumb']}" alt="{$monograph['title']}" align="left" style="margin-right: 20px;">
							<h2>{$monograph['author']}</h2>
							<h3>{$monograph['title']}</h3>
							</a>
							<br/>
							<p><a href="{$monograph['file']}" target="_blank">View the Monograph</a></p>
							
							<div style="clear:both; height:1px; margin-bottom:-1px;">&nbsp;</div>
							
						
END;
					
						edit_post_link( 'Edit This Event', '', '' );
						echo "</article>";												
					endwhile; 		
				?>
					
				<br/>
				<nav>
				    <span class="older"><?php next_posts_link('Older &raquo;'); ?></span>
				    <span class="newer"><?php previous_posts_link('&laquo; Newer'); ?></span>		    
				</nav>

				<?php 
				  $wp_query = null; 
				  $wp_query = $temp;  // Reset
				?>
							
				<footer>
					<?php edit_post_link( __( 'Edit', 'starkers' ), '', '' ); ?>
				</footer>
			</article>
		</div>


	</div> <!-- End Wrap -->
</section>

<?php get_footer(); ?>