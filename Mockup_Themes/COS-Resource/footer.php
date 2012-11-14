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
			show_people_cats(); /* Important: do not remove  */
		?>

			<div class="dept_list">
				<h1><span><a href="http://ucf.edu">UCF</a></span> <a href="http://www.cos.ucf.edu">College of Sciences</a></h1>
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

<!-- All of our jQuery scripts go here -->
<script type="text/javascript">
	var colorDarkBlue = "#22282D";
	var colorOffWhite = "#F2F2F2";
	var colorBlueGray = "#475159";
	var colorLightBlueGray = "#6C747A";

	// Slider
	try{
		$('.sliderItems').flexslider({
			animation: "fade",
			slideshow: "true",
			slideshowSpeed: 7000,
			directionNav: true,
			controlNav: true
		});
	} catch(err) {
		//console.log('flexslider.js not loaded.');
	}

	// Indicate people nav link
	$('#main_header nav>ul>li>a:contains("People")').parent().addClass('peopleNav');

    // Display people categories in nav menu
	$('.peopleNav').append( $('#people_cats') );

	// Main nav links and dropdown menu
	$('#main_header nav>ul>li').hover(
		function(){
			$(this).children('ul.children').slideDown('').show(); 
			$(this).children('ul.sub-menu').slideDown('').show(); 

		},
		function(){ 
			if( !$(this).hasClass('current_page_item') ){
				$(this).children('ul.children').hide();
				$(this).children('ul.sub-menu').hide();
			} else {
				$(this).children('ul.children').hide();
				$(this).children('ul.sub-menu').hide();
			}
		}
	);
	$('#main_header nav>ul>li>ul>li').hover(
		function(){
			$(this).children('ul.children').slideDown('').show();
			$(this).children('ul.sub-menu').slideDown('').show();
		},
		function(){ 
			if( !$(this).hasClass('current_page_item') ){
				$(this).children('ul.children').hide();
				$(this).children('ul.sub-menu').hide();
			} else {
				$(this).children('ul.children').hide();
				$(this).children('ul.sub-menu').hide();
			}
		}
	);

	$('#main_header nav>ul>li>ul>li>ul>li').hover(
		function(){
			$(this).children('ul.children').slideDown('').show();
			$(this).children('ul.sub-menu').slideDown('').show();
		},
		function(){ 
			if( !$(this).hasClass('current_page_item') ){
				$(this).children('ul.children').hide();
				$(this).children('ul.sub-menu').hide();
			} else {
				$(this).children('ul.children').hide();
				$(this).children('ul.sub-menu').hide();
			}
		}
	);

	// Contact Box and Search Form
	$('#searchform #s, #inner_searchform #s').focusin(function(){
		$(this).addClass('searchFocus').val('');
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

	// Back to top button
	var scrollToTop = function(){
		$('html, body').animate({scrollTop: 0}, 'medium'/*, 'easeInOutCubic'*/);
		return false;
	};

	$('#backToTop>a').click( scrollToTop );
	$(window).scroll(function(){
		if( $(window).scrollTop() > 10 ){
			$('#backToTop').fadeIn('slow');
		} else {
			$('#backToTop').fadeOut('slow');
		}
	});

	// Custom menu nav shenanigans 
	(function(){
		var top_level = $('#custom_menu_nav>div>ul li.current_page_item');
		//console.log( top_level.children('ul').length );
		if( top_level.children('ul').length > 0 ){
			$('#custom_menu_nav').prepend( top_level.children('ul').show() ).prepend('<h2>'+top_level.html()+'</h2>');
			$('#custom_menu_nav>div').hide();
		} else {
			top_level = top_level.parent().parent();
			//console.log(top_level);
			$('#custom_menu_nav').prepend( top_level.children('ul').show() ).prepend('<h2>'+top_level.html()+'</h2>');
			$('#custom_menu_nav>div').hide();
		}
	})();

	// Parent finding for nav li elements 
	$('nav li').has('.children, .sub-menu').addClass('parent');

	// Page nav expand
	$('.pageNav li.parent').prepend('<span class="expand"><div>+</div></span>');
	$('.pageNav .expand>div').click( function(){
		$this = $(this);
		$children = $this.parent().parent().children('.children, .sub-menu');
		if($children.is(':visible')){
			$this.text('+');
			$children.hide();
		} else {
			$this.text('-');
			$children.show();
		};
	});

	// Link Icons 
	$('.innerContent a').parent('li').addClass('link www');
	$('a[href$=\\.pdf], a[href$=\\.PDF]').parent('li').removeClass('www').addClass('pdf');
	$('a[href$=\\.doc], a[href$=\\.DOC]').parent('li').removeClass('www').addClass('doc');
	$('.personBasics li, .tabNavigation li').removeClass('link www pdf doc');

	// Disable same-page clicking
	$('.current_page_item>a').contents().unwrap().wrap('<span class="unclickable"></span>');

	// Dropdown for top dept links
	$('#top_dept_links').hide();
	$('.branding_prefix').click(function(){
		$('#top_dept_links').toggle();
		//console.log('clocked');
	});


	// Replace title of page if longer one already exists in post
	(function(){
		var oldTitle = $('.innerContent>article>header>h1');
		var newTitle = oldTitle.parent().next('h1');

		if( newTitle.length > 0 ){ oldTitle.replaceWith(newTitle); }
	})();
</script>

<!-- ADD UCF HEADER -->
<script type="text/javascript" src="http://universityheader.ucf.edu/bar/js/university-header.js"></script>
<!-- END UCF HEADER -->
</body>
</html>