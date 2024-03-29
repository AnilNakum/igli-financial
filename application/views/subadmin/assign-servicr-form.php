<?php
if (isset($user_info) && $user_info->id > 0) {
    $id = array('name' => 'user_id', 'id' => 'user_id', 'value' => ($user_info->id > 0) ? $user_info->id : "", 'type' => 'hidden');
}

$Service = array('name' => 'service_id', 'id' => 'service_id', 'class' => "select2", "tabindex" => 4, "data-validation" => "required");
$ServiceList = array("" => "Select Service") + $Services;

$User = array('name' => 'service_user_id', 'id' => 'service_user_id', 'class' => "select2", "tabindex" => 4, "data-validation" => "required");
$UserList = array("" => "Select User") + $Users;

$Partner = array('name' => 'partner[]', 'id' => 'partner', 'class' => "select2",'multiple'=>"multiple", "tabindex" => 4);
$PartnersList = $Users;



$S = array(
    "2" => "Inactive",
);
$Status = array('name' => 'status', 'id' => 'status', 'class' => "select2 ", "tabindex" => 4, "data-validation" => "required");
$StatusList = array("1" => "Active") + $S;
$StatusID = set_value('status');

$submit_btn = array('name' => 'submit_btn', 'id' => 'submit_btn', 'value' => 'SAVE', 'class' => 'btn btn-round l-blue');
$cancel_btn = array('name' => 'cancel_btn', 'id' => 'cancel_btn', 'content' => 'CANCEL', 'class' => 'btn btn-round btn-white', "onclick" => "pop_up.close()");
$form_attr = array('class' => 'default_form assign_frm', 'id' => 'assign_frm', 'name' => 'assign_frm');
?>
<?php echo form_open_multipart('subadmin/assign_form', $form_attr); ?>
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
             if (isset($user_info) && $user_info->id > 0) {
                echo form_input($id);
            }
            ?>
            <div class="row">
                <div class="col-md-12 card">
                    <div class="header">
                        <h2><strong>Sub Admin </strong> Details </h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label"><b> Name :</b>
                                    <?php echo $user_info->first_name .' '.$user_info->last_name .'( '.$user_info->username.' )'; ?></label>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><b> Email :</b> <?php echo $user_info->email; ?></label>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><b> Phone :</b> <?php echo $user_info->phone; ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Service <span class="text-danger">*</span></label>
                                <?php echo form_dropdown($Service, $ServiceList); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">User <span class="text-danger">*</span></label>
                                <?php echo form_dropdown($User, $UserList); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Sub Users / Partners  <span class="text-info">Optional</span></label>
                                <?php echo form_dropdown($Partner, $PartnersList); ?>
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