<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        user_allow([]);
    }

    public function index()
    {
        $view_data = [
            'title'     => 'Pengaturan',
            'cname'     => 'Settings',
            'page'      => 'settings/index',
            'script'    => 'settings/script'
        ];
        $this->load->view('layout/dashboard', $view_data);
    }

    public function update_settings()
    {
        $update = [];
        foreach($this->input->post() as $key => $value){
            $update[] = [
                '_key' => $key,
                '_value' => $value,
            ];
        }
        $this->db->update_batch("_config",$update,"_key");
        redirect("Settings");
    }
}
