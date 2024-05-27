<?php

/*
 * This Helper Use Only DataTables Action Row Function
 */

function Status($status)
{
    if ($status == 1) {
        $return = <<<EOF
        <span class="text text-success badge badge-success m-l-10 hidden-sm-down">Active</span>
EOF;
    } else {
        $return = <<<EOF
        <span class="text text-danger badge badge-danger m-l-10 hidden-sm-down">Inactive</span>
EOF;
    }
    return $return;
}

function isDeleted($status)
{
    if ($status == 1) {
        $return = <<<EOF
        <span class="text text-danger badge badge-danger m-l-10 hidden-sm-down">Deleted</span>
        EOF;
    } else {
        $return = <<<EOF
        <span class="text text-success badge badge-success m-l-10 hidden-sm-down">Active</span>
EOF;
    }
    return $return;
}

function PaymentStatus($status)
{
    if ($status == 'completed') {
        $return = <<<EOF
        <span class="text text-success badge badge-success m-l-10 hidden-sm-down">Completed</span>
EOF;
    } else {
        $return = <<<EOF
        <span class="text text-warning badge badge-warning m-l-10 hidden-sm-down">Pending</span>
EOF;
    }
    return $return;
}
function CCPaymentStatus($status)
{
    if ($status == 'Success') {
        $return = <<<EOF
        <span class="text text-success badge badge-success m-l-10 hidden-sm-down">Success</span>
EOF;
    } 
    else if ($status == 'Invalid') {
        $return = <<<EOF
        <span class="text text-danger badge badge-danger m-l-10 hidden-sm-down">Invalid</span>
EOF;
    } 
    else if ($status == 'Timeout') {
        $return = <<<EOF
        <span class="text text-secondary badge badge-secondary m-l-10 hidden-sm-down">Timeout</span>
EOF;
    } 
    else if ($status == 'Awaited') {
        $return = <<<EOF
        <span class="text text-info badge badge-info m-l-10 hidden-sm-down">Awaited</span>
EOF;
    } 
    else if ($status == 'Aborted') {
        $return = <<<EOF
        <span class="text text-secondary badge badge-secondary m-l-10 hidden-sm-down">Aborted</span>
EOF;
    } 
    else if ($status == 'Failure') {
        $return = <<<EOF
        <span class="text text-danger badge badge-danger m-l-10 hidden-sm-down">Failure</span>
EOF;
    } 
    else {
        $return = <<<EOF
        <span class="text text-warning badge badge-warning m-l-10 hidden-sm-down">Pending</span>
EOF;
    }
    return $return;
}

function PStatus($status)
{
    if ($status == 'onhold') {
        $return = 'On Hold';
    } else if ($status == 'completed') {
        $return ='Completed';
    } else if($status == 'pending'){
        $return ='Pending';
    } else {
        $return ='On Going';
    }
    return $return;
}


function ContactStatus($status)
{
    if ($status == '2') {
        $return = <<<EOF
        <span class="text text-info"><i class="fa-solid fa-envelope-open-text"></i> Viewed</span>
EOF;
    } else if ($status == '3') {
        $return = <<<EOF
        <span class="text text-success"><i class="zmdi zmdi-check-circle"></i> Colsed</span>
EOF;
    } else {
        $return = <<<EOF
        <span class="text text-warning"><i class="zmdi zmdi-time-interval"></i> Waiting For Responce</span>
EOF;
    }
    return $return;
}

function ServiceStatus($status)
{
    if ($status == 'onhold') {
        $return = <<<EOF
        <span class="text text-warning "><i class="fa-solid fa-circle-pause"></i> On Hold</span>
EOF;
    } else if ($status == 'completed') {
        $return = <<<EOF
        <span class="text text-success"><i class="fa-solid fa-circle-check"></i> Completed</span>
EOF;
    } else {
        $return = <<<EOF
        <span class="text text-info"><i class="fa-solid fa-circle-play"></i> On Going</span>
EOF;
    }
    return $return;
}

