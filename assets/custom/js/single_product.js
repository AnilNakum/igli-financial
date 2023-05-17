$(document).ready(function () {
    checkbox_change();
    // $('#user_item_as_variants').change(function (er) {
    //     if (er.handled !== true) {
    //         er.handled = true;
    //         return;
    //     }
    //     checkbox_change();
    // });



    $(document).on("click", ".edit-catlog", function (event) {
        var data_id = $(this).attr('data-id');
        $.ajax({
            type: 'POST',
            url: BASEURL + 'single_upload/edit_catlog/' + data_id,
            dataType: 'json',
            beforeSend: function () {
                $(".page-loader-wrapper").fadeIn();
            },
            success: function (returnData) {
                var data = returnData.data;
                if (returnData.status == "ok") {
                    var $Ccode = data.catlog_code;
                    if (data.step_status == 1) {
                        window.location.replace(BASEURL + "product/product-image/" + $Ccode);
                    } else if (data.step_status == 2) {
                        window.location.replace(BASEURL + "product/product-basic-details/" + $Ccode);
                    } else if (data.step_status == 3) {
                        window.location.replace(BASEURL + "product/product-variants/" + $Ccode);
                    } else if (data.step_status == 4) {
                        window.location.replace(BASEURL + "product/send-for-approval/" + $Ccode);
                    } else {
                        window.location.replace(BASEURL + "product/categories-brand");
                    }
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                $this.removeAttr('disabled');
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
                // $(".page-loader-wrapper").fadeOut();
            }
        });
        return false;
    });
    $(document).on("click", ".view-catlog", function (event) {
        var data_id = $(this).attr('data-id');
        $.ajax({
            type: 'POST',
            url: BASEURL + 'single_upload/edit_catlog/' + data_id,
            dataType: 'json',
            beforeSend: function () {
                $(".page-loader-wrapper").fadeIn();
            },
            success: function (returnData) {
                var data = returnData.data;
                if (returnData.status == "ok") {
                    var $Ccode = data.CatlogCode;
                    window.location.replace(BASEURL + "product/send-for-approval/" + $Ccode);
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                $this.removeAttr('disabled');
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
                // $(".page-loader-wrapper").fadeOut();
            }
        });
        return false;
    });
    $(document).on("click", ".action", function (event) {
        event.preventDefault();
        var $this = $(this);
        var text = $this.text();
        var url;
        var formdata;
        url = $('#product-form').attr('action');
        var form = $('#product-form')[0];
        formdata = new FormData(form);
        if ($('#product-form').attr('name') == 'product_basic_frm') {
            var CKdata = CKEDITOR.instances.editor.getData();
            $('#description').val(CKdata);
            var x = JSON.parse(localStorage.getItem('mediaImages'));
            if (x && x.length > 0) {
                for (let i = 0; i < x.length; i++) {
                    var f = new File([x[i].result], x[i].name, x[i]);
                    formdata.append(i, f)
                }
            }
            // for (let i = 0; i < $('input[type=file]')[0].files.length; i++) {
            //     formdata.append(i, $('input[type=file]')[0].files[i]);
            // }
            formdata.delete('file');
        }

        if ($('#product-form').attr('name') == 'product_images_frm') {
            var form = $('#product-form')[0];
            formdata = new FormData(form);
            var x = JSON.parse(localStorage.getItem('mainImages'));
            if (x && x.length > 0) {
                for (let i = 0; i < x.length; i++) {
                    var f = new File([x[i].result], x[i].name, x[i]);
                    formdata.append(i, f)
                }
            }
            //for (let i = 0; i < $('input[type=file]')[0].files.length; i++) {
            //console.log($('input[type=file]')[0].files[i]);
            //formdata.append(i, $('input[type=file]')[0].files[i])
            //}
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
                // overlay.show();
                $(".page-loader-wrapper").fadeIn();
                $this.text('Please wait...!').attr('disabled', 'disabled');
            },
            success: function (returnData) {
                if (returnData.status == "ok") {
                    if ($('#product-form').attr('name') == 'product_approval_frm') {
                        pop_up.notification(returnData.message, 'redirect', "'" + 'product/' + "'", true);
                    } else {
                        var $Ccode = returnData.Ccode;
                        history.pushState(null, null, BASEURL + 'product/' + returnData.method + '/' + $Ccode);
                        $(document).attr("title", BASE_TITLE + returnData.page_title);

                        $("#product-content").html(returnData.html);
                        $('.header-title span').html(returnData.page_title);
                        $('#tooltip').attr('title', returnData.help);
                        $('#tooltip').attr('data-original-title', returnData.help);
                        if ($("select.select2").length > 0) {
                            $("select.select2").select2();
                        }
                        if ($('.common_datatable').length > 0) {
                            get_datatable();
                        }
                        location.reload();
                        // $.getScript(ASSETS_PATH + 'custom/js/single_product.js');
                    }
                } else {
                    $(".page-loader-wrapper").fadeOut();
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
                $(".page-loader-wrapper").fadeOut();
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
                $(".page-loader-wrapper").fadeOut();
                $(".modal-backdrop").remove();
            }
        });
    });
    $(document).on("click", ".delete_item", function (event) {
        var data_id = $(this).attr('data-id');
        var control = $(this).attr('data-control');
        var method = $(this).attr('data-method');

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
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
                $.ajax({
                    type: 'POST',
                    url: BASEURL + control + '/' + method + '/' + data_id,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (returnData) {
                        if (returnData.status == "ok") {
                            $('#item_' + data_id).css('display', 'none');
                            $('#item_' + data_id).html('');
                            swalWithBootstrapButtons.fire(
                                'Deleted!',
                                'Your Catlog item has been deleted.',
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
                    'Your imaginary Catlog item is safe :)',
                    'error'
                )
            }
        })
    });

    $(document).on("click", ".delete-option", function (event) {
        var data_id = $(this).attr('data-id');
        $("#option_" + data_id).remove();
        var cnt = $("#opt_count").val();
        $("#opt_count").val(parseInt(cnt) - 1);
    });
    $(document).on("click", ".add-option", function (event) {
        event.preventDefault();
        var cnt = $("#opt_count").val();
        var html = '<span id="option_' + cnt + '"><div class="row"><input type="hidden" name="option[' + cnt + '][option_id]" value=""><div class="col-lg-5 col-md-12 col-sm-12"><div class="form-group"><input  type="text" class="form-control" placeholder="Option Name" name="option[' + cnt + '][option_name]" id="option_name_' + cnt + '" value=""></div></div><div class="col-lg-4 col-md-12 col-sm-12"><div class="form-group modifier"><select class="select2 form-control " name="option[' + cnt + '][option_mod]" id="option_mod_' + cnt + '"> <option value="0"> + </option><option value="1"> - </option> </select> <input type="text" style="width: 73%;" class="form-control" placeholder="Price" name="option[' + cnt + '][option_price]" id="option_price_' + cnt + '" value=""></div></div> <div class="col-lg-3 col-md-12 col-sm-12 text-center"> <div class="form-group"><div class="radio"> <input type="radio" name="is_default" id="is_default_' + cnt + '" value="' + cnt + '"> <label for="is_default_' + cnt + '"> Is Default </label></div> <a href="javascript:;" class="btn btn-danger btn-icon btn-icon-mini btn-round delete-option" data-id="' + cnt + '"><i class="fa-solid fa-trash-can"></i></a></div></div></div><hr></span>';
        $("#opt_count").val(parseInt(cnt) + 1);
        $("#new-div").before(html);
        if ($("select.select2").length > 0) {
            $("select.select2").select2();
        }
    });

    // $(document).on("change", ".change_attribute", function (e) {
    //     if (e.handled !== true) {
    //         e.handled = true;
    //         return;
    //     }
    //     $('#choice_options').html(null);
    //     $.each($("#attributes option:selected"), function () {
    //         add_more_choice_option($(this).val(), $(this).text());
    //     });

    //     get_attribute_combination();
    // });

    // $(document).on("change", ".attribute_choice", function (e) {
    //     if (e.handled !== true) {
    //         e.handled = true;
    //         return;
    //     }
    //     console.log('here');
    //     get_attribute_combination();
    // });

    $(document).on("change", ".product_cat", function (e) {
        if (e.handled !== true) {
            e.handled = true;
            return;
        }
        var formData = $(this).closest('form').serialize();
        $.ajax({
            type: 'POST',
            url: BASEURL + 'common_ajax/get_sub_catlist',
            async: false,
            data: formData,
            dataType: 'json',

            success: function (returnData) {
                if (returnData.status === "ok") {
                    setText(returnData.categories[0]);
                    $("#search").val('');
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
            }
        });

    });

    $("#search").keyup(function () {
        var search = $(this).val();
        var Data = {
            'search': search
        }
        if (search != "") {
            $.ajax({
                type: 'POST',
                url: BASEURL + 'single_upload/search_category',
                data: Data,
                dataType: 'json',
                success: function (returnData) {
                    if (returnData.status == "ok") {
                        var result = returnData.categories;
                        var len = result.length;
                        $("#searchResult").css('display', 'block');
                        $("#searchResult").empty();
                        if (len > 0) {
                            for (var i = 0; i < len; i++) {
                                var Data = result[i];
                                if (Data['sub'] && Data['sub'] != undefined) {
                                    $("#searchResult").append(`<li data-id='${i}'> <p><b>${Data['name']}</b></p> <span>${Data['sub']}<span> <b>${Data['name']}</b></span> </li>`);
                                } else {
                                    $("#searchResult").append(`<li data-id='${i}'> <p><b>${Data['name']}</b></p> </li>`);
                                }
                            }
                        } else {
                            $("#searchResult").css('display', 'none');
                        }

                        $("#searchResult li").bind("click", function () {
                            var index = $(this).attr("data-id")
                            $("#pro_cat").val(result[index].id).trigger('change');
                            $("#search").val(result[index].name);
                            $("#searchResult").css('display', 'none');
                            // setText(result[index]);
                        });
                    } else {
                        pop_up.alert(returnData.message);
                    }
                },
                error: function (xhr, textStatus, errorThrown) {
                    if (xhr.status == 401) {
                        login.pop_up();
                    }
                }
            });
        } else {
            $('.cat-error').html('');
            $("#searchResult").css('display', 'none');
        }
    });
});

function setText(item) {
    getCategoryBrand(item['id']);
    var Sub = '';
    subHtml = `<ul> <li><i class="fa-regular fa-circle-check"></i> ${item['name']} </li></ul>`;
    if (item['sub'] && item['sub'] != undefined) {
        Sub = item['sub'];
        var subArray = Sub.split(' > ');
        var subHtml = getCatChild(item['name'], subArray, 0);
    }
    var html = `<span><i class="fa-solid fa-store"></i> ${Sub}
    <i>${item['name']}</i> </span><br>
    <hr>    <i class="fa-solid fa-store"></i> <b> Categories</b>
   ${subHtml} `;
    $('.tree').html(html);
}

function getCatChild(Name, Arr, I, html = '') {
    if (Arr[I] != '') {
        html = `<ul> <li><i class="fa-regular fa-folder-open"></i> ${Arr[I]} `;
        I++;
        if (Arr[I] != '') {
            html += getCatChild(Name, Arr, I, html);
        } else {
            html += `<ul><li><i class="fa-regular fa-circle-check"></i> <b> ${Name}</b> </li></ul>`;
        }
        html += `</li></ul>`;
    } else {
        html = `<ul> <li><i class="fa-regular fa-circle-check"></i> ${Name} </li></ul>`;
    }
    return html;
}

function load_previous_step($Step, $Ccode) {
    window.location.replace(BASEURL + $Step + $Ccode);
}

function checkbox_change() {
    if ($("#user_item_as_variants").prop('checked') == true) {
        $('#option_name').prop('disabled', false);
        $('#option_type').prop('disabled', false);
    } else {
        $('#option_name').prop('disabled', true);
        $('#option_type').prop('disabled', true);
    }
    // get_attribute_combination();
}

function add_more_choice_option(id, name) {
    var Data = {
        id: id,
        catlog_code: $('#catlog_code').val(),
        product_id: $('#product_id').val(),
        product_code: $('#product_code').val()
    }
    $.ajax({
        type: 'POST',
        url: BASEURL + 'common_ajax/get_attribute_values',
        data: Data,
        dataType: 'json',

        beforeSend: function () {

        },
        success: function (returnData) {
            if (returnData.status == "ok") {
                $('#choice_options').append(`
                    <div class="form-group">
                    <label class="form-label">Select ${name} Values <span class="text-danger">*</span></label> <!-- <a href="javascript:;" data-original-title="Add New ${name} Option" data-placement="top"
                    data-toggle="tooltip" class="text-info pull-right open_my_form"
                    data-control="single_upload" data-method="add_new_attribute_value" data-id="${id}"><i class="fa-solid fa-circle-plus"></i> Add New</a> -->
                        <input type="hidden" name="choice_no[]" value="${id}">
                        <input type="hidden" name="choice[]" value="${name}" placeholder="${name}" readonly>
                        <select class="form-control select2 attribute_choice" onchange="get_attribute_combination()" id="attr_${name.toLowerCase()}" name="choice_options_${id}[]" multiple>
                        ${returnData.html}
                        </select >
                    </div > `);

                if (returnData.selected == 'selected') {
                    setTimeout(() => {
                        get_attribute_combination();
                    }, 1000);
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

        }
    });
}

function change_attribute() {
    $('#choice_options').html(null);
    $.each($("#attributes option:selected"), function () {
        add_more_choice_option($(this).val(), $(this).text());
    });

    get_attribute_combination();

}

function get_attribute_combination() {
    $.ajax({
        type: 'POST',
        url: BASEURL + 'single_upload/get_attribute_combination',
        // data: $('#product-form').serialize(),
        data: $('#product-form').serialize(),
        dataType: 'json',
        beforeSend: function () {

        },
        success: function (returnData) {
            if (returnData.status == "ok") {
                $('#attribute_combination').html(returnData.html);
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

        }
    });
}

function delete_variant(em) {
    $(em).closest('.variant').remove();
}