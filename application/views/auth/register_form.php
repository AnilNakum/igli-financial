<?php
if (isset($errors)) {
    if (isset($errors['phone_varified'])) {
        $Phone_Error = 1;
        $Phone_Error_class = 'phone-not-varified';
    } else {
        $Phone_Error = 0;
        $Phone_Error_class = '';
    }
}
// if ($use_username) {
//     $username = array(
//         'name'    => 'username',
//         'id'    => 'username',
//         'class' => 'form-control',
//         'placeholder' => 'Enter Username',
//         'value' => set_value('username'),
//         'maxlength'    => $this->config->item('username_max_length', 'tank_auth'),
//         'size'    => 30,
//     );
// }
$first_name = array(
    'name' => 'first_name',
    'id' => 'first_name',
    'class' => 'form-control',
    'placeholder' => 'Enter First Name',
    'value' => set_value('first_name'),
    'maxlength' => 20,
    'size' => 30,
);
$last_name = array(
    'name' => 'last_name',
    'id' => 'last_name',
    'class' => 'form-control',
    'placeholder' => 'Enter Last Name',
    'value' => set_value('last_name'),
    'maxlength' => 20,
    'size' => 30,
);
$email = array(
    'name' => 'email',
    'id' => 'email',
    'class' => 'form-control',
    'placeholder' => 'Enter Email',
    'value' => set_value('email'),
    'maxlength' => 80,
    'size' => 30,
);
$phone = array(
    'name' => 'phone',
    'id' => 'phone',
    'class' => 'form-control',
    'placeholder' => 'Enter Phone No.',
    'value' => set_value('phone'),
    'maxlength' => 10,
    'size' => 30,
);
$password = array(
    'name' => 'password',
    'id' => 'password',
    'class' => 'form-control',
    'placeholder' => 'Enter Password',
    'value' => set_value('password'),
    'maxlength' => $this->config->item('password_max_length', 'tank_auth'),
    'size' => 30,
);
$confirm_password = array(
    'name' => 'confirm_password',
    'id' => 'confirm_password',
    'class' => 'form-control',
    'placeholder' => 'Enter Confirm Password',
    'value' => set_value('confirm_password'),
    'maxlength' => $this->config->item('password_max_length', 'tank_auth'),
    'size' => 30,
);
$captcha = array(
    'name' => 'captcha',
    'id' => 'captcha',
    'maxlength' => 8,
);
$submit_btn = array(
    'name' => 'login_submit',
    'id' => 'login_submit',
    'value' => 'Register',
    'class' => 'btn l-cyan btn-round btn-lg btn-block waves-effect waves-light',
);
$register_page = 1;
?>
<?php include 'auth_header.php';?>
<style>
#view_pass i,
#view_cpass i {
    cursor: pointer;
}

.i-group .text-danger {
    margin-top: -10px;
}
</style>

