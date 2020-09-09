<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
fungsi untuk memberikan batasan akses user

param
$array_access : array yang digunakan untuk menyimpan level berapa saja yang bisa mengakses 
    contoh user_allow([1,2]) maka user yang bisa akses hanya level 1 dan 2 
    contoh user_allow() maka semua user bisa akses

$redirect : parameter untuk melakukan redirect jika belum login akan ke error401 jika sudah login tapi tidak berhak mengakses ke error403
*/
if (!function_exists('user_allow')) {
    function user_allow($array_access = [],$redirect=true)
    {
        $CI =& get_instance();
        $userlogin = $CI->session->userdata('userlogin');

        $redirecter = "";
        if($userlogin['is_loggedin']){
            if(count($array_access) != 0){
                if(!in_array($userlogin['level'],$array_access)){
                    $redirecter = "Error403";
                }
            }
            
        }else{
            $redirecter = "Error401";
        }

        if($redirecter != ""){
            if($redirect){
                redirect($redirecter);
            }else{
                return false;
            }
        }else{
            return true;
        }
    }
}
