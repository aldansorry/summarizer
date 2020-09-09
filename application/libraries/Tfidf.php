<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Tfidf
{
    var $arrayOfDoc;
    var $listWord;
    var $matrixTF;
    var $matrixTF_assoc;
    var $matrixDF;
    var $matrixIDF;
    var $matrixIDFplus;
    var $matrixTFIDF;
    var $matrixTFIDF_assoc;
    var $indexWord;

    public function mergeWord()
    {
        $listWord = [];
        foreach ($this->arrayOfDoc as $value) {
            $listWord = array_merge($listWord, $value);
        }
        $listWord = array_unique($listWord);
        $this->listWord = $listWord;
    }

    public function matrixTF()
    {
        $indexWord = [];
        $matrixTF = [];
        foreach ($this->listWord as $key_word => $word) {

            foreach ($this->arrayOfDoc as $key_text => $value_text) {
                $count_word = 0;
                foreach ($value_text as $v) {
                    if ($word == $v) {
                        $count_word++;
                    }
                }
                $indexWord[$key_word] = $word;
                $matrixTF[$key_word][$key_text] = $count_word;
            }
        }
        $this->indexWord = $indexWord;
        $this->matrixTF = $matrixTF;
    }

    public function matrixDF()
    {
        $matrixDF = [];
        foreach ($this->matrixTF as $key => $value) {
            $df = 0;
            foreach ($value as $k => $v) {
                if ($v > 0) {
                    $df++;
                }
            }
            $matrixDF[$key] = $df;
        }
        $this->matrixDF = $matrixDF;
    }

    public function matrixTFIDF()
    {
        $text_dperdf = [];
        $matrixIDF = [];
        $matrixIDFplus = [];
        $word_count = count($this->arrayOfDoc);
        foreach ($this->matrixDF as $key => $value) {
            $dperdf = $word_count / $value;
            $text_dperdf[$key] = $dperdf;
            $idf = log10($dperdf);
            $matrixIDF[$key] = $idf;
            $matrixIDFplus[$key] = $idf + 1;
        }

        $matrixTFIDF = [];
        foreach ($this->matrixTF as $key => $value) {
            foreach ($value as $k => $v) {
                $matrixTFIDF[$key][$k] = $v * $matrixIDFplus[$key];
            }
        }

        $this->matrixIDF = $matrixIDF;
        $this->matrixIDFplus = $matrixIDFplus;
        $this->matrixTFIDF = $matrixTFIDF;
    }

    public function matrixTFIDF_assoc()
    {
        $matrixTFIDF_assoc = [];
        foreach($this->matrixTFIDF as $key => $value){
            foreach($value as $k => $v){
                $matrixTFIDF_assoc[$this->indexWord[$key]][$k] = $v;
            }
        }

        $this->matrixTFIDF_assoc = $matrixTFIDF_assoc;
    }

    public function matrixTF_assoc()
    {
        $matrixTF_assoc = [];
        foreach($this->matrixTF as $key => $value){
            foreach($value as $k => $v){
                $matrixTF_assoc[$this->indexWord[$key]][$k] = $v;
            }
        }

        $this->matrixTF_assoc = $matrixTF_assoc;
    }

    public function process($arrayOfDoc)
    {
        $this->arrayOfDoc = $arrayOfDoc;
        $tfidf = (object) [];
        $this->mergeWord();
        $this->matrixTF();
        $this->matrixDF();
        $this->matrixTFIDF();
        $this->matrixTFIDF_assoc();
        $this->matrixTF_assoc();


        $tfidf->arrayOfDoc = $this->arrayOfDoc;
        $tfidf->indexWord = $this->indexWord;
        $tfidf->listWord = $this->listWord;
        $tfidf->matrixTF = $this->matrixTF;
        $tfidf->matrixDF = $this->matrixDF;
        $tfidf->matrixIDF = $this->matrixIDF;
        $tfidf->matrixIDFplus = $this->matrixIDFplus;
        $tfidf->matrixTFIDF = $this->matrixTFIDF;
        $tfidf->matrixTFIDF_assoc = $this->matrixTFIDF_assoc;
        $tfidf->matrixTF_assoc = $this->matrixTF_assoc;
        return $tfidf;
    }
}