<div class="row ">
    <div class="col-md-1"></div>
    <div class="col-md-5">
        <div class="card profile-greeting">
            <div class="card-body pb-0">
                <div class="media">
                    <div class="media-body">
                        <div class="greeting-user">
                            <h4 class="f-w-600 font-primary" id="greeting">Good Morning</h4>
                            <p>Become a <b>IGLI</b> and grow your business across India... </p>
                        </div>
                    </div>
                    <div class="badge-groups">
                        <div class="badge f-10"><i class="fa-solid fa-clock"></i> <span id="txt"></span></div>
                    </div>
                </div>
                <div class="cartoon cimg"><img class="img-fluid"
                        src="<?php echo ASSETS_PATH; ?>images/auth/register_bg.svg" alt=""></div>
                <div class="contact-info text-center">
                    <strong>For any query call us on </strong>
                    <br />(+91) <?php echo config_item('site_phone_1') . ' (or) ' . config_item('site_phone_2'); ?>
                </div>

                <div class="copyrights">
                    <span>Copyright @ <?php echo config_item('copyright_year') . ' ' . WEBSITE_NAME; ?>.
                        <br /> All Rights Reserved <br />
                        Managed by<a href="<?php echo WEBSITE_URL; ?>" target="_blank"> <?php echo WEBSITE; ?>
                        </a></span>
                </div>
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

                <h4>Create your account </h4>
                <p>Enter your personal details to create account</p>
                <div class="d-flex">
                    <input type="hidden" name="firebase_uid" id="firebase_uid" value="<?php echo '' ?>">
                    <input type="hidden" name="auth_provider" id="auth_provider" value="">
                    <div class="form-group left-input">
                        <?php echo form_input($first_name); ?>
                        <?php echo form_error($first_name['name'], '<p class="text-danger  text-left">', '</p>'); ?><?php echo isset($errors[$first_name['name']]) ? '<p class="text-danger text-left">' . $errors[$first_name['name']] . '</p>' : ''; ?>
                    </div>
                    <div class="form-group right-input">
                        <?php echo form_input($last_name); ?>
                        <?php echo form_error($last_name['name'], '<p class="text-danger  text-left">', '</p>'); ?><?php echo isset($errors[$last_name['name']]) ? '<p class="text-danger text-left">' . $errors[$last_name['name']] . '</p>' : ''; ?>
                    </div>
                </div>
                <div class="form-group ">
                    <?php echo form_input($email); ?>
                    <?php echo form_error($email['name'], '<p class="text-danger  text-left">', '</p>'); ?><?php echo isset($errors[$email['name']]) ? '<p class="text-danger text-left">' . $errors[$email['name']] . '</p>' : ''; ?>
                </div>
                <div class="form-group i-group">
                    <div class="input-group">
                        <?php echo form_input($phone); ?>
                        <span class="input-group-addon" id="phone_varification" data-toggle="modal"
                            data-target="#phoneVarification">
                            <i class="zmdi zmdi-alert-polygon text-danger" data-toggle="tooltip" data-placement="top"
                                title="Phone no verification required!"></i>
                        </span>
                    </div>
                    <?php echo form_error($phone['name'], '<p class="text-danger  text-left">', '</p>'); ?><?php echo isset($errors[$phone['name']]) ? '<p class="text-danger text-left ' . $Phone_Error_class . ' ">' . $errors[$phone['name']] . '</p>' : ''; ?>
                </div>
                <div class="form-group i-group">
                    <div class="input-group">
                        <?php echo form_password($password); ?>
                        <span class="input-group-addon" id="view_pass">
                            <i id="p" class="zmdi zmdi-eye"></i>
                        </span>
                    </div>
                    <?php echo form_error($password['name'], '<p class="text-danger  text-left">', '</p>'); ?><?php echo isset($errors[$password['name']]) ? '<p class="text-danger text-left">' . $errors[$email['name']] . '</p>' : ''; ?>
                </div>
                <div class="form-group i-group">
                    <div class="input-group">
                        <?php echo form_password($confirm_password); ?>
                        <span class="input-group-addon" id="view_cpass">
                            <i id="cp" class="zmdi zmdi-eye"></i>
                        </span>
                    </div>
                    <?php echo form_error($confirm_password['name'], '<p class="text-danger  text-left">', '</p>'); ?><?php echo isset($errors[$confirm_password['name']]) ? '<p class="text-danger text-left">' . $errors[$confirm_password['name']] . '</p>' : ''; ?>
                </div>
                <div class="form-group mb-0">
                    <?php echo form_submit($submit_btn); ?>
                </div>
                <h6 class="text-center mt-2 or">Or Register with</h6>
                <div class="social mt-2">
                    <div class="text-center">
                        <a class="btn btn-light btn-simple" href="javascript:;" onclick="google()"><i
                                class="fa-brands fa-google"></i>
                            Google </a>
                        <a class="btn btn-light btn-simple" href="javascript:;" onclick="facebook()"><i
                                class="fa-brands fa-facebook-f"></i> Facebook</a>
                    </div>
                </div>
                <p class="mt-2 mb-0 text-center">Already have an account? <?php echo anchor('/auth/login', 'Log In'); ?>
                </p>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="phoneVarification" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <div class="logo-container">
                    <img class="img-fluid" src="<?php echo ASSETS_PATH; ?>images/slogo.png" alt="">
                </div>
            </div>
            <div class="text-center otp">
                <h4 class="title" id="phoneVarificationLabel">OTP Varification</h4>
                <div class="phone-div">
                    <p>We will send you an <b>One Time Password</b> on this mobile number</p>
                    <div class="form-group">
                        <input type="text" name="mobile" value="" id="mobile" class="form-control"
                            placeholder="Please Enter Phone no." maxlength="10" size="30">
                        <p class="text-danger  text-left" id="mobile_error"></p>
                    </div>
                    <div class="recaptcha-container">
                        <div id="recaptcha-container"></div>
                    </div>
                </div>
                <div class="otp-div" style="display:none;">

                    <p><b> Please enter the one time password </b><br> </p>
                    <div> <span> sent to</span> <small id="num">+1******4343</small> </div>
                    <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
                        <input class="m-2 text-center form-control rounded" type="text" id="input1"
                            v-on:keyup="inputenter(1)" maxlength="1" />
                        <input class="m-2 text-center form-control rounded" v-on:keyup="inputenter(2)" type="text"
                            id="input2" maxlength="1" />
                        <input class="m-2 text-center form-control rounded" v-on:keyup="inputenter(3)" type="text"
                            id="input3" maxlength="1" />
                        <input class="m-2 text-center form-control rounded" v-on:keyup="inputenter(4)" type="text"
                            id="input4" maxlength="1" />
                        <input class="m-2 text-center form-control rounded" v-on:keyup="inputenter(5)" type="text"
                            id="input5" maxlength="1" />
                        <input class="m-2 text-center form-control rounded" v-on:keyup="inputenter(6)" type="text"
                            id="input6" maxlength="1" />
                    </div>
                    <p class="text-danger  text-left" id="otp_error"></p>
                    <div class="mt-3 content d-flex justify-content-center align-items-center"> <span>Didn't get the
                            OTP, </span>&nbsp; <div class="countdown"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="send_btn" type="button" class="btn l-cyan btn-round waves-effect waves-light"
                    onclick="phoneAuth()">Send OTP</button>
                <button id="validate_btn" type="button" class="btn l-cyan btn-round waves-effect waves-light"
                    style="display:none;" onclick="otpValidate()">Validate</button>
                <button type="button" class="btn btn-default btn-round waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
