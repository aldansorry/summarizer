<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cosine
{

    var $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->library(['preprocessing', 'tfidf']);
    }

    /*
    $query_berita = judul query berita
    $doc_berita = array doc berita key = id => value = judul
    */
    public function process($query_berita, $array_doc_berita)
    {
        $similarity = [];
        $query_preprocessing = $this->CI->preprocessing->process($query_berita)->processed;

        foreach ($array_doc_berita as $id_berita => $doc_berita) {
            $doc_preprocessing = $this->CI->preprocessing->process($doc_berita)->processed;

            $tfidf = $this->CI->tfidf->process([$query_preprocessing, $doc_preprocessing]);

            $sum_a = 0;
            $sum_b = 0;
            $sum_c = 0;
            foreach ($tfidf->matrixTFIDF as $key => $value) {
                $sum_a += $value[0] * $value[1];
                $sum_b += pow($value[0],2);
                $sum_c += pow($value[1],2);
            }

            $sim = $sum_a / sqrt($sum_b * $sum_c);
            $similarity[$id_berita] = $sim;
        }
        return $similarity;
    }
}
