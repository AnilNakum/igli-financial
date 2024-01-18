<!-- File Input -->
<link href="<?php echo ASSETS_PATH; ?>plugins/fileinput/css/fileinput.css" media="all" rel="stylesheet"
    type="text/css" />
<link href="<?php echo ASSETS_PATH; ?>plugins/fileinput/themes/explorer-fas/theme.css" media="all" rel="stylesheet"
    type="text/css" />
<style>
    .file-caption.form-control.kv-fileinput-caption {
        height: 40px!important;
        top: 5px!important;
    } 
</style>
<!-- datetimepicker -->
<link
    href="<?php echo ASSETS_PATH; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css"
    rel="stylesheet">

<!-- select2 -->
<link href="<?php echo ASSETS_PATH; ?>bower_components/select2/dist/css/select2.css" rel="stylesheet">    

<link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH; ?>custom/css/custom.css">

<?php
if($Data) {
$FID = array('name' => 'form_id', 'id' => 'form_id', 'value' => ($Data->FID > 0) ? $Data->FID : "", 'type' => 'hidden');
$FormCode = array('name' => 'form_code', 'id' => 'form_code', 'value' => ($Data->FormCode != '') ? $Data->FormCode : "", 'type' => 'hidden');

$FormData = json_decode($Data->FormData);
}
$submit_btn = array(
    'name' => 'custom_submit',
    'id' => 'custom_submit',
    'value' => 'Submit',
    'class' => 'btn l-blue btn-round btn-lg btn-block waves-effect waves-light custom-submit',
);
$form_attr = array('class' => 'default_form custom_frm', 'id' => 'custom_frm', 'name' => 'custom_frm');
?>
<?php include 'auth_header.php';?>
<style>
#view_pass i {
    cursor: pointer;
}
</style>

