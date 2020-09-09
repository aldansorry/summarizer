<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bobot extends CI_Controller
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
            'title'     => 'Bobot',
            'cname'     => 'Bobot',
            'page'      => 'bobot/index',
            'script'    => 'bobot/script'
        ];
        $this->load->view('layout/dashboard', $view_data);
    }

    public function getBobot()
    {
        $data['data'] = $this->db
            ->get('bobot')->result();
        echo json_encode($data);
    }

    public function modalInsert()
    {
        $this->load->view('pages/bobot/modal_insert');
    }
    public function modalUpdate()
    {
        $id_bobot = $this->input->post('id_bobot');
        $data['data_bobot'] = $this->db->where('id', $id_bobot)->get("bobot")->row(0);
        $this->load->view('pages/bobot/modal_update', $data);
    }

    public function insert_action()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules("nama", "Nama", "required|min_length[4]|is_unique[bobot.nama]");
        $this->form_validation->set_rules("kompresi", "Kompresi", "required");
        $this->form_validation->set_rules("f1", "F1", "required");
        $this->form_validation->set_rules("f2", "F2", "required");
        $this->form_validation->set_rules("f3", "F3", "required");
        $this->form_validation->set_rules("f4", "F4", "required");
        $this->form_validation->set_rules("f5", "F5", "required");
        $this->form_validation->set_rules("f6", "F6", "required");

        if ($this->form_validation->run() == true) {
            $set = [
                'nama' => $this->input->post('nama'),
                'kompresi' => $this->input->post('kompresi'),
                'f1' => $this->input->post('f1'),
                'f2' => $this->input->post('f2'),
                'f3' => $this->input->post('f3'),
                'f4' => $this->input->post('f4'),
                'f5' => $this->input->post('f5'),
                'f6' => $this->input->post('f6'),
            ];
            $insert = $this->db->insert('bobot', $set);

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

            echo json_encode([
                'error' => true,
                'form_error' => $this->form_validation->error_array()
            ]);
        }
    }

    public function update_action()
    {
        $this->load->library('form_validation');

        $id_bobot = $this->input->post('id_bobot');

        $bobot_data = $this->db
            ->where('id', $id_bobot)
            ->get('bobot')
            ->row(0);

        $unique_nama = "";
        if ($this->input->post('nama') != $bobot_data->nama) {
            $unique_nama = '|is_unique[bobot.nama]';
        }

        $this->form_validation->set_rules('nama', 'Nama', 'trim|required|min_length[4]' . $unique_nama);
        $this->form_validation->set_rules("kompresi", "Kompresi", "required");
        $this->form_validation->set_rules("f1", "F1", "required");
        $this->form_validation->set_rules("f2", "F2", "required");
        $this->form_validation->set_rules("f3", "F3", "required");
        $this->form_validation->set_rules("f4", "F4", "required");
        $this->form_validation->set_rules("f5", "F5", "required");
        $this->form_validation->set_rules("f6", "F6", "required");


        if ($this->form_validation->run() == true) {
            $set = [
                'nama' => $this->input->post('nama'),
                'kompresi' => $this->input->post('kompresi'),
                'f1' => $this->input->post('f1'),
                'f2' => $this->input->post('f2'),
                'f3' => $this->input->post('f3'),
                'f4' => $this->input->post('f4'),
                'f5' => $this->input->post('f5'),
                'f6' => $this->input->post('f6'),
            ];
            $update = $this->db->where('id', $id_bobot)->update('bobot', $set);

            if ($update) {
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

            echo json_encode([
                'error' => true,
                'form_error' => $this->form_validation->error_array()
            ]);
        }
    }

    public function delete()
    {
        $id_bobot = $this->input->post('id_bobot');

        $bobot_data = $this->db
            ->where('id', $id_bobot)
            ->get('bobot')
            ->row(0);

        $delete = $this->db
            ->where('id', $id_bobot)
            ->delete('bobot');

        if ($delete) {
            echo json_encode([
                'swal' => [
                    'icon' => 'success',
                    'title' => "Hapus Berhasil",
                    'text' => "Hapus berhasil dengan nama : " . $bobot_data->nama,
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
        $list_bobot = $this->input->post('list_bobot');

        $count_success = 0;
        $count_failed = 0;

        foreach ($list_bobot as $key => $value) {

            $delete = $this->db
                ->where('id', $value)
                ->delete('bobot');

            if ($delete) {
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
