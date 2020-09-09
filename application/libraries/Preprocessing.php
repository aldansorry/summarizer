<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Preprocessing
{
    var $plain;
    var $processed;

    public function lower()
    {
        $this->processed = strtolower($this->processed);
    }

    public function filter()
    {
        $this->processed = preg_replace("/[^a-zA-Z\s .]/", "", $this->processed);
    }

    public function stem()
    {
        $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
        $stemmer  = $stemmerFactory->createStemmer();

        $this->processed = $stemmer->stem($this->processed);
    }

    public function token()
    {
        $this->processed = explode(" ", $this->processed);
    }

    public function stopword()
    {
        $file_stopword = "application/sources/stopword.txt";
        $GLOBALS['stopwords'] = explode("\n", file_get_contents($file_stopword));

        $this->processed = array_filter($this->processed, function ($key) {
            return !in_array($key, $GLOBALS['stopwords']);
        });
    }

    public function process($text, $stopword = true, $lower = true, $filter = true)
    {
        $this->plain = $text;
        $this->processed = $text;
        
        $preprocessing = (object)[];
        if ($lower) {
            $this->lower();
        }
        $preprocessing->lower = $this->processed;

        if ($filter) {
            $this->filter();
        }
        $preprocessing->filter = $this->processed;
        
        if ($lower) {
            $this->stem();
        }
        $preprocessing->stem = $this->processed;

        $this->token();
        $preprocessing->token = $this->processed;

        if ($stopword) {
            $this->stopword();
        }
        $preprocessing->stopword = $this->processed;
        $preprocessing->processed = $this->processed;

        return $preprocessing;
    }
}
