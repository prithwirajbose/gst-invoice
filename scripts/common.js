$(document).ready(function() {
    $(document).ajaxStart(function() {
        $.loader({
            content: '<img src="scripts/jquery.loader/images/ajax-loader.gif" style="height:100px; width:auto;" />',
            className: 'ajaxloader',
            background: { opacity: 0.8, id: 'jquery-loader-background' }
        });
    });

    $(document).ajaxComplete(function() {
        $.loader('close');
    });

    $(document).ajaxStop(function() {
        $.loader('close');
    });

    $(document).ajaxError(function(e, xhr) {
        APP.showError("An error has occured." +
            (xhr.responseJSON && xhr.responseJSON.message ? '<br>' + xhr.responseJSON.message : ''));
    });

    $('.logout').click(function(e) {
        $.ajax({
            url: APP.site + "/ajax.php?action=logout",
            method: 'get',
            success: function(resp) {
                if (resp && resp.success && resp.success === true) {
                    window.location = 'login.php';
                } else {
                    APP.showError("Logout failed. An error has occured." +
                        (resp.message && resp.message ? '<br>' + resp.message : ''));
                }
            }
        });
    });
});

APP.showInfo = function(message, title) {
    $('#dialog .bd').removeClass('error');
    $('#dialog').dialog({
        draggable: true,
        modal: true,
        resizable: false,
        title: title && title != null ? title : 'Information',
        width: 350
    });
    $('#dialog .bd').html(message && message != null ? message : 'Information');
}

APP.showError = function(message, title) {
    $('#dialog .bd').removeClass('error');
    $('#dialog').dialog({
        draggable: true,
        modal: true,
        resizable: false,
        title: title && title != null ? title : 'Error',
        width: 350
    });
    $('#dialog .bd').html(message && message != null ? message : 'An error has occured').addClass('error');
}