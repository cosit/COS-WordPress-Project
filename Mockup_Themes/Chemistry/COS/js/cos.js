$(function() {
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
	$('#main_header nav>ul>li>a:contains("People")').parent().addClass('peopleNav');

    // Display people categories in nav menu
	$('.peopleNav').append( $('#people_cats') );

	// Main nav links and dropdown menu
	(function(){
		$('#main_header nav>ul>li, #main_header nav>ul>li>ul>li, #main_header nav>ul>li>ul>li>ul>li').hover(
			function(){
				$(this).children('ul.children').slideDown('fast').show(); 
				$(this).children('ul.sub-menu').slideDown('fast').show(); 
				// $(this).children('a').animate({ backgroundColor: colorOffWhite, color: colorDarkBlue }, 'fast').addClass('navLinkHover');
			},
			function(){ 
				$(this).children('ul.children').slideUp('fast');
				$(this).children('ul.sub-menu').slideUp('fast');
			}
		);
	})();

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
		console.log( top_level.children('ul').length );
		if( top_level.children('ul').length > 0 ){
			console.log(1);
			$('#custom_menu_nav').prepend( top_level.children('ul').show() ).prepend('<h2>'+top_level.html()+'</h2>');
			$('#custom_menu_nav>div').hide();
		} else {
			console.log(331);
			top_level = top_level.parent().parent();
			console.log(top_level);
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
	$('.personBasics li, .personTabs li, .customTabs li').removeClass('link www pdf doc');

	// Disable same-page clicking
	$('.current_page_item>a').contents().unwrap().wrap('<span class="unclickable"></span>');

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
});