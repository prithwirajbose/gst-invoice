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