<?php

$User = array('name' => 'user_id', 'id' => 'user_id_filter', 'class' => "select2 UserFilter", "tabindex" => 4);
$UserList = array("" => "Select User") + $Users;
$UserID = (isset($id) && $id != 1) ? $id : '';

$S = array(
    "ongoing" => "On going",
    "onhold" => "On hold",
    "completed" => "Completed"
);
$Status = array('name' => 'service_status', 'id' => 'service_status_filter', 'class' => "select2 ServieStatusFilter", "tabindex" => 4);
$StatusList = array("" => "All") + $S;

?>
<section class="content home">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-4 col-sm-4">
                <h2><?php echo $page_title; ?>
                    <a href="javascript:void(0);"><img src="<?php echo ASSETS_PATH; ?>images/question.jpg"
                            data-toggle="tooltip" data-placement="right" title="You can manage User Services." /></a>
                </h2>
            </div>
            <div class="col-lg-7 col-md-8 col-sm-8">

            </div>
        </div>
    </div>
    <?php echo add_edit_form(); ?>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
            
                <div class="card">
                    <?php if (count((array) $Services) == 0) {?>
                    <div class="body text-center manage-list">
                        <div class="institute-box">
                            <img src="<?php echo ASSETS_PATH; ?>images/finder.png">
                            <h3>No user services assigned right now </h3><br />
                        </div>
                    </div>
                    <?php } else {?>
                    <div class="body">
                        <div class="setup-table-block">
                            <div class="setup-header">
                                <div class="row">
                                    <div class="col-md-3 col-sm-3">
                                        <div class="form-group">
                                        <label class="form-label">Sub Admin </label>
                                            <?php echo form_dropdown($User, $UserList, $UserID); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3">
                                        <div class="form-group">
                                            <label class="form-label">Service Status </label>
                                            <?php echo form_dropdown($Status, $StatusList); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="manage-rightside">
                                            <div class="form-group">
                                                <div class="manage-searchbar">
                                                    <span class="glyphicon glyphicon-search form-control-feedback">
                                                    </span>
                                                    <input class="form-control" id="search"
                                                        placeholder="Search Services" type="search">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="setup-content">
                                <div class="manage-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover common_datatable" data-control="subadmin"
                                            data-method="manage_user_service" data-id="<?php echo $id;?>">
                                            <thead>
                                                <tr>
                                                    <th>Service</th>
                                                    <th>User</th>
                                                    <th width="20%">Sub Users/Partners</th>
                                                    <th>Status</th>
                                                    <th>RM Name</th>
                                                    <th>Created At</th>
                                                    <th class="no-sort text-center">Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</section>