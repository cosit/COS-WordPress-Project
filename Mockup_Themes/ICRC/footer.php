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
	<?php  
	//If there is nothing in any of the footer widgets show nothing
	if (   ! is_active_sidebar( 'first-footer-widget-area'  )
	    && ! is_active_sidebar( 'second-footer-widget-area' )
		&& ! is_active_sidebar( 'third-footer-widget-area'  )		
	        ){}
	else{ 
	//Display the widget content
	?>
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
	<?php } ?>

	<section id="the_footer">
				
			<?php show_social(); ?>
			<h3 id="copyright">Copyright © <?php echo date(Y);?> UCF, All Rights Reserved</h3>
		
		<div class="footer_right">
			<?php if ( is_active_sidebar( 'footer-menu-area' ) ) : 
                dynamic_sidebar( 'footer-menu-area' ); 
                  endif; ?>
		</div>
		
	</section>
</footer>

<?php wp_footer(); ?>

</body>
</html>