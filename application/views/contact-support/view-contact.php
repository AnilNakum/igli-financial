<?php
$cancel_btn = array('name' => 'cancel_btn', 'id' => 'cancel_btn', 'content' => 'CLOSE', 'class' => 'btn btn-round btn-white', "onclick" => "pop_up.half_close()");
?>
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