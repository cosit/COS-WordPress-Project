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
			
		<?php show_people_cats(); ?> <!-- Important: do not remove  -->
			<?php show_social(); ?>  			
			<p class="center">
				Office of the Special Assistant to the President for Global Perspectives <br />University of Central Florida, Howard Phillips Hall 202,<br />
				4000 Central Florida Blvd, P.O. Box 160003, Orlando, FL 32816 - (407) 823-0688<br/>
				© <?php echo date(Y);?> Global Perspectives, All Rights Reserved
			</p>
			<div class="right">
				<!-- Begin MailChimp Signup Form -->
				<style type="text/css">
				                #mce-EMAIL {
				                	border: 1px solid gray;
				                	padding: 5px;
				                	margin: 5px 0;
				                }
				                #mc-embedded-subscribe {
				                	border: 1px solid gray;
				                	padding: 5px;

				                }
				                #mc-embedded-subscribe:active {
				                	-moz-box-shadow: inset 0px 2px 5px gray;
				                	-webkit-box-shadow: inset 0px 2px 5px gray;
				                	box-shadow: inset 0px 2px 5px gray;
				                	padding-top: 6px;
				                	padding-bottom: 4px;
				                }
				</style>
				<div id="mc_embed_signup">
				<form action="http://ucfglobalperspectives.us2.list-manage2.com/subscribe/post?u=d81e72be623226ed7d732e621&amp;id=84544adfc5" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
				                <label for="mce-EMAIL">Subscribe to our mailing list</label>
				                <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
				                <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
				</form>
				</div>
				 
				<!--End mc_embed_signup-->
			</div>
		</div>

		
	</section>
</footer>

<?php wp_footer(); ?>

</body>
</html>