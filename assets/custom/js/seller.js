var overlay = {
    show: function () {
        $("body").append('<div id="survey-overlay"><div class="img-tag"><img class="zmdi-hc-spin" src="' + BASEURL + 'assets/images/logo.png" width="50" height="50" alt="Loading..."><p class="text-white">Please wait...</p><div></div>');
    },
    hide: function () {
        $("body").find("#survey-overlay").remove();
    }
};
var survey_pop_up = {
    open: function () {
        $("#survey_popup").addClass("cbp-spmenu-open");
    },
    close: function (callback) {
        if (callback) {
            eval(callback + "()");
        }
        $("#survey_popup").removeClass("cbp-spmenu-open");
        $("#survey_popup").html("");
    }
};
$(document).ready(function () {
    $(document).on("click", ".action", function (event) {
        event.preventDefault();
        var $this = $(this);
        var text = $this.text();
        var url;
        formdata;
        url = $('#seller-form').attr('action');
        var form = $('#seller-form')[0];
        formdata = new FormData(form);
        console.log(formdata);
        if ($('#seller-form').attr('name') == 'seller_signature_frm') {
            var form = $('#seller-form')[0];
            var formdata = new FormData(form);
            formdata.append('file', $('input[type=file]')[0].files[0]);
        }
        formdata.append('save', 1);

        $.ajax({
            type: 'POST',
            url: url,
            data: formdata,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                //overlay.show();
                $this.text('Please wait...!').attr('disabled', 'disabled');
            },
            success: function (returnData) {
                if (returnData.status == "ok") {
                    if ($('#seller-form').attr('name') == 'seller_signature_frm') {
                        pop_up.notification(returnData.message, 'redirect', "'" + '/' + "'", true);
                    } else {
                        $("#seller-form-content").html(returnData.html);
                        $("#phoneVarification").modal();
                        $(document).attr("title", BASE_TITLE + returnData.page_title);
                        history.pushState(null, null, BASEURL + 'setup/' + returnData.method);
                        $('.header-title span').html(returnData.page_title);
                        $('#tooltip').attr('title', returnData.help);
                        $('#tooltip').attr('data-original-title', returnData.help);
                        if ($("select.select2").length > 0) {
                            $("select.select2").select2();
                        }

                    }
                } else {
                    console.log(returnData);
                    var error_html = '';
                    if (typeof returnData.error != "undefined") {
                        $.each(returnData.error, function (idx, topic) {
                            error_html += '<li>' + topic + '</li>';
                        });
                    }
                    if (error_html != '') {
                        pop_up.alert(error_html);
                    } else {
                        pop_up.alert(returnData.message);
                    }

                    if (returnData.heading == 'phone') {
                        $('.verify-text').css('display', 'block')
                    }
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                if (xhr.status == 401) {
                    login.pop_up();
                } else {
                    if (xhr.responseText != '') {
                        pop_up.alert(xhr.responseText);
                    } else {
                        pop_up.alert('There was an unknown error that occurred. You will need to refresh the page to continue working.');
                    }
                }
            },
            complete: function (returnData) {
                $this.text(text).removeAttr('disabled');
                // overlay.hide();
                $(".modal-backdrop").remove();
            }
        });
    });

    $("#skip").change(function () {
        if ($("#skip").is(':checked')) {
            $('.skip-btn').removeClass('disabled');
        } else {
            $('.skip-btn').addClass('disabled');
        }
    });
});


function load_current_step($url) {
    if ($url === undefined) {
        $url = window.location.href;
    }
    $.ajax({
        type: 'POST',
        url: $url,
        dataType: 'json',
        beforeSend: function () {
            //overlay.show();
        },
        success: function (returnData) {
            if (returnData.status == "ok") {
                $("#seller-form-content").html(returnData.html);
                $("#phoneVarification").modal();
                $(document).attr("title", BASE_TITLE + returnData.page_title);
                history.pushState(null, null, BASEURL + 'setup/' + returnData.method);
                $('.header-title span').html(returnData.page_title);
                $('#tooltip').attr('title', returnData.help);
                $('#tooltip').attr('data-original-title', returnData.help);
                if ($("select.select2").length > 0) {
                    $("select.select2").select2();
                }
            } else {
                var error_html = '';
                if (typeof returnData.error != "undefined") {
                    $.each(returnData.error, function (idx, topic) {
                        error_html += '<li>' + topic + '</li>';
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
            if (xhr.status == 401) {
                login.pop_up();
            } else {
                if (xhr.responseText != '') {
                    pop_up.alert(xhr.responseText);
                } else {
                    pop_up.alert('There was an unknown error that occurred. You will need to refresh the page to continue working.');
                }
            }
        },
        complete: function (returnData) {
            //overlay.hide();
        }
    });
}

function skip_step($url) {
    if (!$('.skip-btn').hasClass('disabled')) {
        if ($url === undefined) {
            $url = window.location.href;
        }
        $.ajax({
            type: 'POST',
            url: $url,
            dataType: 'json',
            beforeSend: function () {
                //overlay.show();
            },
            success: function (returnData) {
                if (returnData.status == "ok") {
                    $("#seller-form-content").html(returnData.html);
                    $(document).attr("title", BASE_TITLE + returnData.page_title);
                    history.pushState(null, null, BASEURL + 'setup/' + returnData.method);
                    $('.header-title span').html(returnData.page_title);
                    $('#tooltip').attr('title', returnData.help);
                    $('#tooltip').attr('data-original-title', returnData.help);
                    if ($("select.select2").length > 0) {
                        $("select.select2").select2();
                    }
                } else {
                    var error_html = '';
                    if (typeof returnData.error != "undefined") {
                        $.each(returnData.error, function (idx, topic) {
                            error_html += '<li>' + topic + '</li>';
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
                if (xhr.status == 401) {
                    login.pop_up();
                } else {
                    if (xhr.responseText != '') {
                        pop_up.alert(xhr.responseText);
                    } else {
                        pop_up.alert('There was an unknown error that occurred. You will need to refresh the page to continue working.');
                    }
                }
            },
            complete: function (returnData) {
                //overlay.hide();
            }
        });
    }
}