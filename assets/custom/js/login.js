var ajax;
var login = {
    pop_up: function () {
        $.ajax({
            type: 'POST',
            url: BASEURL + 'auth/ajax_form',
            async: false,
            dataType: 'json',
            success: function (returnData, textStatus, xhr) {
                setTimeout(function () {
                    $('body').append(returnData.html);
                }, 500);
            },
            error: function (xhr, textStatus, errorThrown) {
                pop_up.alert('There was an unknown error that occurred. You will need to refresh the page to continue working.');
            }
        });
    },
    form: function ($this) {
        var formData = new FormData($($this)[0]);
        var form = $($this).attr('name');
        $.ajax({
            type: 'POST',
            url: $($this).attr('action'),
            data: formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('input[type="submit"]').val('Please wait...!').attr('disabled', 'disabled');
            },
            success: function (returnData) {
                if (returnData.status == "ok") {
                    pop_up.notification(returnData.message);
                } else {
                    var error_html = '';
                    if (typeof returnData.error != "undefined") {
                        $.each(returnData.error, function (idx, topic) {
                            error_html += '<p class="text-danger">' + topic + '</p>';
                        });
                    }
                    if (error_html != '') {
                        pop_up.alert(error_html);
                    } else {
                        pop_up.alert(returnData.message);
                    }
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                pop_up.alert('There was an unknown error that occurred. You will need to refresh the page to continue working.');
            },
            complete: function () {
                $('input[type="submit"]').val('SAVE').removeAttr('disabled');
            }
        });
        return false;
    },
    check: function () {
        if (ajax) {
            ajax.abort();
        }
        ajax = $.ajax({
            type: 'POST',
            url: BASEURL + 'auth/check_login',
            async: false,
            dataType: 'json',
            success: function (returnData, textStatus, xhr) {
                if (returnData.status == 'login') {
                    if ($(document).find(".LoginModalAjax").length > 0) {
                        $(document).find(".LoginModalAjax").remove();
                        if (returnData.email != LOGIN_EMAIL) {
                            location.reload();
                        }
                    } else {
                        if (returnData.email != LOGIN_EMAIL) {
                            location.reload();
                        }
                    }
                } else {
                    if (!$(document).find(".LoginModalAjax").length > 0) {
                        login.pop_up();
                    }
                }
            },
            error: function (xhr, textStatus, errorThrown) {
//                showErrorMessage('There was an unknown error that occurred. You will need to refresh the page to continue working.');
            }
        });
    }
};
$(document).ready(function () {
    var vis = (function () {
        var stateKey,
                eventKey,
                keys = {
                    hidden: "visibilitychange",
                    webkitHidden: "webkitvisibilitychange",
                    mozHidden: "mozvisibilitychange",
                    msHidden: "msvisibilitychange"
                };
        for (stateKey in keys) {
            if (stateKey in document) {
                eventKey = keys[stateKey];
                break;
            }
        }
        return function (c) {
            if (c)
                document.addEventListener(eventKey, c);
            return !document[stateKey];
        };
    })();
    vis(function () {
        if (vis()) {
            setTimeout(function () {
                login.check();
            }, 300);
        }
    });
    $(document).on("submit", "form.login-frm", function (event) {
        var formData = new FormData($(this)[0]);
        var form = $(this).attr('name');
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('.login-btn').text('Please wait...!').attr('disabled', 'disabled');
            },
            success: function (returnData) {
                if (returnData.status == "ok") {
                    pop_up.notification(returnData.message);
                    login.check();
                } else {
                    var error_html = '';
                    if (typeof returnData.error != "undefined") {
                        $.each(returnData.error, function (idx, topic) {
                            error_html += '<p class="text-danger">' + topic + '</p>';
                        });
                    }
                    if (error_html != '') {
                        pop_up.alert(error_html);
                    } else {
                        pop_up.alert(returnData.message);
                    }
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                pop_up.alert('There was an unknown error that occurred. You will need to refresh the page to continue working.');
            },
            complete: function () {
                $('.login-btn').text('LOG IN').removeAttr('disabled');
            }
        });
        return false;
    });
});
