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
		<div id="single_person" class="innerContent">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

			<h1>People <span>&raquo;</span> <?php $title = preg_split('/,/', $post->post_title); echo $title[1] . ' ' . $title[0]; ?> </h1>
				<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> >
				<!--[if lt IE 9]> <?php show_person( get_the_ID(), true ); ?> <![endif]-->
				<!--[if IE 9]><?php show_person( get_the_ID(), false ); ?> <![endif]-->
				<!--[if !IE]><!--> <?php show_person( get_the_ID(), false ); ?> <!--<![endif]-->
				
					<footer>
						<?php edit_post_link( __( 'Edit Person', 'starkers' ), '', '' ); ?>
					</footer>
				</article>
		</div>

	<div id="sidebar">
		<?php people_nav(); ?>
		<?php get_sidebar(); ?>
	</div>
	
<?php endwhile; ?>
	</div>
</section>

<?php get_footer(); ?>

