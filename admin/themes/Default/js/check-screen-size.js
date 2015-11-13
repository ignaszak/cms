function getScreenSize() {
    if ($(window).width() < 768) {
        return 'xs'; // Extra small devices Phones (<768px)
    }
    else if ($(window).width() >= 768 && $(window).width() <= 992) {
        return 'sm'; // Extra small devices Phones (<768px)
    }
    else if ($(window).width() > 992 && $(window).width() <= 1200) {
        return 'md'; // Extra small devices Phones (<768px)
    }
    else  {
        return 'lg'; // Extra small devices Phones (<768px)
    }
}

function isScreenSize(size) {
    size = size.replace(' ', '');
    sizeArray = new Array();
    sizeArray = size.split(',');
    screenSize = getScreenSize();

    check = 0;
    for (i=0;i<sizeArray.length;++i) {
        if (screenSize == sizeArray[i]) {
            check += 1;
        } else {
            check += 0;
        }
    }

    if (check > 0) {
        return true;
    } else {
        return false;
    }

}