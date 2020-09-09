<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Featuring extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        user_allow([]);
    }

    public function index()
    {
        $view_data = [
            'title'     => 'Featuring Analyst',
            'cname'     => 'Featuring',
            'page'      => 'featuring/index',
            'script'    => 'featuring/script'
        ];
        $view_data['bobot'] = $this->db->get('bobot')->result();
        $this->load->view('layout/dashboard', $view_data);
    }


    public function getRawData()
    {
        $data['raw_berita'] = $this->db
            ->select('berita.*')
            ->join('berita_kalimat', 'berita.id=berita_kalimat.fk_berita', 'left')
            ->where('berita_kalimat.kalimat !=', null)
            ->where('berita_kalimat.f1', null)
            // ->where('berita_kalimat.f2',null)
            // ->where('berita_kalimat.f3',null)
            // ->where('berita_kalimat.f4',null)
            // ->where('berita_kalimat.f5',null)
            // ->where('berita_kalimat.f6',null)
            ->group_by('berita.id')
            ->order_by('berita.id')
            ->get('berita')
            ->result();

        echo json_encode($data);
    }

    public function doFeaturing()
    {
        $data_unfeatured = $this->db
            ->select('berita.*')
            ->join('berita_kalimat', 'berita.id=berita_kalimat.fk_berita', 'left')
            ->where('berita_kalimat.kalimat !=', null)
            ->where('berita_kalimat.f1', null)
            // ->where('berita_kalimat.f2',null)
            // ->where('berita_kalimat.f3',null)
            // ->where('berita_kalimat.f4',null)
            // ->where('berita_kalimat.f5',null)
            // ->where('berita_kalimat.f6',null)
            ->group_by('berita.id')
            ->order_by('berita.id')
            ->get('berita', 10, 0)
            ->result();

        $this->load->library('featurebased');

        $count_featured = 0;
        foreach ($data_unfeatured as $data_berita) {
            $data_berita = $this->db->where('id', $data_berita->id)->get('berita')->row(0);
            $data_berita_kalimat = $this->db->where('fk_berita', $data_berita->id)->get('berita_kalimat')->result();

            #tfidf
            $preprocessing_kalimat = [];
            foreach ($data_berita_kalimat as $key => $value) {
                $preprocessing_kalimat[$value->index_kalimat] = $value->kalimat;
            }

            $feature = $this->featurebased->process($data_berita->judul, $preprocessing_kalimat);

            foreach ($feature as $key => $value) {
                $set = $value;
                $update = $this->db
                    ->where('fk_berita', $data_berita->id)
                    ->where('index_kalimat', $key)
                    ->update('berita_kalimat', $set);
            }
            if ($update) {
                $count_featured++;
            }
        }

        $has_continue = true;
        if (count($data_unfeatured) == 0) $has_continue = false;

        echo json_encode([
            'count_featured' => $count_featured,
            'has_continue' => $has_continue
        ]);
    }


    public function getFeaturingBerita()
    {
        #createview#
        $data['data'] =  $this->db
            ->select('berita.*')
            ->join('berita_kalimat', 'berita.id=berita_kalimat.fk_berita', 'left')
            ->where('berita_kalimat.kalimat !=', null)
            ->group_by('berita.id')
            ->order_by('berita.id')
            ->get('berita')
            ->result();

        foreach ($data['data'] as $key => $value) {
            $data['data'][$key]->tanggal = date("d-m-Y H:i", strtotime($value->tanggal));
        }

        echo json_encode($data);
    }

    public function getBeritaDetail()
    {

        $this->load->library('preprocessing');
        $this->load->library('tfidf');
        $this->load->library('featurebased');

        $id = $this->input->post('id');

        $data_berita = $this->db->where('id', $id)->get('berita')->row(0);
        $data_berita_kalimat = $this->db
            ->where('fk_berita', $id)
            ->get('berita_kalimat')
            ->result();

        $preprocessing_kalimat = [];
        foreach ($data_berita_kalimat as $key => $value) {
            $preprocessing_kalimat[$value->index_kalimat] = $value->kalimat;
        }

        $feature = $this->featurebased->process($data_berita->judul, $preprocessing_kalimat);

        if ($data_berita_kalimat[0]->f1 == null) {
            foreach ($feature as $key => $value) {
                $set = $value;
                $update = $this->db
                    ->where('fk_berita', $id)
                    ->where('index_kalimat', $key)
                    ->update('berita_kalimat', $set);
            }
            $data_berita_kalimat = $this->db
                ->where('fk_berita', $id)
                ->get('berita_kalimat')
                ->result();
        }

        $feature_data = $this->featurebased->getData();

        $f1_data = [];
        $f1_column = [];
        foreach ($feature_data['f1']['vt'] as $key => $value) {
            foreach ($value as $k => $v) {
                if ($v != $feature_data['f1']['clsa'][$key][$k]) {
                    $f1_data[$key]["no" . ($k + 1)] = "<strike>" . $v . "</strike>";
                } else {
                    $f1_data[$key]["no" . ($k + 1)] = $v;
                }
            }
            $f1_data[$key]['avg'] = $feature_data['f1']['avg'][$key];
        }
        $length_index = $key + 1;
        foreach ($feature_data['f1']['length'] as $key => $value) {
            $f1_data[$length_index]["no" . ($key + 1)] = "<b>" . $value . "</b>";;
        }
        $f1_data[$length_index]['avg'] = "";

        foreach ($f1_data[0] as $key => $value) {
            $f1_column[] = [
                'title' => $key,
                'data' => $key,
                'orderable' => ($key == "avg" ? false : true)
            ];
        }

        $data_preprocessing = [];
        $preprocessing_kalimat = [];
        foreach ($data_berita_kalimat as $key => $value) {
            $preprocessing = $this->preprocessing->process($value->kalimat);
            $preprocessing_kalimat[$value->index_kalimat + 1] = $preprocessing->processed;

            $string_tokenizing = "[" . implode("],[", $preprocessing->token) . "]";
            $string_stopword = "[" . implode("],[", $preprocessing->processed) . "]";

            $data_preprocessing[] = [
                'plain' => $value->kalimat,
                'lower' => $preprocessing->lower,
                'filtered' => $preprocessing->filter,
                'stem' => $preprocessing->stem,
                'no_kalimat' => $value->index_kalimat + 1,
                'tokenizing' => $string_tokenizing,
                'stopword' => $string_stopword,
            ];
        }

        $tfidf = $this->tfidf->process($preprocessing_kalimat);

        $tf_data = [];
        foreach ($tfidf->matrixTF as $key => $value) {
            $row_data = [];
            $row_data['no'] = $key + 1;
            $row_data['kata'] = $tfidf->indexWord[$key];
            foreach ($value as $k => $v) {
                $row_data['no' . $k] = $v;
            }
            $row_data['df'] = $tfidf->matrixDF[$key];
            $row_data['idf'] = $tfidf->matrixIDF[$key];
            $row_data['idfplus'] = $tfidf->matrixIDFplus[$key];
            $tf_data[] = $row_data;
        }
        $tf_column = [];
        foreach ($tf_data[0] as $key => $value) {
            $tf_column[] = [
                'title' => $key,
                'data' => $key,
            ];
        }

        $tfidf_data = [];
        foreach ($tfidf->matrixTFIDF as $key => $value) {
            $row_data = [];
            $row_data['no'] = $key + 1;
            $row_data['kata'] = $tfidf->indexWord[$key];
            foreach ($value as $k => $v) {
                $row_data['no' . $k] = $v;
            }
            $tfidf_data[] = $row_data;
        }
        $tfidf_column = [];
        foreach ($tfidf_data[0] as $key => $value) {
            $tfidf_column[] = [
                'title' => $key,
                'data' => $key,
            ];
        }

        $data['berita_data'] = $this->db
            ->select('*')
            ->from('berita')
            ->where('id', $id)
            ->get()
            ->row(0);
        $data['kalimat_data'] = $data_berita_kalimat;
        $data['tf'] = [
            'column' => $tf_column,
            'data' => $tf_data
        ];
        $data['tfidf'] = [
            'column' => $tfidf_column,
            'data' => $tfidf_data
        ];
        $data['f1'] = [
            'column' => $f1_column,
            'data' => $f1_data
        ];
        $data['preprocessing_data'] = $data_preprocessing;
        $data['f1_data'] = $this->load->view('pages/featuring/table_f1', ['column' => $f1_column, 'data' => $f1_data], true);
        $data['f2_data'] = $this->load->view('pages/featuring/table_f2', $feature_data['f2'], true);
        $data['f3_data'] = $this->load->view('pages/featuring/table_f3', $feature_data['f3'], true);
        $data['f4_data'] = $this->load->view('pages/featuring/table_f4', $feature_data['f4'], true);
        $data['f5_data'] = $this->load->view('pages/featuring/table_f5', $feature_data['f5'], true);
        $data['f6_data'] = $this->load->view('pages/featuring/table_f6', $feature_data['f6'], true);
        $data['konten_data'] = $this->load->view('pages/featuring/konten', ['data_berita_kalimat' => $data_berita_kalimat], true);

        echo json_encode($data);
    }

    public function getSummarized()
    {
        $this->load->library("summarizer");
        $id_berita = $this->input->post('id_berita');
        $id_bobot = $this->input->post('id_bobot');

        $db_bobot = $this->db
            ->where('id', $id_bobot)
            ->get('bobot')
            ->row(0);


        $db_berita_kalimat = $this->db
            ->where('fk_berita', $id_berita)
            ->get('berita_kalimat')
            ->result();

        $summarized_kalimat = $this->summarizer->process($db_berita_kalimat, $db_bobot);
        $matrix_pembobotan = $this->summarizer->matrix_pembobotan;

        echo json_encode([
            'data_pembobotan' => $matrix_pembobotan,
            'summarized_kalimat' => $summarized_kalimat,
            'ringkasan_data' => $this->load->view('pages/featuring/ringkasan', ['summarized_kalimat' => $summarized_kalimat], true)
        ]);
    }

    public function coba()
    {
        $this->load->library('preprocessing');
        $this->load->library('tfidf');
        $this->load->library('featurebased');

        $data_berita = $this->db
            ->select('*')
            ->from('berita')
            ->where('id', 21)
            ->get()
            ->row(0);
        $data_berita_kalimat = $this->db
            ->where('fk_berita', 21)
            ->get('berita_kalimat')
            ->result();

        #tfidf
        $preprocessing_kalimat = [];
        foreach ($data_berita_kalimat as $key => $value) {
            $preprocessing_kalimat[$value->index_kalimat] = $value->kalimat;
        }

        dd($this->featurebased->process($data_berita->judul, $preprocessing_kalimat));
    }
}
