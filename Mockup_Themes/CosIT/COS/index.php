<?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers HTML5 3.0
 */
 
get_header(); ?>
 

<section id="sliderbox">
	<!-- jQuery slider will be implemented here, and pulled from 'slider' category of posts -->

	<?php show_slider_items(); ?>
	
</section>

<!-- Contact box - not a section because it lies on top of slider -->
<div id="contactContainer">
	<div id="contact" style="float:right;">
		<?php get_search_form(); ?> <!-- grabs custom search form at searchform.php -->

		<?php show_contact_area(); ?>
	</div>
	<div style="clear:both;"></div>
</div>

<!-- Main box links for dept websites; e.g. "Undergraduate", "Graduate", "Research" -->
<section id="main_links">
	<div class="wrap">
		<?php show_main_links(); ?>
	</div>
</section>


<!-- Central content for dept home page - default shown is News + Events -->
<section id="main_content">
	<div class="wrap clearfix">
		<?php if ( is_active_sidebar( 'front-left-widget-area' ) ) : ?>
			<?php dynamic_sidebar( 'front-left-widget-area' ); ?>
		<?php endif; ?>
		<?php // show_news(); ?>

		<?php if ( is_active_sidebar( 'front-right-widget-area' ) ) : ?>
			<?php dynamic_sidebar( 'front-right-widget-area' ); ?>
		<?php endif; ?>

	</div>
</section>
 
<!-- <?php // get_sidebar(); ?>  Sidebar is hidden on main page -->


<?php get_footer(); ?>

