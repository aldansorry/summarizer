<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        if(user_allow([],false)){
            redirect("Dashboard");
        }
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_auth_username');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_auth_password');
        if ($this->form_validation->run() == false) {
            $view_data = [
                'title'     => 'Login',
                'cname'     => 'Login',
            ];
            $this->load->view('layout/login', $view_data);
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');


            $data_users = $this->db
                ->where('username', $username)
                ->where('password', md5($password))
                ->get('users')
                ->row(0);

            $session_data = [
                'is_loggedin' => true,
                'id' => $data_users->id,
                'nama' => $data_users->nama,
                'username' => $data_users->username,
                'level' => $data_users->level,
                'gambar' => $data_users->gambar
            ];

            $this->session->set_userdata('userlogin', $session_data);
            redirect("Dashboard");
        }
    }

    function auth_username($username)
    {
        $query = $this->db
            ->where('username', $username)
            ->get('users');

        if ($query->num_rows() != 1) {
            $this->form_validation->set_message('auth_username', '{field} belum terdaftar');
            return false;
        }
        return true;
    }

    function auth_password($password)
    {
        $username = $this->input->post('username');
        $query_username = $this->db
            ->where('username', $username)
            ->get('users');

        $query_password = $this->db
            ->where('username', $username)
            ->where('password', md5($password))
            ->get('users');

        if ($query_username->num_rows() == 1) {
            if ($query_password->num_rows() != 1) {
                $this->form_validation->set_message('auth_password', '{field} salah');
                return false;
            }
        }
        return true;
    }

    public function logout()
    {
        $this->session->unset_userdata('userlogin');
        redirect("Login");
    }
}
