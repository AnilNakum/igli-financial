<?php
if ($login_by_username and $login_by_email) {
    $login_label = 'Register Email';
} else if ($login_by_username) {
    $login_label = 'Login';
} else {
    $login_label = 'Email';
}
$login = array(
    'name' => 'login',
    'id' => 'login',
    'class' => 'form-control',
    'value' => set_value('login'),
    'maxlength' => 80,
    'placeholder' => 'Enter your email ',
    'size' => 30,
);
$password = array(
    'name' => 'password',
    'class' => 'form-control',
    'id' => 'password',
    'placeholder' => '*********',
    'size' => 30,
);
$remember = array(
    'name' => 'remember',
    'id' => 'remember',
    'value' => 1,
    'checked' => set_value('remember'),
);
$login_btn = array(
    'value' => 'Login',
    'type' => 'submit',
    'class' => 'btn btn-primary btn-cons',
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
);
$submit_btn = array(
    'name' => 'login_submit',
    'id' => 'login_submit',
    'value' => 'Sign In',
    'class' => 'btn l-blue btn-round btn-lg btn-block waves-effect waves-light',
);
$login_page = 1;
?>
<?php include 'auth_header.php';?>
<style>
#view_pass i {
    cursor: pointer;
}
</style>

<div class="row">
    <div class="col-md-6 p-0">
        <div class="login-card">
            <div class="login-main">
                <div class="header">
                    <div class="logo-container">
                        <img class="img-fluid" src="<?php echo ASSETS_PATH; ?>images/igli-logo.webp" alt="">
                    </div>
                </div>
                <?php echo form_open($this->uri->uri_string(), array('action' => '', 'method' => 'post', 'id' => 'login-form', 'class' => 'login-form form')); ?>

                <h4>Log in to account</h4>
                <p>Enter your email & password to login</p>
                <div class="form-group">
                    <!-- <label class="col-form-label">Email </label> -->
                    <?php echo form_input($login); ?>
                </div>
                <?php echo form_error($login['name'], '<p class="text-danger text-left">', '</p>'); ?><?php echo isset($errors[$login['name']]) ? '<p class="text-danger text-left">' . $errors[$login['name']] . '</p>' : ''; ?>

                <div class="form-group">
                    <!-- <label class="col-form-label">Password </label> -->
                    <div class="input-group">
                        <?php echo form_password($password); ?>
                        <span class="input-group-addon" id="view_pass">
                            <i class="zmdi zmdi-eye"></i>
                        </span>
                    </div>
                </div>
                <?php echo form_error($password['name'], '<p class="text-danger  text-left">', '</p>'); ?><?php echo isset($errors[$password['name']]) ? '<p class="text-danger text-left">' . $errors[$password['name']] . '</p>' : ''; ?>

                <div class="form-group mb-0">
                    <div class="checkbox p-0 float-left">
                        <?php echo form_checkbox($remember); ?> <label for="remember">Remember password</label>
                    </div>
                    <div class="float-right">
                        <?php echo anchor('/auth/forgot_password/', 'Forgot Password?'); ?>
                    </div>
                    <?php echo form_submit($submit_btn); ?>
                </div>
                <!-- <h6 class="text-center mt-4 or">Or Log in with</h6>
                <div class="social mt-4">
                    <div class="text-center">
                        <a class="btn btn-light btn-simple" href="javascript:;" onclick="google()"><i
                                class="fa-brands fa-google"></i>
                            Google </a>
                        <a class="btn btn-light btn-simple" href="javascript:;" onclick="facebook()"><i
                                class="fa-brands fa-facebook-f"></i> Facebook</a>
                    </div>
                </div>
                <p class="mt-4 mb-0 text-center">Don't have account?
                    <?php echo anchor('/auth/register', 'Create Account'); ?></p> -->
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card profile-greeting">
            <div class="card-body pb-0">
                <div class="media">
                    <div class="media-body">
                        <div class="greeting-user">
                            <h4 class="f-w-600 font-primary" id="greeting">Good Morning</h4>
                            <p>Here whats happening in your account today, Let's Login...</p>
                        </div>
                    </div>
                    <div class="badge-groups">
                        <div class="badge f-10"><i class="fa-solid fa-clock"></i> <span id="txt"></span></div>
                    </div>
                </div>
                <div class="cartoon limg"><img class="img-fluid"
                        src="<?php echo ASSETS_PATH; ?>images/auth/login_bg.webp" alt=""></div>
            </div>
        </div>
    </div>
    <div class="col-md-1"></div>
</div>

<?php include 'auth_footer.php';?>

<script type="text/javascript">
$(document).ready(function() {
    localStorage.removeItem("user");
    localStorage.removeItem("phone");
    startTime();
    $('#view_pass').click(function() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
        $(".zmdi-eye, .zmdi-eye-off").toggleClass("zmdi-eye zmdi-eye-off");
    });

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
    if (i < 10) {
        i = "0" + i
    }; // add zero in front of numbers < 10
    return i;
}
</script>