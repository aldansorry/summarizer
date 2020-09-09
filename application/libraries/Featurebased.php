<?php
defined('BASEPATH') or exit('No direct script access allowed');


class FeatureBased
{
    protected $CI;

    var $title;
    var $arrayOfSentence;

    var $feature1;
    var $feature2;
    var $feature3;
    var $feature4;
    var $feature5;
    var $feature6;
    var $feature1_data;
    var $feature2_data;
    var $feature3_data;
    var $feature4_data;
    var $feature5_data;
    var $feature6_data;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->library("matrix");
        $this->CI->load->library("tfidf");
        $this->CI->load->library("preprocessing");
    }



    public function cal_f1()
    {

        $errorlevel = error_reporting();
        error_reporting($errorlevel & ~E_NOTICE);

        $data_preprocessing = [];
        foreach ($this->arrayOfSentence as $key => $value) {
            $data_preprocessing[$key] = $this->CI->preprocessing->process($value)->processed;
        }


        $tfidf = $this->CI->tfidf->process($data_preprocessing);

        $USV = $this->CI->matrix->svd($tfidf->matrixTFIDF);

        $matrix_vt = $this->CI->matrix->matrixRound($USV["V"]);

        ##destroy nan to 0
        foreach($matrix_vt as $key => $value){
            foreach($value as $k => $v){
                if(is_nan($v)){
                    $matrix_vt[$key][$k] = 0;
                }
            }
        }

        error_reporting($errorlevel);

        $matrix_vt_avg = [];
        foreach ($matrix_vt as $key => $value) {
            $matrix_vt_avg[$key] = (array_sum($value)) / count($value);
        }


        $matrix_clsa = $matrix_vt;
        foreach ($matrix_vt as $key => $value) {
            foreach ($value as $k => $v) {
                if ($v < $matrix_vt_avg[$key]) {
                    $matrix_clsa[$key][$k] = 0;
                }
            }
        }

        $matrix_clsa_length = [];
        foreach ($data_preprocessing as $key => $value) {
            $matrix_clsa_length[$key] = 0;
        }
        foreach ($matrix_clsa as $key => $value) {

            foreach ($value as $k => $v) {
                $matrix_clsa_length[$k] += $v;
            }
        }


        $feature1 = $matrix_clsa_length;
        $this->feature1 = $feature1;
        $this->feature1_data = [
            'vt' => $matrix_vt,
            'avg' => $matrix_vt_avg,
            'clsa' => $matrix_clsa,
            'length' => $matrix_clsa_length
        ];
    }

    public function cal_f2()
    {

        $title_preprocess = $this->CI->preprocessing->process($this->title, $stopword = false)->processed;

        $preprocessing_kalimat = [];
        foreach ($this->arrayOfSentence as $key => $value) {
            $preprocessing_kalimat[$key] = $this->CI->preprocessing->process($value, $stopword = false)->processed;
        }

        $count_judul = count($title_preprocess);
        $feature2 = [];
        foreach ($preprocessing_kalimat as $key => $value) {
            $feature2[$key] = count(array_intersect($value, $title_preprocess)) / $count_judul;
        }

        $this->feature2 = $feature2;
        $this->feature2_data = [
            'title_preprocessing' => $title_preprocess,
            'data_preprocessing' => $preprocessing_kalimat,
        ];
    }

    public function cal_f3()
    {
        $preprocessing_kalimat = [];
        foreach ($this->arrayOfSentence as $key => $value) {
            $preprocessing_kalimat[$key] = $this->CI->preprocessing->process($value, $stopword = false, $lower = false)->processed;
        }
        $feature3 = [];
        foreach ($preprocessing_kalimat as $key => $value) {
            $count_capital = 0;
            foreach ($value as $k => $v) {
                if (preg_match('/[A-Z]/', $v)) {
                    $count_capital++;
                }
            }
            $feature3[$key] = $count_capital / count($value);
        }
        $this->feature3 = $feature3;
        $this->feature3_data = [
            'data_preprocessing' => $preprocessing_kalimat,
        ];
    }

    public function cal_f4()
    {
        $preprocessing_kalimat = [];
        foreach ($this->arrayOfSentence as $key => $value) {
            $preprocessing_kalimat[$key] = $this->CI->preprocessing->process($value, $stopword = false, $lower = false, $filter = false)->processed;
        }

        $count_kalimat = [];
        foreach ($preprocessing_kalimat as $key => $value) {
            $count_kalimat[$key] = count($value);
        }

        $longest_kalimat = max($count_kalimat);
        $kata_dalam_kutipan = [];
        $feature4 = [];
        foreach ($preprocessing_kalimat as $key => $value) {
            if (preg_match('/"([^"]+)"/', implode(" ", $value), $m)) {
                $kata_dalam_kutipan[$key] = count(explode(" ", $m[1]));
                $feature4[$key] = count(explode(" ", $m[1])) / $longest_kalimat;
            } else {
                $kata_dalam_kutipan[$key] = 0;
                $feature4[$key] = 0;
            }
        }
        $this->feature4 = $feature4;
        $this->feature4_data = [
            'kalimat_terpanjang' => $longest_kalimat,
            'kata_dalam_kutipan' => $kata_dalam_kutipan,
            'data_preprocessing' => $preprocessing_kalimat,
        ];
    }

    public function cal_f5()
    {
        $preprocessing_kalimat = [];
        foreach ($this->arrayOfSentence as $key => $value) {
            $preprocessing_kalimat[$key] = $this->CI->preprocessing->process($value, $stopword = false, $lower = false, $filter = false)->processed;
        }

        $feature5 = [];
        foreach ($preprocessing_kalimat as $key => $value) {
            $count_number = 0;
            foreach ($value as $k => $v) {
                if (is_numeric(preg_replace("/[^a-zA-Z0-9\s .]/", "", $v))) {
                    $count_number++;
                }
            }
            $feature5[$key] = $count_number / count($value);
        }
        $this->feature5 = $feature5;
        $this->feature5_data = [
            'data_preprocessing' => $preprocessing_kalimat,
        ];
    }

    public function cal_f6()
    {
        $preprocessing_kalimat = [];
        foreach ($this->arrayOfSentence as $key => $value) {
            $preprocessing_kalimat[$key] = $this->CI->preprocessing->process($value, $stopword = false, $lower = false, $filter = false)->processed;
        }

        $count_kalimat = [];
        foreach ($preprocessing_kalimat as $key => $value) {
            $count_kalimat[$key] = count($value);
        }

        $longest_kalimat = max($count_kalimat);
        $feature6 = [];
        foreach ($preprocessing_kalimat as $key => $value) {
            $feature6[$key] = count($value) / $longest_kalimat;
        }

        $this->feature6 = $feature6;
        
        $this->feature6_data = [
            'kalimat_terpanjang' => $longest_kalimat,
            'data_preprocessing' => $preprocessing_kalimat,
        ];
    }

    public function process($title, $arrayOfSentence)
    {
        $this->title = $title;
        $this->arrayOfSentence = $arrayOfSentence;

        $this->cal_f1();
        $this->cal_f2();
        $this->cal_f3();
        $this->cal_f4();
        $this->cal_f5();
        $this->cal_f6();

        $feature = [];
        foreach($this->arrayOfSentence as $key => $value){
            $feature[$key] = [
                'f1' => $this->feature1[$key],
                'f2' => $this->feature2[$key],
                'f3' => $this->feature3[$key],
                'f4' => $this->feature4[$key],
                'f5' => $this->feature5[$key],
                'f6' => $this->feature6[$key],
            ];
        }

        return $feature;
    }

    public function getData()
    {
        $data = [
            'f1' => $this->feature1_data,
            'f2' => $this->feature2_data,
            'f3' => $this->feature3_data,
            'f4' => $this->feature4_data,
            'f5' => $this->feature5_data,
            'f6' => $this->feature6_data,
        ];

        return $data;
    }
}