function GetProgressStatus($status)
{
    if ($status == 'Pending With Client') {
        $return = <<<EOF
        <span class="text text-warning badge badge-warning m-l-10 hidden-sm-down"> Pending With Client</span>
EOF;
    } else if ($status == 'Pending with Government') {
        $return = <<<EOF
        <span class="text text-success badge badge-success m-l-10 hidden-sm-down"> Pending with Government</span>
EOF;
    }else if ($status == 'Pending With IGLI FINANCIAL') {
        $return = <<<EOF
        <span class="text text-danger badge badge-danger m-l-10 hidden-sm-down"> Pending With IGLI FINANCIAL</span>
EOF;
    } else {
        $return = <<<EOF
        <span class="text text-info badge badge-info m-l-10 hidden-sm-down"> On Going</span>
EOF;
    }
    return $return;
}

function ProductAprovelStatus($status)
{
    if ($status == 'pending') {
        $return = <<<EOF
        <span class="text text-warning"><i class="zmdi zmdi-time-interval"></i> Waiting For Approval</span>
EOF;
    } else if ($status == 'published') {
        $return = <<<EOF
        <span class="text text-success"><i class="zmdi zmdi-check-circle"></i> Live</span>
EOF;
    } else if ($status == 'rejected') {
        $return = <<<EOF
        <span class="text text-danger"><i class="zmdi zmdi-alert-polygon"></i> Rejected</span>
EOF;
    } else {
        $return = <<<EOF
        <span class="text text-secondary"><i class="fa fa-pencil-square-o"></i> Draft</span>
EOF;
    }
    return $return;
}

function GetImage($img)
{   
    $Img = IMAGE_DIR . $img;
    $action = <<<EOF
        <img src="{$Img}" alt="Image" class="table-image img-thumbnail">
        EOF;
    return $action;
}



function GetUserImage($img)
{
    $Img = IMAGE_DIR . $img;
if (!@getimagesize($Img)) {
    $Img = NO_PROFILE;
}
    $action = <<<EOF
            <img src="{$Img}" alt="Image" class="table-image img-thumbnail">
EOF;
    return $action;
}

function banner_action_row($BannerID)
{
    $BannerID = encrypt($BannerID);
    $action = <<<EOF
            <div class="tooltip-top text-center">
                <a data-original-title="Update Banner" data-placement="top" data-toggle="tooltip" href="javascript:;" class="btn btn-xs l-blue  btn-equal btn-sm btn-edit btn-mini open_my_form" data-id="{$BannerID}" data-control="banner" data-method="update"><i class="fas fa-pencil-alt"></i></a>
                <a data-original-title="Remove Banner" data-placement="top" data-toggle="tooltip" href="javascript:;" class="btn btn-xs btn-danger btn-equal btn-mini btn-sm delete_btn" data-id="{$BannerID}" data-control="remove" data-method="banner"><i class="far fa-trash-alt"></i></a>
            </div>
EOF;
    return $action;
}

function service_type_action_row($STID)
{
    $STID = encrypt($STID);
    $action = <<<EOF
            <div class="tooltip-top text-center">
                <a data-original-title="Update Service Type" data-placement="top" data-toggle="tooltip" href="javascript:;" class="btn btn-xs l-blue  btn-equal btn-sm btn-edit btn-mini open_my_form" data-id="{$STID}" data-control="services" data-method="update_type"><i class="fas fa-pencil-alt"></i></a>
                <a data-original-title="Remove Service Type" data-placement="top" data-toggle="tooltip" href="javascript:;" class="btn btn-xs btn-danger btn-equal btn-mini btn-sm delete_btn" data-id="{$STID}" data-control="remove" data-method="service_type"><i class="far fa-trash-alt"></i></a>
            </div>
EOF;
    return $action;
}

function service_action_row($ServiceID)
{
    $ServiceID = encrypt($ServiceID);
    if(ROLE == 1){
    $action = <<<EOF
            <div class="tooltip-top text-center">
                <a data-original-title="Update Service" data-placement="top" data-toggle="tooltip" href="javascript:;" class="btn btn-xs l-blue  btn-equal btn-sm btn-edit btn-mini open_my_form" data-form_type="full" data-id="{$ServiceID}" data-control="services" data-method="update"><i class="fas fa-pencil-alt"></i></a>
                <a data-original-title="Remove Service" data-placement="top" data-toggle="tooltip" href="javascript:;" class="btn btn-xs btn-danger btn-equal btn-mini btn-sm delete_btn" data-id="{$ServiceID}" data-control="remove" data-method="service"><i class="far fa-trash-alt"></i></a>
            </div>
EOF;
    }else{
//         $action = <<<EOF
//             <div class="tooltip-top text-center">
//                 <a data-original-title="Update Service" data-placement="top" data-toggle="tooltip" href="javascript:;" class="btn btn-xs l-blue  btn-equal btn-sm btn-edit btn-mini open_my_form" data-form_type="full" data-id="{$ServiceID}" data-control="services" data-method="update"><i class="fas fa-pencil-alt"></i></a>
//             </div>
// EOF;
$action ='None';
    }
    return $action;
}

