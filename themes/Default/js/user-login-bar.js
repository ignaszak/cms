$(document).ready(function() {

    /**
     * Tooltip
     */
    $('[data-toggle="tooltip"]').tooltip();

    /**
     * User remember button
     */
    var userRemember = 0;
    $("#userRemember").click(function() {
        if (userRemember == 0) {
            $("#userRemember i").removeClass('fa-square-o').addClass(
                'fa-check-square-o');
            userRemember = 1;
        } else {
            $("#userRemember i").removeClass('fa-check-square-o').addClass(
                'fa-square-o');
            userRemember = 0;
        }
    });

});