<!doctype html>
<html class="no-js gr__devloper-2 firefox" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="description" content="T-Score">
        <title><?php echo BASE_TITLE; ?><?php echo (isset($page_title) && !empty($page_title)) ? $page_title : ''; ?></title>
        <link rel="icon" href="<?php echo FAVICON ?>" type="image/x-icon">
        <link href="<?php echo ASSETS_PATH; ?>plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo ASSETS_PATH; ?>bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- <link href="<?php echo ASSETS_PATH; ?>bower_components/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet"> -->
        <link href="<?php echo ASSETS_PATH; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
        <link href="<?php echo ASSETS_PATH; ?>plugins/dropzone/dropzone.css" rel="stylesheet">
        <link href="<?php echo ASSETS_PATH; ?>plugins/jquery-datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link href="<?php echo ASSETS_PATH; ?>plugins/jquery-datatable/jquery.dataTables.min.css" rel="stylesheet">
        <link href="<?php echo ASSETS_PATH; ?>plugins/jquery-datatable/responsive.dataTables.min.css" rel="stylesheet">
        <link href="<?php echo ASSETS_PATH; ?>plugins/jquery-datatable/datatables.responsive.button.css" rel="stylesheet">
        <link href="<?php echo ASSETS_PATH; ?>plugins/sweetalert/sweetalert.css" rel="stylesheet"/>
        <link href="<?php echo ASSETS_PATH; ?>css/main.css" rel="stylesheet">
        <link href="<?php echo ASSETS_PATH; ?>css/hm-style.css" rel="stylesheet">
        <link href="<?php echo ASSETS_PATH; ?>css/color_skins.css" rel="stylesheet">
        <link href="<?php echo ASSETS_PATH; ?>plugins/alert/css/alert.min.css" rel="stylesheet">
        <link href="<?php echo ASSETS_PATH; ?>plugins/alert/themes/default/theme.min.css" rel="stylesheet">
        <link href="<?php echo ASSETS_PATH; ?>bower_components/select2/dist/css/select2.css" rel="stylesheet">
        <link href="<?php echo ASSETS_PATH; ?>css/custom.css" rel="stylesheet">
        <link href="<?php echo ASSETS_PATH; ?>css/responsive.css" rel="stylesheet">
        <link href="<?php echo ASSETS_PATH; ?>css/owl.carousel.min.css" rel="stylesheet">
        <link href="<?php echo ASSETS_PATH; ?>custom/css/custom_dev.css" rel="stylesheet">
        <link href="<?php echo ASSETS_PATH; ?>css/perfect-scrollbar.css" rel="stylesheet">
        <script src="<?php echo ASSETS_PATH; ?>bower_components/jquery/dist/jquery.min.js"></script>
        <script type="text/javascript">
            var BASEURL = "<?php echo base_url(); ?>";
            var ASSETS_PATH = "<?php echo ASSETS_PATH; ?>";
            var UNKNOWN_WEB_ERROR = "<?php echo UNKNOWN_WEB_ERROR; ?>";
            var SITE_LOGO = "<?php echo SITE_LOGO; ?>";
            var BASE_TITLE = "<?php echo BASE_TITLE; ?>";
//            var LOGIN_EMAIL = "<?php // echo $this->session->userdata('email');  ?>";
        </script>
        <style type="text/css">.jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;box-sizing: content-box;z-index: 10000;}.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}</style>
    </head>
    <body class="theme-blue index2" data-gr-c-s-loaded="true" style="overflow: auto;">
        <section class="content" id="main-wrapper">
            <!-- Page Loader -->
            <div class="page-loader-wrapper">
                <div class="loader">
                    <div class="m-t-30"><img class="zmdi-hc-spin" src="<?php echo SITE_LOGO; ?>" alt="<?php echo WEBSITE_NAME; ?>" width="48" height="48"></div>
                    <p>Please wait...</p>
                </div>
            </div>
            <!-- Overlay For Sidebars -->
            <div class="overlay"></div>
            <!-- Top Bar -->
            <nav class="navbar p-l-5 p-r-5">
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <div class="navbar-header">
                            <a href="javascript:void(0);" class="bars" style="display: none;"></a>
                            <a class="navbar-brand" href="<?php echo base_url(); ?>"><img src="<?php echo SITE_LOGO; ?>" alt="Logo" width="50"><span class="m-l-10"><?php echo WEBSITE_NAME; ?></span></a>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- Main Content -->

