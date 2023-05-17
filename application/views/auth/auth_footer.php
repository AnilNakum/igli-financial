<footer class="footer">
    <div class="container">
        <nav>
            <ul>
                <li><a href="https://iglifinancial.com/contact-us/">Contact Us</a></li>
                <li><a href="https://iglifinancial.com/about-us/">About Us</a></li>
            </ul>
        </nav>
        <div class="copyright">
            <span class="footer-copyright"><b> &copy; Copyright IGLI FINANCIAL PRIVATE LIMITED. </b>
                All Rights Reserved.</span>
        </div>
    </div>
</footer>

</div>

<!-- Jquery Core Js -->
<script src="<?php echo ASSETS_PATH; ?>bundles/libscripts.bundle.js"></script>
<script src="<?php echo ASSETS_PATH; ?>bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->

<script src="<?php echo ASSETS_PATH; ?>bower_components/font-awesome/js/all.min.js"></script>
<script src="<?php echo ASSETS_PATH; ?>custom/js/login_form.js"></script>
<script src="<?php echo ASSETS_PATH; ?>custom/js/custom-for-all.js"></script>

<script>
$(document).ready(function() {

});

//=============================================================================
$('.form-control').on("focus", function() {
    $(this).parent('.input-group').addClass("input-group-focus");
}).on("blur", function() {
    $(this).parent(".input-group").removeClass("input-group-focus");
});
</script>
</body>

</html>