<?php include 'auth_footer.php';?>


<script type="text/javascript">
$(document).ready(function() {
    var Temp = <?php echo $Phone_Error; ?>;
    if (Temp == 1) {
        $('#phoneVarification').modal('toggle');
    }
    startTime();
    renderCaptcha();

    $('#view_pass').click(function() {
        var x = document.getElementById("password");
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
        var x = document.getElementById("confirm_password");
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
    var phone = localStorage.getItem("phone");
    if (phone != '' && phone != null) {
        $('#phone').val(phone);
        $('#phone_varification').html(
            `<i class="zmdi zmdi-check-all text-success" data-toggle="tooltip" data-placement="top" title="Phone no Verified.!"></i>&nbsp;
            <i class="zmdi zmdi-close-circle-o text-danger" data-toggle="tooltip" data-placement="top" title="Change Number.!" onclick="changeNumber()"></i>
            `
        );
        $('#phone').prop('readonly', true);
        $('#phone_varification').css('background', '#f2f2f2');
        $('#phone_varification').attr('data-toggle', '');

        var user = JSON.parse(localStorage.getItem("user"));
        $('#firebase_uid').val(user.uid);
        $('#auth_provider').val('Phone');
        $('[data-toggle="tooltip"]').tooltip();
    }

    $("#phoneVarification").on('shown.bs.modal', function() {
        var num = $('#phone').val();
        if (num != '') {
            $('#mobile').val(num);
        }
    });

});

function changeNumber() {
    $('#phone').val('');
    $('[data-toggle="tooltip"]').tooltip("hide");
    $('#phone_varification').html(
        `<i class="zmdi zmdi-alert-polygon text-danger" data-toggle="tooltip" data-placement="top" title="Phone no verification required!"></i>`
    );
    $('#phone').prop('readonly', false);
    $('#phone_varification').css('background', '#fff');
    $('#phone_varification').attr('data-toggle', 'modal');
    $('#firebase_uid').val('');
    $('#auth_provider').val('');
    localStorage.removeItem("user");
    localStorage.removeItem("phone");


    $('[data-toggle="tooltip"]').tooltip();
}

function renderCaptcha() {
    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container')
    recaptchaVerifier.render();
}

function phoneAuth() {
    if ($('#mobile').val() != '') {

        $.ajax({
            type: 'POST',
            url: BASEURL + 'auth/is_phone_available/' + $('#mobile').val(),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#send_btn').val('Please wait...!').attr('disabled', 'disabled');
            },
            success: function(returnData) {
                if (returnData.status == "ok") {
                    var number = '+91' + $('#mobile').val();
                    firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function(
                        confirmationResult) {
                        window.confirmationResult = confirmationResult;
                        coderesult = confirmationResult;

                        $('.otp-div').css('display', 'block');
                        $('.phone-div').css('display', 'none');

                        $('#validate_btn').css('display', 'block');
                        $('#send_btn').css('display', 'none');
                        $('#num').html(number);
                        resendTimer();
                    }).catch(function(error) {
                        message = error.message;
                        if (error.code == 'auth/invalid-phone-number') {
                            message = 'The enterd phone no. is invalid.';
                        }
                        $('#mobile_error').html(message);
                    });
                } else {
                    $('#mobile_error').html(returnData.message);
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                pop_up.alert(
                    'There was an unknown error that occurred. You will need to refresh the page to continue working.'
                );
            },
            complete: function() {
                $('#send_btn').val('Send OTP').removeAttr('disabled');
            }
        });
    } else {
        $('#mobile_error').html('Please enter phone no.');
    }
}

function otpValidate() {
    var number = $('#mobile').val();
    var code = $('#input1').val() + $('#input2').val() + $('#input3').val() + $('#input4').val() + $('#input5').val() +
        $('#input6').val();
    coderesult.confirm(code).then(function(result) {
        $('#phone').val(number);
        $('#phone').prop('readonly', true);
        $('#phone_varification').css('background', '#f2f2f2');

        $('#phone_varification').html(
            `<i class="zmdi zmdi-check-all text-success" data-toggle="tooltip" data-placement="top" title="Phone no Verified.!"></i>&nbsp;
            <i class="zmdi zmdi-close-circle-o text-danger" data-toggle="tooltip" data-placement="top" title="Change Number.!"></i>
             `
        );
        $('#phone_varification').attr('data-toggle', '');

        $('#phoneVarification').modal('toggle');
        $('[data-toggle="tooltip"]').tooltip();
        $('.otp-div').css('display', 'none');
        $('.phone-div').css('display', 'block');

        $('#validate_btn').css('display', 'none');
        $('#send_btn').css('display', 'block');
        $('.phone-not-varified ').html('');
        var user = result.user.toJSON();
        $('#firebase_uid').val(user.uid);
        $('#auth_provider').val('Phone');
        localStorage.setItem("user", JSON.stringify(user));
        localStorage.setItem("phone", number);

    }).catch(function(error) {
        message = error.message;
        if (error.code == 'auth/invalid-verification-code') {
            message = 'The SMS verification code used for phone no. varification is invalid.';
        }
        $('#otp_error').html(message);
    });
}

function reSend() {
    recaptchaVerifier.clear();
    renderCaptcha();
    $('.otp-div').css('display', 'none');
    $('.phone-div').css('display', 'block');
    $('#validate_btn').css('display', 'none');
    $('#send_btn').css('display', 'block');
}

function resendTimer() {
    var timer2 = "1:01";
    var interval = setInterval(function() {
        var timer = timer2.split(':');
        //by parsing integer, I avoid all extra string processing
        var minutes = parseInt(timer[0], 10);
        var seconds = parseInt(timer[1], 10);
        --seconds;
        minutes = (seconds < 0) ? --minutes : minutes;
        if (minutes < 0) clearInterval(interval);
        seconds = (seconds < 0) ? 59 : seconds;
        seconds = (seconds < 10) ? '0' + seconds : seconds;
        //minutes = (minutes < 10) ?  minutes : minutes;
        $('.countdown').html(' resend OTP in <a href="javascript:;">' + minutes + ':' + seconds + '</a>');
        timer2 = minutes + ':' + seconds;
        if (minutes < 0) {
            $('.countdown').html(
                `<a href="javascript:;" class="text-decoration-none ms-3" onclick="reSend()"> Resend</a>`
            )
        }
    }, 1000);
}

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

document.addEventListener("DOMContentLoaded", function(event) {
    function OTPInput() {
        const inputs = document.querySelectorAll('#otp > *[id]');
        for (let i = 0; i < inputs.length; i++) {
            inputs[i].addEventListener('keydown', function(event) {
                if (event.key === "Backspace") {
                    inputs[i].value = '';
                    if (i !== 0) {
                        inputs[i - 1].focus();
                    }
                } else {
                    if (i === inputs.length - 1 && inputs[i].value !== '') {
                        return true;
                    } else if (event.keyCode > 47 && event.keyCode < 58) {
                        inputs[i].value = event.key;
                        if (i !== inputs.length - 1) inputs[i + 1].focus();
                        event.preventDefault();
                    } else if (event.keyCode > 64 && event.keyCode < 91) {
                        inputs[i].value = String.fromCharCode(event.keyCode);
                        if (i !== inputs.length - 1) inputs[i + 1].focus();
                        event.preventDefault();
                    }
                }
            });
        }
    }
    OTPInput();
});
</script>