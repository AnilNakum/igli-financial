<div class="body">
    <?php if (count((array) $Events) == 0) {?>
    <div class="body text-center manage-list">
        <div class="institute-box">
            <img src="<?php echo ASSETS_PATH; ?>images/finder.png">
            <h3>No records for Events right now <br /> Please add new</h3>
            <a href="javascript:void(0);" class="open_my_form" data-control="calendar" data-method="add"><img
                    class="add-btn" src="<?php echo ASSETS_PATH; ?>images/btn.png"></a>
        </div>
    </div>
    <?php } else {
                        foreach ($Events as $key => $value) {?>
    <div class="event-name b-primary row">
        <div class="col-2 text-center">
            <h4><?php echo date("d", strtotime($value->DateTime));?><span><?php echo date("F", strtotime($value->DateTime));?></span><span><?php echo date("Y", strtotime($value->DateTime));?></span>
            </h4>
        </div>
        <div class="col-8">
            <h6><?php echo $value->Title;?></h6>
            <p><?php echo $value->Description;?></p>
            <address class="text-info"><i class="zmdi zmdi-time"></i>
                <?php echo date('h:i A', strtotime($value->DateTime));?></address>
        </div>
        <div class="col-2 tooltip-top text-center">
            <a data-original-title="Update Event" data-placement="top" data-toggle="tooltip" href="javascript:;"
                class="btn btn-xs l-blue  btn-equal btn-sm btn-edit btn-mini open_my_form"
                data-id="<?php echo encrypt($value->ID);?>" data-control="calendar" data-method="update"><i
                    class="fas fa-pencil-alt"></i></a>
            <a data-original-title="Remove Event" data-placement="top" data-toggle="tooltip" href="javascript:;"
                class="btn btn-xs btn-danger btn-equal btn-mini btn-sm delete_btn"
                data-id="<?php echo encrypt($value->ID);?>" data-control="remove" data-method="event"><i
                    class="far fa-trash-alt"></i></a>
        </div>
    </div>
    <br>
    <?php } } ?>
</div>

<script>
    $(document).ready(function() {
        $('#calendar').fullCalendar('removeEvents');
        var newEvents = [
            <?php foreach ($Events as $key => $value) { ?> {
                title: '<?php echo $value->Title;?>',
                start: '<?php echo $value->DateTime;?>',
                className: 'b-l b-2x b-primary'
            },
            <?php } ?>
        ]
    $('#calendar').fullCalendar('addEventSource', newEvents);
    });
</script>