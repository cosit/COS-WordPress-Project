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
			<?php if(get_option('COS_pagenav_type') =='custom') {
				custom_menu_nav();
			} else {
				page_nav(); 
			}?>
			<?php get_sidebar(); ?>
		</div>		
		<div id="single_person" class="innerContent">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

			<h1>Speaker <span>&raquo;</span> <?php $title = preg_split('/,/', $post->post_title); echo $title[1] . ' ' . $title[0]; ?> </h1>
				<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> >
				<?php show_person( get_the_ID(), false ); ?>
				
					<footer>
						<?php edit_post_link( __( 'Edit Person', 'starkers' ), '', '' ); ?>
					</footer>
				</article>
		</div>
	
<?php endwhile; ?>
	</div>
</section>

<?php get_footer(); ?>

