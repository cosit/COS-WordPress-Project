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

			<div class="dept_list">
				<div class="ucf50"></div>
			</div>
		</div>		
	</section>
</footer>

<?php wp_footer(); ?>

<!-- ADD UCF HEADER -->
<script type="text/javascript" src="http://universityheader.ucf.edu/bar/js/university-header.js"></script>
<!-- END UCF HEADER -->

</body>
</html>