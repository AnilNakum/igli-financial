<script src="<?php echo ASSETS_PATH; ?>custom/js/form-builder.min.js"></script>
<section class="content home">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2><?php echo $page_title; ?>
                    <a href="javascript:void(0);"><img src="<?php echo ASSETS_PATH; ?>images/question.jpg"
                            data-toggle="tooltip" data-placement="right" title="You can manage form builder." /></a>
                </h2>
            </div>

        </div>
    </div>
    <div class="container-fluid">
        <div id="fb-editor"></div>
    </div>
</section>

<script>
jQuery(function($) {
    var options = {
        controlPosition: 'left',
        disableFields: ['autocomplete', 'button', 'hidden'],
        showActionButtons: false,
        controlOrder: [
            'header',
            'text',
            'number',
            'date',
            'textarea',
            'file',
            'select',
            'checkbox-group',
            'radio-group'
        ],
    };
    $(document.getElementById('fb-editor')).formBuilder(options);
});
</script>