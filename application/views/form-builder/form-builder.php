<?php 
if (isset($form_info) && $form_info->FID > 0) {
    $FID = array('name' => 'form_id', 'id' => 'form_id', 'value' => ($form_info->FID > 0) ? $form_info->FID : "", 'type' => 'hidden');
}

$FormName = array('name' => 'form_name', 'id' => 'form_name', 'value' => (isset($form_info) && $form_info->FormName != "") ? $form_info->FormName : set_value('form_name'), 'class' => "form-control form-name", "tabindex" => 1, 'placeholder' => "Enter Form Name", "data-validation" => "required");

$cancel_btn = array('name' => 'cancel_btn', 'id' => 'cancel_btn', 'content' => 'CANCEL', 'class' => 'btn btn-round btn-white ', "onclick" => "pop_up.close()");
?>
<script src="<?php echo ASSETS_PATH; ?>custom/js/form-builder.min.js"></script>
<section class="content home">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2><?php echo $page_title; ?>
                    <a href="javascript:void(0);"><img src="<?php echo ASSETS_PATH; ?>images/question.jpg"
                            data-toggle="tooltip" data-placement="right" title="You can manage form builder." /></a>
                </h2>
            </div>
            <div class="sidebar-header-content">
                    <a href="<?php echo base_url('form'); ?>" ><i class="fa fa-times"></i></a>
                </div>
        </div>
    </div>
    <div class="container-fluid">       
        <div class="sidebar-section">
            <?php echo validation_errors(); 
             if (isset($form_info) && $form_info->FID > 0) {
                echo form_input($FID);
            }
            
            ?>
            <div class="row justify-content-md-center">
                <div class="col-md-6 p-2">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Form Name <span class="text-danger">*</span></label>
                                <?php echo form_input($FormName); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="fb-editor"></div>
        </div>
        <footer id="sidebar-footer">
            <div class="sidebar-footer ">
                <div class="side-footer-button">
                    <div class="form-group">
                        <button class="btn btn-round l-blue" id="getJSData" type="button">SAVE</button>
                        <button class="btn btn-round btn-white" id="cancel_btn" type="button">CLEAR</button>
                        <a href="<?php echo base_url('form-builder'); ?>" class="btn btn-round btn-white">CANCEL</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</section>

<script>
jQuery(function($) {
    var options = {
        controlPosition: 'left',
        disableFields: ['autocomplete', 'button', 'hidden'],
        showActionButtons: false,
        controlOrder: [
            'header',
            'text',
            'number',
            'date',
            'textarea',
            'file',
            'select',
            'checkbox-group',
            'radio-group'
        ],
    };

    var fbEditor = document.getElementById('fb-editor');
    var formBuilder = $(fbEditor).formBuilder(options);

    document.getElementById('cancel_btn').addEventListener('click', function() {
        document.getElementById('form_name').value = '';
        formBuilder.actions.clearFields();
    });
    document.getElementById('getJSData').addEventListener('click', function() {
        var formName = document.getElementById('form_name').value;
        var formData = formBuilder.actions.getData();
        var error_html = '';
        if (formName == '') {
            error_html += '<li> From Name field should not be blank.</li>';
        }
        if (formData.length <= 0) {
            error_html += '<li> From Data should not be blank.</li>';
        }

        if (error_html != '') {
            pop_up.alert(error_html);
        } else {
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: 'form_builder/submit_form',
                data: {
                    formName: formName,
                    formData: formData
                },
                dataType: 'json',
                cache: false,
                success: function(returnData) {
                    if (returnData.status == "ok") {
                        pop_up.notification(returnData.message, 'redirect', "'" + 'form-builder/' + "'", true);
                    } else {
                        var error_html = '';
                        if (typeof returnData.error != "undefined") {
                            $.each(returnData.error, function(idx, topic) {
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
                error: function(xhr, textStatus, errorThrown) {
                    if (xhr.status == 401) {
                        login.pop_up();
                    } else {
                        if (xhr.responseText != '') {
                            pop_up.alert(xhr.responseText);
                        } else {
                            pop_up.alert(
                                'There was an unknown error that occurred. You will need to refresh the page to continue working.'
                                );
                        }
                    }
                },
            });
        }
    });
});
</script>