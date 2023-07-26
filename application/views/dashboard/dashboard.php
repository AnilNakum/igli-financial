<section class="content home">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>IGLI Dashboard
                    <small class="text-muted">Welcome to IGLI Financial</small>
                </h2>
            </div>

        </div>
    </div>
    <div class="container-fluid">
        <!-- <div class="col-lg-12 col-md-12">
                <div class="not-found">
                    <img src="<?php echo ASSETS_PATH; ?>images/work-in-progress.png" alt="">
                </div>
                <center>
                    <h2>Coming Soon...</h2>
                </center>
            </div> -->
        <div class="row clearfix">
            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Total</strong> Services</h2>
                    </div>
                    <div class="body text-center">
                        <h3 class="m-b-0 "><img src="<?php echo ASSETS_PATH; ?>images/favicon.png" width="30"
                                alt="IGLI Financial"> <?php echo $Services;?></h3>
                        <span><a href="<?php echo base_url('services'); ?>">View all </a></span>
                    </div>
                </div>
                <div class="card">
                    <div class="header">
                        <h2><strong>User</strong> Services By Status</h2>
                    </div>
                    <div class="body">
                        <div id="donut_chart" class="dashboard-donut-chart"></div>
                        <ul class="row profile_state list-unstyled">
                            <li class="col-lg-4 col-md-4 col-6">
                                <div class="body">
                                    <i class="fa-solid fa-circle-play col-blue"></i>
                                    <h4><?php echo $Ongoing;?></h4>
                                    <span><a href="<?php echo base_url('services/ongoing'); ?>">On Going</a></span>
                                </div>
                            </li>
                            <li class="col-lg-4 col-md-4 col-6">
                                <div class="body">
                                    <i class="fa-solid fa-circle-pause col-red"></i>
                                    <h4><?php echo $Onhold;?></h4>
                                    <span><a href="<?php echo base_url('services/onhold'); ?>"> On Hold </a></span>
                                </div>
                            </li>
                            <li class="col-lg-4 col-md-4 col-6">
                                <div class="body">
                                    <i class="fa-solid fa-circle-check col-green"></i>
                                    <h4><?php echo $Completed;?></h4>
                                    <span><a href="<?php echo base_url('services/completed'); ?>">Completed </a></span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
            <?php if(ROLE == 1){?>
                <div class="card">
                    <div class="header">
                        <h2><strong>Total</strong> Sub Admins</h2>
                    </div>
                    <div class="body text-center">
                        <h3 class="m-b-0"><i class="fa-solid fa-user-tie"></i> <?php echo $SubAdmin;?></h3>
                        <span><a href="<?php echo base_url('subadmin'); ?>"> View all </a></span>
                    </div>
                </div>
                <div class="card">
                    <div class="header">

                        <h2><strong>Total</strong> Contact Request</h2>
                    </div>
                    <div class="body text-center">
                        <h3 class="m-b-0"><i class="fa-solid fa-inbox"></i> <?php echo $Contact;?></h3>
                        <span><a href="<?php echo base_url('contact_support'); ?>"> View all </a></span>
                    </div>
                </div>
            <?php } ?>
            </div>
            <div class="col-lg-4 col-md-6">
            <?php if(ROLE == 1){?>
                <div class="card">
                    <div class="header">
                        <h2><strong>Total</strong> Active Users</h2>
                    </div>
                    <div class="body text-center">
                        <h3 class="m-b-0"><i class="fa-solid fa-users"></i> <?php echo $Users;?></h3>
                        <span><a href="<?php echo base_url('user'); ?>"> View all </a></span>
                    </div>
                </div>
                <div class="card">
                    <div class="header">
                        <h2><strong>Total</strong> Compliance Calendar</h2>
                    </div>
                    <div class="body text-center">
                        <h3 class="m-b-0"><i class="fa-solid fa-calendar-day"></i> <?php echo $Event;?></h3>
                        <span><a href="<?php echo base_url('calendar'); ?>"> View all </a></span>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
    Morris.Donut({
        element: 'donut_chart',
        data: [{
            label: 'On Going',
            value: <?php echo $Ongoing;?>
        }, {
            label: 'On Hold',
            value: <?php echo $Onhold;?>
        }, {
            label: 'Completed',
            value: <?php echo $Completed;?>
        }],
        colors: ['#457fca', '#ec3b57', '#78b83e'],
        formatter: function(y) {
            return y
        }
    });
});
</script>