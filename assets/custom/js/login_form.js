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
        }
    })();
    vis(function () {
        var pathname = window.location.pathname;
        const parts = pathname.split('/');
        const pageType = parts.at(-2);
        var ajax;
        if (vis()) {
            setTimeout(function () {
                if (ajax) {
                    ajax.abort();
                }
                ajax = $.ajax({
                    type: 'POST',
                    url: BASEURL + 'auth/check_login',
                    async: false,
                    data: 'pstdata=1',
                    dataType: 'json',
                    beforeSend: function () {
                    },
                    success: function (returnData, textStatus, xhr) {
                        if (returnData.status == 'login' && (pageType != 'igli_form' && pageType != 'complete')) {                            
                            window.location.href = BASEURL;
                        }
                        return true;
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        //                showErrorMessage('There was an unknown error that occurred. You will need to refresh the page to continue working.');
                    }
                });
            }, 300);
        }
    });


});