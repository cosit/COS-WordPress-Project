jQuery(document).ready(function ($) {

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

	//
	$('article.type-minutes:nth-child(3n)').addClass('clear');
	if($('#meetings .meeting-span2').length == 1){
		$('#meetings .meeting-span2').css({width: '97%'});
	}
	//

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

	// Custom menu nav shenanigans v2.0
	$(function() {
		//Set 'top_level' to the page's parent item
		var top_level = $('#custom_menu_nav>div>ul li.current-menu-parent');
		//If the current page doesn't have a parent item
		if(top_level.length == 0){
			top_level = $('#custom_menu_nav>div>ul li.current_page_item');
			//If the page is not associated with any other page
			if(top_level.length == 0){
				$('#custom_menu_nav').hide();
			} else{
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

	
	$('.handbook_content').hide();
	$('.handbook_title a.title').click(function(){
		$(this).next('div').toggle();
		$(this).toggleClass('expanded');
		//$(this).next('div').slideToggle('fast');
		
		return false;
	});

	// Link Icons 
	$('.innerContent a').parent('li').addClass('link www');
	$('a[href$=\\.pdf], a[href$=\\.PDF]').parent('li').removeClass('www').addClass('pdf');
	$('a[href$=\\.doc], a[href$=\\.DOC], a[href$=\\.docx], a[href$=\\.DOCX]').parent('li').removeClass('www').addClass('doc');
	$('a[href$=\\.ppt], a[href$=\\.PPT], a[href$=\\.pptx], a[href$=\\.PPTX]').parent('li').removeClass('www').addClass('ppt');
	$('a[href$=\\.xls], a[href$=\\.XLS], a[href$=\\.xlsx], a[href$=\\.XLSX]' ).parent('li').removeClass('www').addClass('excel');
	$('.personBasics li, .tabNavigation li, .ai1ec-calendar-toolbar li').removeClass('link www pdf doc');

	// Disable same-page clicking
	$('.current_page_item>a').contents().unwrap().wrap('<span class="unclickable"></span>');

	// Dropdown for top dept links
	$('#top_dept_links').hide();
	$('.branding_prefix').click(function(){
		$('#top_dept_links').toggle();
		//console.log('clocked');
	});

	// Clear every third div listed on the eUpdates page
	//$('article#eupdates>div:nth-child(3n-1)').css("clear", "both");


	// Replace title of page if longer one already exists in post
	(function(){
		var oldTitle = $('.innerContent>article>header>h1');
		var newTitle = oldTitle.parent().next('h1');

		if( newTitle.length > 0 ){ oldTitle.replaceWith(newTitle); }
	})();	
});