<link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>custom/css/fullcalendar.min.css">
<section class="content page-calendar">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-4 col-sm-4">
                <h2><?php echo $page_title; ?>
                    <a href="javascript:void(0);"><img src="<?php echo ASSETS_PATH; ?>images/question.jpg"
                            data-toggle="tooltip" data-placement="right"
                            title="You can manage & add/update Event." /></a>
                </h2>
            </div>
            <div class="col-lg-7 col-md-8 col-sm-8">
                <button class="btn btn-primary btn-round waves-effect" id="change-view-today">Today</button>
                    <button class="btn btn-default btn-simple btn-round waves-effect" id="change-view-day">Day</button>
                    <button class="btn btn-default btn-simple btn-round waves-effect"
                        id="change-view-week">Week</button>
                    <button class="btn btn-default btn-simple btn-round waves-effect"
                        id="change-view-month">Month</button>
                <a href="javascript:void(0);" class="btn btn-round l-blue pull-right open_my_form" data-control="calendar"
                    data-method="add">Add New Event</a>
            </div>
        </div>
    </div>
    <?php echo add_edit_form(); ?>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-md-12 col-lg-4 col-xl-4">
                <div class="body">
                    <div class="event-name b-primary row">
                        <div class="col-2 text-center">
                            <h4>11<span>Dec</span><span>2017</span></h4>
                        </div>
                        <div class="col-10">
                            <h6>Conference</h6>
                            <p>It is a long established fact that a reader will be distracted</p>
                            <address><i class="zmdi zmdi-pin"></i> 123 6th St. Melbourne, FL 32904</address>
                        </div>
                    </div>
                    <div class="event-name b-primary row">
                        <div class="col-2 text-center">
                            <h4>13<span>Dec</span><span>2017</span></h4>
                        </div>
                        <div class="col-10">
                            <h6>Birthday</h6>
                            <p>It is a long established fact that a reader will be distracted</p>
                            <address><i class="zmdi zmdi-pin"></i> 123 6th St. Melbourne, FL 32904</address>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="col-md-12 col-lg-8 col-xl-8">
                <div class="body">
                    
                    <div id="calendar" class="m-t-20"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
$(document).ready(function() {
    $('#calendar').fullCalendar({
        header: {
            left: 'prev',
            center: 'title',
            right: 'next'
        },
        defaultDate: '2017-12-12',
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar
        drop: function() {
            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {
                // if so, remove the element from the "Draggable Events" list
                $(this).remove();
            }
        },
        eventLimit: true, // allow "more" link when too many events
        events: [
            {
                title: 'All Day Event',
                start: '2017-11-01',
                className: 'b-l b-2x b-greensea'
            },
            {
                title: 'Long Event',
                start: '2017-12-07',
                end: '2017-12-10',
                className: 'bg-cyan'
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: '2017-12-09T16:00:00',
                className: 'b-l b-2x b-lightred'
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: '2017-12-16T16:00:00',
                className: 'b-l b-2x b-success'
            },
            {
                title: 'Conference',
                start: '2017-12-11',
                end: '2017-12-13',
                className: 'b-l b-2x b-primary'
            },
            {
                title: 'Meeting',
                start: '2017-12-12T10:30:00',
                end: '2017-12-12T12:30:00',
                className: 'b-l b-2x b-amethyst'
            },
            {
                title: 'Lunch',
                start: '2017-12-12T12:00:00',
                className: 'b-l b-2x b-primary'
            },
            {
                title: 'Meeting',
                start: '2017-12-12T14:30:00',
                className: 'b-l b-2x b-drank'
            },
            {
                title: 'Happy Hour',
                start: '2017-12-12T17:30:00',
                className: 'b-l b-2x b-lightred'
            },
            {
                title: 'Dinner',
                start: '2017-12-12T20:00:00',
                className: 'b-l b-2x b-amethyst'
            },
            {
                title: 'Birthday Party',
                start: '2017-12-13T07:00:00',
                className: 'b-l b-2x b-primary'
            },
            {
                title: 'Click for Google',
                url: 'http://google.com/',
                start: '2017-12-28',
                className: 'b-l b-2x b-greensea'
            }
        ]
    });
});
</script>