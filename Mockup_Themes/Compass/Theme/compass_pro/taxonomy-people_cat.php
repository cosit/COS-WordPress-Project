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
			<h1>People <span>&raquo;</span> <?php echo ucwords( preg_replace("/-/", " ", $_GET['people_cat'] ) ); ?> </h1>
			<?php show_people( $_GET['people_cat'] ); ?>
		</div>

		<div id="sidebar">
			<?php if(get_option('COS_pagenav_type')=='custom') {
				custom_menu_nav();
			} else {
				page_nav(); 
			}?>
			<?php if(get_option('COS_show_sidebar')=='show') {
				get_sidebar();
			}?>
		</div>

	</div> <!-- End Wrap -->
</section>

<?php get_footer(); ?>