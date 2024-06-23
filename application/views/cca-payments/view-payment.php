<?php

$cancel_btn = array('name' => 'cancel_btn', 'id' => 'cancel_btn', 'content' => 'CLOSE', 'class' => 'btn btn-round btn-white', "onclick" => "pop_up.close()");
?>
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
            ?>
            <div class="row">
                <div class="col-md-12 card">
                <div class="header">
                        <h2><strong>Pamenty</strong> Details </h2>
                        <hr>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><b> Transaction ID :</b> <?php echo $payment_info->TransactionID; ?></label>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><b> OrderID :</b> <?php echo $payment_info->OrderID; ?></label>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><b> Amount :</b> <?php echo $payment_info->Amount; ?></label>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><b> User Name :</b> <?php echo $payment_info->Name; ?></label>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><b> Email :</b> <?php echo $payment_info->Email; ?></label>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><b> Phone No. :</b> <?php echo $payment_info->Phone; ?></label>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><b> Company Name :</b> <?php echo $payment_info->CompanyName; ?></label>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><b> GST :</b> <?php echo $payment_info->GST; ?></label>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><b> Address :</b> <?php echo $payment_info->Address; ?></label>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label"><b> Payment Date :</b>
                            <?php echo date('l d F Y', strtotime($payment_info->CreatedAt)); ?></label>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><b> Status :</b>
                            <?php echo CCPayment_Status($payment_info->Status); ?></label>
                    </div>
                    
                    
                    <!-- <?php pr($payment_info);?> -->

                    
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