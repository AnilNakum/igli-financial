<?php
if (isset($payment_info) && $payment_info->PID > 0) {
    $PID = array('name' => 'payment_id', 'id' => 'payment_id', 'value' => ($payment_info->PID > 0) ? $payment_info->PID : "", 'type' => 'hidden');
}

$Service = array('name' => 'service_id', 'id' => 'service_id', 'class' => "select2", "tabindex" => 4, "data-validation" => "required");
$ServiceList = array("" => "Select Service") + $Services;
$ServiceID = (isset($payment_info) && $payment_info->ServiceID != "") ? $payment_info->ServiceID : set_value('service_id');

$User = array('name' => 'user_id[]', 'id' => 'user_id', 'class' => "select2", 'multiple'=>"multiple", "tabindex" => 4, "data-validation" => "required");
$UserList =  $Users;
$UserID = (isset($payment_info) && $payment_info->UserID != "") ? explode(",",$payment_info->UserID) : set_value('user_id');


$DueAmount = array('name' => 'due_amount', 'id' => 'due_amount', 'value' => (isset($payment_info) && $payment_info->DueAmount != "") ? $payment_info->DueAmount : set_value('due_amount'), 'class' => "form-control", "tabindex" => 1, 'placeholder' => "Enter Due Amount", "data-validation" => "required");

$PS = array(
    "completed" => "Completed"
);
$PStatus = array('name' => 'payment_status', 'id' => 'payment_status', 'class' => "select2 ", "tabindex" => 4, "data-validation" => "required");
$PStatusList = array("pending" => "Pending") + $PS;
$PStatusID = (isset($payment_info) && $payment_info->PaymentStatus != "") ? $payment_info->PaymentStatus : set_value('payment_status');

$S = array( 
    "onhold" => "On hold",
        "completed" => "Completed"
);
$Status = array('name' => 'status', 'id' => 'status', 'class' => "select2 ", "tabindex" => 4, "data-validation" => "required");
$StatusList = array("ongoing" => "On Going") + $S;
$StatusID = (isset($payment_info) && $payment_info->Status != "") ? $payment_info->Status : set_value('status');

$submit_btn = array('name' => 'submit_btn', 'id' => 'submit_btn', 'value' => 'SAVE', 'class' => 'btn btn-round l-blue');
$cancel_btn = array('name' => 'cancel_btn', 'id' => 'cancel_btn', 'content' => 'CANCEL', 'class' => 'btn btn-round btn-white', "onclick" => "pop_up.close()");
$form_attr = array('class' => 'default_form payment_frm', 'id' => 'payment_frm', 'name' => 'payment_frm');
?>
<?php echo form_open_multipart('payment/submit_form', $form_attr); ?>
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
             if (isset($payment_info) && $payment_info->PID > 0) {
                echo form_input($PID);
            }
            
            ?>
            <div class="row">
                <div class="col-md-12 card">


                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Service <span class="text-danger">*</span></label>
                                <?php echo form_dropdown($Service, $ServiceList, $ServiceID); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">User <span class="text-danger">*</span></label>
                                <?php echo form_dropdown($User, $UserList, $UserID); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Due Amount <span class="text-danger">*</span></label>
                                <?php echo form_input($DueAmount); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Payment Status <span class="text-danger">*</span></label>
                                <?php echo form_dropdown($PStatus, $PStatusList, $PStatusID); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Service Status <span class="text-danger">*</span></label>
                                <?php echo form_dropdown($Status, $StatusList, $StatusID); ?>
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