<?php
if (isset($us_info) && $us_info->ID > 0) {
    $ID = array('name' => 'id', 'id' => 'id', 'value' => ($us_info->ID > 0) ? $us_info->ID : "", 'type' => 'hidden');
}

$Service = array('name' => 'service_id', 'id' => 'service_id', 'class' => "select2", "tabindex" => 4, "data-validation" => "required");
$ServiceList = array("" => "Select Service") + $Services;
$ServiceID = (isset($us_info) && $us_info->ServiceID != "") ? $us_info->ServiceID : set_value('service_id');

$User = array('name' => 'user_id', 'id' => 'user_id', 'class' => "select2", "tabindex" => 4, "data-validation" => "required");
$UserList = array("" => "Select User") + $Users;
$UserID = (isset($us_info) && $us_info->UserID != "") ? $us_info->UserID : set_value('user_id');


$SS = array(
    "onhold" => "On hold",
    "completed" => "Completed"
);
$SStatus = array('name' => 'service_status', 'id' => 'service_status', 'class' => "select2 ", "tabindex" => 4, "data-validation" => "required");
$SStatusList = array("ongoing" => "Ongoing") + $SS;
$SStatusID = (isset($us_info) && $us_info->ServiceStatus != "") ? $us_info->ServiceStatus : $type;


$submit_btn = array('name' => 'submit_btn', 'id' => 'submit_btn', 'value' => 'SAVE', 'class' => 'btn btn-round l-blue');
$cancel_btn = array('name' => 'cancel_btn', 'id' => 'cancel_btn', 'content' => 'CANCEL', 'class' => 'btn btn-round btn-white', "onclick" => "pop_up.close()");
$form_attr = array('class' => 'default_form assign_services_frm', 'id' => 'assign_services_frm', 'name' => 'assign_services_frm', 'type' => $type);
?>
<?php echo form_open_multipart('user_services/submit_form', $form_attr); ?>
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
             if (isset($us_info) && $us_info->ID > 0) {
                echo form_input($ID);
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
                                <label class="form-label">Service Status <span class="text-danger">*</span></label>
                                <?php echo form_dropdown($SStatus, $SStatusList, $SStatusID); ?>
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