var onScrollMarginBotom = 30;

function footerLocation() {
	var sidebar = $('.sidebar-affix');
	var container = sidebar.parent().parent();
	var sidebarBottom = sidebar.offset().top + sidebar.outerHeight(true);
	var containerBottom = container.position().top + container.outerHeight(true);
	if (sidebarBottom > containerBottom) {
		var footerTop = sidebarBottom;
	} else {
		var footerTop = containerBottom;
	}
	$('footer').css({
    	'position' : 'absolute',
    	'left' : 0,
    	'right' : 0,
    	'top' : footerTop
    });
}

function initView() {

	$('body').css({'padding-top':$('nav .container').outerHeight(true)});

	if ($('a#menu-toggle').is(':hidden') !== false) { // DESKTOP

		/**
		 * Load categories from wrapper to sidebar
		 */
		var sidebar_category = $('#sidebar-wrapper').html();
		$('.sidebar-category').html(
				'<h1>Categories</h1>' +
				'<div class="sidebar-overflow">' +
				sidebar_category +
				'</div>'
		);
		$('.sidebar-category ul.sidebar-nav')
			.removeClass('sidebar-nav')
			.addClass('nav nav-stacked');

		/**
		 * Add tooltip and hide move op bottom
		 */
		$('[data-toggle="nav-tooltip"]').tooltip({
	        placement : 'bottom'
	    });
		$('#move-top').hide();

		/**
		 * Default sidebar style
		 */
		var sidebarAffix = $('.sidebar-affix');
		sidebarAffix.css({
        	'position' : 'absolute',
        	'top' : 0,
        	'width' : sidebarAffix.parent().width()
        });

		/**
		 * Sidebar affix and move top button efect
		 */
	    $(window).on('scroll', function() {

	    	footerLocation();

	        var bodyTop = $('.body-top').position().top - onScrollMarginBotom;

	        if ($(window).scrollTop() > bodyTop) { // OUT NAVBAR
	            $('#move-top').fadeIn(300);
	            sidebarAffix.css({
	            	'position' : 'fixed',
	            	'top' : $('.navbar-fixed-top .container')
	            		.outerHeight(true) + onScrollMarginBotom,
	            	'width' : sidebarAffix.parent().width()
	            });
	        } else { // IN NAVBAR
	            $('#move-top').fadeOut(300);
	            sidebarAffix.css({
	            	'position' : 'absolute',
	            	'top' : 0,
	            	'width' : sidebarAffix.parent().width()
	            });
	        }
	    });

	} // END DESKTOP
}

$(document).ready(function() {
	initView();
	footerLocation();

	/**
	 * Hide ans show scrollbar effect
	 */
	$('.sidebar-overflow').mouseover(function(){
		$(this).css({"overflow":"auto"});
	}).mouseout(function(){
		$(this).css({"overflow":"hidden"});
	});

});

$(window).resize(function(){
	initView();
});