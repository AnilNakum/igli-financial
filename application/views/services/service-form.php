<?php
if (isset($service_info) && $service_info->ServiceID > 0) {
    $ServiceID = array('name' => 'service_id', 'id' => 'service_id', 'value' => ($service_info->ServiceID > 0) ? $service_info->ServiceID : "", 'type' => 'hidden');
}
$ServiceType = array('name' => 'service_type', 'id' => 'service_type', 'class' => "select2", "tabindex" => 4, "data-validation" => "required");
$ServiceTypesList = array("" => "Select Service Type") + $ServiceTypes;
$STID = (isset($service_info) && $service_info->STID != "") ? $service_info->STID : set_value('service_type');

$ServiceTitle = array('name' => 'service_title', 'id' => 'service_title', 'value' => (isset($service_info) && $service_info->ServiceTitle != "") ? $service_info->ServiceTitle : set_value('service_title'), 'class' => "form-control", "tabindex" => 1, 'placeholder' => "Enter Service Title", "data-validation" => "required");
$Amount = array('name' => 'amount', 'id' => 'amount', 'value' => (isset($service_info) && $service_info->Amount != "") ? $service_info->Amount : set_value('amount'), 'class' => "form-control", "tabindex" => 1, 'placeholder' => "Enter Amount", "data-validation" => "required");
$DiscountAmount = array('name' => 'discount_amount', 'id' => 'discount_amount', 'value' => (isset($service_info) && $service_info->DiscountAmount != "") ? $service_info->DiscountAmount : set_value('discount_amount'), 'class' => "form-control", "tabindex" => 1, 'placeholder' => "Enter Discount Amount", "data-validation" => "required");

$GST = array(
    "incl.GST" => "incl.GST",
    "excl.GST" => "excl.GST"
);

$AmountType = array('name' => 'amount_type', 'id' => 'amount_type', 'class' => "select2 ", "tabindex" => 4, "data-validation" => "required");
$GSTList = array("" => "Select Amount Type") + $GST;
$AmountTypeVal = (isset($service_info) && $service_info->AmountType != "") ? $service_info->AmountType : set_value('amount_type');

$DiscountAmountType = array('name' => 'discount_amount_type', 'id' => 'discount_amount_type', 'class' => "select2 ", "tabindex" => 4, "data-validation" => "required");
$DGSTList = array("" => "Select Amount Type") + $GST;
$DiscountAmountTypeVal = (isset($service_info) && $service_info->DiscountAmountType != "") ? $service_info->DiscountAmountType : set_value('discount_amount_type');

$OldLogo = array('name' => 'old_image', 'id' => 'old_image', 'value' => (isset($service_info) && $service_info->Logo != "") ? $service_info->Logo : '', 'type' => "hidden",);

$S = array(
    "2" => "Inactive",
);
$Status = array('name' => 'status', 'id' => 'status', 'class' => "select2 ", "tabindex" => 4, "data-validation" => "required");
$StatusList = array("1" => "Active") + $S;
$StatusID = (isset($service_info) && $service_info->Status != "") ? $service_info->Status : set_value('status');

