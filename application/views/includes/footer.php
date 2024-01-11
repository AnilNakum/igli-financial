<!-- Jquery Core Js -->
<script src="<?php echo ASSETS_PATH; ?>bundles/libscripts.bundle.js"></script>
<script src="<?php echo ASSETS_PATH; ?>plugins/jquery/jquery-ui.js"></script>
<script src="<?php echo ASSETS_PATH; ?>bundles/vendorscripts.bundle.js"></script>
<script src="<?php echo ASSETS_PATH; ?>bundles/datatablescripts.bundle.js"></script>

<script src="<?php echo ASSETS_PATH; ?>bower_components/bootstrap/dist/js/bootstrap.js"></script>
<script src="<?php echo ASSETS_PATH; ?>plugins/momentjs/moment.js"></script>
<script src="<?php echo ASSETS_PATH; ?>plugins/dropzone/dropzone.js"></script>
<script
    src="<?php echo ASSETS_PATH; ?>plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js">
</script>
<script src="<?php echo ASSETS_PATH; ?>bundles/mainscripts.bundle.js"></script>

<script src="<?php echo ASSETS_PATH; ?>plugins/jquery-datatable/dataTables.buttons.min.js"></script>
<script src="<?php echo ASSETS_PATH; ?>plugins/jquery-datatable/jszip.min.js"></script>
<script src="<?php echo ASSETS_PATH; ?>plugins/jquery-datatable/buttons.html5.min.js"></script>
<script src="<?php echo ASSETS_PATH; ?>plugins/jquery-datatable/datatables.responsive.js"></script>

<script src="<?php echo ASSETS_PATH; ?>plugins/ion-rangeslider/js/ion.rangeSlider.js"></script>
<script src="<?php echo ASSETS_PATH; ?>js/notifications.js" type="text/javascript"></script>
<script src="<?php echo ASSETS_PATH; ?>plugins/bootstrap-notify/bootstrap-notify.js"></script>
<script src="<?php echo ASSETS_PATH; ?>js/pages/ui/notifications.js"></script> <!-- Custom Js -->

<script src="<?php echo ASSETS_PATH; ?>plugins/alert/js/alert.min.js"></script>
<script src="<?php echo ASSETS_PATH; ?>js/custom.js"></script>
<script src="<?php echo ASSETS_PATH; ?>js/owl.carousel.min.js"></script>
<script src="<?php echo ASSETS_PATH; ?>bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo ASSETS_PATH; ?>plugins/sweetalert/sweetalert2.all.min.js"></script>
<script src="<?php echo ASSETS_PATH; ?>plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>


<!-- File Input-->
<script src="<?php echo ASSETS_PATH; ?>plugins/fileinput/js/fileinput.js" type="text/javascript"></script>
<script src="<?php echo ASSETS_PATH; ?>plugins/fileinput/themes/fas/theme.js" type="text/javascript"></script>
<script src="<?php echo ASSETS_PATH; ?>plugins/fileinput/js/plugins/sortable.js" type="text/javascript">
</script>
<!-- <script src="<?php echo ASSETS_PATH; ?>plugins/bootstrap-fileinput/js/fileinput.js" type="text/javascript"></script>
<script src="<?php echo ASSETS_PATH; ?>plugins/bootstrap-fileinput/themes/fas/theme.js" type="text/javascript"></script>
<script src="<?php echo ASSETS_PATH; ?>plugins/bootstrap-fileinput/themes/explorer-fas/theme.js" type="text/javascript">
</script> -->
<!-- CkEditor -->
<script src="<?php echo ASSETS_PATH; ?>plugins/ckeditor/ckeditor.js" type="text/javascript"></script>

<script src="<?php echo ASSETS_PATH; ?>custom/js/login.js"></script>
<script src="<?php echo ASSETS_PATH; ?>custom/js/custom-for-all.js"></script>

<script>
$(document).ready(function() {
    const Name = LOGIN_USERNAME.split(" ");
    var firstName = Name[0];
    var lastName = Name[1];
    var intials = firstName.charAt(0) + lastName.charAt(0);
    var profileImage = $('#profileImage').text(intials);
});
</script>


<?php
if (isset($extra_js) && is_array($extra_js) && !empty($extra_js)) {
    foreach ($extra_js as $js) {
        if (!empty($js)) {
            $extension = explode(".", $js);
            $extension = end($extension);
            if (in_array($extension, array('php', 'js'))) {
                echo '<script src="' . ASSETS_PATH . 'custom/js/' . $js . '?' . randomNumber() . '"></script>' . "\n";
            } else {
                echo '<script src="' . ASSETS_PATH . 'custom/js/' . $js . '.js?' . randomNumber() . '"></script>' . "\n";
            }
        }
    }
}
?>

</body>

</html>