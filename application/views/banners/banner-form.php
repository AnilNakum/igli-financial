<?php
if (isset($banner_info) && $banner_info->BannerID > 0) {
    $BannerID = array('name' => 'banner_id', 'id' => 'banner_id', 'value' => ($banner_info->BannerID > 0) ? $banner_info->BannerID : "", 'type' => 'hidden');
}

$BannerTitle = array('name' => 'banner_title', 'id' => 'banner_title', 'value' => (isset($banner_info) && $banner_info->Title != "") ? $banner_info->Title : set_value('banner_title'), 'class' => "form-control", "tabindex" => 1, 'placeholder' => "Banner Title", "data-validation" => "required");
$Description = array('name' => 'description', 'id' => 'description', 'value' => (isset($banner_info) && $banner_info->Description != "") ? $banner_info->Description : set_value('description'), 'class' => "form-control", "rows" => 6, "tabindex" => 2, "style" => "resize:none");
$Order = array('name' => 'order', 'id' => 'order', 'value' => (isset($banner_info) && $banner_info->Order != "") ? $banner_info->Order : set_value('order'), 'class' => "form-control", "tabindex" => 1, 'placeholder' => "Banner Order", "data-validation" => "required");

$OldImage = array('name' => 'old_image', 'id' => 'old_image', 'value' => (isset($banner_info) && $banner_info->Image != "") ? $banner_info->Image : '', 'type' => "hidden",);

$S = array(
    "2" => "Inactive",
);
$Status = array('name' => 'status', 'id' => 'status', 'class' => "select2 ", "tabindex" => 4, "data-validation" => "required");
$StatusList = array("1" => "Active") + $S;
$StatusID = (isset($banner_info) && $banner_info->Status != "") ? $banner_info->Status : set_value('status');

$submit_btn = array('name' => 'submit_btn', 'id' => 'submit_btn', 'value' => 'SAVE', 'class' => 'btn btn-round l-blue');
$cancel_btn = array('name' => 'cancel_btn', 'id' => 'cancel_btn', 'content' => 'CANCEL', 'class' => 'btn btn-round btn-white', "onclick" => "pop_up.close()");
$form_attr = array('class' => 'default_form banner_frm', 'id' => 'banner_frm', 'name' => 'banner_frm');
?>
<?php echo form_open_multipart('banner/submit_form', $form_attr); ?>
<div class="popup_body_area">
    <header id="sidebar-header">
        <div class="sidebar-header">
            <div class="sidebar-header-content">
                <h3><?php echo $page_title; ?></h3>
                <a href="javascript:;" onclick="pop_up.close()"><i class="fa fa-times"></i></a>
            </div>
        </div>
    </header>
    <section id="sidebar-section">
        <div class="sidebar-section">
            <?php echo validation_errors(); 
             if (isset($banner_info) && $banner_info->BannerID > 0) {
                echo form_input($BannerID);
            }
            if (isset($banner_info) && $banner_info->Image != '') {
                echo form_input($OldImage);
            }
            ?>
            <div class="row">
                <div class="col-md-12 card">
                    <div class="header">
                        <h2><strong>Banner</strong> Details </h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Banner Title <span class="text-danger">*</span></label>
                                <?php echo form_input($BannerTitle); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Banner Description <span class="text-danger">*</span></label>
                                <?php echo form_textarea($Description); ?>
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
                                <label class="form-label">Banner Image <span class="text-danger">*</span></label>
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
                                <label class="form-label">Banner Order </label>
                                <?php echo form_input($Order); ?>
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
        allowedFileExtensions: ['jpg', 'png', 'jpeg', 'webp'],
        maxFileSize: 1000,
        autoReplace: false,
        overwriteInitial: true,
        initialPreviewAsData: true,
        initialPreview: [
            <?php if (isset($banner_info)) {
    echo "'" . IMAGE_DIR . $banner_info->Image."'" ;
}?>
        ],
        slugCallback: function(filename) {
            return filename.replace('(', '_').replace(']',
                '_');
        }
    });
});
</script>