<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $view_data = [
            'title'     => 'Home',
            'cname'     => 'Home',
            'page'      => 'home/index',
            'script'    => 'home/script'
        ];
        $this->load->view('layout/home', $view_data);
    }

    public function getBerita()
    {
        $this->load->library('summarizer');
        $limit = $this->input->post('limit');
        $offset = $this->input->post('offset');
        $sumber = $this->input->post('sumber');
        $tanggal = $this->input->post('tanggal');
        $search = $this->input->post('search');

        if ($sumber != "") {
            $this->db->where_in('berita.fk_sumber', $sumber);
        }

        if ($tanggal != "") {
            $ex_tanggal = explode(" - ", $tanggal);

            $date_from = new DateTime($ex_tanggal[0]);
            $date_to = new DateTime($ex_tanggal[1]);

            $date_to->modify('+1 day');

            $this->db->where('berita.tanggal >=', $date_from->format("Y-m-d"));
            $this->db->where('berita.tanggal <=', $date_to->format("Y-m-d"));
        }

        if ($search != "") {
            $this->db->like('berita.judul', $search);
        }

        $db_berita = $this->db
            ->select('berita.*,sumber.nama sumber, sumber.icon icon_sumber, sumber.url url_sumber')
            ->join('sumber', 'berita.fk_sumber=sumber.id')
            ->join('berita_kalimat', 'berita.id=berita_kalimat.fk_berita', 'left')
            ->group_by('berita.id')
            ->order_by('berita.tanggal', 'desc')
            ->where('berita_kalimat.f1 !=', null)
            ->get('berita', $limit, $offset)->result();



        $ret_berita = [];
        foreach ($db_berita as $key => $value) {
            $berita = $this->getBeritaDatas($value->id);
            $ret_berita[] = $berita;
        }

        echo json_encode($ret_berita);
    }

    public function doRelevansi()
    {
        $id_berita = $this->input->post('id_berita');

        ini_set('max_execution_time', 1200);
        set_time_limit(1200);
        ini_set('memory_limit', '-1');

        $this->load->library("preprocessing");
        $this->load->library("cosine");

        $threshold = getConfig("relevansi_kompresi");
        $berita = $this->db->where('id', $id_berita)->get('berita')->row(0);

        $similarity = [];
        $other_sumber = [1, 2, 3];
        unset($other_sumber[$berita->fk_sumber - 1]);
        foreach ($other_sumber as $k => $fk_sumber) {
            $after = getConfig("relevansi_selisih_sesudah");
            $before = getConfig("relevansi_selisih_sebelum");

            $tanggal = new DateTime($berita->tanggal);
            $tanggal_after = $tanggal->modify("+" . $after . " days")->format("Y-m-d");
            $tanggal_bofore = $tanggal->modify("-" . ($after + $before) . " days")->format("Y-m-d");

            $campared_berita = $this->db
                ->where('tanggal <=', $tanggal_after)
                ->where('tanggal >=', $tanggal_bofore)
                ->where('fk_sumber', $fk_sumber)
                ->get('berita')->result();

            $doc_berita = [];
            foreach ($campared_berita as $key => $value) {
                $doc_berita[$value->id] = $value->judul;
            }

            $similarity[$fk_sumber] = $this->cosine->process($berita->judul, $doc_berita);
        }

        $berita_relevan = [];
        foreach ($similarity as $k => $v) {
            if (count($v) != 0) {
                $max = max($v);
                $id_compared = array_keys($v, $max)[0];


                if ($max > $threshold) {
                    $berita_relevan[$k] = $id_compared;
                    $db_relevan = $this->db->query('select * from relevansi where (fk_berita_1 = ' . $berita->id . ' AND fk_berita_2=' . $id_compared . ') OR (fk_berita_2 = ' . $berita->id . ' AND fk_berita_1=' . $id_compared . ')');
                    if ($db_relevan->num_rows() == 0) {
                        $set = [
                            'fk_berita_1' => $berita->id,
                            'fk_berita_2' => $id_compared,
                            'nilai' => $max,
                        ];
                        $this->db->insert('relevansi', $set);
                    }
                }
            }
        }

        $badge_relevansi = [];
        foreach ($berita_relevan as $fk_sumber => $id_berita) {
            $db_sumber = $this->db->where('id', $fk_sumber)->get('sumber')->row(0);
            $sumber_class = "";
            switch ($db_sumber->id) {
                case 1:
                    $sumber_class = "primary";
                    break;
                case 2:
                    $sumber_class = "info";
                    break;
                case 3:
                    $sumber_class = "danger";
                    break;
            }

            $badge_relevansi[] = (object) [
                'class' => $sumber_class,
                'text' => $db_sumber->nama,
                'id' => $id_berita,
            ];
        }

        echo json_encode([
            'badge' => $badge_relevansi,
        ]);
    }

    function getBeritaDatas($id)
    {

        $this->load->library('summarizer');
        $db_bobot = $this->db->where('id', getConfig("bobot_default"))->get('bobot')->row(0);

        $data_berita = $this->db
            ->select('berita.*,sumber.nama sumber, sumber.icon icon_sumber, sumber.url url_sumber')
            ->join('sumber', 'berita.fk_sumber=sumber.id')
            ->where('berita.id', $id)
            ->get('berita')->row(0);
        $data_kalimat = $this->db->where('fk_berita', $data_berita->id)->get('berita_kalimat')->result();

        $deskripsi_summarize = $this->summarizer->process($data_kalimat, $db_bobot, 2, 2);

        $deskripsi_teks = "";
        $deskripsi = [];
        foreach ($deskripsi_summarize as $k => $v) {
            $kalimat = new stdClass;
            $kalimat->index = $v->no;
            $kalimat->paragraft = $v->paragraft;
            $kalimat->kalimat = $v->kalimat;
            $deskripsi[] = $kalimat;
            $deskripsi_teks .= $v->kalimat . ". ";
        }

        $konten_summarize = $this->summarizer->process($data_kalimat, $db_bobot);
        $konten = $this->load->view('pages/home/konten_paragraft', ['data_berita_kalimat' => $konten_summarize], true);


        $tanggal = new DateTime($data_berita->tanggal);

        switch ($data_berita->fk_sumber) {
            case 1:
                $sumber_class = "primary";
                break;
            case 2:
                $sumber_class = "info";
                break;
            case 3:
                $sumber_class = "danger";
                break;
        }

        $berita = new stdClass;
        $berita->id = $data_berita->id;
        $berita->tanggal = (object) [
            'time' => $tanggal->format("H:i A"),
            'format' => $tanggal->format('d F' . ($tanggal->format('Y') != date('Y') ? ' Y' : "")),
        ];
        $berita->judul = trim($data_berita->judul);
        $berita->kategori = $data_berita->kategori;
        $berita->link_full_page = $data_berita->link;
        $berita->link = berita_link($data_berita->tanggal, $data_berita->judul);
        $berita->gambar = $data_berita->gambar;
        $berita->sumber = (object) [
            'text' => $data_berita->sumber,
            'icon' => $data_berita->icon_sumber,
            'url' => $data_berita->url_sumber,
            'class' => $sumber_class
        ];
        $berita->deskripsi = $deskripsi;
        $berita->deskripsi_text = $deskripsi_teks;
        $berita->konten = $konten;
        return $berita;
    }

    public function getSingleBerita()
    {
        $id_berita = $this->input->post('id_berita');
        $berita = $this->getBeritaDatas($id_berita);

        echo json_encode($berita);
    }
}
