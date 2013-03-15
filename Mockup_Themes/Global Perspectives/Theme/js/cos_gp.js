
$(function(){
	$('.gp_video').ceebox();

	//$('#main_header nav ul>li>a:contains("Staff")').attr("id", "peopleLink").parent().addClass('peopleNav');

	$('.gp_eventDate').each(function(){
		var monthNames = monthNames || ['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC'];
		var $this = $(this);
		var rawDate = $this.html();
		var date = rawDate.split(/[\/\s-]/);
		// var date = rawDate.split(' ');
		var day = date[2].trim();
		var monthMatch = /0?(\d{1,2})/.exec(date[1]);
		var month = monthNames[ --monthMatch[1] ];
		var year = date[0].trim();

		// formats and outputs the date in a template that can be styled
		$this.html('<ul><li class="eventMonth">'+month+'</li>'
						+'<li class="eventDay">'+day+'</li>'
						+'<li class="eventYear">'+year+'</li>'
						+'<li class="eventDate">'+rawDate+'</ul>');
		
	});

	// hide empty paragraphs
	(function(){
		$('p').filter(function() {
	        return $.trim($(this).text()) === ''
	    }).remove();


	})();

	// GP Videos
	//console.log($('#gp_videos>div>img'));
	$('#gp_videos>div>img').each(function(){
		$(this).appendTo($(this).prev('a'));
	});


	// Reverse events in sidebar to show up and coming events
	// ul = $('#sidebar .events>ul');
	// ul.children('li').each(function(i,li){ul.prepend(li)});

	// Sort upcoming events 
	var mylist = $('#gp_upcoming_events');
	var listitems = mylist.children('article').get();
	listitems.sort(function(a, b) {
	   var compA = $(a).find('.eventDate').text().toUpperCase();
	   var compB = $(b).find('.eventDate').text().toUpperCase();
	   console.log( compA + " and " + compB);
	   return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
	})
	$.each(listitems, function(idx, itm) { mylist.append(itm); });
	mylist.append(mylist.find('footer')[0]);

});
