<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Berita extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        user_allow([]);
    }

    public function index()
    {
        $view_data = [
            'title'     => 'Berita',
            'cname'     => 'Berita',
            'page'      => 'berita/index',
            'script'    => 'berita/script'
        ];

        $this->load->view('layout/dashboard', $view_data);
    }

    public function getData()
    {
        $data['data'] = $this->db->order_by('id', 'desc')
            ->get('berita')->result();

        foreach ($data['data'] as $key => $value) {
            $data['data'][$key]->tanggal = date("d-m-Y H:i", strtotime($value->tanggal));
        }
        echo json_encode($data);
    }

    public function delete($id_berita)
    {
        $this->db->where('id', $id_berita)->delete('berita');
    }

    public function modalDetail()
    {
        $id_berita = $this->input->post('id_berita');

        $data_berita_kalimat = $this->db
            ->where('fk_berita', $id_berita)
            ->get('berita_kalimat')
            ->result();


        $view_data['data_berita_kalimat'] = $data_berita_kalimat;
        $this->load->view('pages/berita/modal_detail', $view_data);
    }

    public function deleteBerita()
    {
        $id_berita = $this->input->post('id_berita');

        $this->db->where('id', $id_berita)->delete('berita');

        echo json_encode([
            'type' => 'success',
            'title' => 'Delete',
            'text' => 'Delete Berhasil'
        ]);
    }

    public function deleteBeritaBatch()
    {
        $list_berita = $this->input->post('list_berita');

        $this->db->where_in('id', $list_berita)->delete('berita');

        echo json_encode([
            'type' => 'success',
            'title' => 'Delete',
            'text' => 'Delete Berhasil ' . count($list_berita) . " data"
        ]);
    }
}
