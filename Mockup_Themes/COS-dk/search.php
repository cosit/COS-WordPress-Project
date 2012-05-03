<?php
/**
 * The template for displaying Search Results pages.
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
		<div id="search_results" class="innerContent">

		<?php if (have_posts()) : ?>
			<h1><?php printf( __( 'Search Results for: <span>%s</span>', 'starkers' ), '' . get_search_query() . '' ); ?></h1>
			<?php while (have_posts()) : the_post(); ?>
				<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
					<h2><a href="?page_id=<?php the_ID();?>"><?php the_title(); ?></a></h2>			
					<div class="entry">
						<?php the_excerpt(); ?>
					</div>
				</div>
			<?php endwhile; ?>
	
			<?php
				get_template_part( 'loop', 'search' );
			?>
		<?php else : ?>
		<h1><?php printf( __( 'Nothing Found for: <span>%s</span>', 'starkers' ), '' . get_search_query() . ''); ?></h1>
			<h2><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'starkers' ); ?></h2>
		<?php endif; ?>
		</div> <!-- End innerContent -->
	</div> <!-- End Wrap -->
</section>

<?php get_footer(); ?>