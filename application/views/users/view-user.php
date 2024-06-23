<?php
$cancel_btn = array('name' => 'cancel_btn', 'id' => 'cancel_btn', 'content' => 'CANCEL', 'class' => 'btn btn-round btn-white', "onclick" => "pop_up.close()");
?>
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
            ?>
            <div class="row">
                <div class="col-md-12 card">

                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label class="form-label"><b> Username :</b> <?php echo $user_info->username; ?></label>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><b> Full Name :</b> <?php echo $user_info->name; ?></label>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><b> Email :</b> <?php echo $user_info->phone; ?></label>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><b> Phone No :</b> <?php echo $user_info->phone; ?></label>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><b> Date Of Birth :</b> <?php echo $user_info->dob; ?></label>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><b> Compnay Name :</b> <?php echo $user_info->compnay_name; ?></label>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="form-label">Profile Image</label>
                                <?php 
                                $Img = IMAGE_DIR . $user_info->profile_image_name;
                                if (!@getimagesize($Img)) {
                                    $Img = NO_PROFILE;
                                }?>
                                <img src="<?php echo $Img;?>" alt="" width="150px" height="180px">
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
echo form_button($cancel_btn);
?>
                </div>
            </div>
        </div>
    </footer>
</div>
