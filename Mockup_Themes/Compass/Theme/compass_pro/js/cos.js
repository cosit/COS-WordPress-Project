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
		//console.log('flexslider.js not loaded.');
	}

	// Indicate people nav link
	$('#main_header nav>ul>li>a:contains("People")').attr("id", "peopleLink").parent().addClass('peopleNav');

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
				$(this).children('ul.children').hide();
				$(this).children('ul.sub-menu').hide();
			}
		);
	})();

	// Submenu links
	// $('#main_header nav ul.children>li').hover(
	// 	function(){ $(this).animate({ backgroundColor: colorLightBlueGray }, 'medium')},
	// 	function(){ $(this).animate({ backgroundColor: colorBlueGray }, 'medium')}
	// );

	// Contact Box and Search Form
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

	// Custom menu nav shenanigans v2.0
	$(function() {
		//Set 'top_level' to the page's parent item
		var top_level = $('#custom_menu_nav>div>ul li.current-menu-ancestor');
		//If the current page doesn't have a parent item
		if(top_level.length == 0){
			top_level = $('#custom_menu_nav>div>ul li.current-menu-item');
			//If the page is not associated with any other page
			if(top_level.length == 0){
				$('#custom_menu_nav').hide();
			}
			else{
				$('#custom_menu_nav').prepend( top_level.children('ul').show() ).prepend('<h2>'+top_level.html()+'</h2>');	
				$('#custom_menu_nav>h2 .expand').hide();	//Remove any extra expands
				$('#custom_menu_nav>div').hide();
			}
			
		} else{
			$('#custom_menu_nav').prepend( top_level.children('ul').show() ).prepend('<h2>'+top_level.html()+'</h2>');		
			$('#custom_menu_nav>h2 .expand').hide();	//Remove any extra expands
			$('#custom_menu_nav>div').hide();
		}
	});

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
	$('.pageNav li.current_page_item.parent>span.expand>div').trigger('click');
	
    // Hide empty list items in people display
    $('.personBasics li').filter(function(){
    	return $.trim($(this).text()) === '';
    }).hide();

    // Display page/people nav correctly
    $('#main_content>div.wrap').append( $('.innerContent .pageNav, .innerContent .peopleNav').remove() );

    
	// Link Icons 
	$('.innerContent a').parent('li').addClass('link');
	$('a[href$=\\.pdf], a[href$=\\.PDF]').parent('li').removeClass('www').addClass('pdf');
	$('a[href$=\\.doc], a[href$=\\.DOC]').parent('li').removeClass('www').addClass('doc');
	$('.personBasics li, .customTabs li').removeClass('link www pdf doc');

	// Disable same-page clicking
	$('.current_page_item>a').contents().unwrap().wrap('<span class="unclickable"></span>');

	// Replace title of page if longer one already exists in post
	(function(){
		var oldTitle = $('.innerContent>article>header>h1');
		var newTitle = oldTitle.parent().next('h1');

		if( newTitle.length > 0 ){ oldTitle.replaceWith(newTitle); }
	})();

	// Make sidebar sticky
	//$('#sidebar').stickySidebar({speed: 0, padding: 0, constrain: true});
});