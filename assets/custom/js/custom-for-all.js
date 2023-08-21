$.ajaxPrefilter(function (options, original_Options, jqXHR) {
    options.async = true;
});
$(document).ready(function () {
    if ($("select.select2").length > 0) {
        $("select.select2").select2();
    }
    if ($('[data-toggle="tooltip"]').length > 0) {
        $('[data-toggle="tooltip"]').tooltip();
    }
    $(document).on('focus', 'input[type="text"]', function () {
        $(this).attr('autocomplete', 'off');
    });
    $(document).ajaxComplete(function () {
        if ($("select.select2").length > 0) {
            $("select.select2").select2();
        }
        if ($('[data-toggle="tooltip"]').length > 0) {
            $('[data-toggle="tooltip"]').tooltip();
        }
        $(document).on('focus', 'input[type="text"]', function () {
            $(this).attr('autocomplete', 'off');
        });
    });
    if ($('.common_datatable').length > 0) {
        get_datatable();
    }

    $("#ckbCheckAll").click(function () {
        $(".data_list").prop('checked', $(this).prop('checked'));
    });

    $(".data_list").change(function () {
        if (!$(this).prop("checked")) {
            $("#ckbCheckAll").prop("checked", false);
        }
    });

    $(document).on("click", ".open_my_form", function (event) {
        var frm_type = $(this).attr('data-form_type');
        var data_id = $(this).attr('data-id');
        var controller = $(this).attr('data-control');
        var method = $(this).attr('data-method');
        var data_method = $(this).attr('data-method');
        var $this = $(this);
        if (typeof data_id != "undefined") {
            method = method + '/' + data_id;
        }
        var $is_main_frm = true;
        if ($(this).hasClass('sub-form')) {
            $is_main_frm = false;
            $(this).attr('disabled', 'disabled');
        }
        if ($is_main_frm) {
            if (frm_type == 'full') {
                pop_up.full_open();
            } else if (frm_type == 'half') {
                pop_up.half_open();
            } else {
                pop_up.open();
            }
        }
        $.ajax({
            type: 'POST',
            url: BASEURL + controller + '/' + method,
            //            async: false,
            dataType: 'html',
            beforeSend: function () {
                if ($is_main_frm) {
                    if (frm_type == 'full') {
                        pop_up.loader('full_form');
                    } else if (frm_type == 'half') {
                        pop_up.loader('half_form');
                    } else {
                        pop_up.loader('add_edit_form');
                    }
                } else {
                    $('#add_edit_form').append('<div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="sub-form"></div>');
                    pop_up.loader('sub-form');
                    setTimeout(function () {
                        $("#sub-form").addClass("cbp-spmenu-open");
                    }, 200);
                }
            },
            success: function (returnData) {
                setTimeout(function () {
                    $this.removeAttr('disabled');

                    if ($is_main_frm) {
                        if (frm_type == 'full') {
                            $('#full_form').html(returnData);
                        } else if (frm_type == 'half') {
                            $('#half_form').html(returnData);
                        } else {
                            $('#add_edit_form').html(returnData);
                        }
                    } else {
                        $('#sub-form').html(returnData);
                    }
                    if ($('.instant-add').length > 0) {
                        $(".instant-add").click(function () {
                            var data_add = $(this).data('add');
                            if ($('#' + data_add).is(':visible')) {
                                $(this).text("ADD NEW +");
                            } else {
                                $(this).html("CLOSE <i class='fa fa-times'></i>");
                            }
                            $('#' + data_add).fadeToggle();
                            $('#' + data_add).find($('input:text')).focus();
                        });
                    }
                    if ($("select.select2").length > 0) {
                        $("select.select2").select2();
                    }
                    if ($('[data-toggle="tooltip"]').length > 0) {
                        $('[data-toggle="tooltip"]').tooltip();
                    }
                }, 500);
            },
            error: function (xhr, textStatus, errorThrown) {
                $this.removeAttr('disabled');
                if ($is_main_frm) {
                    if (frm_type == 'full') {
                        pop_up.full_close();
                    } else if (frm_type == 'half') {
                        pop_up.half_close();
                    } else {
                        pop_up.close();
                    }
                } else {
                    pop_up.close_sub('sub-form');
                }
                if (xhr.status == 401) {
                    login.pop_up();
                } else {
                    if (xhr.responseText != '') {
                        pop_up.alert(xhr.responseText);
                    } else {
                        pop_up.alert('There was an unknown error that occurred. You will need to refresh the page to continue working.');
                    }
                }
            }
        });
        return false;
    });
    $(document).on("submit", "form.default_form", function (event) {
        event.preventDefault();
        var formData = new FormData($(this)[0]);
        var form = $(this).attr('name');
        var type = $(this).attr('type');

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
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
                    if (form == 'banner_frm') {
                        if ($('.common_datatable').length > 0) {
                            get_updated_datatable(false);
                        } else {
                            pop_up.notification(returnData.message, 'redirect', "'" + 'banner/' + "'", true);
                        }
                    }
                    if (form == 'services_type_frm') {
                        if ($('.common_datatable').length > 0) {
                            get_updated_datatable(false);
                        } else {
                            pop_up.notification(returnData.message, 'redirect', "'" + 'services/type/' + "'", true);
                        }
                    }
                    if (form == 'service_frm') {
                        if ($('.common_datatable').length > 0) {
                            get_updated_datatable(false);
                        } else {
                            pop_up.notification(returnData.message, 'redirect', "'" + 'services/' + "'", true);
                        }
                    }
                    if (form == 'user_frm') {
                        if ($('.common_datatable').length > 0) {
                            get_updated_datatable(false);
                        } else {
                            pop_up.notification(returnData.message, 'redirect', "'" + 'user/' + "'", true);
                        }
                    }
                    if (form == 'subadmin_frm') {
                        if ($('.common_datatable').length > 0) {
                            get_updated_datatable(false);
                        } else {
                            pop_up.notification(returnData.message, 'redirect', "'" + 'subadmin/' + "'", true);
                        }
                    }
                    if (form == 'payment_frm') {
                        if ($('.common_datatable').length > 0) {
                            get_updated_datatable(false);
                        } else {
                            pop_up.notification(returnData.message, 'redirect', "'" + 'payment/' + "'", true);
                        }
                    }
                    if (form == 'document_frm') {
                        if ($('.common_datatable').length > 0) {
                            get_updated_datatable(false);
                        } else {
                            pop_up.notification(returnData.message, 'redirect', "'" + 'document/' + "'", true);
                        }
                    }
                    if (form == 'assign_services_frm') {
                        if ($('.common_datatable').length > 0) {
                            get_updated_datatable(false);
                        } else {
                            pop_up.notification(returnData.message, 'redirect', "'" + "services/" +type + "/'", true);
                        }
                    }
                    if (form == 'contact_frm') {
                        if ($('.common_datatable').length > 0) {
                            get_updated_datatable(false);
                        } else {
                            pop_up.notification(returnData.message, 'redirect', "'" + "contact_support/" + "'", true);
                        }
                    }
                    if (form == 'event_frm') {
                        pop_up.notification(returnData.message, 'redirect', "'" + "calendar/" + "'", true);
                    }
                    if (form == 'page_setting_frm') {
                        pop_up.notification(returnData.message, 'redirect', "'" + "pages/" + "'", true);
                    }

                    pop_up.close();
                    pop_up.half_close();
                    pop_up.full_close();

                } else {
                    var error_html = '';
                    if (typeof returnData.error != "undefined") {
                        $.each(returnData.error, function (idx, topic) {
                            error_html += '<li>' + topic + '</li>';
                        });
                    }
                    if (error_html != '') {
                        pop_up.alert(error_html);
                        //                        showErrorMessage(error_html);
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
                if (form == 'seller_info_frm') {
                    $('input[type="submit"]').val('NEXT').removeAttr('disabled');
                } else {
                    $('input[type="submit"]').val('SAVE').removeAttr('disabled');
                }
            }
        });
        return false;
    });
    $(document).on("change", ".change_list", function () {
        var method = $(this).data('method');
        var change = $(this).data('change');
        var data_id = $(this).data('id');
        var parent = $(this).data('parent');
        var id = $(this).val();

        if (typeof data_id != "undefined") {
            method = method + '/' + data_id;
        }
        if (typeof parent != "undefined") {
            var $parent_id = $(document).find('.' + parent).val();
            if ($parent_id == '') {
                pop_up.alert('Please select parent dropdown');
                return false;
            }
            method = method + '/' + $parent_id;
        }
        if (method == 'get_variant_cat') {
            $('.child-cat').addClass('hidden');
        }
        reset_dropdown(change);
        if ($(this).val() != '') {
            $('.' + change).prop('disabled', false);

            $.ajax({
                type: 'POST',
                url: BASEURL + 'common_ajax/' + method,
                async: false,
                data: {
                    id: $(this).val()
                },
                dataType: 'json',
                beforeSend: function () {
                    if ($('#product-form').length == 0) {
                        // pop_up.please_wait_show('.' + change);
                    }
                },
                success: function (returnData) {
                    if (returnData.status === "ok") {

                        if (typeof returnData.results !== "undefined") {
                            if (Object.keys(returnData.results).length > 0) {
                                $('#' + change).removeClass('hidden');
                            }
                            $.each(returnData.results, function (id, value) {
                                $('.' + change).append('<option value="' + id + '">' + value + '</option>');
                            });
                            if ($('.brand_frm').length > 0) {
                                var array = $.map(returnData.results, function (value, index) {
                                    return [value];
                                });
                                if (array.length == 0) {
                                    $('#brand_name').prop('disabled', false);
                                } else {
                                    $('#brand_name').val('');
                                    $('#brand_name').prop('disabled', true);
                                }
                            }
                            if ($('#product-form').length > 0) {
                                // reset_dropdown('product_brand');
                                // $('#pro_brand').prop('disabled', true);
                                var array = $.map(returnData.results, function (value, index) {
                                    return [value];
                                });
                                // if (array.length == 0) {
                                if (method == 'get_variant_cat') {
                                    getCategoryBrand(id);
                                    $('#pro_brand').prop('disabled', false);
                                }
                                // } else {
                                //     $('#pro_brand').prop('disabled', true);
                                // }
                            }
                        }
                    }
                    pop_up.please_wait_hide('.' + change);
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
                    pop_up.please_wait_hide('.' + change);
                },
                complete: function (returnData) {
                    pop_up.please_wait_hide('.' + change);
                }
            });
        } else {
            $('.' + change).prop('disabled', true);
            $('#' + change).addClass('hidden');
        }
    });
    $(document).on("change", ".get_list", function () {
        //        var formData = $('.default_form').serialize();
        var formData = $(this).closest('form').serialize();
        var method = $(this).data('method');
        var change = $(this).data('change');
        reset_dropdown(change);
        $.ajax({
            type: 'POST',
            url: BASEURL + 'common_ajax/' + method,
            async: false,
            data: formData,
            dataType: 'json',
            beforeSend: function () {
                // pop_up.please_wait_show('.' + change);
            },
            success: function (returnData) {
                if (returnData.status === "ok") {
                    if (typeof returnData.results !== "undefined") {
                        $.each(returnData.results, function (id, value) {
                            $('.' + change).append('<option value="' + id + '">' + value + '</option>');
                        });
                        $('.' + change).prop('disabled', false);
                    }
                }
                pop_up.please_wait_hide('.' + change);
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
                pop_up.please_wait_hide('.' + change);
            },
            complete: function (returnData) {
                pop_up.please_wait_hide('.' + change);
            }
        });
    });
    $(document).on("click", "#reset_btn", function () {
        $('select.select2').val(null).trigger('change');
        if ($('.mapped').length > 0) {
            $('.mapped').hide();
        }
    });
    $(document).on("click", ".delete_btn", function () {
        var data_id = $(this).attr('data-id');
        var data_type = ($(this).attr('data-type')) ?? 'soft';
        var data_where = ($(this).attr('data-where')) ?? '';
        var control = $(this).attr('data-control');
        var method = $(this).attr('data-method');
        var $ts = $(this);

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn l-blue',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                swalWithBootstrapButtons.fire({
                    title: 'Submit your Account Password',
                    input: 'password',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Delete Now!',
                    ancelButtonText: 'No, cancel!',
                    showLoaderOnConfirm: true,
                    preConfirm: (pass) => {
                        if (pass == '') {
                            Swal.showValidationMessage(
                                `Failed: Account Password required for Delete!`
                            );
                        }
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: BASEURL + control + '/' + method,
                            async: false,
                            data: { id: data_id, type: data_type, where: data_where, pass: btoa(result.value) },
                            dataType: 'json',

                            success: function (returnData) {
                                if (returnData.status == "ok") {
                                    $ts.closest("tr").remove();
                                    get_updated_datatable(false);
                                    swalWithBootstrapButtons.fire(
                                        'Deleted!',
                                        'Your data has been deleted.',
                                        'success'
                                    )
                                } else {
                                    swalWithBootstrapButtons.fire(
                                        'Error!',
                                        returnData.message,
                                        'error'
                                    )
                                }
                            },
                            error: function (xhr, textStatus, errorThrown) {
                                if (xhr.status == 401) {
                                    login.pop_up();
                                }
                            }
                        });
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Cancelled',
                            'Your imaginary data is safe :)',
                            'error'
                        )
                    }
                })



            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your imaginary data is safe :)',
                    'error'
                )
            }
        })
    });
    $(document).on("click", ".login_as_admin", function () {
        var controller = $(this).attr('data-control');
        var method = $(this).attr('data-method');
        $.ajax({
            type: 'POST',
            url: BASEURL + controller + '/' + method,
            dataType: 'json',
            success: function (returnData) {
                if (returnData.status === "ok") {
                    window.location.reload();
                } else {
                    var error_html = '';
                    if (typeof returnData.error !== "undefined") {
                        $.each(returnData.error, function (idx, topic) {
                            error_html += '<li>' + topic + '</li>';
                        });
                    }
                    if (error_html !== '') {
                        pop_up.alert(error_html);
                    } else {
                        pop_up.alert(returnData.message);
                    }
                }
            },
            error: function () {
                pop_up.alert('There was an unknown error that occurred. You will need to refresh the page to continue working.');
            }
        });
        return false;
    });
    $(document).on("click", ".login_as_seller", function () {
        var data_id = $(this).attr('data-id');
        var controller = $(this).attr('data-control');
        var method = $(this).attr('data-method');
        $.ajax({
            type: 'POST',
            url: BASEURL + controller + '/' + method,
            data: {
                id: data_id
            },
            dataType: 'json',
            beforeSend: function () { },
            success: function (returnData) {
                if (returnData.status === "ok") {
                    window.location.reload();
                } else {
                    var error_html = '';
                    if (typeof returnData.error !== "undefined") {
                        $.each(returnData.error, function (idx, topic) {
                            error_html += '<li>' + topic + '</li>';
                        });
                    }
                    if (error_html !== '') {
                        showErrorMessage(error_html);
                    } else {
                        showErrorMessage(returnData.message);
                    }
                }
            },
            error: function () {
                showErrorMessage('There was an unknown error that occurred. You will need to refresh the page to continue working.');
            },
            complete: function () { }
        });
        return false;
    });
});

