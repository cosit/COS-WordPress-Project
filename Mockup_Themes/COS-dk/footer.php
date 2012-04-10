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
</div> <!-- /container -->



<footer id="main_footer">
	<!-- Bottom widgets -->
	<section id="widgets">
		<div class="wrap clearfix">
			<?php 
				//Query widget posts
				query_posts( array ( 'category_name' => 'Widgets', 'posts_per_page' => -1 ) );

				// Loop widget posts
				while( have_posts() ) : the_post();
					echo '<div class="widget"><h1>';
					the_title();
					echo '</h1><p>';
					the_content();
					echo '</p></div>';
				endwhile;
			?>
		</div>
	</section>

	<section id="the_footer">
		<div class="wrap">
		<?php 
			get_sidebar( 'footer' );
			show_people_cats(); 
		?>

		<h1><span>UCF</span> College of Sciences</h1>
		</div>
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
		$('.sliderItems').flexslider();
	} catch(err) {
		console.log('flexslider.js not loaded.');
	}

	// Indicate people nav link
	$('#main_header nav>ul>li').has('a:contains("People")').addClass('peopleNav');

    // Display people categories in nav menu
	$('.peopleNav').append( $('#people_cats').hide() );

	// Main nav links and dropdown menu
	$('#main_header nav>ul>li').hover(
		function(){
			$(this).find('ul.children').slideDown('fast').show(); 
			// $(this).children('a').animate({ backgroundColor: colorOffWhite, color: colorDarkBlue }, 'fast').addClass('navLinkHover');
		},
		function(){ 
			if( !$(this).hasClass('current_page_item') ){
				$(this).find('ul.children').delay(500).slideUp('fast');
				// $(this).children('a').animate({ backgroundColor: colorDarkBlue, color: colorOffWhite }, 'fast');
			} else {
				$(this).find('ul.children').delay(500).slideUp('fast');
			}
		}
	);

	// Submenu links
	// $('#main_header nav ul.children>li').hover(
	// 	function(){ $(this).animate({ backgroundColor: colorLightBlueGray }, 'medium')},
	// 	function(){ $(this).animate({ backgroundColor: colorBlueGray }, 'medium')}
	// );

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

	// Ensure that the entire area of a navigational element is clickable
	// $('.events article, nav li').click(function(){
	// 	window.location = $(this).find('a').attr('href');
	// });

	// Back to top button
	var scrollToTop = function(){
		$('html, body').animate({scrollTop: 0}, 'medium', 'easeInOutCubic');
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

	// Breadcrumb hover 
	// $(window).resize( function(){
	// 	var currentWidth = $(window).width();
	// 	var leftMargin = ($(window).width() - 960) / 2;
	// 	$('#breadcrumbs a:first-child').css({'margin-left': leftMargin });
	// });
	$('#breadcrumbs a').hover(
		function(){$(this).next().addClass('breadcrumbHover')},
		function(){$(this).next().removeClass('breadcrumbHover')}
	);

	// AJAX functions for displaying full person info
	// $.ajaxSetup ({  
 //        cache: false  
 //    });  
 
 //    $(".person").click(function(){  
 //    	scrollToTop();
 //    	$this = $(this);
 //    	$this.addClass('mainPerson');
 //    	$('.person').hide();
 //    	$this.find('.person_research').hide();
 //        $this.find('.personDetailsLoading').show();
 //        $this.find('.personDetails').load( $this.find("h2 a").attr('href') );
 //        $this.ajaxStop(function() {
 //        	$this.find('.personDetailsLoading').slideUp('fast');
 //        	$this.find('.personDetails').slideDown('fast');
 //        })  
 //    });  

    // Hide empty list items in people display
    $('.personBasics li').filter(function(){
    	return $.trim($(this).text()) === '';
    }).hide();

    // Display page/people nav correctly
    $('#main_content>div.wrap').append( $('.innerContent .pageNav, .innerContent .peopleNav').remove() );

    // Single Person Tabs
	$('.personTabs>li>a').click(function(){
		var $this = $(this);
		console.log($this.parent().hasClass('personTabSelected'));
		if( ! $this.parent().hasClass('personTabSelected') ){
			var target = $this.attr('href').substring(1);
			var newHeight = $('.personContent #' + target).outerHeight();
			console.log(target);
			$('.personTabs>li').removeClass('personTabSelected'); // deselect all tabs
			$this.parent().addClass('personTabSelected');
			$('.personContent>li').hide();
			$('.personContent #' + target).fadeIn('fast');
			$('.personContent').animate({
				height: newHeight,
			});
		};
		return false;
	})
	$('.personTabs li:first-child a').trigger('click');

</script>

</body>
</html>