<?php include 'auth_header.php';?>
<script>
	window.onload = function() {
		var d = new Date().getTime();
		document.getElementById("tid").value = d;
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
                <div class="cartoon limg"><img class="img-fluid"
                        src="<?php echo ASSETS_PATH; ?>images/payment.png" alt=""></div>
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
                <!-- <?php //echo form_open($this->uri->uri_string(), array('action' => '', 'method' => 'post', 'id' => 'login-form', 'class' => 'login-form form')); ?>
<img class="img-fluid"
                        src="<?php echo ASSETS_PATH; ?>images/right.png" alt="">
                <p class="text-center text-success">Your responce has been successfully recorded.</p>
                <?php// echo anchor($FormURL, 'Submit Another Responce' , array('class' => 'btn l-blue btn-round btn-lg btn-block waves-effect waves-light')); ?>
                -->


                <?php echo form_open_multipart('auth/save_payment', /*$form_attr*/); ?>
		<table width="40%" height="100"  align="center">
			<table width="40%" height="100"  align="center" class="table" >
				
				<tr>
					<td>TID	:</td><td><input type="text" name="tid" id="tid" readonly /></td>
				</tr>
				<tr>
					<td>Merchant Id	:</td><td><input type="text" name="merchant_id" value="78901"/></td>
				</tr>
				<tr>
					<td>Order Id	:</td><td><input type="text" name="order_id" value="123654789"/></td>
				</tr>
				<tr>
					<td>Amount	:</td><td><input type="text" name="amount" value="1.00"/></td>
				</tr>
				<tr>
					<td>Currency	:</td><td><input type="text" name="currency" value="INR"/></td>
				</tr>
				<tr>
					<td>Redirect URL	:</td><td><input type="text" name="redirect_url" value="http://localhost/CCAvenue/www/index.php/payment_handler/"/></td>
				</tr>
			 	<tr>
			 		<td>Cancel URL	:</td><td><input type="text" name="cancel_url" value="http://localhost/CCAvenue/www/index.php/payment_handler/"/></td>
			 	</tr>
			 	<tr>
					<td>Language	:</td><td><input type="text" name="language" value="EN"/></td>
				</tr>
		     	
		        
		        <tr>
		        	<td></td><td><INPUT TYPE="submit" value="CheckOut"></td>
		        </tr>
	      	</table>
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