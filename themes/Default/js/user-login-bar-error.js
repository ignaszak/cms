$(document).ready(function() {

    /**
     * Generate invalid data error
     */
    popoverCloseButton = '<a href="#" class="close" data-dismiss="alert">×</a>';
    $('form#login .login-group').popover({
        trigger: 'manual',
        placement: 'bottom',
        html: true,
        title: '<b>Invalid data!</b>' + popoverCloseButton,
        content: '<div style="min-width:300px; max-width:600px;">' +
            'Following fields are incorrect:<br>login/email or password.<br>' +
            '<a href="#">Remind password</a></div>'
    });
    $(document).on("click", ".popover .close", function() {
        $(this).parents(".popover").popover('hide');
    });
    $('form#login .login-group').popover('show');

});