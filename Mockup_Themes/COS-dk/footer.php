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
	</section>

	<section id="the_footer">
		<div class="wrap">
			
		<?php 
			// get_sidebar( 'footer' );
			show_people_cats(); /* Important: do not remove  */
		?>

			<div class="dept_list">
				<h1><span>UCF</span> College of Sciences</h1>
				<ul>
					<li><a href="http://anthropology.cos.ucf.edu" target="_new">Anthropology</a></li>
					<li><a href="http://biology.cos.ucf.edu" target="_new">Biology</a></li>
					<li><a href="http://chemistry.cos.ucf.edu" target="_new">Chemistry</a></li>
					<li><a href="http://communication.cos.ucf.edu" target="_new">Communication</a></li>
					<li><a href="http://math.cos.ucf.edu" target="_new">Mathematics</a></li>
					<li><a href="http://physics.cos.ucf.edu" target="_new">Physics</a></li>
					<li><a href="http://politicalscience.cos.ucf.edu" target="_new">Political Science</a></li>
					<li><a href="http://psychology.cos.ucf.edu" target="_new">Psychology</a></li>
					<li><a href="http://sociology.cos.ucf.edu" target="_new">Sociology</a></li>
					<li><a href="http://statistics.cos.ucf.edu" target="_new">Statistics</a></li>
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

<script type="text/javascript">

</script>

<!-- All of our jQuery scripts go here -->
<!-- ADD UCF HEADER -->
<script type="text/javascript" src="http://universityheader.ucf.edu/bar/js/university-header.js"></script>
<!-- END UCF HEADER -->

</body>
</html>