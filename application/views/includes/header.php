<!doctype html>
<html class="no-js " lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="keywords" content="IGLI FINANCIAL" />
    <meta name="site_name" content="IGLI FINANCIAL - Largest Legal Services Platform" />
    <meta name="description"
        content="Welcome to IGLI FINANCIAL IGLI FINANCIAL is the largest online business and tax compliance platform that helps Entrepreneurs and Families with various registration, tax filing, accounting and government services. Explore More   Startup India Registration The Startup India Registration is the process of registering a startup with the Government of India. LLP Registration LLP registration… Continue reading Home">

    <title>
        <?php echo WEBSITE_NAME; ?><?php echo (isset($page_title) && !empty($page_title)) ? ' - ' . $page_title : ''; ?>
    </title>
    <link rel="icon" href="<?php echo FAVICON; ?>" type="image/x-icon">
    <link href="<?php echo ASSETS_PATH; ?>plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo ASSETS_PATH; ?>bower_components/font-awesome/css/all.min.css" rel="stylesheet">
    <link
        href="<?php echo ASSETS_PATH; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css"
        rel="stylesheet">
    <link href="<?php echo ASSETS_PATH; ?>plugins/dropzone/dropzone.css" rel="stylesheet">
    <link href="<?php echo ASSETS_PATH; ?>plugins/jquery-datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="<?php echo ASSETS_PATH; ?>plugins/jquery-datatable/jquery.dataTables.min.css" rel="stylesheet">
    <link href="<?php echo ASSETS_PATH; ?>plugins/jquery-datatable/responsive.dataTables.min.css" rel="stylesheet">
    <link href="<?php echo ASSETS_PATH; ?>plugins/jquery-datatable/datatables.responsive.button.css" rel="stylesheet">
    <link href="<?php echo ASSETS_PATH; ?>plugins/ion-rangeslider/css/ion.rangeSlider.css" rel="stylesheet">
    <link href="<?php echo ASSETS_PATH; ?>plugins/ion-rangeslider/css/ion.rangeSlider.skinFlat.css" rel="stylesheet">
    <link href="<?php echo ASSETS_PATH; ?>plugins/sweetalert/sweetalert.css" rel="stylesheet" />
    <link href="<?php echo ASSETS_PATH; ?>plugins/sweetalert/sweetalert2.min.css" rel="stylesheet" />
    <link href="<?php echo ASSETS_PATH; ?>/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">

    <!-- File Input-->
    <link href="<?php echo ASSETS_PATH; ?>plugins/fileinput/css/fileinput.css" media="all" rel="stylesheet"
        type="text/css" />
    <link href="<?php echo ASSETS_PATH; ?>plugins/fileinput/themes/explorer-fas/theme.css" media="all" rel="stylesheet"
        type="text/css" />


    <style>
    .file-caption.form-control.kv-fileinput-caption {
        height: 40px !important;
        top: 5px !important;
    }
    </style>

    <!-- Custom Css -->
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/main.css">
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/chatapp.css">
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/ecommerce.css">
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/color_skins.css">

    <link href="<?php echo ASSETS_PATH; ?>plugins/alert/css/alert.min.css" rel="stylesheet">
    <link href="<?php echo ASSETS_PATH; ?>plugins/alert/themes/default/theme.min.css" rel="stylesheet">
    <link href="<?php echo ASSETS_PATH; ?>bower_components/select2/dist/css/select2.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH; ?>custom/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH; ?>custom/css/custom.css">

    <!-- <link href="<?php //echo ASSETS_PATH;
?>custom/css/custom_dev.css" rel="stylesheet"> -->
    <link href="<?php echo ASSETS_PATH; ?>css/responsive.css" rel="stylesheet">

    <script src="<?php echo ASSETS_PATH; ?>bower_components/jquery/dist/jquery.min.js"></script>


    <script type="text/javascript">
    var BASEURL = "<?php echo base_url(); ?>";
    var ASSETS_PATH = "<?php echo ASSETS_PATH; ?>";
    var UNKNOWN_WEB_ERROR = "<?php echo UNKNOWN_WEB_ERROR; ?>";
    var SITE_LOGO = "<?php echo SITE_LOGO; ?>";
    var BASE_TITLE = "<?php echo BASE_TITLE; ?>";
    var LOGIN_EMAIL = "<?php echo $this->session->userdata('email'); ?>";
    var LOGIN_USERNAME = "<?php echo $this->session->userdata('fullname'); ?>";
    </script>

    <style type="text/css">
    .jqstooltip {
        position: absolute;
        left: 0px;
        top: 0px;
        visibility: hidden;
        background: rgb(0, 0, 0) transparent;
        background-color: rgba(0, 0, 0, 0.6);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);
        -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";
        color: white;
        font: 10px arial, san serif;
        text-align: left;
        white-space: nowrap;
        padding: 5px;
        border: 1px solid white;
        box-sizing: content-box;
        z-index: 10000;
    }

    .jqsfield {
        color: white;
        font: 10px arial, san serif;
        text-align: left;
    }
    </style>
