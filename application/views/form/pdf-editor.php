<?php 
if (isset($form_info) && $form_info->FID > 0) {
    $FID = array('name' => 'form_id', 'id' => 'form_id', 'value' => ($form_info->FID > 0) ? $form_info->FID : "", 'type' => 'hidden');
    $FormFiled = json_decode($form_info->FormData);
}
$S = array(
    "2" => "Inactive",
);
$Status = array('name' => 'status', 'id' => 'statuss', 'class' => "select2 ", "data-validation" => "required");
$StatusList = array("1" => "Active") + $S;

$StatusID = (isset($form_info) && $form_info->Status != "") ? $form_info->Status : set_value('status');

$submit_btn = array('name' => 'submit_btn', 'id' => 'submit_btn', 'value' => 'SAVE', 'class' => 'btn btn-round l-blue');
$form_attr = array('class' => 'default_form pdf_frm', 'id' => 'pdf_frm', 'name' => 'pdf_frm');
?>
<?php echo form_open_multipart('form/submit_pdf_form', $form_attr); ?>
<section class="content home">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2><?php echo $page_title; ?>
                    <a href="javascript:void(0);"><img src="<?php echo ASSETS_PATH; ?>images/question.jpg"
                            data-toggle="tooltip" data-placement="right" title="You can manage PDF View." /></a>
                </h2>
            </div>
            <div class="sidebar-header-content">
                <a href="<?php echo base_url('form'); ?>"><i class="fa fa-times"></i></a>
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
                <div class="col-md-12 p-2">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label text-info">Use Following KeyWords For Replace With Real Data.</label>
                                <table class="table keyword-table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">KeyWord</th>
                                            <th scope="col">Use For</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($FormFiled as $key => $value) { 
                                            if($value->type != 'header' && $value->type != 'paragraph'){ ?>                                                
                                            <tr>
                                                <th scope="row"><?php echo $key;?></th>
                                                <td><?php echo '<b>{'.$value->name.'}</b>';?></td>
                                                <td><?php echo $value->label;?></td>
                                            </tr>
                                        <?php } } ?>                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">PDF Editor <span class="text-danger">*</span></label>
                                <textarea
                                    id="pdf_editor"><?php echo (isset($form_info) && $form_info->PdfView != "") ? $form_info->PdfView : '' ?></textarea>
                                <input type="hidden" id="PdfView" name="PdfView"
                                    value='<?php echo (isset($form_info) && $form_info->PdfView != "") ? $form_info->PdfView : '' ?>'>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Status <span class="text-danger">*</span></label>                                                                           
                                <?php 
                                    echo form_dropdown($Status, $StatusList, $StatusID); 
                                    ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <footer id="sidebar-footer">
            <div class="sidebar-footer ">
                <div class="side-footer-button">
                    <div class="form-group">
                        <?php echo form_submit($submit_btn);?>
                        <a href="<?php echo base_url('form-builder'); ?>" class="btn btn-round btn-white">CANCEL</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</section>
<?php echo form_close(); ?>
<script>
$(document).ready(function() {
    if ($("#pdf_editor").length > 0) {
        var editorElement = CKEDITOR.document.getById('pdf_editor');
        editorElement.setAttribute('contenteditable', 'true');
        CKEDITOR.replace('pdf_editor', {
            height: 400
        });
    }

    CKEDITOR.instances.pdf_editor.on('change', function() {
        var CKdata = CKEDITOR.instances.pdf_editor.getData();
        $('#PdfView').val(CKdata);
    });
});
</script>