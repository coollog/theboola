$(function() {
	/*$('div').click(function() {
		var attr = $(this).attr('href');
		if (typeof attr !== 'undefined' && attr !== false)
			window.location = attr;
	});*/
	$('.logo').hover(function() {
		$('.dropdown').animate({
			opacity: 0.7
		}, 300, "easeInOutCubic");
	}, function() {
		$('.dropdown').animate({
			opacity: 0
		}, 300, "easeInOutCubic");
	}).click(function() {
		$('.menu').slideToggle(500, "easeInOutCubic");
		$('.dropdown').fadeToggle(500, "easeInOutCubic");
	});
	$('.content').click(function() {
		$('.menu').slideUp(500, "easeInOutCubic");
		$('.dropdown').fadeIn(500, "easeInOutCubic");
	});
});