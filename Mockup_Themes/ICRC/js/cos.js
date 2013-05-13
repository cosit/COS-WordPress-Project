jQuery(document).ready(function ($) {

	var colorDarkBlue = "#22282D";
	var colorOffWhite = "#F2F2F2";
	var colorBlueGray = "#475159";
	var colorLightBlueGray = "#6C747A";


	// Slider
	try{
		$('.sliderItems').flexslider({
			animation: "slide",
			slideshow: "true",
			slideshowSpeed: 7000,
			directionNav: false,
			controlNav: false
		});
	} catch(err) {
		//console.log('flexslider.js not loaded.');
	}

	// Indicate people nav link
	$('#main_header nav>ul>li>a:contains("Speakers")').attr("id", "peopleLink").parent().addClass('peopleNav');

    // Display people categories in nav menu
	$('.peopleNav').append( $('#people_cats') );

	// Main nav links and dropdown menu
	// (function(){
	// 	$('#main_header nav>ul>li, #main_header nav>ul>li>ul>li, #main_header nav>ul>li>ul>li>ul>li').hover(
	// 		function(){
	// 			$(this).children('ul.children').slideDown('fast').show(); 
	// 			$(this).children('ul.sub-menu').slideDown('fast').show(); 
	// 			// $(this).children('a').animate({ backgroundColor: colorOffWhite, color: colorDarkBlue }, 'fast').addClass('navLinkHover');
	// 		},
	// 		function(){ 
	// 			$(this).children('ul.children').hide();
	// 			$(this).children('ul.sub-menu').hide();
	// 		}
	// 	);
	// })();

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
		var top_level = $('#custom_menu_nav>div>ul li.current-menu-ancestor');
		//If the current page is not part of the custom menu		
		if(top_level.length == 0){
			top_level = $('#custom_menu_nav>div>ul li.current_page_item');
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

	//Function for Tabs on Person Page
	$(function () {
		var tabContainers = $('div.tabs > div');
		//tabContainers.hide().filter(':first').show();			
		$('div.tabs ul.tabNavigation a').click(function () {			
			tabContainers.hide();
			tabContainers.filter(this.hash).show();
			$('div.tabs ul.tabNavigation a').removeClass('selected');
			$('div.tabs ul.tabNavigation li').removeClass('selected');
			$(this).addClass('selected');
			$(this).parent().addClass('selected');
			
			return false;
		}).filter(':first').click();
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
	$('.innerContent a').parent('li').addClass('link www');
	$('a[href$=\\.pdf], a[href$=\\.PDF]').parent('li').removeClass('www').addClass('pdf');
	$('a[href$=\\.doc], a[href$=\\.DOC], a[href$=\\.docx], a[href$=\\.DOCX]').parent('li').removeClass('www').addClass('doc');
	$('a[href$=\\.ppt], a[href$=\\.PPT], a[href$=\\.pptx], a[href$=\\.PPTX]').parent('li').removeClass('www').addClass('ppt');
	$('a[href$=\\.xls], a[href$=\\.XLS], a[href$=\\.xlsx], a[href$=\\.XLSX]' ).parent('li').removeClass('www').addClass('excel');
	$('.personBasics li, .personTabs li, .tabNavigation li').removeClass('link www pdf doc');

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

	
	/******************/
	/* Jquery Rearrange divs for mobile */
	/******************/
	var delay = (function(){
    var timer = 0;
    return function(callback, ms){
	        clearTimeout (timer);
	        timer = setTimeout(callback, ms);
	    };
	})();

	$(function() {
	    var pause = 10; // will only process code within delay(function() { ... }) every 100ms.
	    $(window).resize(function() {
	        delay(function() {	        
	            var width = $(window).width();	    	            
	            if( width > 540 ) {
	            	$('.footerWidgetDiv').show();
	            	$(".innerContent").insertAfter("#sidebar");
	            }else if( width < 540 ) {
	                // code for mobile portrait
	                $('.footerWidgetDiv').hide();
	                $("#sidebar").insertAfter(".innerContent");	                
	            }
	        }, pause );	    
	    });	    
	    $(window).resize();
	});
	/******************/

	/*****************/
	/* Functions to show/hide the widget information when it's in the phone view < 540px */	
	$('#first-footer-widget-area h1.title').click(function(){		
		$('#first-footer-widget-area i').toggleClass('icon-double-angle-down icon-double-angle-up');
		$(this).next('.footerWidgetDiv').toggle();		
		return false;
	});
	$('#second-footer-widget-area h1.title').click(function(){		
		$('#second-footer-widget-area i').toggleClass('icon-double-angle-down icon-double-angle-up');
		$(this).next('.footerWidgetDiv').toggle();		
		return false;
	});
	$('#third-footer-widget-area h1.title').click(function(){		
		$('#third-footer-widget-area i').toggleClass('icon-double-angle-down icon-double-angle-up');
		$(this).next('.footerWidgetDiv').toggle();		
		return false;
	});
	/******************/

});