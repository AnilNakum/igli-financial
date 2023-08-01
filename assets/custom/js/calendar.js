"use strict";
// Hide default header
//$('.fc-header').hide();

// Previous month action
$('#cal-prev').on('click', function () {
    $('#calendar').fullCalendar('prev');
});

// Next month action
$('#cal-next').on('click', function () {
    $('#calendar').fullCalendar('next');
});

// Change to month view
$('#change-view-month').on('click', function () {
    $('#calendar').fullCalendar('changeView', 'month');
    var view = $('#calendar').fullCalendar('getView');
    getEventData(view.intervalStart.format(), view.intervalEnd.format(), view.name);

    // safari fix
    $('#content .main').fadeOut(0, function () {
        setTimeout(function () {
            $('#content .main').css({ 'display': 'table' });
        }, 0);
    });

});

// Change to week view
$('#change-view-week').on('click', function () {
    $('#calendar').fullCalendar('changeView', 'agendaWeek');
    var view = $('#calendar').fullCalendar('getView');
    getEventData(view.intervalStart.format(), view.intervalEnd.format(), view.name);

    // safari fix
    $('#content .main').fadeOut(0, function () {
        setTimeout(function () {
            $('#content .main').css({ 'display': 'table' });
        }, 0);
    });

});

// Change to day view
$('#change-view-day').on('click', function () {
    $('#calendar').fullCalendar('changeView', 'agendaDay');
    var view = $('#calendar').fullCalendar('getView');

    getEventData(view.intervalStart.format(), view.intervalEnd.format(), view.name);
    // safari fix
    $('#content .main').fadeOut(0, function () {
        setTimeout(function () {
            $('#content .main').css({ 'display': 'table' });
        }, 0);
    });

});

// Change to today view
$('#change-view-today').on('click', function () {
    $('#calendar').fullCalendar('today');
    var view = $('#calendar').fullCalendar('getView');
    getEventData(view.intervalStart.format(), view.intervalEnd.format(), view.name);
});

