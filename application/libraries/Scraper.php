<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Scraper
{
    protected $CI;


    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function getElementsByClass(&$parentNode, $tagName, $className)
    {
        $nodes = array();

        $childNodeList = $parentNode->getElementsByTagName($tagName);
        for ($i = 0; $i < $childNodeList->length; $i++) {
            $temp = $childNodeList->item($i);
            if (in_array($className, explode(" ", $temp->getAttribute('class')))) {
                $nodes[] = $temp;
            }
        }

        return $nodes;
    }

    public function katadata($date_from, $date_to, $is_curl = true)
    {
        $result = [];
        $page = 0;

        $judul_tmp = "";

        do {
            $is_continue = true;
            $html = "https://katadata.co.id/indeks/search/-/" . $date_from . "/" . $date_to . "/1/-/-/" . ($page * 10);
            if ($is_curl) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $html);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $html_content = curl_exec($ch);
            } else {
                $html_content = @file_get_contents($html);
            }

            if ($html_content == false) {
                return false;
            }

            libxml_use_internal_errors(true);
            $DOM = new DOMDocument();
            $DOM->loadHTML($html_content);
            $finder = new DomXPath($DOM);

            $header_class = 'listing2';
            $header_node = $finder->query("//*[contains(@class, '$header_class')]");

            $sum = 0;
            foreach ($header_node as $node) {
                $ul = $node->getElementsByTagName('ul');
                $li = $ul[1]->getElementsByTagName('li');
                foreach ($li as $key => $a) {
                    // $arr_category[] = $DOM->saveHTML($a);
                    $p = $a->getElementsByTagName('p');
                    $h2 = $a->getElementsByTagName('h2');
                    $h3 = $a->getElementsByTagName('h3');
                    $img = $a->getElementsByTagName('img');
                    $aa = $a->getElementsByTagName('a');


                    $time = substr($p[0]->nodeValue, 0, -3);
                    $time = str_replace(".", ":", $time);
                    $time = str_replace("/", "-", $time);

                    $judul = trim($h2[0]->nodeValue);
                    if($key == 0){
                        if($judul == $judul_tmp){
                            $is_continue = false;
                        }else{
                            $judul_tmp = $judul;
                        }
                    }

                    $result[] = [
                        'tanggal' => date('Y-m-d H:i:s', strtotime($time)),
                        'judul' => $judul,
                        'kategori' => trim($aa[0]->nodeValue),
                        'gambar' => trim($img[0]->getAttribute("data-src")),
                        'link' => trim($aa[2]->getAttribute("href")),
                        'fk_sumber' => 1,
                    ];
                    $sum++;
                }
            }

            if (!$is_continue) {
                break;
            }
            $page++;
        } while ($sum == 10);

        return (object) [
            'result' => $result,
            'count' => count($result)
        ];
    }

    public function detikConvertTime($time)
    {
        if (strpos($time, "JAM")) {
            $get_number = preg_replace('/[^0-9]/', '', $time);
            return date("Y-m-d H:i:s", strtotime("-" . $get_number . " hour"));
        } else if (strpos($time, "MENIT")) {
            $get_number = preg_replace('/[^0-9]/', '', $time);
            return date("Y-m-d H:i:s", strtotime("-" . $get_number . " minutes"));
        } else {
            $string = $time;

            $string = substr($string, 0, -4);
            if (isset(explode(", ", $string)[1])) {
                $string = explode(", ", $string)[1];
            } else {
                echo $time;
                die("HAYO");
            }

            $string = str_replace("Jan", "Jan", $string);
            $string = str_replace("Feb", "Feb", $string);
            $string = str_replace("Mar", "Mar", $string);
            $string = str_replace("Apr", "Apr", $string);
            $string = str_replace("Mei", "May", $string);
            $string = str_replace("Jun", "Jun", $string);
            $string = str_replace("Jul", "Jul", $string);
            $string = str_replace("Agu", "Aug", $string);
            $string = str_replace("Sep", "Sep", $string);
            $string = str_replace("Okt", "Oct", $string);
            $string = str_replace("Nov", "Nov", $string);
            $string = str_replace("Des", "Dec", $string);

            return date("Y-m-d H:i:s", strtotime($string));
        }
    }

    public function detik($date_from, $date_to, $is_curl = true)
    {
        $category[] = [
            'name' => 'detikNews',
            'link' => 'https://news.detik.com/indeks',
            'type' => 1,
        ];
        $category[] = [
            'name' => 'detikFinance',
            'link' => 'https://finance.detik.com/indeks',
            'type' => 2,
        ];
        $category[] = [
            'name' => 'detikHot',
            'link' => 'https://hot.detik.com/indeks',
            'type' => 2,
        ];
        $category[] = [
            'name' => 'detikSport',
            'link' => 'https://sport.detik.com/indeks',
            'type' => 2,
        ];
        $category[] = [
            'name' => 'detikOto',
            'link' => 'https://oto.detik.com/indeks',
            'type' => 2,
        ];

        $category[] = [
            'name' => 'Sepak Bola',
            'link' => 'https://sport.detik.com/sepakbola/indeks',
            'type' => 2,
        ];

        $category[] = [
            'name' => 'detikFood',
            'link' => 'https://food.detik.com/indeks',
            'type' => 3,
        ];

        $category[] = [
            'name' => 'detikNet',
            'link' => 'https://inet.detik.com/indeks',
            'type' => 3,
        ];

        $category[] = [
            'name' => 'detikHealth',
            'link' => 'https://health.detik.com/indeks',
            'type' => 4,
        ];


        $category[] = [
            'name' => 'detikTravel',
            'link' => 'https://travel.detik.com/indeks',
            'type' => 5,
        ];

        $category[] = [
            'name' => 'detikWolipop',
            'link' => 'https://wolipop.detik.com/indeks',
            'type' => 6,
        ];
        $result = [];



        foreach ($category as $key => $value) {

            $first_date = new DateTime($date_from);
            $last_date = new DateTime($date_to);
            for ($i = $first_date; $i <= $last_date; $i->modify("+1 day")) {
                $page = 1;
                do {
                    $html = $value['link'] . "/" . $page . "?date=" . $i->format('m/d/Y');



                    if ($is_curl) {
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $html);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $html_content = curl_exec($ch);
                    } else {
                        $html_content = @file_get_contents($html);
                    }

                    if ($html_content == false) {
                        return false;
                    }


                    libxml_use_internal_errors(true);
                    $DOM = new DOMDocument();
                    $DOM->loadHTML($html_content);
                    $finder = new DomXPath($DOM);


                    $sum = 0;
                    if ($value['type'] == 1) {
                        $header_class = 'list-content__item';
                        $header_node = $finder->query("//*[contains(@class, '$header_class')]");

                        foreach ($header_node as $node) {
                            // $result[] = $node->nodeValue;

                            $image_node = $this->getElementsByClass($node, "div", 'media__image');
                            $title_node = $this->getElementsByClass($node, "h3", 'media__title');
                            $tanggal_node = $this->getElementsByClass($node, "div", "media__date");


                            $time = $tanggal_node[0]->getElementsByTagName('span')[0]->getAttribute('d-time');

                            $link = $title_node[0]->getElementsByTagName('a')[0]->getAttribute('href');
                            $image = $image_node[0]->getElementsByTagName('img')[0]->getAttribute('src');

                            $result[] = [
                                'tanggal' => date("Y-m-d H:i:s", $time),
                                'judul' => trim($title_node[0]->nodeValue),
                                'kategori' => $value['name'],
                                'gambar' => $image,
                                'link' => $link,
                                'fk_sumber' => 2,
                            ];
                            $sum++;
                        }
                    }
                    if ($value['type'] == 2) {
                        $header_class = 'desc_idx';
                        $header_node = $finder->query("//*[contains(@class, '$header_class')]");

                        foreach ($header_node as $node) {
                            // $result[] = $node->nodeValue;
                            if (strpos($node->getElementsByTagName('span')[0]->nodeValue, "WIB") === false) {
                                $time = $node->getElementsByTagName('span')[1]->nodeValue;
                            } else {
                                $time = $node->getElementsByTagName('span')[0]->nodeValue;
                            }
                            $link = $node->getElementsByTagName('a')[0]->getAttribute('href');
                            $judul = $node->getElementsByTagName('a')[0]->nodeValue;

                            $result[] = [
                                'tanggal' => $this->detikConvertTime($time),
                                'judul' => trim($judul),
                                'kategori' => $value['name'],
                                'gambar' => "",
                                'link' => $link,
                                'fk_sumber' => 2,
                            ];
                            $sum++;
                        }
                    }
                    if ($value['type'] == 3) {
                        $header_class = 'feed';
                        $header_node = $finder->query("//*[contains(@class, '$header_class')]");

                        foreach ($header_node as $node) {
                            $li = $node->getElementsByTagName('li');
                            foreach ($li as $node_li) {

                                $time = $node_li->getElementsByTagName('span')[0]->nodeValue;
                                $link = $node_li->getElementsByTagName('a')[0]->getAttribute('href');
                                $judul = $node_li->getElementsByTagName('a')[0]->nodeValue;
                                $result[] = [
                                    'tanggal' => $this->detikConvertTime($time),
                                    'judul' => trim($judul),
                                    'kategori' => $value['name'],
                                    'gambar' => "",
                                    'link' => $link,
                                    'fk_sumber' => 2,
                                ];
                                $sum++;
                            }
                        }
                    }
                    if ($value['type'] == 4) {
                        $header_class = 'pd10';
                        $header_node = $finder->query("//*[contains(@class, '$header_class')]");

                        foreach ($header_node as $node) {
                            $li = $node->getElementsByTagName('li');
                            foreach ($li as $node_li) {

                                $time = $node_li->getElementsByTagName('span')[0]->nodeValue;
                                $link = $node_li->getElementsByTagName('a')[0]->getAttribute('href');
                                $judul = $node_li->getElementsByTagName('a')[0]->nodeValue;
                                $result[] = [
                                    'tanggal' => $this->detikConvertTime($time),
                                    'judul' => trim($judul),
                                    'kategori' => $value['name'],
                                    'gambar' => "",
                                    'link' => $link,
                                    'fk_sumber' => 2,
                                ];
                                $sum++;
                            }
                        }
                    }
                    if ($value['type'] == 5) {
                        $header_class = 'list__news__content';
                        $header_node = $finder->query("//*[contains(@class, '$header_class')]");

                        foreach ($header_node as $node) {

                            if (strpos($node->getElementsByTagName('div')[0]->nodeValue, "WIB") === false) {
                                $time = $node->getElementsByTagName('div')[1]->nodeValue;
                            } else {
                                $time = $node->getElementsByTagName('div')[0]->nodeValue;
                            }
                            $link = $node->getElementsByTagName('a')[0]->getAttribute('href');
                            $judul = $node->getElementsByTagName('a')[0]->nodeValue;

                            $result[] = [
                                'tanggal' => $this->detikConvertTime($time),
                                'judul' => trim($judul),
                                'kategori' => $value['name'],
                                'gambar' => "",
                                'link' => $link,
                                'fk_sumber' => 2,
                            ];
                            $sum++;
                        }
                    }
                    if ($value['type'] == 6) {
                        $header_class = 'list_indeks';
                        $header_node = $finder->query("//*[contains(@class, '$header_class')]");

                        foreach ($header_node as $node) {
                            $li = $node->getElementsByTagName('li');
                            foreach ($li as $node_li) {

                                $time = $node_li->getElementsByTagName('span')[0]->nodeValue;
                                $link = $node_li->getElementsByTagName('a')[0]->getAttribute('href');
                                $judul = $node_li->getElementsByTagName('a')[0]->nodeValue;
                                $result[] = [
                                    'tanggal' => $this->detikConvertTime($time),
                                    'judul' => trim($judul),
                                    'kategori' => $value['name'],
                                    'gambar' => "",
                                    'link' => $link,
                                    'fk_sumber' => 2,
                                ];
                                $sum++;
                            }
                        }
                    }
                    $page++;
                } while ($sum != 0);
            }
        }


        return (object) [
            'result' => $result,
            'count' => count($result)
        ];
    }

    public function kompas($date_from, $date_to, $is_curl = true)
    {
        $first_date = new DateTime($date_from);
        $last_date = new DateTime($date_to);

        $result = [];

        for ($i = $first_date; $i <= $last_date; $i->modify("+1 day")) {
            $page = 1;
            do {
                $html = "https://news.kompas.com/search/" . $i->format('Y-m-d') . "/" . $page;

                if ($is_curl) {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $html);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $html_content = curl_exec($ch);
                } else {
                    $html_content = @file_get_contents($html);
                }

                if ($html_content == false) {
                    return false;
                }


                libxml_use_internal_errors(true);
                $DOM = new DOMDocument();
                $DOM->loadHTML($html_content);
                $finder = new DomXPath($DOM);

                $header_class = 'latest--news';
                $header_node = $finder->query("//*[contains(@class, '$header_class')]");

                $sum = 0;
                foreach ($header_node as $node2) {

                    $news_node = $this->getElementsByClass($node2, "div", 'article__list');

                    foreach ($news_node as $node) {

                        $image_node = $this->getElementsByClass($node, "div", 'article__asset');
                        $title_node = $this->getElementsByClass($node, "h3", 'article__title');
                        $category_node = $this->getElementsByClass($node, "div", "article__subtitle");
                        $time_node = $this->getElementsByClass($node, "div", "article__date");


                        $time = $time_node[0]->nodeValue;
                        $time = substr($time, 0, -4);
                        $time = str_replace(",", "", $time);
                        $time = str_replace("/", "-", $time);

                        $link = $title_node[0]->getElementsByTagName('a')[0]->getAttribute('href');
                        $image = $image_node[0]->getElementsByTagName('img')[0]->getAttribute('data-src');

                        $result[] = [
                            'tanggal' => date("Y-m-d H:i:s", strtotime($time)),
                            'judul' => trim($title_node[0]->nodeValue),
                            'kategori' => trim($category_node[0]->nodeValue),
                            'gambar' => $image,
                            'link' => $link,
                            'fk_sumber' => 3,
                        ];
                        $sum++;
                    }
                }

                $page++;
            } while ($sum != 0);
        }

        return (object) [
            'result' => $result,
            'count' => count($result)
        ];
    }

    public function segmentasi_paragraft($arr_paragraph)
    {
        $arr_kalimat = [];
        $idx_kalimat = 0;
        foreach ($arr_paragraph as $key => $value) {
            $text_no_quote = preg_replace('/"([^"]+)"/', "||QUOTE||", $value);
            preg_match('/"([^"]+)"/', $value, $quotes);

            $has_quote = false;
            if (strpos($text_no_quote, '||QUOTE||') !== false) {
                $has_quote = true;
            }
            $segmentation = explode(". ", $text_no_quote);
            $segmentation = array_filter($segmentation);

            foreach ($segmentation as $k => $v) {
                if (trim($v) == "" || is_numeric(trim($v))) {
                    continue;
                }
                if (substr($v, -1, 1) == ".") {
                    $v = substr($v, 0, -1);
                }
                if ($has_quote) {
                    $v = str_replace("||QUOTE||", (isset($quotes) ? $quotes[0] : ""), $v);
                }
                $arr_kalimat[] = [
                    'paragraft' => $key,
                    'index_kalimat' => $idx_kalimat,
                    'kalimat' => $v,
                ];
                $idx_kalimat++;
            }
        }

        return $arr_kalimat;
    }

    public function konten_katadata($link_berita)
    {
        $html_content = @file_get_contents($link_berita);

        if ($html_content == false) {
            return false;
        }

        libxml_use_internal_errors(true);
        $DOM = new DOMDocument();
        $DOM->loadHTML($html_content);
        $finder = new DomXPath($DOM);

        $arr_paragraph = [];
        $classname = 'textArticle';
        $paragraft_node = $finder->query("//*[contains(@class, '$classname')]");
        foreach ($paragraft_node as $node) {
            $paragraph = $node->getElementsByTagName('p');
            foreach ($paragraph as $a) {
                if (substr($a->nodeValue, 0, 6) != "(Baca:" and substr($a->nodeValue, 0, 6) != "Report") {
                    $arr_paragraph[] = str_replace(["&ldquo;", "&rdquo;"], '"', str_replace("&nbsp;", " ", htmlentities($a->nodeValue, null, 'utf-8')));
                }
            }
        }

        return $this->segmentasi_paragraft($arr_paragraph);
    }

    public function konten_detik($link_berita, $kategori)
    {
        $category[] = [
            'name' => 'detikNews',
            'type' => 1,
        ];
        $category[] = [
            'name' => 'detikFinance',
            'type' => 2,
        ];
        $category[] = [
            'name' => 'detikHot',
            'type' => 2,
        ];
        $category[] = [
            'name' => 'detikSport',
            'type' => 2,
        ];
        $category[] = [
            'name' => 'detikOto',
            'type' => 2,
        ];
        $category[] = [
            'name' => 'Sepak Bola',
            'type' => 2,
        ];
        $category[] = [
            'name' => 'detikFood',
            'type' => 3,
        ];
        $category[] = [
            'name' => 'detikNet',
            'type' => 3,
        ];
        $category[] = [
            'name' => 'detikHealth',
            'type' => 4,
        ];
        $category[] = [
            'name' => 'detikTravel',
            'type' => 5,
        ];
        $category[] = [
            'name' => 'detikWolipop',
            'type' => 6,
        ];
        $type = -1;
        foreach ($category as $key => $value) {
            if ($value['name'] == $kategori) {
                $type = $value['type'];
            }
        }
        if ($type == -1) {
            return false;
        }

        $html = @file_get_contents($link_berita . "?single=1");
        if ($html == false) {
            return false;
        }

        libxml_use_internal_errors(true);
        $DOM = new DOMDocument();
        $DOM->loadHTML($html);
        $finder = new DomXPath($DOM);

        $arr_paragraph = [];
        if ($type == 1) {
            $classname = 'detail__body-text';
            $paragraft_node = $finder->query("//*[contains(@class, '$classname')]");
            foreach ($paragraft_node as $node) {
                $paragraph = $node->getElementsByTagName('p');
                foreach ($paragraph as $a) {
                    $paragraft_filter = str_replace(["&ldquo;", "&rdquo;"], '"', str_replace("&nbsp;", " ", htmlentities($a->nodeValue, null, 'utf-8')));
                    if ($paragraft_filter != "" && substr($paragraft_filter, 0, 8) != "Tonton v" && substr($paragraft_filter, 0, 13) != "[Gambas:Video" && substr($paragraft_filter, -1, 1) != ":") {
                        $arr_paragraph[] = $paragraft_filter;
                    }
                }
            }
        } else if ($type == 2 || $type == 3 || $type == 4 || $type == 6) {
            $classname = 'detail_text';
            $paragraft_node = $finder->query("//*[contains(@class, '$classname')]");
            foreach ($paragraft_node as $node) {
                $paragraph = $node->getElementsByTagName('p');
                foreach ($paragraph as $a) {
                    $paragraft_filter = str_replace(["&ldquo;", "&rdquo;"], '"', str_replace("&nbsp;", " ", htmlentities($a->nodeValue, null, 'utf-8')));
                    if ($paragraft_filter != "" && substr($paragraft_filter, 0, 8) != "Tonton v" && substr($paragraft_filter, 0, 13) != "[Gambas:Video" && substr($paragraft_filter, -1, 1) != ":") {
                        $arr_paragraph[] = $paragraft_filter;
                    }
                }
            }
        } else if ($type == 5) {
            $classname = 'read__content';
            $paragraft_node = $finder->query("//*[contains(@class, '$classname')]");
            foreach ($paragraft_node as $node) {
                $paragraph = $node->getElementsByTagName('p');
                foreach ($paragraph as $a) {
                    $paragraft_filter = str_replace(["&ldquo;", "&rdquo;"], '"', str_replace("&nbsp;", " ", htmlentities($a->nodeValue, null, 'utf-8')));
                    if ($paragraft_filter != "" && substr($paragraft_filter, 0, 8) != "Tonton v" && substr($paragraft_filter, 0, 13) != "[Gambas:Video" && substr($paragraft_filter, -1, 1) != ":") {
                        $arr_paragraph[] = $paragraft_filter;
                    }
                }
            }
        } else {
            return false;
        }

        return $this->segmentasi_paragraft($arr_paragraph);
    }

    public function konten_kompas($link_berita)
    {
        $html_content = @file_get_contents($link_berita . "?page=all");

        if ($html_content == false) {
            return false;
        }

        libxml_use_internal_errors(true);
        $DOM = new DOMDocument();
        $DOM->loadHTML($html_content);
        $finder = new DomXPath($DOM);

        $arr_paragraph = [];
        $classname = 'read__content';
        $paragraft_node = $finder->query("//*[contains(@class, '$classname')]");
        foreach ($paragraft_node as $node) {
            $paragraph = $node->getElementsByTagName('p');
            foreach ($paragraph as $a) {
                $paragraft_filter = trim(str_replace(["&ldquo;", "&rdquo;"], '"', str_replace("&nbsp;", " ", htmlentities($a->nodeValue, null, 'utf-8'))));
                if ($paragraft_filter != "" && substr($paragraft_filter, 0, 10) != "Baca juga:" && substr($paragraft_filter, 0, 7) != "SUMBER:" && substr($paragraft_filter, -1, 1) != ":") {
                    $arr_paragraph[] = $paragraft_filter;
                }
            }
        }

        return $this->segmentasi_paragraft($arr_paragraph);
    }
}
