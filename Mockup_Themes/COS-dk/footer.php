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
		<a href="top"></a>
	</div>

	<footer><div class="wrap">
		


<?php
	get_sidebar( 'footer' );
?>

		<a href="<?php echo home_url( '/' ) ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<?php bloginfo( 'name' ); ?>
		</a>

		<?php do_action( 'starkers_credits' ); ?>
		
		<a href="<?php echo esc_url( __('http://wordpress.org/', 'starkers') ); ?>" title="<?php esc_attr_e('Semantic Personal Publishing Platform', 'starkers'); ?>" rel="generator"> 
			<?php printf( __('Proudly powered by %s.', 'starkers'), 'WordPress' ); ?>
		</a>

	</div></footer>

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>

<!-- All of our jQuery scripts go here -->
<script type="text/javascript">
	var colorDarkBlue = "#22282D";
	var colorOffWhite = "#F2F2F2";
	var colorBlueGray = "#475159";
	var colorLightBlueGray = "#6C747A";


	// Slider
	$('.sliderItems').flexslider();
	$('ul.slides li').each(function(){
		// Relocates the image to outside the post body so it can be manipulated
		$(this).append($(this).find("img").remove());
	});

	// Main nav links and dropdown menu
	$('nav>ul>li').hover(
		function(){
			$(this).find('ul.children').slideDown('fast').show(); 
			$(this).children('a').animate({ backgroundColor: colorOffWhite, color: colorDarkBlue }, 'medium').addClass('navLinkHover');
		},
		function(){ 
			$(this).find('ul.children').slideUp('fast');
			$(this).children('a').animate({ backgroundColor: colorDarkBlue, color: colorOffWhite }, 'medium').removeClass('navLinkHover');
		}
	);

	// Submenu links
	$('nav ul.children>li').hover(
		function(){ $(this).animate({ backgroundColor: colorLightBlueGray }, 'medium')},
		function(){ $(this).animate({ backgroundColor: colorBlueGray }, 'medium')}
	);

	// Contact Box and Search Form
	$('#searchform #s').focusin(function(){
		$(this).addClass('searchFocus').val('');
	});
	$('#searchform #s').focusout(function(){
		$(this).removeClass('searchFocus').val('Search <?php bloginfo( "name" ); ?>...');
	});
	$('#contact h2').wrapInner('<span />');
	$('#contact ul:nth-child(odd)').addClass('contactOdd');

	// Events styling for date
	$('.eventDate').each(function(){
		var monthNames = monthNames || ['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC'];
		var $this = $(this);
		var rawDate = $this.html();
		// var date = rawDate.split(/[\/-]/);
		var date = rawDate.split(' ');
		var day = date[0].trim();
		var month = date[1].trim();
		var year = date[2].trim();

		// formats and outputs the date in a template that can be styled
		$this.html('<ul><li id="eventMonth">'+month+'</li>'
						+'<li id="eventDay">'+day+'</li>'
						+'<li id="eventYear">'+year+'</li>'
						+'<li id="eventDate">'+rawDate+'</ul>');
	});
	$('.events article').click(function(){
		window.location = $(this).find('a').attr('href');
	});

	// Back to top button
	$('#backToTop>a').click(function(){
		$('html, body').animate({scrollTop: 0}, 'medium', 'easeInOutCubic');
		return false;
	});
	$(window).scroll(function(){
		if( $(window).scrollTop() > 10 ){
			$('#backToTop').fadeIn('slow');
		} else {
			$('#backToTop').fadeOut('slow');
		}
	})

</script>

</body>
</html>