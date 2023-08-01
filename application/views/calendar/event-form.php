<?php
if (isset($event_info) && $event_info->ID > 0) {
    $ID = array('name' => 'id', 'id' => 'id', 'value' => ($event_info->ID > 0) ? $event_info->ID : "", 'type' => 'hidden');
}

// $Date = array('name' => 'date', 'id' => 'date', 'value' => (isset($event_info) && $event_info->Date != "") ? $event_info->Date : set_value('date'), 'class' => "form-control");

$Date = array('name' => 'event_date', 'id' => 'event_date', 'value' => (isset($event_info) && $event_info->DateTime != "" && $event_info->DateTime != "0000-00-00") ? date('l d F Y - h:i A', strtotime($event_info->DateTime)) : set_value('event_date'), 'size' => 30, 'class' => "form-control event_date", 'placeholder' => "Please choose date & time...", "tabindex" => 1, 'style' => "cursor:pointer;");
$Title = array('name' => 'title', 'id' => 'title', 'value' => (isset($event_info) && $event_info->Title != "") ? $event_info->Title : set_value('title'), 'class' => "form-control", "tabindex" => 1, 'placeholder' => "Banner Title", "data-validation" => "required");
$Description = array('name' => 'description', 'id' => 'description', 'value' => (isset($event_info) && $event_info->Description != "") ? $event_info->Description : set_value('description'), 'class' => "form-control", "rows" => 6, "tabindex" => 2, "style" => "resize:none");

$S = array(
    "2" => "Inactive",
);
$Status = array('name' => 'status', 'id' => 'status', 'class' => "select2 ", "tabindex" => 4, "data-validation" => "required");
$StatusList = array("1" => "Active") + $S;
$StatusID = (isset($event_info) && $event_info->Status != "") ? $event_info->Status : set_value('status');

$submit_btn = array('name' => 'submit_btn', 'id' => 'submit_btn', 'value' => 'SAVE', 'class' => 'btn btn-round l-blue');
$cancel_btn = array('name' => 'cancel_btn', 'id' => 'cancel_btn', 'content' => 'CANCEL', 'class' => 'btn btn-round btn-white', "onclick" => "pop_up.close()");
$form_attr = array('class' => 'default_form event_frm', 'id' => 'event_frm', 'name' => 'event_frm');
?>
<?php echo form_open_multipart('calendar/submit_form', $form_attr); ?>
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
             if (isset($event_info) && $event_info->ID > 0) {
                echo form_input($ID);
            }
            
            ?>
            <div class="row">
                <div class="col-md-12 card">
                    <div class="header">
                        <h2><strong>Event</strong> Details </h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Event Date <span class="text-danger">*</span></label>
                                <?php echo form_input($Date); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Event Title <span class="text-danger">*</span></label>
                                <?php echo form_input($Title); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Event Description <span class="text-danger">*</span></label>
                                <?php echo form_textarea($Description); ?>
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

<script type="text/javascript">
$(document).ready(function() {
    if ($(".event_date").length > 0) {
        $('.event_date').bootstrapMaterialDatePicker({
            format: 'dddd DD MMMM YYYY - hh:mm A',
            twelvehour: true,
            clearButton: true,
            weekStart: 1,
            shortTime: true,
            minDate: new Date()
        });
    }
});
</script>