<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Relevansi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        user_allow([]);
    }

    public function index()
    {
        $view_data = [
            'title'     => 'Relevansi',
            'cname'     => 'Relevansi',
            'page'      => 'relevansi/index',
            'script'    => 'relevansi/script'
        ];
        $this->load->view('layout/dashboard', $view_data);
    }

    public function getRelevansiData()
    {
        $data['data'] = $this->db
            ->select('relevansi.*,berita_1.judul as judul_berita_1,berita_2.judul as judul_berita_2')
            ->join('berita berita_1', "relevansi.fk_berita_1=berita_1.id")
            ->join('berita berita_2', "relevansi.fk_berita_2=berita_2.id")
            ->get('relevansi')
            ->result();

        echo json_encode($data);
    }

    public function getContent()
    {
        $query_relevanted = $this->db->where('_relevanted',0)->get('berita');
        echo json_encode([
            'count_unrelevanted' => $query_relevanted->num_rows(),
        ]);
    }

    public function doRelevansi()
    {
        ini_set('max_execution_time', 1200);
        set_time_limit(1200);
        ini_set('memory_limit', '-1');

        $this->load->library("preprocessing");
        $this->load->library("cosine");

        $threshold = (float) getConfig("relevansi_kompresi");
        
        $data_berita = $this->db->order_by('tanggal', 'desc')->where('_relevanted',0)->get('berita',5,0)->result();

        $count_relevanted = 0;
        foreach ($data_berita as $key => $berita) {
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

            foreach ($similarity as $k => $v) {

                if(count($v) == 0)
                    continue;
                $max = max($v);
                $id_compared = array_keys($v, $max)[0];


                if ($max > $threshold) {
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
            $this->db->where('id',$berita->id)->update('berita',['_relevanted' => 1]);
            $count_relevanted++;
        }

        $query_berita = $this->db->order_by('tanggal', 'desc')->where('_relevanted',0)->get('berita',5,0);
        $has_continue = true;
        if($query_berita->num_rows() == 0){
            $has_continue = false;
        }

        echo json_encode([
            'has_continue' => $has_continue,
            'count_relevanted' => $count_relevanted,
        ]);
    }

    public function test()
    {
        $this->load->library("preprocessing");
        $this->load->library("cosine");

        $time_start = microtime(true);

        $data_berita = $this->db->where('id', 9128)->get('berita')->row(0);

        $after = getConfig("relevansi_selisih_sesudah");
        $before = getConfig("relevansi_selisih_sebelum");

        $tanggal = new DateTime($data_berita->tanggal);
        $tanggal_after = $tanggal->modify("+" . $after . " days")->format("Y-m-d");
        $tanggal_bofore = $tanggal->modify("-" . ($after + $before) . " days")->format("Y-m-d");

        $campared_berita = $this->db
            ->where('tanggal <=', $tanggal_after)
            ->where('tanggal >=', $tanggal_bofore)
            ->where('fk_sumber !=', $data_berita->fk_sumber)
            ->get('berita')->result();

        $doc_berita = [];
        foreach ($campared_berita as $key => $value) {
            $doc_berita[$value->id] = $value->judul;
        }

        $similarity = $this->cosine->process($data_berita->judul, $doc_berita);

        $time_end = microtime(true);

        d($similarity);
        $execution_time = ($time_end - $time_start);
        dd($execution_time);
    }
}
