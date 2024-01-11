<?php
if (isset($form_info) && $form_info->FID > 0) {
    $FID = array('name' => 'id', 'id' => 'id', 'value' => ($form_info->FID > 0) ? $form_info->FID : "", 'type' => 'hidden');
    $FormName= $form_info->FormName;
    $FormCode= $form_info->FormCode;
    $FormData = json_decode($form_info->FormData);

}

$cancel_btn = array('name' => 'cancel_btn', 'id' => 'cancel_btn', 'content' => 'CLOSE', 'class' => 'btn btn-round btn-white', "onclick" => "pop_up.half_close()");
?>


<div class="popup_body_area">
    <header id="sidebar-header">
        <div class="sidebar-header">
            <div class="sidebar-header-content">
                <h3><?php echo $page_title; ?></h3>
                <a href="javascript:;" onclick="pop_up.half_close()"><i class="fa fa-times"></i></a>
            </div>
        </div>
    </header>
    <section id="sidebar-section">
        <div class="sidebar-section">
            <?php echo validation_errors(); 
             if (isset($form_info) && $form_info->FID > 0) {
                echo form_input($FID);
            }
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label"><b> Form Name :</b> <?php echo $FormName; ?></label>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><b> Form Code :</b> <?php echo $FormCode; ?></label>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><b> Form Preview :</b></label>
                    </div>
                    <div class="form-card sidebar-section">
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
                                            }
                                            echo '<div class="file-loading">
                                            <input id="'.$f->name.'" type="file" name="'.$Name.'" class="file form-control"
                                                data-upload-url="#" data-browse-on-zone-click="true"
                                                data-overwrite-initial="true" data-theme="fas" '.$M.' data-show-caption="true" data-msg-placeholder="Select {files} for upload...">
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
                </div>
            </div>

        </div>
    </section>
    <footer id="sidebar-footer">
        <div class="sidebar-footer">
            <div class="side-footer-button">
                <div class="form-group">
                    <?php
echo form_button($cancel_btn);
?>
                </div>
            </div>
        </div>
    </footer>
</div>

<script>
$(document).ready(function() {
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
                var id = "#" + e.name;
                $(id).fileinput({
                    theme: 'fas',
                    autoReplace: false,
                    maxFileCount: 10,
                    overwriteInitial: true,
                    initialPreviewAsData: true,
                    slugCallback: function(filename) {
                        return filename.replace('(', '_').replace(']',
                            '_');
                    },
                });
            }else if (e.type == 'select'){
                var id = "#" + e.name;
                $(id).select2({
                    placeholder: ((e.placeholder)) ? e.placeholder:'',
                });
            }
        });
});
</script>