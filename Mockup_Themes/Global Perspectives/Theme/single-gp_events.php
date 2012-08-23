<?php
/**
 * The Template for displaying a single event.
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
		<div id="single_person" class="innerContent">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

			<h1>Event <span>&raquo;</span> <?php echo $post->post_title; ?> </h1>
				<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> >
				<?php show_gp_event(); ?>
				</article>
		</div>
asdfasdf
	<div id="sidebar" style="float: <?php echo get_option('COS_sidebar_location');?>;">
		<?php get_sidebar(); ?>
	</div>
	
<?php endwhile; ?>
	</div>
</section>

<?php get_footer(); ?>

