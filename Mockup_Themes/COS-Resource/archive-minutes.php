<?php
/**
 * The Template for displaying recent posts.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers HTML5 3.0
 */

get_header(); ?>
<?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); ?>

<section id="main_content">
	<div class="wrap clearfix">
	<?php if (function_exists('breadcrumbs')) breadcrumbs(); ?>
	<?php get_search_form(); ?>

		<div id="sidebar" style="float: <?php echo get_option('COS_sidebar_location');?>;">		
		<?php get_sidebar(); ?>
		</div> 

<?php 
    // Enable Pagination
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    $args = array(
    	'post_type' => 'minutes',
    	'paged' => $paged,
    	);

	query_posts($args); ?>

	<div class="innerContent">	
		<h1>Most Recent Toolbox Entries: </h1>
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); 
		$thisID = $post->ID;
	?>		
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>					
				</header>
				<div class="tbSummaryEntry">
					<h3>Description</h3>
					<p><?php echo get_post_meta($thisID, 'wpcf-question-activity-description', true);?></p>

					<a href="<?php the_permalink(); ?>">...Read full entry</a><br/><br/>
					<?php

					echo "<h3>Question / Activity Categories</h3>";

					$cats =  get_the_terms($thisID, "subject-matter");
					if($cats){
						
						foreach ($cats as $cat) {
							echo "<span>".($cat->name != 'Subject Matter'? "<a href=\"".get_term_link($cat->slug, 'subject-matter')."\">".strtoupper($cat->name)."</a></span>" : ''); 
						}
					} else{
						echo "<p>This Toolbox Entry has not been associated with any category.</p>";
					}


					/*echo "<br/><br/><h2>Question / Activity Description";
					the_meta();*/
				?>
				</div>			
				<footer>
					<?php edit_post_link( __( 'Edit', 'starkers' ), '', '' ); ?>
				</footer>
				
			</article>
	<?php endwhile; posts_nav_link(); ?>

	</div>

	</div> <!-- End Wrap -->
</section>

<?php get_footer(); ?>