<div class="row">
    <div class="col-md-8 p-0">
        <div class="login-card">
            <div class="login-main form-main">
                <div class="header">
                    <div class="logo-container">
                        <img class="img-fluid" src="<?php echo ASSETS_PATH; ?>images/igli-logo.webp" alt="">
                    </div>
                </div>
                <?php if(!$Data || $Data->Status == 2 || $Data->isDeleted == 1) {?>
                <div class="body text-center manage-list">
                    <div class="institute-box">
                        <img src="<?php echo ASSETS_PATH; ?>images/finder.png" width="50%">
                        <h6>No form right now.</h6>
                    </div>
                </div>
                <?php } else {?>
                <?php 
                echo form_open_multipart('form/submit_form', $form_attr); 
                echo form_input($FID);
                echo form_input($FormCode);
                ?>
                <h4 class="text-center form-title"><?php echo $Data->FormName;?></h4>

                <div class="sidebar-section">
                    <div class="row">
                        <div class="col-md-12 card">
                            <div class="header">
                                <h2><strong>Form</strong> Details </h2>
                            </div>
                            <?php foreach ($FormData as $i => $f) {?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label
                                            class="form-label"><?php echo $f->label; if(isset($f->required) && $f->required == 'true') {echo ' <span
                                                class="text-danger">*</span>';} if(isset($f->description)) {echo '&nbsp; <a data-original-title="'.$f->description.'" data-placement="top" data-toggle="tooltip" href="javascript:;" class="text-secondary"><i class="fa fa-info-circle"></i></a>';}?></label>
                                        <?php 
                                        if($f->type == 'text'){
                                            $Text = array('type' => (isset($f->subtype)) ? $f->subtype:'text','name' => $f->name, 'id' => $f->name, 'value' => (isset($f->value)) ? $f->value : (($f->subtype == 'color') ? '#000000' : set_value($f->name)), 'class' => $f->className, 'placeholder' => (isset($f->placeholder)) ? $f->placeholder:'','maxlength'=> (isset($f->maxlength)) ? $f->maxlength:'','autocomplete'=>false );
                                            echo form_input($Text); 
                                        }else if($f->type == 'number'){
                                            $Num = array( 'type' => 'number','name' => $f->name, 'id' => $f->name, 'value' => (isset($f->value)) ? $f->value : set_value($f->name), 'class' => $f->className, 'placeholder' => (isset($f->placeholder)) ? $f->placeholder:'','max'=> (isset($f->max)) ? $f->max:'','min'=> (isset($f->min)) ? $f->min:'','step'=> (isset($f->step)) ? $f->step:'' );
                                            echo form_input($Num); 
                                        }else if($f->type == 'date'){
                                            $Date = array( 'name' => $f->name, 'id' => $f->name, 'value' => (isset($f->value)) ? $f->value : set_value($f->name), 'class' => $f->className, 'placeholder' => (isset($f->placeholder)) ? $f->placeholder:'','style' => "cursor:pointer;" );
                                            echo form_input($Date);                                          
                                        }else if($f->type == 'date'){
                                            $Date = array( 'name' => $f->name, 'id' => $f->name, 'value' => (isset($f->value)) ? $f->value : set_value($f->name), 'class' => $f->className, 'placeholder' => (isset($f->placeholder)) ? $f->placeholder:'','style' => "cursor:pointer;" );
                                            echo form_input($Date);                                             
                                        }else if($f->type == 'textarea'){
                                            $Textarea = array( 'name' => $f->name, 'id' => $f->name, 'value' => (isset($f->value)) ? $f->value : set_value($f->name), 'class' => $f->className, 'placeholder' => (isset($f->placeholder)) ? $f->placeholder:'',"rows" => (isset($f->rows)) ? $f->rows:3,'maxlength'=> (isset($f->maxlength)) ? $f->maxlength:'' );
                                            echo form_textarea($Textarea);                                             
                                        }else if($f->type == 'file'){
                                            $Name = $f->name;
                                            $M = '';
                                            if($f->multiple == 'true'){
                                                $Name = $f->name.'[]';
                                                $M = 'multiple';
                                                echo '(<span class="text-info">Upload Multiple Files</span>)';
                                                // echo '<div class="'.$f->name.'_inputs"></div>';
                                            }
                                            echo '<div class="file-loading">
                                            <input id="'.$f->name.'" type="file" name="'.$Name.'" class="file form-control"
                                                data-browse-on-zone-click="true"
                                                data-theme="fas" '.$M.' data-show-caption="true" data-msg-placeholder="Select {files} for upload...">
                                        </div>';     
                                        }else if($f->type == 'select'){
                                            $Name = $f->name;
                                            $M = '';
                                            $Select = array( 'name' => $Name, 'id' => $f->name, 'class' => $f->className.' select2');
                                            $S=[];
                                            if(count($f->values) > 0){
                                                foreach ($f->values as $key => $value) {
                                                    $S[$value->value] = $value->label;
                                                }
                                            }
                                            $SelectList = array("" => (isset($f->placeholder)) ? $f->placeholder:'') + $S;

                                            if($f->multiple == 'true'){
                                                $Name = $f->name.'[]';
                                                echo '(<span class="text-info">Select Multiple</span>)';
                                                $Select = array( 'name' => $Name, 'id' => $f->name, 'class' => $f->className.' select2',"multiple"=>"multiple");
                                                $SelectList = $S;
                                            }
                                            
                                            echo form_dropdown($Select, $SelectList);                                          
                                        
                                        }else if($f->type == 'checkbox-group'){  
                                            if(count($f->values) > 0){
                                                echo '<div class="form-group">';
                                                foreach ($f->values as $key => $value) {                                                                          
                                                    $Inline = '';
                                                    $NewLine = '</br>';
                                                    if($f->inline == 'true'){
                                                        $Inline = 'form-check-inline'; 
                                                        $NewLine = ''; 
                                                    }
                                                    if($f->toggle == 'true'){
                                                        echo '<label class="switch"><input type="checkbox" name="'.$f->name.'[]" value="'.$value->value.'" id="'.$f->name.'-'.$value->value.'"><span class="slider round"></span> </label> <label for="'.$f->name.'-'.$value->value.'" class="form-label switch-label">
                                                        '.$value->label.'</label> &nbsp;'.$NewLine;
                                                    }else{                                                        
                                                        echo '<div class="checkbox '.$Inline.'"><input type="checkbox" name="'.$f->name.'[]" value="'.$value->value.'" id="'.$f->name.'-'.$value->value.'" class="checkbox"><label for="'.$f->name.'-'.$value->value.'" class="form-label">
                                                        '.$value->label.'</label></div>';
                                                    }                                                                   
                                                }                                                   
                                                echo '</div>';
                                            }
                                        }else if($f->type == 'radio-group'){
                                            if(count($f->values) > 0){
                                                echo '<div class="form-group">';
                                                foreach ($f->values as $key => $value) {                                                                          
                                                    $Inline = '';
                                                    if($f->inline == 'true'){
                                                        $Inline = 'inlineblock'; 
                                                    }
                                                    echo '<div class="radio '.$Inline.' m-r-20">
                                                        <input type="radio" name="'.$f->name.'"  id="'.$f->name.'-'.$value->value.'" class="with-gap" value="'.$value->value.'">
                                                        <label for="'.$f->name.'-'.$value->value.'">'.$value->label.'</label>
                                                    </div>';
                                                }
                                                echo '</div>';
                                            }                                            
                                        }else{
                                            echo '<div class="form-group">';
                                            echo '<'.$f->subtype.'>'.$f->label.'</'.$f->subtype.'>';
                                            echo '</div>';
                                        }
                                         ?>
                                    </div>
                                </div>
                            </div>
                            <?php }                            ?>
                        </div>
                    </div>
                </div>               
                <!-- <?php pr($FormData);?> -->
                <div class="form-group mb-0 mt-2 text-center">
                    <?php echo form_submit($submit_btn); ?>
                </div>

                <?php echo form_close(); ?>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card profile-greeting">
            <div class="card-body pb-0">
                <div class="media">
                    <div class="media-body">
                        <div class="greeting-user">
                            <h4 class="f-w-600 font-primary" id="greeting">Good Morning</h4>
                            <!-- <p>Here whats happening in your account today, Let's Login...</p> -->
                        </div>
                    </div>
                    <div class="badge-groups">
                        <div class="badge f-10"><i class="fa-solid fa-clock"></i> <span id="txt"></span></div>
                    </div>
                </div>
                <div class="cartoon limg"><img class="img-fluid" src="<?php echo ASSETS_PATH; ?>images/forms.png"
                        alt=""></div>
            </div>
        </div>
    </div>
</div>

</div>

<!-- Jquery Core Js -->
<script src="<?php echo ASSETS_PATH; ?>bundles/libscripts.bundle.js"></script>
<script src="<?php echo ASSETS_PATH; ?>bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->

<script src="<?php echo ASSETS_PATH; ?>plugins/momentjs/moment.js"></script>
<script
    src="<?php echo ASSETS_PATH; ?>plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js">
< script src = "<?php echo ASSETS_PATH; ?>bower_components/font-awesome/js/all.min.js" >
</script>
<script src="<?php echo ASSETS_PATH; ?>custom/js/login_form.js"></script>
<script src="<?php echo ASSETS_PATH; ?>custom/js/custom-for-all.js"></script>

<script src="<?php echo ASSETS_PATH; ?>plugins/fileinput/js/fileinput.js" type="text/javascript"></script>
<script src="<?php echo ASSETS_PATH; ?>plugins/fileinput/themes/fas/theme.js" type="text/javascript"></script>
<script src="<?php echo ASSETS_PATH; ?>plugins/fileinput/js/plugins/sortable.js" type="text/javascript"></script>


<script src="<?php echo ASSETS_PATH; ?>bower_components/select2/dist/js/select2.full.min.js"></script>


<script type = "text/javascript">

    $(document).ready(function() {
        var FileArray = [];
        if ($('[data-toggle="tooltip"]').length > 0) {
            $('[data-toggle="tooltip"]').tooltip();
        }
        var arrayFromPHP = <?php echo json_encode($FormData); ?>;
        arrayFromPHP.forEach(e => {
            if (e.type == 'date') {
                var $Formate = 'dddd DD MMMM YYYY - hh:mm A';
                if (e.subtype == 'date') {
                    $Formate = 'dddd DD MMMM YYYY';
                    date = true;
                    time = false;
                }
                if (e.subtype == 'time') {
                    $Formate = 'hh:mm A';
                    date = false;
                    time = true;
                }
                var id = "#" + e.name;
                if ($(id).length > 0) {
                    newDate = new Date();
                    maxDate = (newDate.getFullYear() + 100) + '-' + (newDate.getMonth() + 1) + '-' + newDate
                        .getDay();
                    minDate = (newDate.getFullYear() - 100) + '-' + (newDate.getMonth() + 1) + '-' + newDate
                        .getDay();

                    $(id).bootstrapMaterialDatePicker({
                        date: date,
                        time: time,
                        format: $Formate,
                        twelvehour: true,
                        clearButton: true,
                        weekStart: 1,
                        shortTime: true,
                        maxDate: (e.max) ? moment(e.max, "YYYY-MM-DD") : moment(maxDate,
                            "YYYY-MM-DD"),
                        minDate: (e.min) ? moment(e.min, "YYYY-MM-DD") : moment(minDate,
                            "YYYY-MM-DD")
                    });

                }
            }else if (e.type == 'file') {
                var $el1 = $("#" + e.name);
                console.log(BASEURL);
                $("#" + e.name).fileinput({                    
                    theme: 'fas',      
                    showUpload: false, // hide upload button
                    showRemove: true,
                    minFileCount: 1,
                    maxFileCount: 10,
                    browseOnZoneClick: true,
                    uploadExtraData: function(previewId, index) {
                        return {key: index};
                    },
                    overwriteInitial: false,
                    initialPreviewAsData: true,              
                    slugCallback: function(filename) {
                        return filename.replace('(', '_').replace(']','_');
                    }
                });               
            }else if (e.type == 'select'){
                var id = "#" + e.name;
                $(id).select2({
                    placeholder: ((e.placeholder)) ? e.placeholder:'',
                });
            }
        });

        startTime();

        var today = new Date()
        var curHr = today.getHours()

        if (curHr >= 0 && curHr < 4) {
            document.getElementById("greeting").innerHTML = 'Good Night';
        } else if (curHr >= 4 && curHr < 12) {
            document.getElementById("greeting").innerHTML = 'Good Morning';
        } else if (curHr >= 12 && curHr < 16) {
            document.getElementById("greeting").innerHTML = 'Good Afternoon';
        } else {
            document.getElementById("greeting").innerHTML = 'Good Evening';
        }

    });
// time
function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    // var s = today.getSeconds();
    var ampm = h >= 12 ? 'PM' : 'AM';
    h = h % 12;
    h = h ? h : 12;
    m = checkTime(m);
    // s = checkTime(s);
    document.getElementById('txt').innerHTML =
        h + ":" + m + ' ' + ampm;
    var t = setTimeout(startTime, 500);
}

function checkTime(i) {
    if (i < 10) {
        i = "0" + i
    }; // add zero in front of numbers < 10
    return i;
}
</script>