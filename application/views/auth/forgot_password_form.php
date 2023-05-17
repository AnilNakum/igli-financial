<?php
$login = array(
    'name' => 'login',
    'id' => 'login',
    'class' => 'form-control',
    'value' => set_value('login'),
    'placeholder' => 'Enter Email',
);

if ($this->config->item('use_username', 'tank_auth')) {
    $login_label = 'Enter Register Email';
} else {
    $login_label = 'Email';
}

$submit_btn = array(
    'name' => 'reset',
    'id' => 'reset',
    'value' => 'Get New Password',
    'class' => 'btn l-blue btn-round btn-lg btn-block waves-effect waves-light',
);

$Cancel_btn = array(
    'name' => 'reset',
    'id' => 'reset',
    'value' => 'Cancel',
    'class' => 'btn btn-default',
);
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
                        <p><b>Forgot Password?</b> That's Okay, it happens! enter your registered email id to reset your password. </p>
                    </div>
                    </div>
                    <div class="badge-groups">
                    <div class="badge f-10"><i class="fa-solid fa-clock"></i> <span id="txt"></span></div>
                    </div>
                </div>
                <div class="cartoon cimg"><img class="img-fluid" src="<?php echo ASSETS_PATH; ?>images/auth/password.png" alt=""></div>
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

                <h4>Forgot Password</h4>
                <p>Please enter your registered email id</p>
                <div class="form-group">
                    <label class="col-form-label">Email </label>
                    <?php echo form_input($login); ?>
                </div>
                <?php echo form_error($login['name'], '<p class="text-danger text-left">', '</p>'); ?><?php echo isset($errors[$login['name']]) ? '<p class="text-danger text-left">' . $errors[$login['name']] . '</p>' : ''; ?>
                <div class="form-group mb-0">
                    <?php echo form_submit($submit_btn); ?>
                </div>
                <p class="mt-4 mb-0 text-center">Already have an password? <?php echo anchor('/auth/login', 'Log In'); ?></p>
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