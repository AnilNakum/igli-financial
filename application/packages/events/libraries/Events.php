<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Events
{

    public $CI;
    public $method_name;
    private static $Code = false;


    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public static function responce($html)
    {
        return array($html);
    }

    public function event_view($Code=false)
    {
        self::$Code = $Code;
        $Data = array();
        $OrderBy = array("field" => "DateTime","order" => "ASC");
        if($Code){
            $Events = $this->CI->Common->get_all_info(TBL_EVENT,'0','isDeleted','DateTime BETWEEN "'.$Code['start'].'" AND "'.$Code['end'].'"' ,'*',false,false,$OrderBy);
        }else{
            $Events = $this->CI->Common->get_all_info(TBL_EVENT,'0','isDeleted',' MONTH(`DateTime`) = MONTH(now()) and YEAR(`DateTime`) = YEAR(now())','*',false,false,$OrderBy);
        }
        return $this::responce($this->CI->partial('event_view', array('Events' => $Events,'Code'=>$Code), true));
    }

}