function user_action_row($UserID)
{
    $UserID = encrypt($UserID);
    $action = <<<EOF
            <div class="tooltip-top text-center">
                <a data-original-title="Update User" data-placement="top" data-toggle="tooltip" href="javascript:;" class="btn btn-xs l-blue  btn-equal btn-sm btn-edit btn-mini open_my_form" data-form_type="half" data-id="{$UserID}" data-control="user" data-method="update"><i class="fas fa-pencil-alt"></i></a>
                <a data-original-title="Remove User" data-placement="top" data-toggle="tooltip" href="javascript:;" class="btn btn-xs btn-danger btn-equal btn-mini btn-sm delete_btn" data-id="{$UserID}" data-control="remove" data-method="user"><i class="far fa-trash-alt"></i></a>
            </div>
EOF;
    return $action;
}

function subadmin_action_row($UserID)
{
    $UserID = encrypt($UserID);
    $URL = base_url('/service-users/'.$UserID);
    $action = <<<EOF
    <div class="tooltip-top text-center">
                <a data-original-title="Assigned User" data-placement="top" data-toggle="tooltip" href="{$URL}" class="btn btn-xs  l-cyan  btn-equal btn-sm btn-edit btn-mini" data-id="{$UserID}" data-control="subadmin" data-method="assign_service"><i class="fa-solid fa-eye"></i></a>
                <a data-original-title="Assign Service" data-placement="top" data-toggle="tooltip" href="javascript:;" class="btn btn-xs btn-warning  btn-equal btn-sm btn-edit btn-mini open_my_form" data-id="{$UserID}" data-control="subadmin" data-method="assign_service"><i class="fa-solid fa-file-circle-plus"></i></a>
                <a data-original-title="Update Sub Admin" data-placement="top" data-toggle="tooltip" href="javascript:;" class="btn btn-xs l-blue  btn-equal btn-sm btn-edit btn-mini open_my_form" data-form_type="half" data-id="{$UserID}" data-control="subadmin" data-method="update"><i class="fas fa-pencil-alt"></i></a>
                <a data-original-title="Remove Sub Admin" data-placement="top" data-toggle="tooltip" href="javascript:;" class="btn btn-xs btn-danger btn-equal btn-mini btn-sm delete_btn" data-id="{$UserID}" data-control="remove" data-method="user"><i class="far fa-trash-alt"></i></a>
            </div>
EOF;
    return $action;
}

function support_action_row($ID)
{
    $ID = encrypt($ID);
    $action = <<<EOF
            <div class="tooltip-top text-center">
                <a data-original-title="View Request" data-placement="top" data-toggle="tooltip" href="javascript:;" class="btn btn-xs l-blue  btn-equal btn-sm btn-edit btn-mini open_my_form" data-form_type="half" data-id="{$ID}" data-control="contact_support" data-method="view_contact"><i class="fa-regular fa-comment-dots"></i></a>
                <a data-original-title="Remove Request" data-placement="top" data-toggle="tooltip" href="javascript:;" class="btn btn-xs btn-danger btn-equal btn-mini btn-sm delete_btn" data-id="{$ID}" data-control="remove" data-method="support"><i class="far fa-trash-alt"></i></a>
            </div>
EOF;
    return $action;
}

