<?php
if (count((array) $Data) > 0) {
    $FormFiled = json_decode($Data->FormData);
}
?>
<section class="content home">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-4 col-sm-4">
                <h2><?php echo $page_title; ?>
                    <a href="javascript:void(0);"><img src="<?php echo ASSETS_PATH; ?>images/question.jpg"
                            data-toggle="tooltip" data-placement="right"
                            title="You can manage & update Forms Data." /></a>
                </h2>
            </div>
            <div class="col-lg-7 col-md-8 col-sm-8">
                <?php if ($Data && count((array) $Data->Data) > 0) {?>
                <a href="<?php echo base_url('form/export_form_data/'.encrypt($Data->FID)); ?>"
                    class="btn btn-round l-blue pull-right">Export Data <i class="fa-solid fa-file-export"></i> </a>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php echo add_edit_form(); ?>
    <?php echo half_popup(); ?>

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <?php if (count((array) $Data->Data) == 0) {?>
                    <div class="body text-center manage-list">
                        <div class="institute-box">
                            <img src="<?php echo ASSETS_PATH; ?>images/finder.png">
                            <h3>No records for this Form right now </h3>
                        </div>
                    </div>
                    <?php } else {?>
                    <div class="body">
                        <div class="setup-table-block">
                            <div class="setup-header">
                                <div class="row">
                                    <div class="col-md-3 col-sm-3">

                                    </div>
                                    <div class="col-md-9 col-sm-9">
                                        <!-- <div class="manage-rightside">
                                            <div class="form-group">
                                                <div class="manage-searchbar">
                                                    <span class="glyphicon glyphicon-search form-control-feedback">
                                                    </span>
                                                    <input class="form-control" id="search" placeholder="Search Forms"
                                                        type="search">
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="setup-content">
                                <div class="manage-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                        <!-- <table class="table table-hover common_datatable" data-control="form-builder"
                                            data-method="manage-form-data" data-id="<?php echo $Data->FID;?>"> -->
                                            <thead>
                                                <tr>
                                                <th>No.</th>
                                                <?php 
                                                foreach ($FormFiled as $key => $value) {
                                                    if($value->type != 'header' && $value->type != 'paragraph'){
                                                        echo  '<th>'.$value->label.'</th>';
                                                    }
                                                }
                                                ?>
                                                <!-- <th>Status</th> -->
                                                <th>CreatedAt</th>
                                                <th class="no-sort text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $row = 1;
                                                 foreach ($Data->Data as $list) {
                                                    echo '<tr><td>'.$row.'</td>';                                                
                                                    foreach ($FormFiled as $key => $value) {
                                                        if($value->type != 'header' && $value->type != 'paragraph'){
                                                            $Name = $value->name;
                                                            $Str = $list->$Name;
                                    
                                                            if($value->type == 'checkbox-group'){  
                                                                $Str = '';
                                                                $C = json_decode($list->$Name);
                                                                foreach ($C as $k => $v) {                        
                                                                    foreach ($value->values as $k1 => $v1) {
                                                                        if($v1->value == $v){
                                                                            $Str .= $v1->label;
                                                                            if(count($C) >= $k+2){
                                                                                $Str .= ',';
                                                                            }
                                                                        }
                                                                    }
                                                                }       
                                                            }
                                                            if($value->type == 'select'){   
                                                                $Str = '';                        
                                                                if($value->multiple == 'true'){
                                                                    $C = json_decode($list->$Name);
                                                                    foreach ($C as $k => $v) {                        
                                                                        foreach ($value->values as $k1 => $v1) {
                                                                            if($v1->value == $v){
                                                                                $Str .= $v1->label;
                                                                                if(count($C) >= $k+2){
                                                                                    $Str .= ',';
                                                                                }
                                                                            }
                                                                        }
                                                                    }                               
                                                                }else{   
                                                                    foreach ($value->values as $k1 => $v1) {
                                                                        if($v1->value == $list->$Name){
                                                                            $Str .= $v1->label;                                    
                                                                        }
                                                                    }
                                                                }
                                                            }    
                                                            if($value->type == 'radio-group'){  
                                                                $Str = '';
                                                                foreach ($value->values as $k1 => $v1) {
                                                                    if($v1->value == $list->$Name){
                                                                        $Str .= $v1->label;                                    
                                                                    }
                                                                }
                                                            }   
                                                            if($value->type == 'file'){
                                                                $Str = GetFile($list->$Name);       
                                                                // if($value->multiple == 'true'){
                                                                //     $I = json_decode($list->$Name);
                                                                //     if(is_array($I)){
                                                                //         foreach ($I as $k2 => $v2) {
                                                                //             $Str .= IMAGE_DIR . $v2.', ';
                                                                //         }
                                                                //     }
                                                                // }else{
                                                                //     $Str = IMAGE_DIR . $list->$Name;
                                                                // }
                                    
                                                            }                                    
                                                            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $Str);
                                                            // $col++;
                                                            echo '<td>'.$Str.'</td>';
                                                        }
                                                    }
                                                    // echo '<td>'.isDeleted($list->is_deleted).'</td>';
                                                    echo '<td>'.DatetimeFormat($list->created_at).'</td>';
                                                    echo '<td>'.form_data_action_row($list->id,$Data->FormCode).'</td>';
                                                    echo '</tr>';
                                                    $row++;
                                                } 
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</section>