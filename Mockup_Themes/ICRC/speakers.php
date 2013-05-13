<?php
/*
Template Name: Speakers List
*/
?>
<?php get_header(); ?>

<section id="main_content" class="peopleContent">
	<div class="wrap clearfix">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

	<?php if (function_exists('breadcrumbs')) breadcrumbs(); ?>
	<?php get_search_form(); ?>
		<div id="sidebar" style="float: <?php echo get_option('COS_sidebar_location');?>;">
			<?php if(get_option('COS_pagenav_type') =='custom') {
				custom_menu_nav();
			} else {
				page_nav(); 
			}?>
			<?php get_sidebar(); ?>
		</div>	
		<div class="innerContent">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header>
					<h1><?php the_title(); ?></h1>
				</header>				

					<?php show_people(); ?>
							
				<footer>
					<?php edit_post_link( __( 'Edit', 'starkers' ), '', '' ); ?>
				</footer>
			</article>
		</div>
		

<?php endwhile; ?>
	</div> <!-- End Wrap -->
</section>

<?php get_footer(); ?>