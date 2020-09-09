<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Summarizer
{

    var $CI;
    var $sentences;

    var $matrix_pembobotan;


    public function __construct()
    {
        $this->CI = &get_instance();
    }


    public function process($data_berita, $data_bobot, $max_sentence = null, $min_sentence = null)
    {
        $sum_kalimat = [];
        $data_truncate = [];
        foreach ($data_berita as $key => $value) {
            $data_truncate['f1'][] = $value->f1;
            $data_truncate['f2'][] = $value->f2;
            $data_truncate['f3'][] = $value->f3;
            $data_truncate['f4'][] = $value->f4;
            $data_truncate['f5'][] = $value->f5;
            $data_truncate['f6'][] = $value->f6;
        }

        $max_data = [];
        foreach ($data_truncate as $key => $value) {
            $max_data[$key] = max($value);
        }


        $matrix_pembobotan = [];
        foreach ($data_berita as $key => $value) {
            $value->f1 = ($max_data['f1'] == 0 ? 0 : $value->f1 / $max_data['f1']);
            $value->f2 = ($max_data['f2'] == 0 ? 0 : $value->f2 / $max_data['f2']);
            $value->f3 = ($max_data['f3'] == 0 ? 0 : $value->f3 / $max_data['f3']);
            $value->f4 = ($max_data['f4'] == 0 ? 0 : $value->f4 / $max_data['f4']);
            $value->f5 = ($max_data['f5'] == 0 ? 0 : $value->f5 / $max_data['f5']);
            $value->f6 = ($max_data['f6'] == 0 ? 0 : $value->f6 / $max_data['f6']);

            $f1 = $value->f1 * $data_bobot->f1;
            $f2 = $value->f2 * $data_bobot->f2;
            $f3 = $value->f3 * $data_bobot->f3;
            $f4 = $value->f4 * $data_bobot->f4;
            $f5 = $value->f5 * $data_bobot->f5;
            $f6 = $value->f6 * $data_bobot->f6;
            $sum = $f1 + $f2 + $f3 + $f4 + $f5 + $f6;

            $matrix_pembobotan[$key] = [
                'no' => $value->index_kalimat + 1,
                'paragraft' => $value->paragraft,
                'kalimat' => $value->kalimat,
                'f1' => $f1,
                'f2' => $f2,
                'f3' => $f3,
                'f4' => $f4,
                'f5' => $f5,
                'f6' => $f6,
                'sum' => $sum,
            ];
            $sum_kalimat[$key] = $sum;
        }

        $jumlah_kata = count($data_berita) * (100 - $data_bobot->kompresi) / 100;
        $jumlah_kata = ceil($jumlah_kata);

        if ($max_sentence != null) {
            $jumlah_kata = ($jumlah_kata >= $max_sentence ? $max_sentence : $jumlah_kata);
        }


        if ($min_sentence != null) {
            $jumlah_kata = ($jumlah_kata <= $min_sentence ? $min_sentence : $jumlah_kata);
        }

        $rankings = $sum_kalimat;
        rsort($rankings);

        $summarized_value = array_slice($rankings, 0, $jumlah_kata);


        $summarized_kalimat = [];
        foreach ($summarized_value as $value) {
            $key = array_search($value, $sum_kalimat);
            $kalimat = $matrix_pembobotan[$key];
            $summarized_kalimat[(int) $kalimat['no']] = (object) $matrix_pembobotan[$key];
        }

        ksort($summarized_kalimat);
        $this->matrix_pembobotan = $matrix_pembobotan;

        return $summarized_kalimat;
    }

    public function accuracy($auto, $manual)
    {
        $auto_intersect_manual = array_intersect($auto, $manual);

        $count_auto_intersect_manual = count($auto_intersect_manual);

        $count_auto = count($auto);
        $count_manual = count($manual);

        $precision = $count_auto_intersect_manual / $count_auto;
        $recall = $count_auto_intersect_manual / $count_manual;

        if (($precision + $recall) != 0)
            $fmeasure = 2 * (($precision * $recall) / ($precision + $recall));
        else
            $fmeasure = 0;

        return (object) [
            'precision' => $precision,
            'recall' => $recall,
            'fmeasure' => $fmeasure,
        ];
    }
}
