<?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers HTML5 3.0
 */
 
get_header(); ?>
 

<section id="slider">	
	<?php show_slider_items(); ?>
</section>

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

