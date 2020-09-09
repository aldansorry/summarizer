<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        user_allow([]);
    }

    public function index()
    {
        $view_data = [
            'title'     => 'Dashboard',
            'cname'     => 'Dashboard',
            'page'      => 'dashboard/index',
            'script'    => 'dashboard/script'
        ];
        $this->load->view('layout/dashboard', $view_data);
    }

    public function getBeritaMonth()
    {
        $year = $this->input->post('year');

        $berita_month = $this->db
            ->select('month(tanggal) as month,year(tanggal) as year, fk_sumber ,count(id) as jumlah')
            ->group_by('month(tanggal),year(tanggal),fk_sumber')
            ->where('year(tanggal)', $year)
            ->get('berita')->result();

        $data_berita = [];
        foreach ($berita_month as $key => $value) {
            $data_berita[$value->month - 1][$value->fk_sumber] = $value->jumlah;
        }

        $chart_label = [
            'JAN',
            'FEB',
            'MAR',
            'APR',
            'MEI',
            'JUN',
            'JUL',
            'AGU',
            'SEP',
            'NOV',
            'OKT',
            'DES',
        ];

        $chart_data_katadata = [];
        $chart_data_detik = [];
        $chart_data_kompas = [];

        foreach ($chart_label as $key => $value) {

            $chart_data_katadata[$key] = (isset($data_berita[$key][1]) ? $data_berita[$key][1] : 0);
            $chart_data_detik[$key] = (isset($data_berita[$key][2]) ? $data_berita[$key][2] : 0);
            $chart_data_kompas[$key] = (isset($data_berita[$key][3]) ? $data_berita[$key][3] : 0);
        }

        $ret = [
            'chart' => [
                'label' => $chart_label,
                'dataset' => [
                    'katadata' => $chart_data_katadata,
                    'detik' => $chart_data_detik,
                    'kompas' => $chart_data_kompas,
                ],
            ],
        ];


        echo json_encode($ret);
    }

    public function getContent()
    {
        #chart_pie
        $berita_month = $this->db
            ->select('(select nama from sumber where id=berita.fk_sumber) as sumber ,count(id) as jumlah')
            ->group_by('fk_sumber')
            ->get('berita')->result();

        $chart_berita_sumber_label = [];
        $chart_berita_sumber_data = [];
        foreach ($berita_month as $key => $value) {
            $chart_berita_sumber_data[]  = $value->jumlah;
            $chart_berita_sumber_label[] = $value->sumber;
        }

        ##chart kategori
        ###katadata
        $berita_katadata = $this->db
            ->select('berita.kategori ,count(id) as jumlah')
            ->group_by('kategori')
            ->where('fk_sumber',1)
            ->get('berita')->result();

        $chart_berita_katadata_label = [];
        $chart_berita_katadata_data = [];
        foreach ($berita_katadata as $key => $value) {
            $chart_berita_katadata_data[]  = $value->jumlah;
            $chart_berita_katadata_label[] = $value->kategori;
        }
        $berita_detik = $this->db
            ->select('berita.kategori ,count(id) as jumlah')
            ->group_by('kategori')
            ->where('fk_sumber',2)
            ->get('berita')->result();

        $chart_berita_detik_label = [];
        $chart_berita_detik_data = [];
        foreach ($berita_detik as $key => $value) {
            $chart_berita_detik_data[]  = $value->jumlah;
            $chart_berita_detik_label[] = $value->kategori;
        }
        $berita_kompas = $this->db
            ->select('berita.kategori ,count(id) as jumlah')
            ->group_by('kategori')
            ->where('fk_sumber',3)
            ->get('berita')->result();

        $chart_berita_kompas_label = [];
        $chart_berita_kompas_data = [];
        foreach ($berita_kompas as $key => $value) {
            $chart_berita_kompas_data[]  = $value->jumlah;
            $chart_berita_kompas_label[] = $value->kategori;
        }


        #count
        $count_relevansi_berita = $this->db->get('relevansi')->num_rows();
        $count_total_berita = $this->db->get('berita')->num_rows();

        $count_berita_scraped = $this->db
            ->join('berita_kalimat', 'berita.id=berita_kalimat.fk_berita')
            ->group_by('berita.id')
            ->get('berita')->num_rows();

        $count_berita_featured = $this->db
            ->join('berita_kalimat', 'berita.id=berita_kalimat.fk_berita')
            ->where('berita_kalimat.f1 !=', null)
            ->group_by('berita.id')
            ->get('berita')->num_rows();

        $ret = [
            'chart_berita_sumber' => [
                'label' => $chart_berita_sumber_label,
                'data' => $chart_berita_sumber_data
            ],
            'chart_berita_katadata' => [
                'label' => $chart_berita_katadata_label,
                'data' => $chart_berita_katadata_data
            ],
            'chart_berita_detik' => [
                'label' => $chart_berita_detik_label,
                'data' => $chart_berita_detik_data
            ],
            'chart_berita_kompas' => [
                'label' => $chart_berita_kompas_label,
                'data' => $chart_berita_kompas_data
            ],
            'count' => [
                'total_berita' => $count_total_berita,
                'relevansi_berita' => $count_relevansi_berita,
                'berita_scraped' => $count_berita_scraped / $count_total_berita * 100,
                'berita_featured' => $count_berita_featured / $count_total_berita * 100,
            ]
        ];


        echo json_encode($ret);
    }
}
