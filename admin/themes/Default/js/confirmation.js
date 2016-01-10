$(document).ready(function(){
    $('[data-toggle="a-confirm"]').confirmation({
        onConfirm : function () {
            window.location = $(this).attr('href');
        },
        popout : true,
        placement : 'left'
    });

    $('[data-toggle="button-form-confirm"]').confirmation({
        onConfirm : function () {
            $('form').attr("action", $(this).attr('data-href')).submit();
        },
        popout : true
    });
});