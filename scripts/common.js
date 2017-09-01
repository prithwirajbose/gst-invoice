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
                    APP.redirecting();
                    window.location = 'login.php';
                } else {
                    APP.showError("Logout failed. An error has occured." +
                        (resp.message && resp.message ? '<br>' + resp.message : ''));
                }
            }
        });
    });
});

APP.redirecting = function() {
    $('body').append('<div style="position:fixed; top:0px; left:38%; ' +
        'width:15%; margin:0px; padding:10px 50px; z-index:2000; background:#333; color:#fff; opacity:0.9;' +
        'text-align:center;border-radius:0px 0px 5px 5px;">Please wait, Redirecting...</div>');
};

function alert(msg) {
    APP.showInfo(msg);
}

APP.openUrlInPopup = function(pageUrl, title, dimension) {
    $.ajax({
        url: APP.site + pageUrl,
        method: 'get',
        dataType: 'html',
        success: function(content) {
            $('#viewerPopup .bd').html('');
            $('#viewerPopup').dialog({
                draggable: true,
                modal: true,
                resizable: false,
                title: title && title != null ? title : 'Details',
                width: dimension && dimension.width ? dimension.width : 400,
                height: dimension && dimension.height ? dimension.height : 250
            });
            $('#viewerPopup .bd').html(content && content != null ? content :
                '<h1 style="color:#ddd; text-align:center;">Blank Page</h1>');
        }
    });
}

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
};

APP.confirm = function(message, callbackFn, title) {
    $('#dialog .bd').removeClass('error');
    $('#dialog').dialog({
        draggable: true,
        modal: true,
        resizable: false,
        title: title && title != null ? title : 'Confirm',
        width: 400,
        buttons: [{
                text: "Yes",
                icon: "ui-icon-check",
                click: function() {
                    $(this).dialog("close");
                    if (typeof(callbackFn) == 'function') {
                        callbackFn();
                    }
                }
            },
            {
                text: "No",
                icon: "ui-icon-closethick",
                click: function() {
                    $(this).dialog("close");
                }
            }
        ]

    });
    $('#dialog .bd').html(message && message != null ? message : 'Are you sure?');
};

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
};

APP.throwValidationError = function(el, err) {
    var msg = {
        "required": " is required",
        "email": " should be a valid Email Address"
    };
    var errMsg = $(el).attr('label');
    if (errMsg == null || errMsg == '') {
        errMsg = 'Please correct the highlighted field(s)';
    } else {
        errMsg += ' ' + msg[err];
    }
    APP.showError(errMsg);
};

APP.validateForm = function(frm) {
    var isValidationFailed = false;
    if ($(frm).length > 0) {
        var allInputs = $(frm).find('input, textarea,select');
        $(allInputs).removeClass('error');
        $(allInputs).each(function(indx, el) {
            var elObj = $(this);
            var clsNames = $(this)[0].className;
            var val = $(this).val();
            if (clsNames && clsNames != null && clsNames != '') {
                var clsNameArr = $.trim(clsNames).split(" ");
                if (clsNameArr != null && clsNameArr.length > 0) {
                    for (var i = 0; i < clsNameArr.length; i++) {
                        if (typeof(APP.validationFn[clsNameArr[i]]) == 'function') {
                            if (!APP.validationFn[clsNameArr[i]](val)) {
                                if (!isValidationFailed)
                                    APP.throwValidationError(elObj, clsNameArr[i]);

                                $(elObj).addClass('error');
                                isValidationFailed = true;
                            }
                        }
                    }
                }
            }
        });
    }
    return !isValidationFailed;
};

APP.validationFn.required = function(val) {
    return (val != null && $.trim(val) != '');
}

APP.validationFn.email = function(val) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(val);
}