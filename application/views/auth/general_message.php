<?php include 'auth_header.php';?>
<div class="row m-0">
    <div class="col-12 p-0">
        <div class="login-card">
            <div class="login-main">
                <div class="header">
                    <div class="logo-container">
                        <img class="img-fluid" src="<?php echo ASSETS_PATH; ?>images/slogo.png" alt="">
                    </div>
                </div>
                <p class="text-secondary mt-5" style="font-weight: 600;"><?php echo $message; ?></p>
                <?php echo anchor('/auth/logout', 'Go To Log-In Page', array('class' => 'btn l-blue btn-round btn-lg btn-block waves-effect waves-light')); ?>

                <div class="contact-info text-center">
                                    

                                <div class="copyrights">
                                    <span>Copyright @ <?php echo config_item('copyright_year') . ' ' . WEBSITE_NAME; ?>.
                                        <br /> All Rights Reserved <br />
                                        Managed by<a href="<?php echo WEBSITE_URL; ?>" target="_blank"> <?php echo WEBSITE; ?> </a></span>
                                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'auth_footer.php';?>