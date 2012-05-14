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

		<h3 id="copyright">© 2012 University of Central Florida, College of Sciences, All Rights Reserved</h3>
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
		console.log('flexslider.js not loaded.');
	}

	// Indicate people nav link
	$('#main_header nav>ul>li').has('a:contains("People")').addClass('peopleNav');

    // Display people categories in nav menu
	$('.peopleNav').append( $('#people_cats') );

	// Main nav links and dropdown menu
	$('#main_header nav>ul>li').hover(
		function(){
			$(this).children('ul.children').slideDown('fast').show(); 
			// $(this).children('a').animate({ backgroundColor: colorOffWhite, color: colorDarkBlue }, 'fast').addClass('navLinkHover');
		},
		function(){ 
			if( !$(this).hasClass('current_page_item') ){
				$(this).children('ul.children').slideUp('fast');
				// $(this).children('a').animate({ backgroundColor: colorDarkBlue, color: colorOffWhite }, 'fast');
			} else {
				$(this).children('ul.children').slideUp('fast');
			}
		}
	);
	$('#main_header nav>ul>li>ul>li').hover(
		function(){
			$(this).find('ul.children').slideDown('fast').show();
			// $(this).children('a').animate({ backgroundColor: colorOffWhite, color: colorDarkBlue }, 'fast').addClass('navLinkHover');
		},
		function(){ 
			if( !$(this).hasClass('current_page_item') ){
				$(this).find('ul.children').slideUp('fast');
				// $(this).children('a').animate({ backgroundColor: colorDarkBlue, color: colorOffWhite }, 'fast');
			} else {
				$(this).find('ul.children').slideUp('fast');
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

	// Parent finding for nav li elements 
	$('nav li').has('.children').addClass('parent');

	// Page nav expand
	$('.pageNav li.parent').prepend('<span class="expand"><a href="#">+</a></span>');
	$('.pageNav .expand>a').click( function(){
		$this = $(this);
		$children = $this.parent().parent().find('.children');
		if($children.is(':visible')){
			$this.text('+');
			$children.hide();
		} else {
			$this.text('-');
			$children.show();
		};
	});



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

	// Link Icons 
	$('.innerContent a').parent('li').addClass('link www');
	$('a[href$=\\.pdf], a[href$=\\.PDF]').parent('li').removeClass('www').addClass('pdf');
	$('a[href$=\\.doc], a[href$=\\.DOC]').parent('li').removeClass('www').addClass('doc');
	$('.personBasics li, .personTabs li').removeClass('link www pdf doc');

	// Disable same-page clicking
	$('.current_page_item>a').contents().unwrap().wrap('<span class="unclickable"></span>');

	// Dropdown for top dept links
	$('#top_dept_links').hide();
	$('.branding_prefix').click(function(){
		$('#top_dept_links').toggle();
		console.log('clocked');
	});


	// Replace title of page if longer one already exists in post
	(function(){
		var oldTitle = $('.innerContent>article>header>h1');
		var newTitle = oldTitle.parent().next('h1');

		if( newTitle.length > 0 ){ oldTitle.replaceWith(newTitle); }
	})();

	/**
	 * jQuery.fn.sortElements
	 * --------------
	 * @param Function comparator:
	 *   Exactly the same behaviour as [1,2,3].sort(comparator)
	 *   
	 * @param Function getSortable
	 *   A function that should return the element that is
	 *   to be sorted. The comparator will run on the
	 *   current collection, but you may want the actual
	 *   resulting sort to occur on a parent or another
	 *   associated element.
	 *   
	 *   E.g. $('td').sortElements(comparator, function(){
	 *      return this.parentNode; 
	 *   })
	 *   
	 *   The <td>'s parent (<tr>) will be sorted instead
	 *   of the <td> itself.
	 */
	jQuery.fn.sortElements = (function(){
	    var sort = [].sort;
	    return function(comparator, getSortable) {
	        getSortable = getSortable || function(){return this;};
	        var placements = this.map(function(){
	            var sortElement = getSortable.call(this),
	                parentNode = sortElement.parentNode,
	 
	                // Since the element itself will change position, we have
	                // to have some way of storing its original position in
	                // the DOM. The easiest way is to have a 'flag' node:
	                nextSibling = parentNode.insertBefore(
	                    document.createTextNode(''),
	                    sortElement.nextSibling
	                );
	 
	            return function() {
	                if (parentNode === this) {
	                    throw new Error(
	                        "You can't sort elements if any one is a descendant of another."
	                    );
	                }
	 
	                // Insert before flag:
	                parentNode.insertBefore(this, nextSibling);
	                // Remove flag:
	                parentNode.removeChild(nextSibling);
	            };
	        });
	        return sort.call(this, comparator).each(function(i){
	            placements[i].call(getSortable.call(this));
	        });
	    };
	})();

	$('.sort_people').click(function(){
		$('#people_list>.person').sortElements(function(a, b){
	    	return $(a).find('ul.personBasics>h2>a').text() > $(b).find('ul.personBasics>h2>a').text() ? 1 : -1;
		});
	});


</script>

</body>
</html>