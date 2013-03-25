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

	<section id="widgets">
		<div id="widget_container">
			<div id="first-footer-widget-area" class="widget">
				<?php if ( is_active_sidebar( 'first-footer-widget-area' ) ) : ?>
					<?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
				<?php endif; ?>
				
			</div>

			<?php if ( is_active_sidebar( 'second-footer-widget-area' ) ) : ?>
			<div id="second-footer-widget-area" class="widget">
				
					<?php dynamic_sidebar( 'second-footer-widget-area' ); ?>
			</div>
			<?php endif; ?>

			<div id="third-footer-widget-area" class="widget">
				<?php if ( is_active_sidebar( 'third-footer-widget-area' ) ) : ?>
					<?php dynamic_sidebar( 'third-footer-widget-area' ); ?>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<section id="the_footer">
		<div class="wrap">
			
		<?php 			
			show_people_cats(); /* Important: do not remove  */
		?>

			<div class="dept_list">
				<h1><span><a href="http://ucf.edu">UCF</a></span> <a href="http://www.cos.ucf.edu">College of Sciences</a></h1>
				<ul>
					<li><a href="http://anthropology.cos.ucf.edu" target="_blank">Anthropology</a></li>
					<li><a href="http://biology.cos.ucf.edu" target="_blank">Biology</a></li>
					<li><a href="http://chemistry.cos.ucf.edu" target="_blank">Chemistry</a></li>
					<li><a href="http://communication.cos.ucf.edu" target="_blank">Communication</a></li>
					<li><a href="http://math.cos.ucf.edu" target="_blank">Mathematics</a></li>
					<li><a href="http://physics.cos.ucf.edu" target="_blank">Physics</a></li>
					<li><a href="http://politicalscience.cos.ucf.edu" target="_blank">Political Science</a></li>
					<li><a href="http://psychology.cos.ucf.edu" target="_blank">Psychology</a></li>
					<li><a href="http://sociology.cos.ucf.edu" target="_blank">Sociology</a></li>
					<li><a href="http://statistics.cos.ucf.edu" target="_blank">Statistics</a></li>
				</ul>
			</div>
		</div>

		<h3 id="copyright">© <?php echo date(Y);?> University of Central Florida, College of Sciences, All Rights Reserved</h3>
	</section>

</footer>

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>

<script src="<?php bloginfo('template_directory'); ?>/js/cos.js"></script>

<!-- ADD UCF HEADER -->
<script type="text/javascript" src="http://universityheader.ucf.edu/bar/js/university-header.js"></script>
<!-- END UCF HEADER -->
</body>
</html>