</head>

<body class="theme-blue <?php if ($this->uri->segment(1) == 'setup') {
    echo 'ls-toggle-menu';
}?>">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30"><img class="" src="<?php echo ASSETS_PATH; ?>images/favicon.png" width="48" height="48"
                    alt="IGLI Financial"></div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>

    <!-- Top Bar -->
    <nav class="navbar">
        <div class="col-12">
            <div class="navbar-header">
                <?php if ($this->uri->segment(1) != 'setup') {?>
                <a href="javascript:void(0);" class="bars"></a>
                <?php }
?>
                <a class="navbar-brand" href="<?php echo base_url(); ?>"><img
                        src="<?php echo ASSETS_PATH; ?>images/favicon.png" width="30" alt="IGLI Financial"><span
                        class="m-l-10"><?php echo WEBSITE_NAME; ?></span></a>
            </div>
            <ul class="nav navbar-nav navbar-left">
                <?php if ($this->uri->segment(1) != 'setup') {
    ?>
                <li><a href="javascript:void(0);" class="ls-toggle-btn" data-close="true"><i
                            class="zmdi zmdi-swap"></i></a></li>
                <?php }
?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <!-- <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"
                        role="button"><i class="zmdi zmdi-notifications"></i>
                        <div class="notify"><span class="heartbit"></span><span class="point"></span></div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right slideDown">
                        <li class="header">NOTIFICATIONS</li>
                        <li class="body">
                            <ul class="menu list-unstyled">
                                <li> <a href="javascript:void(0);">
                                        <div class="icon-circle bg-blue"><i class="zmdi zmdi-account"></i></div>
                                        <div class="menu-info">
                                            <h4>8 New Members joined</h4>
                                            <p><i class="zmdi zmdi-time"></i> 14 mins ago </p>
                                        </div>
                                    </a> </li>
                                <li> <a href="javascript:void(0);">
                                        <div class="icon-circle bg-amber"><i class="zmdi zmdi-shopping-cart"></i></div>
                                        <div class="menu-info">
                                            <h4>4 Sales made</h4>
                                            <p> <i class="zmdi zmdi-time"></i> 22 mins ago </p>
                                        </div>
                                    </a> </li>
                                <li> <a href="javascript:void(0);">
                                        <div class="icon-circle bg-red"><i class="zmdi zmdi-delete"></i></div>
                                        <div class="menu-info">
                                            <h4><b>Nancy Doe</b> Deleted account</h4>
                                            <p> <i class="zmdi zmdi-time"></i> 3 hours ago </p>
                                        </div>
                                    </a> </li>
                                <li> <a href="javascript:void(0);">
                                        <div class="icon-circle bg-green"><i class="zmdi zmdi-edit"></i></div>
                                        <div class="menu-info">
                                            <h4><b>Nancy</b> Changed name</h4>
                                            <p> <i class="zmdi zmdi-time"></i> 2 hours ago </p>
                                        </div>
                                    </a> </li>
                                <li> <a href="javascript:void(0);">
                                        <div class="icon-circle bg-grey"><i class="zmdi zmdi-comment-text"></i></div>
                                        <div class="menu-info">
                                            <h4><b>John</b> Commented your post</h4>
                                            <p> <i class="zmdi zmdi-time"></i> 4 hours ago </p>
                                        </div>
                                    </a> </li>
                                <li> <a href="javascript:void(0);">
                                        <div class="icon-circle bg-purple"><i class="zmdi zmdi-refresh"></i></div>
                                        <div class="menu-info">
                                            <h4><b>John</b> Updated status</h4>
                                            <p> <i class="zmdi zmdi-time"></i> 3 hours ago </p>
                                        </div>
                                    </a> </li>
                                <li> <a href="javascript:void(0);">
                                        <div class="icon-circle bg-light-blue"><i class="zmdi zmdi-settings"></i></div>
                                        <div class="menu-info">
                                            <h4>Settings Updated</h4>
                                            <p> <i class="zmdi zmdi-time"></i> Yesterday </p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"> <a href="javascript:void(0);">View All Notifications</a> </li>
                    </ul>
                </li> -->
                <li>
                    <a href="javascript:void(0);" class="fullscreen hidden-sm-down" data-provide="fullscreen"
                        data-close="true"><i class="zmdi zmdi-fullscreen"></i></a>
                </li>
                <li class=""><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"
                        role="button"><i class="zmdi zmdi-settings zmdi-hc-spin"></i></a>
                    <ul class="dropdown-menu dropdown-menu-right slideDown user-right-menu">
                        <li class="">
                            <ul class="menu list-unstyled">
                                <li> <a href="<?php echo base_url('auth/change_password'); ?>">
                                        <div class="icon-circle bg-blue"><i class="zmdi zmdi-lock"></i></div>
                                        <div class="menu-info">
                                            <h4>Change Password</h4>
                                        </div>
                                    </a>
                                </li>
                                <li> <a href="<?php echo base_url('auth/logout'); ?>">
                                        <div class="icon-circle bg-red"><i class="zmdi zmdi-power"></i></div>
                                        <div class="menu-info">
                                            <h4>Log Out</h4>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>

    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <div class="menu">
            <ul class="list">
                <li>
                    <div class="user-info">
                        <div class="image"><a href="javascript:;" class="waves-effect waves-block"
                                id="profileImage"></a>
                        </div>
                        <div class="detail">
                            <h4><?php echo $login_username; ?></h4>
                            <small><?php echo $userData->email;?></small><br>
                            <small><?php echo $userData->phone;?></small>
                        </div>
                        <a href="<?php echo base_url(); ?>" title="Profile"><i
                                class="fa-regular fa-address-card"></i></a>
                        <!-- <a href="<?php echo base_url(); ?>" title="Inbox"><i class="fa-regular fa-message"></i></a> -->
                        <a href="<?php echo base_url('auth/logout'); ?>" title="Sign out"><i
                                class="zmdi zmdi-power"></i></a>
                    </div>
                </li>
                <li class="header">MAIN</li>
                <li
                    class="<?php echo (($this->uri->segment(1) == "dashboard") || ($this->uri->segment(1) == "")) ? 'active' : ""; ?>">
                    <a href="<?php echo base_url(); ?>"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a>
                </li>
                
                <?php if(ROLE == 1){?>
                <li class="header">Services</li>
                <li> <a href="javascript:void(0);"
                        class="menu-toggle <?php echo (($this->uri->segment(1) == "services" && $this->uri->segment(2) == "")|| ($this->uri->segment(1) == "type") || ($this->uri->segment(1) == "top-services")) ? 'active toggled' : ""; ?>"><i
                            class="zmdi zmdi-apps"></i><span>Services</span>
                    </a>
                    <ul class="ml-menu">
                    <!-- <?php if(ROLE == 1){?>
                        <li class="<?php echo ($this->uri->segment(1) == "type") ? 'active' : ""; ?>"><a
                                href="<?php echo base_url('type'); ?>">Services Type</a></li>
                                <?php } ?> -->
                        <li
                            class="<?php echo ($this->uri->segment(1) == "services" && $this->uri->segment(2) == "") ? 'active' : ""; ?>">
                            <a href="<?php echo base_url('services'); ?>">Services</a></li>
                            
                        <!-- <li class="<?php echo ($this->uri->segment(1) == "top-services") ? 'active' : ""; ?>"><a
                                href="<?php echo base_url('top-services'); ?>">Our Top Services</a></li> -->
                            </ul>
                        </li>
                        <?php } ?>
               
                <li class="header">User Services</li>
                <li class="<?php echo (($this->uri->segment(2) == "ongoing") ) ? 'active' : ""; ?>">
                    <a href="<?php echo base_url('services/ongoing'); ?>"><i
                            class="fa-solid fa-circle-play"></i><span>On Going</span></a>
                </li>
                <li class="<?php echo (($this->uri->segment(2) == "onhold") ) ? 'active' : ""; ?>">
                    <a href="<?php echo base_url('services/onhold'); ?>"><i
                            class="fa-solid fa-circle-pause"></i><span>Hold</span></a>
                </li>
                <li class="<?php echo (($this->uri->segment(2) == "completed") ) ? 'active' : ""; ?>">
                    <a href="<?php echo base_url('services/completed'); ?>"><i
                            class="fa-solid fa-circle-check"></i><span>Completed</span></a>
                </li>
                <?php if(ROLE == 1){?>
                <li class="<?php echo (($this->uri->segment(1) == "service-users") ) ? 'active' : ""; ?>">
                    <a href="<?php echo base_url('service-users'); ?>"><i class="fa-solid fa-circle-user"></i><span>By SubAdmin</span></a>
                </li>
<?php } ?>
<li class="<?php echo (($this->uri->segment(1) == "task") ) ? 'active' : ""; ?>">
                    <a href="<?php echo base_url('task'); ?>"><i class="fa-solid fa-list-check"></i><span>Service Task</span></a>
                </li>
                <li class="header">Document Upload </li>
                <li class="<?php echo (($this->uri->segment(1) == "upload")) ? 'active' : ""; ?>"> <a
                        href="<?php echo base_url('upload'); ?>"><i class="fa-solid fa-cloud-arrow-up"></i><span>Upload
                        </span></a>
                </li>
                <?php if(ROLE == 1){?>
                <li class="header">PAYMENT</li>
                <li class="<?php echo (($this->uri->segment(1) == "user-payment")) ? 'active' : ""; ?>"> <a
                        href="<?php echo base_url('user-payment'); ?>"><i class="fa-solid fa-receipt"></i><span>Payment
                        </span></a>
                </li>
                <li class="<?php echo (($this->uri->segment(1) == "ccavenue_payment")) ? 'active' : ""; ?>"> <a
                        href="<?php echo base_url('ccavenue_payment'); ?>"><i class="fa-solid fa-receipt"></i><span>Ccavenue Payment
                        </span></a>
                </li>

                <li class="header">OTHERS</li>
                <li class="<?php echo (($this->uri->segment(1) == "user")) ? 'active' : ""; ?>"> <a
                        href="<?php echo base_url('user'); ?>"><i class="zmdi zmdi-accounts"></i><span>Users</span></a>
                </li>
                <li class="<?php echo (($this->uri->segment(1) == "subadmin")) ? 'active' : ""; ?>"> <a
                        href="<?php echo base_url('subadmin'); ?>"><i class="fa-solid fa-user-tie"></i><span>Sub Admin
                        </span></a>
                </li>
                <li class="<?php echo (($this->uri->segment(1) == "calendar")) ? 'active' : ""; ?>"> <a
                        href="<?php echo base_url('calendar'); ?>"><i class="zmdi zmdi-calendar"></i><span>Compliance Calendar</span></a>
                </li>
                <li class="<?php echo (($this->uri->segment(1) == "contact_support")) ? 'active' : ""; ?>"> <a
                        href="<?php echo base_url('contact_support'); ?>"><i class="fa-solid fa-inbox"></i><span>Contact
                            Support</span></a>
                </li>
                <li class="<?php echo (($this->uri->segment(1) == "notification")) ? 'active' : ""; ?>"> <a
                        href="<?php echo base_url('notification'); ?>"><i
                            class="fa-regular fa-bell"></i><span>Notification
                        </span></a>
                </li>
                <li class="<?php echo (($this->uri->segment(1) == "banner")) ? 'active' : ""; ?>"> <a
                        href="<?php echo base_url('banner'); ?>"><i class="fa-solid fa-images"></i><span>App Banners
                        </span></a>
                </li>
                <li class="<?php echo (($this->uri->segment(1) == "pages")) ? 'active' : ""; ?>"> <a
                        href="<?php echo base_url('pages'); ?>"><i class="fa-solid fa-file-lines"></i><span>App Help Pages
                        </span></a>
                </li>
                <li class="<?php echo (($this->uri->segment(1) == "form-builder-form") || ($this->uri->segment(1) == "form-builder")) ? 'active' : ""; ?>"> <a
                        href="<?php echo base_url('form-builder'); ?>"><i class="fa-brands fa-wpforms"></i><span>IGLI Form Builder
                        </span></a>
                </li>
                <?php }else{?>
                <li class="header">OTHERS</li>
                <!-- <li class="<?php echo (($this->uri->segment(1) == "user")) ? 'active' : ""; ?>"> <a
                        href="<?php echo base_url('user'); ?>"><i class="zmdi zmdi-accounts"></i><span>Users</span></a>
                </li> -->
                <li class="<?php echo (($this->uri->segment(1) == "form-builder-form") || ($this->uri->segment(1) == "form-builder")) ? 'active' : ""; ?>"> <a
                        href="<?php echo base_url('form-builder'); ?>"><i class="fa-brands fa-wpforms"></i><span>IGLI Form Builder
                        </span></a>
                </li>
                <?php } ?>
                <!-- <li> <a href="javascript:void(0);"
                        class="menu-toggle <?php echo (($this->uri->segment(1) == "banner") || ($this->uri->segment(1) == "setting")) ? 'active toggled' : ""; ?>"><i
                            class="zmdi zmdi-swap-alt"></i><span>Settings</span> </a>
                    <ul class="ml-menu">
                        <li class="<?php echo ($this->uri->segment(1) == "setting") ? 'active' : ""; ?>"> <a
                                href="<?php echo base_url('setting'); ?>">General</a> </li>
                        <li class="<?php echo ($this->uri->segment(1) == "banner") ? 'active' : ""; ?>"> <a
                                href="<?php echo base_url('banner'); ?>">Banners</a> </li>
                    </ul>
                </li> -->
            </ul>
        </div>
    </aside>