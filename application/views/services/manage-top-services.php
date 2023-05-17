<?php
if (count((array) $Services) > 0) {
    $ServicesList = array("" => "Select") + $Services;
    $Service1 = array('name' => 'service1', 'id' => 'service1', 'class' => "select2", "tabindex" => 1);
    $S1 = (isset($service_info) && $service_info->Service1 != "") ? $service_info->Service1 : set_value('service1');

    $Service2 = array('name' => 'service2', 'id' => 'service2', 'class' => "select2", "tabindex" => 2);
    $S2 = (isset($service_info) && $service_info->Service2 != "") ? $service_info->Service2 : set_value('service2');

    $Service3 = array('name' => 'service3', 'id' => 'service3', 'class' => "select2", "tabindex" => 3);
    $S3 = (isset($service_info) && $service_info->Service3 != "") ? $service_info->Service3 : set_value('service3');

    $Service4 = array('name' => 'service4', 'id' => 'service4', 'class' => "select2", "tabindex" => 4);
    $S4 = (isset($service_info) && $service_info->Service4 != "") ? $service_info->Service4 : set_value('service4');

    $Service5 = array('name' => 'service5', 'id' => 'service5', 'class' => "select2", "tabindex" => 5);
    $S5 = (isset($service_info) && $service_info->Service5 != "") ? $service_info->Service5 : set_value('service5');

    $Service6 = array('name' => 'service6', 'id' => 'service6', 'class' => "select2", "tabindex" => 6);
    $S6 = (isset($service_info) && $service_info->Service6 != "") ? $service_info->Service6 : set_value('service6');

    $Service7 = array('name' => 'service7', 'id' => 'service7', 'class' => "select2", "tabindex" => 7);
    $S7 = (isset($service_info) && $service_info->Service7 != "") ? $service_info->Service7 : set_value('service7');

    $Service8 = array('name' => 'service8', 'id' => 'service8', 'class' => "select2", "tabindex" => 8);
    $S8 = (isset($service_info) && $service_info->Service8 != "") ? $service_info->Service8 : set_value('service8');

    $Service9 = array('name' => 'service9', 'id' => 'service9', 'class' => "select2", "tabindex" => 9);
    $S9 = (isset($service_info) && $service_info->Service9 != "") ? $service_info->Service9 : set_value('service9');
}

$submit_btn = array('name' => 'submit_btn', 'id' => 'submit_btn', 'value' => 'SAVE', 'class' => 'btn btn-round l-blue');
$form_attr = array('class' => 'default_form top_service_frm', 'id' => 'top_service_frm', 'name' => 'top_service_frm');
?>
<section class="content home">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-4 col-sm-4">
                <h2><?php echo $page_title; ?>
                    <a href="javascript:void(0);"><img src="<?php echo ASSETS_PATH; ?>images/question.jpg"
                            data-toggle="tooltip" data-placement="right" title="You can manage Top Services." /></a>
                </h2>
            </div>
            <div class="col-lg-7 col-md-8 col-sm-8">

            </div>
        </div>
    </div>
    <div class="container-fluid">
        <?php echo form_open_multipart('services/submit_top_form', $form_attr); ?>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 ">
                <div class="card">
                    <div class="body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Service 1 </label>
                                    <?php echo form_dropdown($Service1, $ServicesList,$S1 ); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Service 2 </label>
                                    <?php echo form_dropdown($Service2, $ServicesList,$S2 ); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Service 3 </label>
                                    <?php echo form_dropdown($Service3, $ServicesList,$S3 ); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Service 4 </label>
                                    <?php echo form_dropdown($Service4, $ServicesList,$S4 ); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Service 5 </label>
                                    <?php echo form_dropdown($Service5, $ServicesList,$S5 ); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Service 6 </label>
                                    <?php echo form_dropdown($Service6, $ServicesList,$S6 ); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Service 7 </label>
                                    <?php echo form_dropdown($Service7, $ServicesList,$S7 ); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Service 8 </label>
                                    <?php echo form_dropdown($Service8, $ServicesList,$S8 ); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Service 9 </label>
                                    <?php echo form_dropdown($Service9, $ServicesList,$S9 ); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <footer id="sidebar-footer">
                        <div class="sidebar-footer">
                            <div class="side-footer-button">
                                <div class="form-group">
                                    <?php
echo form_submit($submit_btn);
?>
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</section>