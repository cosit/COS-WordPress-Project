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
		<?php people_nav( get_query_var('page_id') ); ?>
		<?php get_sidebar(); ?>
		</div> 
		
		<div class="innerContent">
			<article id="post-<?php the_ID(); ?>" <?php post_class('gp_event'); ?>>
				<header>
					<h1>People <span>&raquo;</span> <?php echo ucwords( str_replace("-"," ", $_GET['people_cat']) ); ?> </h1>	
				</header>				
				<?php 

			  	$catID = $_GET['people_cat'];
			  	$temp = $wp_query; 
			  	$wp_query = null; 
			  	$wp_query = new WP_Query(); 



			  	if($catID == 'fellows-and-scholars'){
			  		$termChildren = get_term_children('29', 'people_cat');
			  		print_r($myTaxes);
			  	
				  	echo "<h2>List of Current / Past Fellows and Scholars: By Semester</h2><ul class=\"listTaxonomies\">";
				     foreach ( $termChildren as $child ) {
				       $term = get_term_by( 'id', $child, 'people_cat');
				       echo "<li><h2><a href=\"?people_cat=".$term->slug."\">". $term->name . "</a></h2></li>";				        
				     }
				     echo "</ul>";
				}elseif($catID == 'past-interns'){
			  		$termChildren = get_term_children('28', 'people_cat');
			  		print_r($myTaxes);
			  	
				  	echo "<h2>List of Past Interns: By Semester</h2><ul class=\"listTaxonomies\">";
				     foreach ( $termChildren as $child ) {
				       $term = get_term_by( 'id', $child, 'people_cat');
				       echo "<li><h2><a href=\"?people_cat=".$term->slug."\">". $term->name . "</a></h2></li>";				        
				     }
				     echo "</ul>";
				}else{
								
					$wp_query->query('post_type=gp_people&people_cat='.$catID.'&posts_per_page=7'.'&paged='.$paged);
					
					echo '<div id="people_list">';

					while ($wp_query->have_posts()) : $wp_query->the_post(); 

						
						// Grab the Post ID for the Custom Fields Function			
						$thisID = get_the_ID();

						$person = array(
							'first_name'  => get_field('first_name'),
							'last_name'  => get_field('last_name'),
							'photo'       => get_field('headshot'),
							'position'    => get_field('position'),
							'biography'   => get_field('biography'),
						);
						
						// display person if person is in category, or category is 'all'
						echo <<<PEOPLE
						<article class="person clearfix {$cats}">
							
								<img src="{$person['photo']}" alt="{$person['last_name']}, {$person['first_name']}" align="left" style="float:left;" />
								<a href="{$person['link']}" class="personLink" title="{$person['last_name']}, {$person['first_name']}"></a>
							
							
								<h2>{$person['first_name']} {$person['last_name']}</h2>
								<h3>{$person['position']}</h3>
								<div class="personBio">{$person['biography']}</div>
							
							
							<div style="clear:both; height:1px; margin-bottom:-1px;">&nbsp;</div>
PEOPLE;

						edit_post_link( 'Edit This Person', '', '' );	
						echo '</article>';											
					endwhile; 		
					?>
						</div>
					<br/>
				
					<?php 	my_paginate();	?>
					
					<br style="clear: left;"/>
					<?php 
					  $wp_query = null; 
					  $wp_query = $temp;  // Reset
				
				}
				?>
				<footer>
					<?php edit_post_link( __( 'Edit', 'starkers' ), '', '' ); ?>
				</footer>
			</article>
		</div>


	</div> <!-- End Wrap -->
</section>

<?php get_footer(); ?>