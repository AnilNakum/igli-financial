<?php
$form_attr = array('class' => 'default_form', 'id' => 'setting_frm', 'name' => 'setting_frm');
$submit_btn = array('name' => 'submit_btn', 'id' => 'submit_btn', 'value' => "SAVE", 'class' => 'btn btn-round btn-md l-cyan');
?>
<section class="content" id="main-wrapper">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <h2><?php echo $page_title; ?>
                    <small><?php echo $page_title; ?></small>
                    <a href="javascript:void(0);"><img src="<?php echo ASSETS_PATH; ?>images/question.jpg"
                            data-toggle="tooltip" data-placement="right"
                            title="You can see and change site settings." /></a>
                </h2>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
            </div>
        </div>
    </div>
    <?php echo add_edit_form(); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Setting</strong> Details </h2>
                    </div>
                    <div class="body">
                        <?php echo form_open_multipart(base_url('setting/submit_form'), $form_attr); ?>
                        <div class="row">
                            <?php foreach ($config_date as $key => $value) { ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b><?php echo lang($key); ?></b> <span class="text-danger">*</span></label>
                                    <?php
                                        if ($key == "favicon" || $key == "logo") {
                                            echo form_upload(array('name' => $key, "onchange" => "loadFile(event)", "accept" => "", 'id' => $key, 'value' => set_value($key, $value), 'class' => "form-control"));
                                        } else if ($key == "ssl_support" || $key == "sms_enable" || $key == "notification_enable") {
                                            $checked = ($value == 1) ? array('checked' => true) : array();
                                            echo '<div class="checkbox check-default">';
                                            echo form_checkbox(array('name' => $key, 'id' => $key, 'value' => 1) + $checked);
                                            echo '<label for="' . $key . '">' . lang($key) . '</label>';
                                            echo '</div>';
                                        } else {
                                            $input = ($key == 'primary_color' || $key == 'secondary_color') ? 'color' : 'text';
                                            echo form_input(array('name' => $key, 'id' => $key, 'value' => set_value($key, $value, false), 'class' => "form-control", 'type' => $input));
                                        }
                                        ?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <hr>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo form_submit($submit_btn); ?>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>