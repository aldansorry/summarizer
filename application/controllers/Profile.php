<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
    var $upload_data;

    public function __construct()
    {
        parent::__construct();
        user_allow([]);
    }

    public function index()
    {
        $view_data = [
            'title'     => 'Profile',
            'cname'     => 'Profile',
            'page'      => 'profile/index',
            'script'    => 'profile/script'
        ];
        $id_users = $this->session->userlogin['id'];
        $view_data['data_users'] = $this->db->where('id', $id_users)->get("users")->row(0);
        $this->load->view('layout/dashboard', $view_data);
    }

    public function update_profile()
    {
        $this->load->library('form_validation');

        $id_users = $this->session->userlogin['id'];

        $users_data = $this->db
            ->where('id', $id_users)
            ->get('users')
            ->row(0);

        $unique_username = "";
        if ($this->input->post('username') != $users_data->username) {
            $unique_username = '|is_unique[users.username]';
        }

        $this->form_validation->set_rules('nama', 'nama', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]' . $unique_username);

        if ($this->input->post('password') != "") {
            $this->form_validation->set_rules('oldpassword', 'Old Password', 'trim|required|min_length[4]|callback_checkOldPassword');

            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]');
            $this->form_validation->set_rules('repassword', 'Re-Password', 'trim|matches[repassword]');
        }

        $this->form_validation->set_rules('gambar', 'Gambar', 'callback_upload_gambar[' . $id_users . ']');

        if ($this->form_validation->run() == true) {
            $set = [
                'nama' => $this->input->post('nama'),
                'username' => $this->input->post('username'),
            ];

            if ($this->upload_data != null) {
                $set['gambar'] = $this->upload_data['file_name'];
            }

            if ($this->input->post('password') != "") {
                $set['password'] = md5($this->input->post('password'));
            }

            $update = $this->db->where('id', $id_users)->update('users', $set);

            $data_users = $this->db
                ->where('id', $id_users)
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

            if ($update) {
                echo json_encode([
                    'error' => false,
                    'swal' => [
                        'icon' => 'success',
                        'title' => "Update Berhasil",
                        'text' => "Update berhasil ",
                    ],
                ]);
            } else {
                echo json_encode([
                    'error' => false,
                    'swal' => [
                        'icon' => 'warning',
                        'title' => "Input Gagal",
                        'text' => "Terjadi Kesalahan",
                    ],
                ]);
            }
        } else {

            if ($this->upload_data != null) {
                $set['gambar'] = $this->upload_data['file_name'];
                $this->db->where('id', $id_users)->update('users', $set);
            }

            echo json_encode([
                'error' => true,
                'form_error' => $this->form_validation->error_array()
            ]);
        }
    }

    function checkOldPassword($oldpassword)
    {
        $username = $this->session->userlogin['username'];
        $query = $this->db->where([
            'username' => $username,
            'password' => md5($oldpassword),
        ])->get("users");

        if($query->num_rows() == 1){
            return true;
        }else{
            $this->form_validation->set_message('checkOldPassword', "{field} tidak sesuai");
            return false;
        }
    }

    function upload_gambar($gambar, $id_users)
    {

        if ($_FILES['gambar']['name'] != "") {
            $config['upload_path']          = './storage/users/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 2000;
            $config['file_ext_tolower']     = true;
            $config['overwrite']     = true;
            $config['file_name']            = "users" . $id_users;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('gambar')) {
                $this->form_validation->set_message('upload_gambar', "{field} : " . $this->upload->display_errors('', ''));
                return false;
            } else {
                $this->upload_data = $this->upload->data();
                return true;
            }
        }
        return true;
    }
}
