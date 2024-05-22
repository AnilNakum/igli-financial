<?php include 'auth_header.php';

$amount = array(
    'name' => 'amount',
    'id' => 'amount',
    'class' => 'form-control amount',
    'placeholder' => 'Amount',
);
$Name = array('name' => 'billing_name', 'id' => 'billing_name',  'class' => "form-control", "tabindex" => 1, 'placeholder' => "Enter Name", "data-validation" => "required");
$Email = array('name' => 'billing_email', 'id' => 'billing_email',  'class' => "form-control", "tabindex" => 1, 'placeholder' => "Enter Email", "data-validation" => "required");
$Phone = array('name' => 'billing_tel', 'id' => 'billing_tel',  'class' => "form-control", "tabindex" => 1, 'placeholder' => "Enter Phone No", "data-validation" => "required");
$CompanyName = array('name' => 'company_name', 'id' => 'company_name',  'class' => "form-control", "tabindex" => 1, 'placeholder' => "Enter Company Name", "data-validation" => "required");
$GST = array('name' => 'gst', 'id' => 'gst',  'class' => "form-control", "tabindex" => 1, 'placeholder' => "Enter GST No", "data-validation" => "required");
$Address = array('name' => 'billing_address', 'id' => 'billing_address',  'class' => "form-control", "tabindex" => 1, 'placeholder' => "Enter Address", "data-validation" => "required","rows" => 2);
$City = array('name' => 'billing_city', 'id' => 'billing_city',  'class' => "form-control", "tabindex" => 1, 'placeholder' => "Enter City", "data-validation" => "required");
$State = array('name' => 'billing_state', 'id' => 'billing_state',  'class' => "form-control", "tabindex" => 1, 'placeholder' => "Enter State", "data-validation" => "required");
$Country = array('name' => 'billing_country', 'id' => 'billing_country',  'class' => "form-control", "tabindex" => 1, 'placeholder' => "Enter Country", "data-validation" => "required");
$Zip = array('name' => 'billing_zip', 'id' => 'billing_zip',  'class' => "form-control", "tabindex" => 1, 'placeholder' => "Enter Zip Code", "data-validation" => "required");

$submit_btn = array(
    'name' => 'checkout',
    'id' => 'checkout',
    'value' => 'CheckOut',
    'class' => 'btn l-blue btn-round btn-lg btn-block waves-effect waves-light',
);
$form_attr = array('class' => 'default_form pay_frm', 'id' => 'pay_frm', 'name' => 'pay_frm');
?>
<script>
window.onload = function() {
    var d = new Date().getTime();
    document.getElementById("tid").value = d;
    document.getElementById("order_id").value = d;
};
</script>

<div class="row">

    <div class="col-md-5">
        <div class="card profile-greeting">
            <div class="card-body pb-0">
                <div class="media">
                    <div class="media-body">
                        <div class="greeting-user">
                            <h4 class="f-w-600 font-primary" id="greeting">Good Morning</h4>
                        </div>
                    </div>
                    <div class="badge-groups">
                        <div class="badge f-10"><i class="fa-solid fa-clock"></i> <span id="txt"></span></div>
                    </div>
                </div>
                <div class="cartoon limg"><img class="img-fluid" src="<?php echo ASSETS_PATH; ?>images/payment.png"
                        alt=""></div>
            </div>
        </div>
    </div>
    <div class="col-md-7 p-0">
        <div class="login-card">
            <div class="login-main payment">
                <div class="header">
                    <div class="logo-container">
                        <img class="img-fluid" src="<?php echo ASSETS_PATH; ?>images/igli-logo.webp" alt="">
                    </div>
                </div>
                <span id="innerHTML"></span>

                <?php echo form_open_multipart('auth/save_payment', $form_attr); ?>
                <br>
                <h6 class="text-center">Payment To IGLI FINANCIAL PRIVATE LIMITED</h6>
                <input type="hidden" name="tid" id="tid" readonly />
                <input type="hidden" name="merchant_id" value="<?php echo CCA_MERCHANT_ID;?>" />
                <input type="hidden" name="order_id" id="order_id" />
                <input type="hidden" name="currency" value="INR" />
                <input type="hidden" name="redirect_url" value="<?php echo BASE_URL .'payment_handler';?>" />
                <input type="hidden" name="cancel_url" value="<?php echo BASE_URL .'payment_handler';?>" />
                <input type="hidden" name="language" value="EN" />
                <br>
                <div class="form-group">
                    <?php echo form_input($amount); ?>
                </div>
                <hr>
                <div class="form-group">
                    <?php echo form_input($Name); ?>
                </div>
                <div class="form-group">
                    <?php echo form_input($Email); ?>
                </div>
                <div class="form-group">
                    <?php echo form_input($Phone); ?>
                </div>
                <div class="form-group">
                    <?php echo form_input($CompanyName); ?>
                </div>
                <div class="form-group">
                    <?php echo form_input($GST); ?>
                </div>
                <div class="form-group">
                    <?php echo form_textarea($Address); ?>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php echo form_input($City); ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php echo form_input($State); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php echo form_input($Country); ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php echo form_input($Zip); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <?php echo form_submit($submit_btn); ?>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
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