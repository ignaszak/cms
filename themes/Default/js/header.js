var onScrollMarginBotom = 30;

function footerLocation() {

    var footer = {
        sidebar : $('.sidebar-affix'),
        get sidebarBottom () {
            var sidebarLeft = this.sidebar.eq(0).offset().top +
                this.sidebar.eq(0).outerHeight(true);
            var sidebarRight = this.sidebar.eq(1).offset().top +
                this.sidebar.eq(1).outerHeight(true);
            return sidebarLeft >= sidebarRight ?
                sidebarLeft : sidebarRight;
        },
        get containerBottom () {
            var container = this.sidebar.eq(1).parent().parent();
            return container.offset().top + container.outerHeight(true);
        },
        get footerTop () {
            var contentBottom = this.sidebarBottom >= this.containerBottom ?
                this.sidebarBottom : this.containerBottom;
            var windowBottom = $(window).height() -
                $('footer').outerHeight(true) -
                $('nav .container').outerHeight(true);
            return windowBottom >= contentBottom ?
                windowBottom : contentBottom;
        }
    }
    console.log(footer.footerTop);
    $('footer').css({
        'top' : footer.footerTop
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
     * Hide and show scrollbar effect
     */
    //$('.sidebar-overflow').css({"overflow":"hidden"});
    $('.sidebar-overflow').css({"overflow":"hidden"}).mouseover(function(){
        $(this).css({"overflow":"auto"});
    }).mouseout(function(){
        $(this).css({"overflow":"hidden"});
    });

});

$(window).resize(function(){
    initView();
});