function get_datatable() {
    $(".common_datatable").each(function () {
        var data_id = '';
        // var order = [0, 'asc'];
        if (typeof $(this).attr('data-id') !== "undefined") {
            data_id = $(this).attr('data-id');
        }
        if (typeof $(this).attr('data-sort') !== "undefined") {
            data_sort = $(this).attr('data-sort');
            order = [data_sort, "desc"]
        }
        var $url = BASEURL + $(this).attr('data-control') + '/' + $(this).attr('data-method') + '/' + data_id;
        var oTable = $(this).dataTable({
            bProcessing: true,
            bServerSide: true,
            lengthChange: false,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            // order: [order],
            aaSorting: [],
            columnDefs: [
                {
                    target: 'sort-desc',

                },
                {
                    targets: 'no-sort',
                    orderable: false
                },
                {
                    targets: 'select-checkbox',
                    orderable: false,
                    render: function (data, type, row) {
                        return '<label class="check-box checkbox-controlborder"><input type="checkbox" class="data_list" value="' + btoa(data) + '"><span class="checkmark-box"></span></label>';
                    }
                }
            ],
            sServerMethod: "POST",
            sAjaxSource: $url,
            dom: "<'row'<'col-sm-6'l><'col-sm-6'>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
            "fnServerParams": function (aoData, fnCallback) {

                var pushDataArray = {
                    'status': '#status_filter',
                    'type': '#type_filter',
                    'payment_status': '#payment_status_filter',
                    'user_id': '#user_id_filter',
                    'service_status': '#service_status_filter',
                };
                $.each(pushDataArray, function (index, item) {
                    if ($(document).find(item).length > 0 && $(document).find(item).val() != '') {
                        aoData.push({
                            "name": index,
                            "value": $(document).find(item).val()
                        });
                    }
                });
                if ($('.status').length > 0) {
                    aoData.push({
                        "name": "status",
                        "value": $('.status:checked').val()
                    });
                }
            },
            "fnInitComplete": function () {
                $('.search_mq').on('change', function () {
                    oTable.fnDraw();
                });

                if ($('.StatusFilter').length > 0) {
                    $('.StatusFilter').on("change", function () {
                        oTable.fnDraw();
                    });
                }
                if ($('.TypeFilter').length > 0) {
                    $('.TypeFilter').on("change", function () {
                        oTable.fnDraw();
                    });
                }
                if ($('.PaymentStatusFilter').length > 0) {
                    $('.PaymentStatusFilter').on("change", function () {
                        oTable.fnDraw();
                    });
                }
                if ($('.UserFilter').length > 0) {
                    $('.UserFilter').on("change", function () {
                        oTable.fnDraw();
                    });
                }
                if ($('.ServieStatusFilter').length > 0) {
                    $('.ServieStatusFilter').on("change", function () {
                        oTable.fnDraw();
                    });
                }


                $("#search").on("keyup search paste cut", function () {
                    oTable.fnFilter(this.value);
                });
            },
            "oLanguage": {
                "sLengthMenu": "_MENU_ ",
                "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
            }
        });
    });
}

