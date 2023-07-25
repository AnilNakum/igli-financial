<?php
if (isset($support_info) && $support_info->ID > 0) {
    $ID = array('name' => 'id', 'id' => 'id', 'value' => ($support_info->ID > 0) ? $support_info->ID : "", 'type' => 'hidden');
}

$Replay = array('name' => 'replay', 'id' => 'replay', 'value' => (isset($support_info) && $support_info->Replay != "") ? $support_info->Replay : set_value('replay'), 'class' => "form-control", "rows" => 6, "tabindex" => 2, "style" => "resize:none");
$S = array(
    "2" => "Mark as Viewed",
    "3" => "Mark as Colsed",
);
$Status = array('name' => 'status', 'id' => 'status', 'class' => "select2 ", "tabindex" => 4, "data-validation" => "required");
$StatusList = array("1" => "Waiting For Responce") + $S;
$StatusID = (isset($support_info) && $support_info->Status != "") ? $support_info->Status : set_value('status');

$submit_btn = array('name' => 'submit_btn', 'id' => 'submit_btn', 'value' => 'SAVE', 'class' => 'btn btn-round l-blue');
$cancel_btn = array('name' => 'cancel_btn', 'id' => 'cancel_btn', 'content' => 'CLOSE', 'class' => 'btn btn-round btn-white', "onclick" => "pop_up.half_close()");
$form_attr = array('class' => 'default_form contact_frm', 'id' => 'contact_frm', 'name' => 'contact_frm');
?>
<?php echo form_open_multipart('contact_support/submit_form', $form_attr); ?>
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
             if (isset($support_info) && $support_info->ID > 0) {
                echo form_input($ID);
            }
            ?>
            <div class="row">
                <div class="col-md-12">

                    <div class="form-group">
                        <label class="form-label"><b> Subject :</b> <?php echo $support_info->Subject; ?></label>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><b> Message :</b> <?php echo $support_info->Message; ?></label>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><b> Status :</b>
                            <?php echo ContactStatus($support_info->Status); ?></label>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><b> Request Date :</b>
                            <?php echo date('l d F Y', strtotime($support_info->CreatedAt)); ?></label>
                    </div>
                    <?php if($support_info->Status == 2){?>
                    <div class="form-group">
                        <label class="form-label"><b> Viewed Date :</b>
                            <?php echo date('l d F Y', strtotime($support_info->UpdatedAt)); ?></label>
                    </div>
                    <?php } else if($support_info->Status == 3 && $support_info->Replay != ''){?>
                    <div class="form-group">
                        <label class="form-label"><b> Replay :</b> <i><?php echo $support_info->Replay; ?></i></label>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><b> Replay Date :</b>
                            <?php echo date('l d F Y', strtotime($support_info->UpdatedAt)); ?></label>
                    </div>
                    <?php } else {?>
                    <div class="row">
                        <div class="col-md-12 card">
                            <div class="header">
                                <h2><strong>Contact Support</strong> Details </h2>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Replay To User</label>
                                        <?php echo form_textarea($Replay); ?>
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
                        </div>
                    </div>
                    <?php } ?>

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