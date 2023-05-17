<?php
$submit_btn = array('name' => 'submit_btn', 'id' => 'submit_btn', 'value' => 'SAVE', 'class' => 'btn btn-round l-cyan');
$form_attr = array('class' => 'default_form img_frm', 'id' => 'img_frm', 'name' => 'img_frm');
?>
<?php echo form_open_multipart('image/submit', $form_attr); ?>
<section class="content home">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-4 col-sm-4">
                <h2><?php echo $page_title; ?>
                    <a href="javascript:void(0);"><img src="<?php echo ASSETS_PATH; ?>images/question.jpg"
                            data-toggle="tooltip" data-placement="right" title="You can manage Images." /></a>
                </h2>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Images Upload</strong> </h2>
                    </div>
                    <div class="body">
                        <div class="form-group">
                            <div class="file-loading">
                                <input id="img" name="img" type="file" accept="image/*" multiple>
                            </div>
                            <div class="inputs"></div>
                        </div>
                        <div class="form-group">
                            <?php
echo form_submit($submit_btn);

?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>



<?php echo form_close(); ?>

<script>
$(document).ready(function() {
    var ImgArray = [];
    var $el1 = $("#img");
    $el1.fileinput({
        theme: 'fas',
        allowedFileExtensions: ['jpg', 'png', 'jpeg', 'gif'],
        uploadUrl: '<?php echo BASE_URL . 'image/upload/img'; ?>',
        uploadAsync: true,
        deleteUrl: '<?php echo BASE_URL . 'image/delete'; ?>',
        showUpload: false, // hide upload button
        showRemove: false, // hide remove button
        overwriteInitial: false, // append files to initial preview
        minFileCount: 1,
        maxFileCount: 5,
        browseOnZoneClick: true,
        initialPreviewAsData: true,
    }).on("filebatchselected", function(event, files) {
        $el1.fileinput("upload");
    }).on('fileuploaded', function(event, previewId, index, fileId) {
        // console.log('File uploaded', previewId);
        I = ImgArray.length;
        ImgArray.push(previewId.response.initialPreviewConfig[0]);
        var key = previewId.response.initialPreviewConfig[0].key;
        var caption = previewId.response.initialPreviewConfig[0].caption;
        var file_name = previewId.response.initialPreviewConfig[0].file_name;
        var size = previewId.response.initialPreviewConfig[0].size;
        var file_type = previewId.response.initialPreviewConfig[0].file_type;
        var url = previewId.response.initialPreviewConfig[0].downloadUrl;

        html = `
        <input type="hidden" name="key[${I}]" value="${key}">
        <input type="hidden" name="caption[${I}]" value="${caption}">
        <input type="hidden" name="file_name[${I}]" value="${file_name}">
        <input type="hidden" name="size[${I}]" value="${size}">
        <input type="hidden" name="file_type[${I}]" value="${file_type}">
        <input type="hidden" name="url[${I}]" value="${url}">`;
        $('.inputs').append(html);
    }).on('filesorted', function(event, params) {
        // console.log('File sorted ', params.previewId, params.oldIndex, params.newIndex, params.stack);
        $('.inputs').html('');
        html = '';
        $.each(params.stack, function(I, V) {
            var key = V.key;
            var caption = V.caption;
            var file_name = V.file_name;
            var size = V.size;
            var file_type = V.file_type;
            var url = V.downloadUrl;

            html += `
        <input type="hidden" name="key[${I}]" value="${key}">
        <input type="hidden" name="caption[${I}]" value="${caption}">
        <input type="hidden" name="file_name[${I}]" value="${file_name}">
        <input type="hidden" name="size[${I}]" value="${size}">
        <input type="hidden" name="file_type[${I}]" value="${file_type}">
        <input type="hidden" name="url[${I}]" value="${url}">`;
        });
        $('.inputs').html(html);
    }).on('filedeleted', function(event, key, jqXHR, data) {
        ImgArray.forEach((e, k) => {
            console.log(e.key);
            if (e.key == key) {
                ImgArray.splice(k, 1);
            }
        });
        var totalFilesCount = $('#img').fileinput('getFilesCount', true);
        $('.inputs').html('');
        if (totalFilesCount > 0) {
            var Files = $('#img').fileinput('getPreview');
            html = '';
            $.each(Files.config, function(I, V) {
                var key = V.key;
                var caption = V.caption;
                var file_name = V.file_name;
                var size = V.size;
                var file_type = V.file_type;
                var url = V.downloadUrl;

                html += `
        <input type="hidden" name="key[${I}]" value="${key}">
        <input type="hidden" name="caption[${I}]" value="${caption}">
        <input type="hidden" name="file_name[${I}]" value="${file_name}">
        <input type="hidden" name="size[${I}]" value="${size}">
        <input type="hidden" name="file_type[${I}]" value="${file_type}">
        <input type="hidden" name="url[${I}]" value="${url}">`;
            });
            $('.inputs').html(html);
        }
    });
});
</script>