function payment_action_row($PaymentID)
{
    $PaymentID = encrypt($PaymentID);
    $action = <<<EOF
            <div class="tooltip-top text-center">
            <a data-original-title="Update Payment" data-placement="top" data-toggle="tooltip" href="javascript:;" class="btn btn-xs l-blue  btn-equal btn-sm btn-edit btn-mini open_my_form"  data-id="{$PaymentID}" data-control="payment" data-method="update"><i class="fas fa-pencil-alt"></i></a>
            <a data-original-title="Remove Payment" data-placement="top" data-toggle="tooltip" href="javascript:;" class="btn btn-xs btn-danger btn-equal btn-mini btn-sm delete_btn" data-id="{$PaymentID}" data-control="remove" data-method="payment"><i class="far fa-trash-alt"></i></a>
            </div>
EOF;
    return $action;
}

function cca_payment_action_row($PaymentID)
{
    $PaymentID = encrypt($PaymentID);
    $action = <<<EOF
            <div class="tooltip-top text-center">
            <a data-original-title="View Details" data-placement="top" data-toggle="tooltip" href="javascript:;" class="btn btn-xs l-blue  btn-equal btn-sm btn-edit btn-mini open_my_form" data-form_type="half" data-id="{$PaymentID}" data-control="ccavenue_payment" data-method="view_payment"><i class="fa-solid fa-eye"></i></a>
            </div>
EOF;
    return $action;
}

function form_data_action_row($ID,$Table){
    $ID = encrypt($ID);        
    // $Table = encrypt($Table);        
    $pdfURL = base_url('form/pdf/'.$Table.'/'.$ID);
    $action = <<<EOF
            <div class="tooltip-top text-center">
            <a data-original-title="Download As PDF" data-placement="top" data-toggle="tooltip" href="{$pdfURL}" class="btn btn-xs  l-cyan  btn-equal btn-sm btn-edit btn-mini" data-id="{$ID}" data-control="form" data-method="pdf"><i class="fa-solid fa-download"></i></a>
            </div>
            EOF;
            // <a data-original-title="Remove Data" data-placement="top" data-toggle="tooltip" href="javascript:;" class="btn btn-xs btn-danger btn-equal btn-mini btn-sm delete_btn" data-id="{$ID}" data-table="{$Table}" data-type="soft"  data-control="remove" data-method="form_data"><i class="far fa-trash-alt"></i></a>
    return $action;

}
function form_action_row($FormID,$FormURL)
{
    $FormID = encrypt($FormID);
    $URL = BASE_URL;
    $dataURL = base_url('form-data/data-view/'.$FormID);
    $pdfURL = base_url('form-data/pdf/'.$FormID);
    $editURL = base_url('form_builder/edit_form/'.$FormID);
    $action = <<<EOF
            <div class="tooltip-top text-center">
            <a data-original-title="View Form" data-placement="top" data-toggle="tooltip" href="javascript:;" class="btn btn-xs  l-cyan  btn-equal btn-sm btn-edit btn-mini open_my_form" data-form_type="half" data-id="{$FormID}" data-control="form-builder" data-method="view_form"><i class="fa-solid fa-eye"></i></a>
            <a data-original-title="PDF Formate" data-placement="top" data-toggle="tooltip" href="{$pdfURL}" class="btn btn-xs  btn-secoundry  btn-equal btn-sm btn-edit btn-mini" data-id="{$FormID}" data-link="{$pdfURL}"  data-control="form" data-method="form_data"><i class="fa-solid fa-file-signature"></i></a>
            <a data-original-title="Form Link" data-placement="top" data-toggle="tooltip" href="javascript:;" class="btn btn-xs  btn-warning  btn-equal btn-sm btn-edit btn-mini" data-id="{$FormID}" data-link="{$FormURL}"  onclick="copyText('{$URL}{$FormURL}')" data-control="form" data-method="form_link"><i class="fa-solid fa-link"></i></a>
            <a data-original-title="Form Data" data-placement="top" data-toggle="tooltip" href="{$dataURL}" class="btn btn-xs  btn-success  btn-equal btn-sm btn-edit btn-mini" data-id="{$FormID}" data-link="{$FormURL}"  data-control="form" data-method="form_data"><i class="fa-regular fa-rectangle-list"></i></a>
            <a data-original-title="Update Form" data-placement="top" data-toggle="tooltip" href="{$editURL}" class="btn btn-xs l-blue btn-equal btn-mini btn-sm" data-id="{$FormID}" data-control="3" data-method="edit_form"><i class="fas fa-pencil-alt"></i></a>
            <a data-original-title="Remove Form" data-placement="top" data-toggle="tooltip" href="javascript:;" class="btn btn-xs btn-danger btn-equal btn-mini btn-sm delete_btn" data-id="{$FormID}" data-control="remove" data-method="form" data-type="soft"><i class="far fa-trash-alt"></i></a>
            </div>
            EOF;
            return $action;
            // <a data-original-title="Update Form" data-placement="top" data-toggle="tooltip" href="javascript:;" class="btn btn-xs l-blue  btn-equal btn-sm btn-edit btn-mini"  data-id="{$FormID}" data-control="form-builder" data-method="update"><i class="fas fa-pencil-alt"></i></a>
}

