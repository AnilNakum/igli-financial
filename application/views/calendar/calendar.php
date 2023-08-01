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
                <button class="btn btn-default btn-simple btn-round waves-effect" id="change-view-week">Week</button>
                <button class="btn btn-default btn-simple btn-round waves-effect" id="change-view-month">Month</button>
                <a href="javascript:void(0);" class="btn btn-round l-blue pull-right open_my_form"
                    data-control="calendar" data-method="add">Add New Event</a>
            </div>
        </div>
    </div>
    <?php echo add_edit_form(); ?>
    <div class="container-fluid ">
        <div class="row clearfix">
            <div class="col-md-5" id="event-data">
                <?php echo $html; ?>
            </div>
            <div class="col-md-7">
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
        defaultDate: new Date(),
        editable: false,
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
            <?php foreach ($Events as $key => $value) { ?> {
                title: '<?php echo $value->Title;?>',
                start: '<?php echo $value->DateTime;?>',
                className: 'b-l b-2x b-primary'
            },
            <?php } ?>
        ]
    });

    $(".fc-prev-button").click(function(event) {
        event.preventDefault();
        var view = $('#calendar').fullCalendar('getView');
        getEventData(view.intervalStart.format(), view.intervalEnd.format(), view.name);
    });

    $(".fc-next-button").click(function(event) {
        event.preventDefault();
        var view = $('#calendar').fullCalendar('getView');
        getEventData(view.intervalStart.format(), view.intervalEnd.format(), view.name);
    });

});
</script>