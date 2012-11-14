<?php
/**
 * The loop that displays a page.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers HTML5 3.2
 */
?>

<section id="main_content">
	<div class="wrap clearfix">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

	<?php if (function_exists('breadcrumbs')) breadcrumbs(); ?>
	<?php get_search_form(); ?>
			
		<div class="innerContent">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header>
					<h1><?php the_title(); ?></h1>
				</header>				

					<?php the_content(); ?>
							
					<?php wp_link_pages( array( 'before' => '<nav>' . __( 'Pages:', 'starkers' ), 'after' => '</nav>' ) ); ?>
							
				<footer>
					<?php edit_post_link( __( 'Edit Page', 'starkers' ), '', '' ); ?>
				</footer>
			</article>
		</div>
		<div id="sidebar" style="float:right;">
				<nav class="pageNav"><h2>News Archives</h2>
					<ul><?php /*Exclude the 'Did You Know' category #18*/ wp_list_categories('exclude=18&title_li='); ?></ul>
				</nav>
				<!--<?php //custom_menu_nav(); ?>-->
				<?php get_sidebar(); ?> 

		</div>
<?php endwhile; ?>
	</div> <!-- End Wrap -->
</section>

