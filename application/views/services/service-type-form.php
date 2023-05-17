<?php
if (isset($services_type_info) && $services_type_info->STID > 0) {
    $STID = array('name' => 'services_type_id', 'id' => 'services_type_id', 'value' => ($services_type_info->STID > 0) ? $services_type_info->STID : "", 'type' => 'hidden');
}

$Name = array('name' => 'services_type_name', 'id' => 'services_type_name', 'value' => (isset($services_type_info) && $services_type_info->Name != "") ? $services_type_info->Name : set_value('services_type_name'), 'class' => "form-control", "tabindex" => 1, 'placeholder' => "Service Type", "data-validation" => "required");
$Order = array('name' => 'order', 'id' => 'order', 'value' => (isset($services_type_info) && $services_type_info->Order != "") ? $services_type_info->Order : set_value('order'), 'class' => "form-control", "tabindex" => 1, 'placeholder' => "Service Type Order", "data-validation" => "required");


$S = array(
    "2" => "Inactive",
);
$Status = array('name' => 'status', 'id' => 'status', 'class' => "select2 ", "tabindex" => 4, "data-validation" => "required");
$StatusList = array("1" => "Active") + $S;
$StatusID = (isset($services_type_info) && $services_type_info->Status != "") ? $services_type_info->Status : set_value('status');

$submit_btn = array('name' => 'submit_btn', 'id' => 'submit_btn', 'value' => 'SAVE', 'class' => 'btn btn-round l-blue');
$cancel_btn = array('name' => 'cancel_btn', 'id' => 'cancel_btn', 'content' => 'CANCEL', 'class' => 'btn btn-round btn-white', "onclick" => "pop_up.close()");
$form_attr = array('class' => 'default_form services_type_frm', 'id' => 'services_type_frm', 'name' => 'services_type_frm');
?>
<?php echo form_open_multipart('services/submit_type_form', $form_attr); ?>
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
             if (isset($services_type_info) && $services_type_info->STID > 0) {
                echo form_input($STID);
            }
            ?>
            <div class="row">
                <div class="col-md-12 card">
                    <div class="header">
                        <h2><strong>Service Type</strong> Details </h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <?php echo form_input($Name); ?>
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
                                <label class="form-label">Order </label>
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