<?php
$email = array(
    'name' => 'email',
    'id' => 'email',
    'value' => set_value('email'),
    'class' => 'form-control',
    'placeholder' => 'Enter Email',
    'maxlength' => 80,
    'size' => 30,
);
$submit_btn = array(
    'name' => 'send',
    'id' => 'send',
    'value' => 'Send',
    'class' => 'btn l-cyan btn-round btn-lg btn-block waves-effect waves-light',
);

$admin_not_allowed = (isset($admin_not_allowed)) ? $admin_not_allowed : 'Please click on the link that has been sent to your email account to varify your email and continue,<br/> If you do not receive a verification mail enter your email to get new link.';
?>

<?php include 'auth_header.php';?>

    <div class="row ">
        <div class="col-md-1"></div>
        <div class="col-md-5">
        <div class="card profile-greeting">
                  <div class="card-body pb-0">
                    <div class="media">
                      <div class="media-body">
                        <div class="greeting-user">
                          <h4 class="f-w-600 font-primary" id="greeting">Good Morning</h4>
                          <p><b>Account Not Activated?</b> Enter your registered email id to get varification link. </p>
                        </div>
                      </div>
                      <div class="badge-groups">
                        <div class="badge f-10"><i class="fa-solid fa-clock"></i> <span id="txt"></span></div>
                      </div>
                    </div>
                    <div class="cartoon cimg"><img class="img-fluid" src="<?php echo ASSETS_PATH; ?>images/auth/activation.png" alt=""></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 p-0">
            <div class="login-card">
                <div class="login-main">
                    <div class="header">
                        <div class="logo-container">
                            <img class="img-fluid" src="<?php echo ASSETS_PATH; ?>images/slogo.png" alt="">
                        </div>
                    </div>
                    <?php echo form_open($this->uri->uri_string(), array('action' => '', 'method' => 'post', 'id' => 'login-form', 'class' => 'login-form form')); ?>

                                <h4>Account Not Activated</h4>
                                <p>Please enter your registered email id</p>
                                <div class="form-group">
        <?php echo form_label('Send Varifiation Link', $email['id']); ?>
        <?php echo form_input($email); ?>
        <?php echo form_error($email['name'], '<p class="text-danger text-left">', '</p>'); ?><?php echo isset($errors[$email['name']]) ? '<p class="text-danger text-left">' . $errors[$email['name']] . '</p>' : ''; ?>
    </div>
                                <div class="form-group mb-0">
                                    <?php echo form_submit($submit_btn); ?>
                                </div>
                                <p class="mt-4 mb-0 text-center">Account Activated? <?php echo anchor('/auth/logout', 'Log In'); ?></p>
                                <div class="contact-info text-center">
        <strong>For any query call us on </strong>
        <br />(+91) <?php echo config_item('site_phone_1') . ' (or) ' . config_item('site_phone_2'); ?>
    </div>

    <div class="copyrights">
        <span>Copyright @ <?php echo config_item('copyright_year') . ' ' . WEBSITE_NAME; ?>.
            <br /> All Rights Reserved <br />
            Managed by<a href="<?php echo WEBSITE_URL; ?>" target="_blank"> <?php echo WEBSITE; ?> </a></span>
    </div>
                                <?php echo form_close(); ?>
                </div>
            </div>
        </div>
</div>
<?php include 'auth_footer.php';?>


<script type="text/javascript">
$(document).ready(function() {
    startTime();
    var today = new Date()
var curHr = today.getHours()

if (curHr >= 0 && curHr < 4) {
    document.getElementById("greeting").innerHTML = 'Good Night';
} else if (curHr >= 4 && curHr < 12) {
    document.getElementById("greeting").innerHTML = 'Good Morning';
} else if (curHr >= 12 && curHr < 16) {
    document.getElementById("greeting").innerHTML = 'Good Afternoon';
} else {
    document.getElementById("greeting").innerHTML = 'Good Evening';
}

});
// time
function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    // var s = today.getSeconds();
    var ampm = h >= 12 ? 'PM' : 'AM';
    h = h % 12;
    h = h ? h : 12;
    m = checkTime(m);
    // s = checkTime(s);
    document.getElementById('txt').innerHTML =
        h + ":" + m + ' ' + ampm;
    var t = setTimeout(startTime, 500);
}
function checkTime(i) {
    if (i < 10) { i = "0" + i };  // add zero in front of numbers < 10
    return i;
}
</script>