function getCategoryBrand(CatID) {
    $.ajax({
        type: 'POST',
        url: BASEURL + 'common_ajax/get_cat_brand',
        async: false,
        data: {
            id: CatID
        },
        dataType: 'json',
        beforeSend: function () {
            $('.product_brand')
                .find('option')
                .remove()
                .end().append('<option value="">Select Brand</option>');
        },
        success: function (returnData) {
            if (returnData.status == 'ok') {
                if (typeof returnData.results !== "undefined") {
                    $.each(returnData.results, function (id, value) {
                        $('.product_brand').append('<option value="' + id + '">' + value + '</option>');
                    });

                    var array = $.map(returnData.results, function (value, index) {
                        return [value];
                    });
                    if (array.length == 0) {
                        $('.nobrand-infor').css('display', 'block');
                        $('#pro_brand').prop('disabled', true);
                    } else {
                        $('.nobrand-infor').css('display', 'none');
                        $('#pro_brand').prop('disabled', false);
                    }
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
        complete: function () {

        }
    });
}

function get_updated_datatable(popup) {
    if (popup === undefined) {
        popup = true;
    }
    if (popup) {
        pop_up.close();
    }
    if ($('.manage-list').length > 0) {
        window.location.reload();
    } else {
        $('.common_datatable').dataTable().fnDraw();
    }
    if ($(".dataTables_paginate li.active a").length > 0)
        $(".dataTables_paginate li.active a").trigger("click");
    else
        $(".dataTable th:eq(0)").trigger("click");
}

function reset_dropdown($class_name) {
    if ($class_name != "") {
        if ($("select." + $class_name).length > 0) {
            $('select.' + $class_name).find("option[value!='']").remove();
            $("select." + $class_name).select2("val", "");
            var change = $('select.' + $class_name).data('change');
            if (typeof change != "undefined") {
                reset_dropdown(change);
                $('.' + change).prop('disabled', 'disabled');
            } else {
                return true;
            }
        }
    }
}

function arrayUnique(array) {
    var a = array.concat();
    for (var i = 0; i < a.length; ++i) {
        for (var j = i + 1; j < a.length; ++j) {
            if (a[i] === a[j])
                a.splice(j--, 1);
        }
    }
    return a;
}
var pop_up = {
    open: function () {
        $("#add_edit_form").addClass("cbp-spmenu-open");
        $("#main-wrapper").addClass("active");
    },
    close: function () {
        $("#add_edit_form").removeClass("cbp-spmenu-open");
        $("#main-wrapper").removeClass("active");
        $("#add_edit_form").html("");
        $("#add_edit_form").css('width', '550');
    },
    half_open: function () {
        $("#half_form").addClass("cbp-spmenu-open");
        $("#main-wrapper").addClass("active");
    },
    half_close: function (callback) {
        $("#half_form").removeClass("cbp-spmenu-open");
        $("#main-wrapper").removeClass("active");
        $("#half_form").html("");
    },
    full_open: function () {
        $("#full_form").addClass("cbp-spmenu-open");
        $("#main-wrapper").addClass("active");
    },
    full_close: function (callback) {
        $("#full_form").removeClass("cbp-spmenu-open");
        $("#main-wrapper").removeClass("active");
        $("#full_form").html("");
        if ($('#added_by_filter').length > 0) {
            get_updated_datatable(false);
        }
    },
    static_open: function () {
        $("#static_popup").addClass("cbp-spmenu-open");
        $("#main-wrapper").addClass("active");
    },
    static_close: function (status) {
        $("#static_popup").css('width', '550');
        $("#static_popup").removeClass("cbp-spmenu-open");
        $("#main-wrapper").removeClass("active");
        if (status === undefined) {
            if ($('#course-filter').length > 0 || $('#staff-filter').length > 0 || $('#student-filter').length > 0 || $('#question-filter').length > 0) {
                if ($("#status1").is(':checked') || $("#status2").is(':checked')) {
                    $('#reset_btn').first().trigger('click');
                    $('.notify').addClass('d-none');
                    get_updated_datatable(false);
                } else if ($("#question_type").val() || $("#option_type").val() || $("#sub_category").val()) {
                    $('#reset_btn').first().trigger('click');
                    $('.notify').addClass('d-none');
                    get_updated_datatable(false);
                }
            }
        }
    },
    close_sub: function ($id) {
        $("#add_edit_form").find("#" + $id).animate({
            width: "toggle"
        },
            400,
            function () {
                $("#add_edit_form").find("#" + $id).remove();
            }
        );
    },
    loader: function (id) {
        $("#" + id).html('<div class="loader" style="position: relative;width: 100%;height: 65vh;"><div style="position: absolute;top: calc(70% - 25px);left: calc(50% - 25px);"><img src="' + ASSETS_PATH + 'images/favicon.png" width="50" height="50" style="width:50px !important;" alt="Loading..."><p>Please wait...</p></div></div>');
    },
    notification: function (message, $function, $ID, $hidden) {
        $hidden = $hidden || false;
        message = message || 'Successfully';
        var $button = '<button class="cancel" style="box-shadow: none;display:none;">Cancel</button> <div class="sa-confirm-button-container"><button class="confirm" onclick="pop_up.notification_close()">OK</button>';
        if ($function && !$hidden) {
            $button = '<button class="cancel" onclick="pop_up.notification_close()" style="box-shadow: none;">Cancel</button> <div class="sa-confirm-button-container" onclick="pop_up.notification_close()"><button class="confirm" onclick="' + $function + '(' + $ID + ')">OK</button>';
        }
        if ($function && $hidden) {
            $button = '<div class="sa-confirm-button-container" onclick="pop_up.notification_close()"><button class="confirm" onclick="' + $function + '(' + $ID + ')">OK</button>';
        }
        $("body").append('<div class="sweet-overlay notification" style="opacity: 1.1; display: block;"></div><div class="sweet-alert showSweetAlert visible notification" data-custom-class="" data-has-cancel-button="false" data-has-confirm-button="true" data-allow-outside-click="false" data-has-done-function="false" data-animation="pop" data-timer="null" style="display: block; margin-top: -150px;"><div class="sa-icon sa-success animate" style="display: block;"><span class="sa-line sa-tip animateSuccessTip"></span><span class="sa-line sa-long animateSuccessLong"></span><div class="sa-placeholder"></div><div class="sa-fix"></div></div><h2>' + message + '</h2><div class="sa-button-container text-center">' + $button + '</div></div></div>');
    },
    alert: function (message) {
        //$('body').append('<div class="sweet-overlay alerts" style="opacity: 1.09; display: block;"></div><div class="sweet-alert showSweetAlert visible alerts" data-custom-class="" data-has-cancel-button="false" data-has-confirm-button="true" data-allow-outside-click="false" data-has-done-function="false" data-animation="pop" data-timer="null" style="display: block;"><div class="sa-icon sa-error animateErrorIcon" style="display: none;"> <span class="sa-x-mark animateXMark"> <span class="sa-line sa-left"></span> <span class="sa-line sa-right"></span> </span> </div><h2 style="display: none;">HTML <small>Title</small>!</h2><div class="text-center text-danger sweet-content"><ul style="margin:0;padding:0;list-style:none;">' + message + '</ul></div><div class="sa-button-container text-center"><div class="sa-confirm-button-container"> <button class="confirm" onclick="pop_up.alert_close();">OK</button></div></div></div>');
        $('body').append(`<div class="sweet-overlay alerts" style="opacity: 1.09; display: block;"></div>
        <div class="sweet-alert showSweetAlert visible alerts" data-custom-class="" data-has-cancel-button="false" data-has-confirm-button="true" data-allow-outside-click="false" data-has-done-function="false" data-animation="pop" data-timer="null" style="display: block;">
        <div class="sidebar-header-content">    
        <a href="javascript:;" onclick="pop_up.alert_close()"><i class="fa fa-times"></i></a>    
        </div>
            <div class="text-center text-danger sweet-content">
                <ul style="margin:0;padding:0;list-style:none;"> ${message} </ul>
            </div>
            <div class="sa-button-container text-center">
                <div class="sa-confirm-button-container">
                    <button class="confirm" onclick="pop_up.alert_close();">OK</button>
                </div>
            </div>
        </div>`);
    },
    alert_delete: function ($this) {
        var data_id = $($this).attr('data-id');
        var data_method = $($this).attr('data-method');
        var data_type = $($this).attr('data-type');

        if (typeof $($this).attr('data-original-title') !== "undefined") {
            var $title = $($this).attr('data-original-title');
            var message = 'Are you sure want to delete' + $title.replace("Remove", " ") + '?';
        } else {
            var message = 'Are you sure want to delete ' + data_method.replace('-', ' ').replace('_', '') + '?';
        }

        $("body").append('<div class="sweet-overlay alert_delete" style="opacity: 1.1; display: block;"></div><div class="sweet-alert showSweetAlert visible alert_delete" data-custom-class="" data-has-cancel-button="true" data-has-confirm-button="true" data-allow-outside-click="false" data-has-done-function="true" data-animation="pop" data-timer="null" style="display: block;"><div class="sa-icon sa-warning pulseWarning" style="display: block;"><span class="sa-body pulseWarningIns"></span><span class="sa-dot pulseWarningIns"></span></div><h2>' + message + '</h2><div class="sa-button-container text-center"><button class="cancel" onclick="pop_up.alert_delete_close()">Cancel</button><button class="confirm" onclick=\'pop_up.prompt_delete("' + data_id + '","' + data_method + '","' + data_type + '");\'>Delete</button></div></div>');
    },
    prompt_delete: function (data_id, data_method, data_type) {
        pop_up.alert_delete_close();
        $("body").append('<div class="sweet-overlay prompt_delete" tabindex="-1" style="opacity: 1.12; display: block;"></div><div class="sweet-alert show-input showSweetAlert visible prompt_delete" data-custom-class="" data-has-cancel-button="true" data-has-confirm-button="true" data-allow-outside-click="false" data-has-done-function="true" data-animation="slide-from-top" data-timer="null" style="display: block; margin-top: -120px;"><h2 style="margin-top:20px !important">Enter your password</h2><fieldset class="m-r-20 m-l-20"><input type="password" id="delete_password" placeholder="Enter here"></fieldset><div class="sa-button-container text-center"><button class="cancel" onclick="pop_up.prompt_close()">Cancel</button><div class="sa-confirm-button-container"><button class="confirm" onclick=\'delete_record("' + data_id + '","' + data_method + '","' + data_type + '");\'>OK</button></div></div></div>');
    },
    notification_close: function () {
        $("body").find('.notification').remove();
    },
    alert_delete_close: function () {
        $("body").find('.alert_delete').remove();
    },
    prompt_close: function () {
        $("body").find('.prompt_delete').remove();
    },
    alert_close: function () {
        $("body").find('.alerts').remove();
    },
    please_wait_show: function (Element) {
        $(Element).parent().append('<div class="please-wait">Please Wait...</div>');
    },
    please_wait_hide: function (Element) {
        $(Element).parent().find('.please-wait').remove();
    },
    bytesToSize: function (bytes) {
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        if (bytes == 0)
            return '0 Byte';
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
    }
};

function delete_record(data_id, data_method, data_type) {
    var $url = BASEURL + 'remove/' + data_method;
    $.ajax({
        type: 'POST',
        url: $url,
        async: false,
        data: { id: data_id, type: data_type, pass: btoa($('#delete_password').val()) },
        dataType: 'json',
        beforeSend: function () {
            pop_up.prompt_close();
            $('.dataTables_processing').css('visibility', 'visible');
        },
        success: function (returnData) {
            if (returnData.status === 'ok') {
                pop_up.notification(returnData.message);
                get_updated_datatable(false);
            } else {
                pop_up.alert(returnData.message);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            if (xhr.status === 401) {
                login.pop_up();
            } else {
                if (xhr.responseText !== '') {
                    pop_up.alert(xhr.responseText);
                } else {
                    pop_up.alert(UNKNOWN_WEB_ERROR);
                }
            }
        },
        complete: function () {
            $('.dataTables_processing').css('visibility', 'hidden');
        }
    });
}
function form_resubmit($FormID) {
    $.ajax({
        type: 'POST',
        url: $($FormID).attr('action'),
        data: $($FormID).serialize() + '&Duplicate=' + 1,
        dataType: 'json',
        beforeSend: function () {
            pop_up.notification_close();
        },
        success: function (returnData) {
            if (returnData.status == "ok") {
                pop_up.notification(returnData.message);
                get_updated_datatable(true);
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
            $('input[type="submit"]').val('SAVE').removeAttr('disabled');
        }
    });
}
var loadImage = function (event) {
    var output = document.getElementById('profile_img');
    output.src = URL.createObjectURL(event.target.files[0]);
};

function redirect(slug) {
    window.location.href = BASEURL + slug;
}

function getEventData(start,end,view) {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: BASEURL + '/calendar/view/1',
        data: { start:start,end:end,view: view },
        success: function (returnData) {
            if (returnData.status == "ok") {
                // $.getScript(ASSETS_PATH + 'custom/js/fullcalendarscripts.bundle.js');
                // $.getScript(ASSETS_PATH + 'custom/js/calendar.js');
                $("#event-data").html(returnData.html);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            if (xhr.status == 401) {
                login.pop_up();
            }
        }
    });
}    