function document_action_row($DocID)
{
    $DocID = encrypt($DocID);
    $action = <<<EOF
    <div class="tooltip-top text-center">
    <a data-original-title="Remove Document" data-placement="top" data-toggle="tooltip" href="javascript:;" class="btn btn-xs btn-danger btn-equal btn-mini btn-sm delete_btn" data-id="{$DocID}" data-control="remove" data-method="document"><i class="far fa-trash-alt"></i></a>
           </div>
EOF;
    return $action;
}

function user_service_action_row($ID)
{
    $ID = encrypt($ID);
    if(ROLE == 1){
    $action = <<<EOF
    <div class="tooltip-top text-center">
    <a data-original-title="Update Service Status" data-placement="top" data-toggle="tooltip" href="javascript:;" class="btn btn-xs l-blue  btn-equal btn-sm btn-edit btn-mini open_my_form"  data-id="{$ID}" data-control="user_services" data-method="update"><i class="fas fa-pencil-alt"></i></a>       
    <a data-original-title="Remove User Service" data-placement="top" data-toggle="tooltip" href="javascript:;" class="btn btn-xs btn-danger btn-equal btn-mini btn-sm delete_btn" data-id="{$ID}" data-control="remove" data-method="user_service" data-type="soft"><i class="far fa-trash-alt"></i></a>
           </div>
EOF;
}else{
    $action = <<<EOF
    <div class="tooltip-top text-center">
    <a data-original-title="Update Service Status" data-placement="top" data-toggle="tooltip" href="javascript:;" class="btn btn-xs l-blue  btn-equal btn-sm btn-edit btn-mini open_my_form"  data-id="{$ID}" data-control="user_services" data-method="update"><i class="fas fa-pencil-alt"></i></a>       
           </div>
EOF;

}
    return $action;
}

function sa_user_service_action_row($ID)
{
    $ID = encrypt($ID);
    $action = <<<EOF
    <div class="tooltip-top text-center">
        <a data-original-title="Remove User Service" data-placement="top" data-toggle="tooltip" href="javascript:;" class="btn btn-xs btn-danger btn-equal btn-mini btn-sm delete_btn" data-id="{$ID}" data-control="remove" data-method="user_service" data-type="soft"><i class="far fa-trash-alt"></i></a>
    </div>
EOF;
    return $action;
}

function form_filed($Name,$Type) {
    pr($Name);
    pr($Type);
}


function PartnersName($P) {
    $ci = &get_instance();
    if($P != ''){
        $Name = '';
        $Partners = explode(",",$P);
        $cnt = 0;
        foreach ($Partners as $key => $p) {
            $user = $ci->Common->get_info(TBL_USERS, $p,'id');  
            if($user){
                if($cnt != 0){
                    $Name .= ', ';
                }
                $Name .= $user->first_name.' '.$user->last_name;
                $cnt++;
            }
        }
        return $Name;
    }else{
        return '-';
    }
}

function GetFile($file)
{
    $I = json_decode($file);
    $action = '';
    if(is_array($I)){
        foreach ($I as $key => $value) {
            $file = IMAGE_DIR . $value;
            $action .= <<<EOF
                <a href="{$file}" target="_blank"><i class="fa-solid fa-file-shield"></i></a>
            EOF;
        }
    }else{

        $file = IMAGE_DIR . $file;
        $action .= <<<EOF
                <a href="{$file}" target="_blank"><i class="fa-solid fa-file-shield"></i></a>
            EOF;
    }
    return '<center>'.$action.'</center>';
}

function GetCheckBox($val) {
    pr($val);die;    
    return $Str;    
}