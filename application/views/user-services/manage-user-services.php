<?php
if($type == 'ongoing'){ 
    $PS = array(
        "On Going" => "On Going",
        "Pending With IGLI FINANCIAL" => "Pending With IGLI FINANCIAL",
        "Pending with Government" => "Pending with Government",
        "Pending With Client" => "Pending With Client"
    );
    $PStatus = array('name' => 'progress_status', 'id' => 'progress_status_filter', 'class' => "select2 ProgressStatusFilter", "tabindex" => 4, "data-validation" => "required");
    $PStatusList = array("" => "All") + $PS;
 }
?>
<section class="content home">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-4 col-sm-4">
                <h2><?php echo $page_title; ?>
                    <a href="javascript:void(0);"><img src="<?php echo ASSETS_PATH; ?>images/question.jpg"
                            data-toggle="tooltip" data-placement="right"
                            title="You can manage User Services." /></a>
                </h2>
            </div>
            <div class="col-lg-7 col-md-8 col-sm-8">
            <?php if(ROLE == 1){?>
                <a href="javascript:void(0);" class="btn btn-round l-blue pull-right open_my_form" data-control="user_services"
                    data-method="add/<?php echo $type;?>">Assign New Service</a>
                    <?php } ?>
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
                            <h3>No records right now  </h3><br />
                            <?php if(ROLE == 1){?>
                                <h3>Please add new</h3>
                            <a href="javascript:void(0);" class="open_my_form" data-control="user_services"
                                data-method="add"><img class="add-btn"
                                    src="<?php echo ASSETS_PATH; ?>images/btn.png"></a>
                                    <?php } ?>
                        </div>
                    </div>
                    <?php } else {?>
                    <div class="body">
                        <div class="setup-table-block">
                            <div class="setup-header">
                                <div class="row">
                                    
                                <div class="col-md-3 col-sm-3">
                                    <?php if($type == 'ongoing'){ ?>
                                        <div class="form-group">
                                        <label class="form-label">Service Progress Status</label>
                                            <?php echo form_dropdown($PStatus, $PStatusList); ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-3 col-sm-3"></div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="manage-rightside">
                                            <div class="form-group">
                                                <div class="manage-searchbar">
                                                    <span class="glyphicon glyphicon-search form-control-feedback">
                                                    </span>
                                                    <input class="form-control" id="search" placeholder="Search Services"
                                                        type="search">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="setup-content">
                                <div class="manage-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover common_datatable" data-control="user_services"
                                            data-method="manage" data-id="<?php echo $type;?>">
                                            <thead>
                                                <tr>
                                                    <th>Service</th>
                                                    <th>User</th>
                                                    <th width="20%">Sub Users/Partners</th>
                                                    <?php if($type == 'ongoing'){ ?><th>Progress Status</th><?php } ?>
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