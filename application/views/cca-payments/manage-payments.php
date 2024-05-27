<?php
if (count((array) $Payments) > 0) {
    $PStatus = array('name' => 'payment_status', 'id' => 'payment_status_filter', 'class' => "select2 PaymentStatusFilter", "tabindex" => 4);
    $PS = array(
        "Pending" => "Pending",
        "Invalid"=>"Invalid",
        "Timeout"=>"Timeout",
        "Awaited"=>"Awaited",
        "Aborted"=>"Aborted",
        "Failure"=>"Failure",
        "Success" => "Success");
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
                            title="You can manage Ccavanue Payments." /></a>
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
                    <?php if (count((array) $Payments) == 0) {?>
                    <div class="body text-center manage-list">
                        <div class="institute-box">
                            <img src="<?php echo ASSETS_PATH; ?>images/finder.png">
                            <h3>No records for Payment right now </h3>
                            
                        </div>
                    </div>
                    <?php } else {?>
                    <div class="body">
                        <div class="setup-table-block">
                            <div class="setup-header">
                                <div class="row">
                                    <div class="col-md-3 col-sm-3">
                                        <div class="form-group">
                                        <label class="form-label">Payment Status</label>
                                            <?php echo form_dropdown($PStatus, $PStatusList); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3">
                                       
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="manage-rightside">
                                            <div class="form-group">
                                                <div class="manage-searchbar">
                                                    <span class="glyphicon glyphicon-search form-control-feedback">
                                                    </span>
                                                    <input class="form-control" id="search" placeholder="Search Payments"
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
                                        <table class="table table-hover common_datatable" data-control="ccavenue_payment"
                                            data-method="manage">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>TransactionID</th>
                                                    <th>Name</th>
                                                    <th>Phone No</th>
                                                    <th>Amount</th>
                                                    <th>Payment Status</th>
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