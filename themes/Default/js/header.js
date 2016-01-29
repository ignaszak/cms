function initView() {
	$('body').css({'padding-top':$('nav .container').outerHeight(true)});

	if ($('a#menu-toggle').is(':hidden') !== false) { // DESKTOP

		var sidebar_category = $('#sidebar-wrapper').html();
		$('.sidebar-category .panel-body').html(sidebar_category);
		$('ul.sidebar-nav')
			.removeClass('sidebar-nav')
			.addClass('nav nav-stacked');

		$('[data-toggle="nav-tooltip"]').tooltip({
	        placement : 'bottom'
	    });

		$('#move-top').hide();

	    $(window).on('scroll', function() {
	        var headPanelHeight = $('.page-header').position().top +
	            $('.page-header').outerHeight(true) - $('nav').outerHeight(true);
	        if ($(window).scrollTop() > headPanelHeight) {
	            $('#move-top').fadeIn(300);
	        } else {
	            $('#move-top').fadeOut(300);
	        }
	    });

	}
}

$(document).ready(function() {
	initView();
});

$(window).resize(function(){
	initView();
});