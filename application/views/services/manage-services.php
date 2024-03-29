<?php
if (count((array) $Services) > 0) {
    $ServiceType = array('name' => 'type', 'id' => 'type_filter', 'class' => "select2 TypeFilter", "tabindex" => 4);
    $ServiceTypesList = array("" => "All") + $ServiceTypes;

    $Status = array('name' => 'status', 'id' => 'status_filter', 'class' => "select2 StatusFilter", "tabindex" => 4);
    $S = array("1" => "Active", "2" => "Inactive");
    $StatusList = array("" => "All") + $S;
}
?>
<section class="content home">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-4 col-sm-4">
                <h2><?php echo $page_title; ?>
                    <a href="javascript:void(0);"><img src="<?php echo ASSETS_PATH; ?>images/question.jpg"
                            data-toggle="tooltip" data-placement="right"
                            title="You can manage & add/update Services." /></a>
                </h2>
            </div>
            <div class="col-lg-7 col-md-8 col-sm-8">
            <?php if(ROLE == 1){?>
                <a href="javascript:void(0);" class="btn btn-round l-blue pull-right open_my_form" data-form_type="full"
                    data-control="services" data-method="add">Add New Service</a>
                    <?php } ?>
            </div>
        </div>
    </div>
    <?php echo add_edit_form(); ?>
    <?php echo full_popup(); ?>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <?php if (count((array) $Services) == 0) {?>
                    <div class="body text-center manage-list">
                        <div class="institute-box">
                            <img src="<?php echo ASSETS_PATH; ?>images/finder.png">
                            <h3>No records for Service right now <br /> Please add new</h3>
                            <a href="javascript:void(0);" class="open_my_form" data-form_type="full"
                                data-control="services" data-method="add"><img class="add-btn"
                                    src="<?php echo ASSETS_PATH; ?>images/btn.png"></a>
                        </div>
                    </div>
                    <?php } else {?>
                    <div class="body">
                        <div class="setup-table-block">
                            <div class="setup-header">
                                <div class="row">
                                    <div class="col-md-3 col-sm-3">
                                        <div class="form-group">
                                            <?php echo form_dropdown($ServiceType, $ServiceTypesList); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3">
                                        <div class="form-group">
                                            <?php echo form_dropdown($Status, $StatusList); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="manage-rightside">
                                            <div class="form-group">
                                                <div class="manage-searchbar">
                                                    <span class="glyphicon glyphicon-search form-control-feedback">
                                                    </span>
                                                    <input class="form-control" id="search" placeholder="Search Service"
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
                                        <table class="table table-hover common_datatable" data-control="services"
                                            data-method="manage">
                                            <thead>
                                                <tr>
                                                    <th>Logo</th>
                                                    <th>Service Type</th>
                                                    <th>Service Name</th>
                                                    <th>Status</th>
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