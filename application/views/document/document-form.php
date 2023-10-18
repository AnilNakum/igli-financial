<?php
if (isset($document_info) && $document_info->ID > 0) {
    $ID = array('name' => 'document_id', 'id' => 'document_id', 'value' => ($document_info->ID > 0) ? $document_info->ID : "", 'type' => 'hidden');
}

$DocName = array('name' => 'doc_name', 'id' => 'doc_name', 'value' => (isset($document_info) && $document_info->DocName != "") ? $document_info->DocName : set_value('doc_name'), 'class' => "form-control", "tabindex" => 1, 'placeholder' => "Document Name", "data-validation" => "required");

$User = array('name' => 'user_id[]', 'id' => 'user_id', 'class' => "select2", 'multiple'=>"multiple", "tabindex" => 4, "data-validation" => "required");
$UserList =  $Users;
$UserID = (isset($document_info) && $document_info->UserID != "") ? explode(",",$document_info->UserID) : set_value('user_id');


$OldDoc = array('name' => 'old_doc', 'id' => 'old_doc', 'value' => (isset($document_info) && $document_info->Document != "") ? $document_info->Document : '', 'type' => "hidden",);


$S = array(
    "2" => "Inactive",
);
$Status = array('name' => 'status', 'id' => 'status', 'class' => "select2 ", "tabindex" => 4, "data-validation" => "required");
$StatusList = array("1" => "Active") + $S;
$StatusID = (isset($document_info) && $document_info->Status != "") ? $document_info->Status : set_value('status');

$submit_btn = array('name' => 'submit_btn', 'id' => 'submit_btn', 'value' => 'SAVE', 'class' => 'btn btn-round l-blue');
$cancel_btn = array('name' => 'cancel_btn', 'id' => 'cancel_btn', 'content' => 'CANCEL', 'class' => 'btn btn-round btn-white', "onclick" => "pop_up.half_close()");
$form_attr = array('class' => 'default_form document_frm', 'id' => 'document_frm', 'name' => 'document_frm');
?>
<?php echo form_open_multipart('document/submit_form', $form_attr); ?>
<div class="popup_body_area">
    <header id="sidebar-header">
        <div class="sidebar-header">
            <div class="sidebar-header-content">
                <h3><?php echo $page_title; ?></h3>
                <a href="javascript:;" onclick="pop_up.half_close()"><i class="fa fa-times"></i></a>
            </div>
        </div>
    </header>
    <section id="sidebar-section">
        <div class="sidebar-section">
            <?php echo validation_errors(); 
             if (isset($document_info) && $document_info->ID > 0) {
                echo form_input($ID);
            }
            if (isset($document_info) && $document_info->Document != '') {
                echo form_input($OldDoc);
            }
           
            ?>
            <div class="row">
                <div class="col-md-12 card">
                    <div class="header">
                        <h2><strong>Document</strong> Details </h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Select User <span class="text-danger">*</span></label>
                                <?php echo form_dropdown($User, $UserList, $UserID); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Document Name <span class="text-danger">*</span></label>
                                <?php echo form_input($DocName); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <?php echo form_dropdown($Status, $StatusList, $StatusID); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Document <span class="text-danger">*</span></label>
                                <div class="file-loading">
                                    <input id="file" type="file" name="doc" class="file form-control" 
                                        data-upload-url="#" data-browse-on-zone-click="true"
                                         data-theme="fas">
                                </div>
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
    $("#file").fileinput({
        theme: 'fas',
        maxFileSize: 1000,
        autoReplace: false,
        overwriteInitial: true,
        initialPreviewAsData: true,
        initialPreview: [
            <?php if (isset($document_info)) {
    echo "'" . IMAGE_DIR . $document_info->Document."'" ;
}?>
        ],
        slugCallback: function(filename) {
            return filename.replace('(', '_').replace(']',
                '_');
        }
    });
});
</script>