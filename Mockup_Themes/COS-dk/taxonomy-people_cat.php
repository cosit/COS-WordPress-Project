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

		<div class="innerContent">
			<h1>People <span>&raquo;</span> <?php echo ucwords( $_GET['people_cat'] ); ?> </h1>
			<?php show_people( $_GET['people_cat'] ); ?>
		</div>
		<div id="sidebar">
			<?php people_nav( get_query_var('page_id') ); ?>
			<?php get_sidebar(); ?>
		</div>

	</div> <!-- End Wrap -->
</section>

<?php get_footer(); ?>