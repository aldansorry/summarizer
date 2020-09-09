<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'third_party/PHPExcel.php');

class ExcelReader extends PHPExcel{

	public function __construct()
	{
		parent::__construct();
	}

	function excelDateConvert($format,$excelDate)
    {
    	$linux_time = ($excelDate-25569)*86400;
        return date($format,(int) $linux_time);
    }   
}
?>