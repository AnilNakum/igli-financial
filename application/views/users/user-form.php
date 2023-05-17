<?php
if (isset($user_info) && $user_info->id > 0) {
    $id = array('name' => 'user_id', 'id' => 'user_id', 'value' => ($user_info->id > 0) ? $user_info->id : "", 'type' => 'hidden');
    $p1 = array('name' => 'password', 'id' => 'password', 'value' => "111", 'type' => 'hidden');
    $p2 = array('name' => 're_password', 'id' => 're_password', 'value' => "111", 'type' => 'hidden');
}

$Username = array('name' => 'username', 'id' => 'username', 'value' => (isset($user_info) && $user_info->username != "") ? $user_info->username : $Username, 'class' => "form-control", "tabindex" => 1, 'placeholder' => "Username", "data-validation" => "required", 'readonly'=>'true');
$FirstName = array('name' => 'first_name', 'id' => 'first_name', 'value' => (isset($user_info) && $user_info->first_name != "") ? $user_info->first_name : set_value('first_name'), 'class' => "form-control", "tabindex" => 1, 'placeholder' => "Enter First Name", "data-validation" => "required");
$LastName = array('name' => 'last_name', 'id' => 'last_name', 'value' => (isset($user_info) && $user_info->last_name != "") ? $user_info->last_name : set_value('last_name'), 'class' => "form-control", "tabindex" => 1, 'placeholder' => "Enter Last Name", "data-validation" => "required");
$Email = array('name' => 'email', 'id' => 'email', 'value' => (isset($user_info) && $user_info->email != "") ? $user_info->email : set_value('email'), 'class' => "form-control", "tabindex" => 1, 'placeholder' => "Enter Email", "data-validation" => "required");
$Phone = array('name' => 'phone', 'id' => 'phone', 'value' => (isset($user_info) && $user_info->phone != "") ? $user_info->phone : set_value('phone'), 'class' => "form-control", "tabindex" => 1, 'placeholder' => "Enter Phone No", "data-validation" => "required");
$Password = array('name' => 'password', 'id' => 'password', 'value' =>  "" , 'class' => "form-control", "tabindex" => 1, 'placeholder' => "Enter Password", "data-validation" => "required");
$RePassword = array('name' => 're_password', 'id' => 're_password', 'value' => "" , 'class' => "form-control", "tabindex" => 1, 'placeholder' => "Enter Confirm Password", "data-validation" => "required");

$OldImage = array('name' => 'old_image', 'id' => 'old_image', 'value' => (isset($user_info) && $user_info->profile_image_name != "") ? $user_info->profile_image_name : '', 'type' => "hidden",);

$S = array(
    "2" => "Inactive",
);

$Status = array('name' => 'activated', 'id' => 'activated', 'class' => "select2 ", "tabindex" => 4, "data-validation" => "required");
$StatusList = array("1" => "Active") + $S;
$StatusID = (isset($user_info) && $user_info->activated != "") ? $user_info->activated : set_value('activated');

$submit_btn = array('name' => 'submit_btn', 'id' => 'submit_btn', 'value' => 'SAVE', 'class' => 'btn btn-round l-blue');
$cancel_btn = array('name' => 'cancel_btn', 'id' => 'cancel_btn', 'content' => 'CANCEL', 'class' => 'btn btn-round btn-white', "onclick" => "pop_up.half_close()");
$form_attr = array('class' => 'default_form user_frm', 'id' => 'user_frm', 'name' => 'user_frm');
?>
<?php echo form_open_multipart('user/submit_form', $form_attr); ?>
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
             if (isset($user_info) && $user_info->id > 0) {
                echo form_input($id);
                echo form_input($p1);
                echo form_input($p2);
            }
            if (isset($user_info) && $user_info->profile_image_name != '') {
                echo form_input($OldImage);
            }
            ?>
            <div class="row">
                <div class="col-md-12 card">

                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label class="form-label">Username <span class="text-danger">*</span></label>
                                <?php echo form_input($Username); ?>
                            </div>

                            <div class="form-group">
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <?php echo form_input($FirstName); ?>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                <?php echo form_input($LastName); ?>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <?php echo form_input($Email); ?>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Phone No<span class="text-danger">*</span></label>
                                <?php echo form_input($Phone); ?>
                            </div>
                            <?php if (!isset($user_info)) {?>
                            <div class="form-group">
                                <label class="form-label">Password<span class="text-danger">*</span></label>
                                <?php echo form_input($Password); ?>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Confirm Password<span class="text-danger">*</span></label>
                                <?php echo form_input($RePassword); ?>
                            </div>
                            <?php } ?>
                            <div class="form-group">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <?php echo form_dropdown($Status, $StatusList, $StatusID); ?>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="form-label">Profile Image</label>
                                <div class="file-loading">
                                    <input id="file" type="file" name="image" class="file form-control"
                                        data-upload-url="#" data-browse-on-zone-click="true"
                                        data-overwrite-initial="true" data-theme="fas">
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
        allowedFileExtensions: ['jpg', 'png', 'jpeg', 'webp'],
        maxFileSize: 1000,
        autoReplace: false,
        overwriteInitial: true,
        initialPreviewAsData: true,
        initialPreview: [
            <?php if (isset($user_info)) {
    echo "'" . IMAGE_DIR . $user_info->profile_image_name."'" ;
}?>
        ],
        slugCallback: function(filename) {
            return filename.replace('(', '_').replace(']',
                '_');
        }
    });
});
</script>