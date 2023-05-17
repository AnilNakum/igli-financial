<?php
$new_password = array(
    'name' => 'new_password',
    'id' => 'new_password',
    'class' => 'form-control',
    'maxlength' => $this->config->item('password_max_length', 'tank_auth'),
    'size' => 30,
    'placeholder' => 'New Password',
);
$confirm_new_password = array(
    'name' => 'confirm_new_password',
    'id' => 'confirm_new_password',
    'class' => 'form-control',
    'maxlength' => $this->config->item('password_max_length', 'tank_auth'),
    'size' => 30,
    'placeholder' => 'Confirm New Password',
);
$submit_btn = array(
    'name' => 'change',
    'id' => 'change',
    'value' => 'Change Password',
    'class' => 'btn l-blue btn-round btn-lg btn-block waves-effect waves-light',
);
?>
<?php include 'auth_header.php';?>

<div class="row ">
    <style>
    #view_pass i,
    #view_cpass i {
        cursor: pointer;
    }
    </style>
    <div class="col-md-1"></div>
    <div class="col-md-5">
        <div class="card profile-greeting">
            <div class="card-body pb-0">
                <div class="media">
                    <div class="media-body">
                        <div class="greeting-user">
                            <h4 class="f-w-600 font-primary" id="greeting">Good Morning</h4>
                            <p>For reset your password enter new password. </p>
                        </div>
                    </div>
                    <div class="badge-groups">
                        <div class="badge f-10"><i class="fa-solid fa-clock"></i> <span id="txt"></span></div>
                    </div>
                </div>
                <div class="cartoon cimg"><img class="img-fluid"
                        src="<?php echo ASSETS_PATH; ?>images/auth/reset_password.png" alt=""></div>
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

                <h4>Reset Password</h4>
                <p>Please enter new password</p>
                <div class="form-group">
                    <div class="input-group">
                        <?php echo form_password($new_password); ?>
                        <span class="input-group-addon" id="view_pass">
                            <i id="p" class="zmdi zmdi-eye"></i>
                        </span>
                    </div>
                    <?php echo form_error($new_password['name'], '<p class="text-danger text-left">', '</p>'); ?><?php echo isset($errors[$new_password['name']]) ? '<p class="text-danger text-left">' . $errors[$new_password['name']] . '</p>' : ''; ?>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <?php echo form_password($confirm_new_password); ?>
                        <span class="input-group-addon" id="view_cpass">
                            <i id="cp" class="zmdi zmdi-eye"></i>
                        </span>
                    </div>
                    <?php echo form_error($confirm_new_password['name'], '<p class="text-danger text-left">', '</p>'); ?><?php echo isset($errors[$confirm_new_password['name']]) ? '<p class="text-danger text-left">' . $errors[$confirm_new_password['name']] . '</p>' : ''; ?>
                </div>
                <div class="form-group mb-0">
                    <?php echo form_submit($submit_btn); ?>
                </div>
                <p class="mt-4 mb-0 text-center">Already have an password?
                    <?php echo anchor('/auth/login', 'Log In'); ?></p>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<?php include 'auth_footer.php';?>


<script type="text/javascript">
$(document).ready(function() {
    startTime();
    $('#view_pass').click(function() {
        var x = document.getElementById("new_password");
        if (x.type === "password") {
            x.type = "text";
            $('#p').removeClass('zmdi-eye');
            $('#p').addClass('zmdi-eye-off');
        } else {
            x.type = "password";
            $('#p').removeClass('zmdi-eye-off');
            $('#p').addClass('zmdi-eye');
        }
        // $(".zmdi-eye, .zmdi-eye-off").toggleClass("zmdi-eye zmdi-eye-off");
    });

    $('#view_cpass').click(function() {
        var x = document.getElementById("confirm_new_password");
        if (x.type === "password") {
            x.type = "text";
            $('#cp').removeClass('zmdi-eye');
            $('#cp').addClass('zmdi-eye-off');
        } else {
            x.type = "password";
            $('#cp').removeClass('zmdi-eye-off');
            $('#cp').addClass('zmdi-eye');
        }
        // $(".zmdi-eye, .zmdi-eye-off").toggleClass("zmdi-eye zmdi-eye-off");
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