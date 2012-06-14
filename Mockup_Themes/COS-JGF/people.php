<?php
/*
Template Name: People List
*/
?>
<?php get_header(); ?>

<section id="main_content">
	<div class="wrap clearfix">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

	<?php if (function_exists('breadcrumbs')) breadcrumbs(); ?>
	<?php get_search_form(); ?>
		<div class="innerContent">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header>
					<h1><?php the_title(); ?></h1>
					<!-- <a class="sort_people" href="#">Sort Alphabetically</a> -->
				</header>				

					<?php show_people(); ?>
							
				<footer>
					<?php edit_post_link( __( 'Edit', 'starkers' ), '', '' ); ?>
				</footer>
			</article>
		</div>
		
		<div id="sidebar">
		<?php people_nav(); ?>
		<?php get_sidebar(); ?>
		</div>	
<?php endwhile; ?>
	</div> <!-- End Wrap -->
</section>

<?php get_footer(); ?>