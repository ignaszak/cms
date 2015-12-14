function hideSidebarMenu() {
    if (isScreenSize('xs')) {
        $('#sidebar-menu').hide();
        $('button.navbar-toggle').click(function(){
            $('#sidebar-menu').show();
        });
    } else {
        $('#sidebar-menu').show();
    }
}

function responsivePanel() {
    navTopPosition = $('nav div.container-fluid').offset().top;
    navTopHeight = $('nav div.container-fluid').outerHeight();
    navBorder = 1;
    sidebarMenuWidth = 250;
    if (!isScreenSize('xs')) {
        $('div#page-context').css({
            'position': 'absolute',
            'top': navTopPosition+navTopHeight+navBorder+'px',
            'left': sidebarMenuWidth+'px',
            'right': '0px'
        });
    } else {
        $('div#page-context').css({
            'position': '',
            'top': '',
            'left': '0px',
            'right': '0px'
        });
    }
}

$(document).ready(function () {

    hideSidebarMenu();
    responsivePanel();

});

$(window).on('resize', function(){
    hideSidebarMenu();
    responsivePanel();
});