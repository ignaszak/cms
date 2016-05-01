function parallax()
{
    var scrolled = $(window).scrollTop();
    $('.parallax').css({
        'background-position' : '0px ' + (-(scrolled*0.1) + 'px')
    });
    $('.parallax h1').css({
        'opacity' : (1-scrolled/175)
    });
}

$(window).scroll(function (e) {
    parallax();
});