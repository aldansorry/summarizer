<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('getConfig')) {
    function getConfig($key)
    {
        $CI =& get_instance();

        $data = $CI->db->where('_key',$key)->get('_config')->row(0);
        if($data != null){
            return $data->_value;
        }else{
            return false;
        }
    }
}
