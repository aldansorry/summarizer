<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
    var $upload_data;

    public function __construct()
    {
        parent::__construct();
        user_allow([1]);
    }

    public function index()
    {
        $view_data = [
            'title'     => 'Users',
            'cname'     => 'Users',
            'page'      => 'users/index',
            'script'    => 'users/script'
        ];
        $this->load->view('layout/dashboard', $view_data);
    }

    public function getUsers()
    {
        $data['data'] = $this->db
            ->get('users')->result();
        echo json_encode($data);
    }

    public function modalInsert()
    {
        $this->load->view('pages/users/modal_insert');
    }
    
    public function modalUpdate()
    {
        $id_users = $this->input->post('id_users');
        $data['data_users'] = $this->db->where('id', $id_users)->get("users")->row(0);
        $this->load->view('pages/users/modal_update', $data);
    }

    public function insert_action()
    {
        $this->load->library('form_validation');

        $next_id = $this->db->query('SHOW TABLE STATUS LIKE "users"')->row(0)->Auto_increment;

        $this->form_validation->set_rules("nama", "Nama", "required|trim|regex_match[/^([a-z ])+$/i]",['regex_match' => "%s can only be filled with letters and spaces"]);
        $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[users.username]|min_length[4]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('repassword', 'Re-Password', 'trim|matches[password]');
        $this->form_validation->set_rules("level", "Level", "required");

        $this->form_validation->set_rules('gambar', 'Gambar', 'callback_upload_gambar[' . $next_id . ']');

        if ($this->form_validation->run() == true) {
            $set = [
                'nama' => $this->input->post('nama'),
                'username' => $this->input->post('username'),
                'password' => md5($this->input->post('password')),
                'level' => $this->input->post('level'),
            ];

            if ($this->upload_data != null) {
                $set['gambar'] = $this->upload_data['file_name'];
            }

            $insert = $this->db->insert('users', $set);

            if ($insert) {
                echo json_encode([
                    'error' => false,
                    'swal' => [
                        'icon' => 'success',
                        'title' => "Input Berhasil",
                        'text' => "Input berhasil dengan nama : " . $set['nama'],
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
                unlink('storage/users/' . $this->upload_data['file_name']);
            }

            echo json_encode([
                'error' => true,
                'form_error' => $this->form_validation->error_array()
            ]);
        }
    }

    public function update_action()
    {
        $this->load->library('form_validation');

        $id_users = $this->input->post('id_users');

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
        $this->form_validation->set_rules("level", "Level", "required");

        if ($this->input->post('password') != "") {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]');
            $this->form_validation->set_rules('repassword', 'Re-Password', 'trim|matches[repassword]');
        }

        $this->form_validation->set_rules('gambar', 'Gambar', 'callback_upload_gambar[' . $id_users . ']');

        if ($this->form_validation->run() == true) {
            $set = [
                'nama' => $this->input->post('nama'),
                'username' => $this->input->post('username'),
                'level' => $this->input->post('level'),
            ];

            if ($this->upload_data != null) {
                $set['gambar'] = $this->upload_data['file_name'];
            }

            if ($this->input->post('password') != "") {
                $set['password'] = md5($this->input->post('password'));
            }

            $insert = $this->db->where('id', $id_users)->update('users', $set);

            if ($insert) {
                echo json_encode([
                    'error' => false,
                    'swal' => [
                        'icon' => 'success',
                        'title' => "Input Berhasil",
                        'text' => "Input berhasil dengan nama : " . $set['nama'],
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

    public function delete()
    {
        $id_users = $this->input->post('id_users');

        $users_data = $this->db
            ->where('id', $id_users)
            ->get('users')
            ->row(0);

        $delete = $this->db
            ->where('id', $id_users)
            ->delete('users');

        if ($delete) {
            if ($users_data->gambar != 'default.png') {
                unlink('storage/users/' . $users_data->gambar);
            }
            echo json_encode([
                'swal' => [
                    'icon' => 'success',
                    'title' => "Hapus Berhasil",
                    'text' => "Hapus berhasil dengan nama : " . $users_data->nama,
                ],
            ]);
        } else {
            echo json_encode([
                'swal' => [
                    'icon' => 'warning',
                    'title' => "Hapus Gagal",
                    'text' => "Terjadi Kesalahan",
                ],
            ]);
        }
    }

    public function deleteBatch()
    {
        $list_users = $this->input->post('list_users');

        $count_success = 0;
        $count_failed = 0;

        foreach ($list_users as $key => $value) {
            $users_data = $this->db
                ->where('id', $value)
                ->get('users')
                ->row(0);

            $delete = $this->db
                ->where('id', $value)
                ->delete('users');

            if ($delete) {
                if ($users_data->gambar != 'default.png') {
                    unlink('storage/users/' . $users_data->gambar);
                }
                $count_success++;
            } else {
                $count_failed++;
            }
        }


        echo json_encode([
            'swal' => [
                'icon' => 'success',
                'title' => "Hapus Batch Berhasil",
                'html' => "Hapus berhasil berjumlah : " . $count_success . "<br> Hapus gagal berjumlah : " . $count_failed,
            ],
        ]);
    }
}
