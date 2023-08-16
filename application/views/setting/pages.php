<?php
$form_attr = array('class' => 'default_form', 'id' => 'page_setting_frm', 'name' => 'page_setting_frm');
$submit_btn = array('name' => 'submit_btn', 'id' => 'submit_btn', 'value' => "SAVE", 'class' => 'btn btn-round btn-md l-cyan');
?>
<section class="content" id="main-wrapper">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <h2><?php echo $page_title; ?>
                    <small><?php echo $page_title; ?></small>
                    <a href="javascript:void(0);"><img src="<?php echo ASSETS_PATH; ?>images/question.jpg"
                            data-toggle="tooltip" data-placement="right"
                            title="You can see and change help page settings." /></a>
                </h2>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
            </div>
        </div>
    </div>
    <?php echo add_edit_form(); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Help Page Setting</strong> Details </h2>
                    </div>
                    <div class="body">
                        <?php echo form_open_multipart(base_url('setting/submit_page_form'), $form_attr); ?>
                        <?php foreach ($config_date as $key => $value) { ?>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><b><?php echo lang($key); ?></b> <span class="text-danger">*</span></label>
                                    <textarea class="editor" name="<?php echo  $key; ?>"
                                        id="editor_<?php echo $key; ?>"><?php echo (isset($value) && $value != "") ? $value : '' ?></textarea>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <hr>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo form_submit($submit_btn); ?>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<script type="text/javascript">
$(document).ready(function() {
    if ($(".editor").length > 0) {
        var config_date = <?php echo json_encode($config_date) ?>;
        $.each(config_date, function(key, value) {
            var editorElement = CKEDITOR.document.getById('editor_' + key);
            editorElement.setAttribute('contenteditable', 'true');
            CKEDITOR.replace('editor_' + key);
        });
    }
});
</script>