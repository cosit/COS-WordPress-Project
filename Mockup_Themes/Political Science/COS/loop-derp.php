<?php
/*
Template Name: Archives
*/

$cat_obj = $wp_query->get_queried_object();
$catID = $cat_obj->term_id;

$args = array(
    'numberposts'     => 50,
    'offset'          => 0,
    'category'        => $catID,
    'orderby'         => 'post_date' ); 
?>
		<?php the_post(); ?>		
			
		<h2>Archives by Subject:</h2>
		<ul>
			 <?php $posts_array = get_posts( $args ); 

		foreach( $posts_array as $post ) :	setup_postdata($post); ?>
			<li><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3></li>
		<?php endforeach; ?>	 
		</ul>

