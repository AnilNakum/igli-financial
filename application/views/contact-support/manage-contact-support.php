<?php
if (count((array) $ContactSupport) > 0) {
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
                            data-toggle="tooltip" data-placement="right" title="You can manage Contact Support." /></a>
                </h2>
            </div>
            <div class="col-lg-7 col-md-8 col-sm-8">

            </div>
        </div>
    </div>
    <?php echo add_edit_form(); ?>
    <?php echo half_popup(); ?>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <?php if (count((array) $ContactSupport) == 0) {?>
                    <div class="body text-center manage-list">
                        <div class="institute-box">
                            <img src="<?php echo ASSETS_PATH; ?>images/finder.png">
                            <h3>No records for Contact Support right now.</h3>
                        </div>
                    </div>
                    <?php } else {?>
                    <div class="body">
                        <div class="setup-table-block">
                            <div class="setup-header">
                                <div class="row">
                                    <div class="col-md-3 col-sm-3">
                                        <div class="form-group">
                                            <?php echo form_dropdown($Status, $StatusList); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-2"></div>
                                    <div class="col-md-7 col-sm-7">
                                        <div class="manage-rightside">
                                            <div class="form-group">
                                                <div class="manage-searchbar">
                                                    <span class="glyphicon glyphicon-search form-control-feedback">
                                                    </span>
                                                    <input class="form-control" id="search" placeholder="Search "
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
                                        <table class="table table-hover common_datatable" data-control="contact_support"
                                            data-method="manage">
                                            <thead>
                                                <tr>
                                                    <th>User Name</th>
                                                    <th>Query</th>
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