$submit_btn = array('name' => 'submit_btn', 'id' => 'submit_btn', 'value' => 'SAVE', 'class' => 'btn btn-round l-blue');
$cancel_btn = array('name' => 'cancel_btn', 'id' => 'cancel_btn', 'content' => 'CANCEL', 'class' => 'btn btn-round btn-white', "onclick" => "pop_up.full_close()");
$form_attr = array('class' => 'default_form service_frm', 'id' => 'service_frm', 'name' => 'service_frm');
?>
<?php echo form_open_multipart('services/submit_form', $form_attr); ?>
<div class="popup_body_area">
    <header id="sidebar-header">
        <div class="sidebar-header">
            <div class="sidebar-header-content">
                <h3><?php echo $page_title; ?></h3>
                <a href="javascript:;" onclick="pop_up.full_close()"><i class="fa fa-times"></i></a>
            </div>
        </div>
    </header>
    <section id="sidebar-section">
        <div class="sidebar-section">
            <?php echo validation_errors(); 
             if (isset($service_info) && $service_info->ServiceID > 0) {
                echo form_input($ServiceID);
            }
            if (isset($service_info) && $service_info->Logo != '') {
                echo form_input($OldLogo);
            }
            ?>
            <div class="row">
                <div class="col-md-12 card">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Service Type <span class="text-danger">*</span></label>
                                <?php echo form_dropdown($ServiceType, $ServiceTypesList,$STID ); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Service Title <span class="text-danger">*</span></label>
                                <?php echo form_input($ServiceTitle); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Amount <span class="text-danger">*</span></label>
                                <?php echo form_input($Amount); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Amount Type <span class="text-danger">*</span></label>
                                <?php echo form_dropdown($AmountType, $GSTList,$AmountTypeVal ); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Discount Amount <span class="text-danger">*</span></label>
                                <?php echo form_input($DiscountAmount); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Discount Amount Type <span
                                        class="text-danger">*</span></label>
                                <?php echo form_dropdown($DiscountAmountType, $DGSTList,$DiscountAmountTypeVal ); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <?php echo form_dropdown($Status, $StatusList, $StatusID); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Service Logo <span class="text-danger">*</span></label>
                                <div class="file-loading">
                                    <input id="file" type="file" name="image" class="file form-control"
                                        data-upload-url="#" data-browse-on-zone-click="true"
                                        data-overwrite-initial="true" data-theme="fas">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">OnGoing <span class="text-danger">*</span></label>
                                <textarea
                                    id="ongoing_editor"><?php echo (isset($service_info) && $service_info->OnGoing != "") ? $service_info->OnGoing : '' ?></textarea>
                                <input type="hidden" id="ongoing" name="ongoing"
                                    value="<?php echo (isset($service_info) && $service_info->OnGoing != "") ? $service_info->OnGoing : '' ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Benefits <span class="text-danger">*</span></label>
                                <textarea
                                    id="benefits_editor"><?php echo (isset($service_info) && $service_info->Benefits != "") ? $service_info->Benefits : '' ?></textarea>
                                <input type="hidden" id="benefits" name="benefits"
                                    value="<?php echo (isset($service_info) && $service_info->Benefits != "") ? $service_info->Benefits : '' ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Documents <span class="text-danger">*</span></label>
                                <textarea
                                    id="documents_editor"><?php echo (isset($service_info) && $service_info->Documents != "") ? $service_info->Documents : '' ?></textarea>
                                <input type="hidden" id="documents" name="documents"
                                    value="<?php echo (isset($service_info) && $service_info->Documents != "") ? $service_info->Documents : '' ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Deliverables <span class="text-danger">*</span></label>
                                <textarea
                                    id="deliverables_editor"><?php echo (isset($service_info) && $service_info->Deliverables != "") ? $service_info->Deliverables : '' ?></textarea>
                                <input type="hidden" id="deliverables" name="deliverables"
                                    value="<?php echo (isset($service_info) && $service_info->Deliverables != "") ? $service_info->Deliverables : '' ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <footer id="sidebar-footer">
        <div class="sidebar-footer">
            <div class="side-footer-button">
                <div class="form-group">
                    <?php
echo form_submit($submit_btn);
echo form_button($cancel_btn);
?>
                </div>
            </div>
        </div>
    </footer>
</div>
<?php echo form_close(); ?>
<script>
$(document).ready(function() {

    if ($("#ongoing_editor").length > 0) {
        var editorElement = CKEDITOR.document.getById('ongoing_editor');
        editorElement.setAttribute('contenteditable', 'true');
        CKEDITOR.replace('ongoing_editor');
    }

    CKEDITOR.instances.ongoing_editor.on('change', function() {
        var CKdata = CKEDITOR.instances.ongoing_editor.getData();
        $('#ongoing').val(CKdata);
    });

    if ($("#benefits_editor").length > 0) {
        var editorElement = CKEDITOR.document.getById('benefits_editor');
        editorElement.setAttribute('contenteditable', 'true');
        CKEDITOR.replace('benefits_editor');
    }

    CKEDITOR.instances.benefits_editor.on('change', function() {
        var CKdata = CKEDITOR.instances.benefits_editor.getData();
        $('#benefits').val(CKdata);
    });

    if ($("#documents_editor").length > 0) {
        var editorElement = CKEDITOR.document.getById('documents_editor');
        editorElement.setAttribute('contenteditable', 'true');
        CKEDITOR.replace('documents_editor');
    }

    CKEDITOR.instances.documents_editor.on('change', function() {
        var CKdata = CKEDITOR.instances.documents_editor.getData();
        $('#documents').val(CKdata);
    });

    if ($("#deliverables_editor").length > 0) {
        var editorElement = CKEDITOR.document.getById('deliverables_editor');
        editorElement.setAttribute('contenteditable', 'true');
        CKEDITOR.replace('deliverables_editor');
    }

    CKEDITOR.instances.deliverables_editor.on('change', function() {
        var CKdata = CKEDITOR.instances.deliverables_editor.getData();
        $('#deliverables').val(CKdata);
    });

    $("#file").fileinput({
        theme: 'fas',
        allowedFileExtensions: ['jpg', 'png', 'jpeg', 'webp'],
        maxFileSize: 1000,
        autoReplace: false,
        overwriteInitial: true,
        initialPreviewAsData: true,
        initialPreview: [
            <?php if (isset($service_info)) {
    echo "'" . IMAGE_DIR . $service_info->Logo."'" ;
}?>
        ],
        slugCallback: function(filename) {
            return filename.replace('(', '_').replace(']',
                '_');
        }
    });
});
</script>