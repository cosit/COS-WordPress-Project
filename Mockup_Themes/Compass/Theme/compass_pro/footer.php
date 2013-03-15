<?php
/**
 * The template for displaying the footer.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers HTML5 3.0
 */
?>
	<div id="backToTop">
		<a href="#top"></a>
	</div>
</div> <!-- /container -->

<footer id="main_footer">
	<!-- Bottom widgets -->

	<?php /*<section id="widgets">
		<div id="widget_container">
			<div id="first-footer-widget-area" class="widget">
				<?php if ( is_active_sidebar( 'first-footer-widget-area' ) ) : ?>
					<?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
				<?php endif; ?>
			</div>

			<div id="second-footer-widget-area" class="widget">
				<?php if ( is_active_sidebar( 'second-footer-widget-area' ) ) : ?>
					<?php dynamic_sidebar( 'second-footer-widget-area' ); ?>
				<?php endif; ?>
			</div>

			<div id="third-footer-widget-area" class="widget">
				<?php if ( is_active_sidebar( 'third-footer-widget-area' ) ) : ?>
					<?php dynamic_sidebar( 'third-footer-widget-area' ); ?>
				<?php endif; ?>
			</div>
		</div>
	</section> */?>

	<section id="the_footer">
		<div class="wrap">
			
		<?php 
			// get_sidebar( 'footer' );
			show_people_cats(); /* Important: do not remove  */
		?>

			<img src="<?php bloginfo('template_directory')?>/css/img/ucf-stands.png" title="" alt="UCF Stands for Opportunity" />
			<img src="<?php bloginfo('template_directory')?>/css/img/ucf50.png" title="" alt="UCF 50th" />
			<a href="http://www.nsf.gov" target="_blank"><img src="<?php bloginfo('template_directory')?>/css/img/NSF_Logo.png" title="National Science Foundation" alt="NSF"></a>
			
		</div>		
	</section>
</footer>

<?php wp_footer(); ?>

</body>
</html>