<?php
if (isset($task_info) && $task_info->ID > 0) {
    $ID = array('name' => 'id', 'id' => 'id', 'value' => ($task_info->ID > 0) ? $task_info->ID : "", 'type' => 'hidden');
    $Services_info = $task_info->Services;
}

$S = array(
    "inprogress" => "In Progress",
    "onhold" => "On hold",
    "completed" => "Completed"
);
$Status = array('name' => 'task_status', 'id' => 'task_status', 'class' => "select2 ", "tabindex" => 4, "data-validation" => "required");
$StatusList = array("pending" => "Pending") + $S;
$StatusID = (isset($task_info) && $task_info->Status != "") ? $task_info->Status : set_value('status');

$submit_btn = array('name' => 'submit_btn', 'id' => 'submit_btn', 'value' => 'SAVE', 'class' => 'btn btn-round l-blue');
$cancel_btn = array('name' => 'cancel_btn', 'id' => 'cancel_btn', 'content' => 'CLOSE', 'class' => 'btn btn-round btn-white', "onclick" => "pop_up.close()");
$form_attr = array('class' => 'default_form task_frm', 'id' => 'task_frm', 'name' => 'task_frm');
?>
<?php echo form_open_multipart('task/submit_form', $form_attr); ?>
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
             if (isset($task_info) && $task_info->ID > 0) {
                echo form_input($ID);
            }
            ?>
            <div class="row">
                <div class="col-md-12 card">
                <div class="header">
                        <h2><strong>Task</strong> Details </h2>
                        <hr>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><b> Task Name :</b> <?php echo $task_info->TaskName .' ('. $Services_info->SID .')'; ?></label>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><b> Reason :</b> <?php echo $task_info->Reason; ?></label>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><b> Description :</b> <?php echo $task_info->Description; ?></label>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><b> Assign Date :</b>
                            <?php echo date('l d F Y', strtotime($task_info->CreatedAt)); ?></label>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><b> Status :</b>
                            <?php echo GetTaskStatus($task_info->Status); ?></label>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Update Status <span class="text-danger">*</span></label>
                                <?php echo form_dropdown($Status, $StatusList, $StatusID); ?>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="header">
                        <h2><strong>User Service</strong> Details </h2>
                        <hr>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><b> Compnay Name :</b> <?php echo $Services_info->CompnayName; ?></label>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><b> Service Name :</b> <?php echo $Services_info->ServiceTitle; ?></label>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><b> User Name :</b> <?php echo $Services_info->name; ?></label>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><b> Partners Name :</b> <?php echo PartnersName($Services_info->PartnersID); ?></label>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><b> Progress Status :</b> <?php echo GetProgressStatus($Services_info->ProgressStatus); ?></label>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><b> Service Status :</b> <?php echo ServiceStatus($Services_info->ServiceStatus); ?></label>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><b> Reason Note :</b> <?php echo $Services_info->Reason; ?></label>
                    </div>
                    <!-- <?php pr($task_info->Services);?> -->

                    
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