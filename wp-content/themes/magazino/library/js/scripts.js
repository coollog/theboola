
jQuery(document).ready(function($){
	
	var $window = $(window),
        $menu = $('div.menu');
	
	function checkWindowSize() {
		var width = $window.width();
		if ( width < 824 ) {
			return $menu.addClass('nav-mobile');
		}
		$menu.removeClass('nav-mobile');
	}
	
	$window
        .resize(checkWindowSize)
        .trigger('checkWindowSize');
		
	checkWindowSize();
	
	/* prepend menu icon */
	$('div.menu').prepend('<div id="menu-icon">Menu</div>');
	
	/* toggle nav */
	$("#menu-icon").on("click", function(){
		$("div.menu > ul").slideToggle();
		$(this).toggleClass("active");
	});
	
	
	/* preloader */
	$('#load-cycle').hide();
	
	/* jquery cycle */
	$('.cycle-slideshow').show();
	
	$('#slide-wrap').hover(function() {
		$('#sliderprev').fadeIn(200);
		$('#slidernext').fadeIn(200);
	}, function() {
		$('#sliderprev').fadeOut(200);
		$('#slidernext').fadeOut(200);
	});
		
	
	/* toggle search box */
	$("#search-icon").on("click", function(){
		$("#search-box-wrap").slideToggle();
	});
	
	$("#close-x").on("click", function(){
		$("#search-box-wrap").slideUp();
	});
	
	$(".post-box").bind("mouseenter", function() {
		$(this).find("img").fadeOut(400);
	});
	
	$(".post-box").bind("mouseleave", function() {
		$(this).find("img").fadeIn(400);
	});

});