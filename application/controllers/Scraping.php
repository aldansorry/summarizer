<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Scraping extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        user_allow([]);
    }

    public function index()
    {
        $view_data = [
            'title'     => 'Scraping',
            'cname'     => 'Scraping',
            'page'      => 'scraping/index',
            'script'    => 'scraping/script'
        ];
        $this->load->view('layout/dashboard', $view_data);
    }

    public function getBeritaScraped()
    {
        $data['raw_berita'] = $this->db->where('(select count(id) from berita_kalimat where fk_berita=berita.id) =', 0)
            ->get('berita')
            ->result();

        foreach ($data['raw_berita'] as $key => $value) {
            $data['raw_berita'][$key]->tanggal = date("d-m-Y H:i", strtotime($value->tanggal));
        }

        echo json_encode($data);
    }

    public function doScraping()
    {
        ini_set('max_execution_time', 300);
        set_time_limit(300);

        $this->load->library("Scraper");

        $source = $this->input->post('source');
        $date = $this->input->post('date');

        $date_from = $date['from'];
        $date_to = $date['to'];

        $is_error = false;
        $message['title'] = "Berhasil";
        $message['html'] = "Berhasil";
        $result = [];

        if ($source == 1) {

            $scraper = $this->scraper->katadata($date_from, $date_to);

            if ($scraper === false) {
                $is_error = true;
                $message = [
                    'title' => 'Error',
                    'html' => 'Internet Error',
                ];
            } else {
                foreach ($scraper->result as $key => $value) {
                    $result[] = $value;
                }
            }
        }
        if ($source == 2) {

            $scraper = $this->scraper->detik($date_from, $date_to);

            if ($scraper === false) {
                $is_error = true;
                $message = [
                    'title' => 'Error',
                    'html' => 'Internet Error',
                ];
            } else {
                foreach ($scraper->result as $key => $value) {
                    $result[] = $value;
                }
            }
        }
        if ($source == 3) {

            $scraper = $this->scraper->kompas($date_from, $date_to);

            if ($scraper === false) {
                $is_error = true;
                $message = [
                    'title' => 'Error',
                    'html' => 'Internet Error',
                ];
            } else {
                foreach ($scraper->result as $key => $value) {
                    $result[] = $value;
                }
            }
        }

        if ($is_error) {
            echo json_encode([
                'error' => true,
                'message' => [
                    'title' => $message['title'],
                    'html' => $message['html'],
                ],
            ]);
        } else {

            $inserted = 0;
            $duplicate = 0;
            foreach ($result as $key => $value) {
                $db_debug = $this->db->db_debug;
                $this->db->db_debug = FALSE;
                $insert = $this->db->insert('berita', $value);
                if (!$insert) {
                    if ($this->db->error()['code'] == 1062) {
                        $duplicate += 1;
                    }
                } else {
                    $inserted += 1;
                }
                $this->db->db_debug = $db_debug;
            }

            $message['html'] =  "Scraping berhasil dengan mendapatkan keterangan ; <br>Inserted : " . $inserted . "<br>Duplicate : " . $duplicate;

            echo json_encode([
                'error' => false,
                'message' => [
                    'title' => $message['title'],
                    'html' => $message['html'],
                ]
            ]);
        }
    }

    public function doScrapingKonten()
    {
        ini_set('max_execution_time', 300);
        set_time_limit(300);
        $this->load->library('scraper');

        $list_berita = $this->db->where('(select count(id) from berita_kalimat where fk_berita=berita.id) =', 0)
            ->get('berita', 10, 0)
            ->result();

        $internet_error = false;
        $scraped = 0;
        $message = "";
        foreach ($list_berita as $data_berita) {
            if ($data_berita->fk_sumber == 1) {
                $arr_kalimat = $this->scraper->konten_katadata($data_berita->link);
            } else if ($data_berita->fk_sumber == 2) {
                $arr_kalimat = $this->scraper->konten_detik($data_berita->link, $data_berita->kategori);
            } else if ($data_berita->fk_sumber == 3) {
                $arr_kalimat = $this->scraper->konten_kompas($data_berita->link);
            }
            if ($arr_kalimat === false) {
                $internet_error = true;
                break;
            } else {
                if (count($arr_kalimat) != 0) {
                    foreach ($arr_kalimat as $value) {
                        $value['fk_berita'] = $data_berita->id;
                        $this->db->insert('berita_kalimat', $value);
                    }
                } else {
                    $this->db->where('id', $data_berita->id)->delete('berita');
                    $message .= "Berita <a href='" . $data_berita->link . "' target='_BLANK' data-toggle='tooltip' data-placement='top' title='" . $data_berita->judul . "'>" . substr($data_berita->judul, 0, 30) . "...</a> dihapus karena tidak mengandung konten<br>";
                }
                $scraped++;
            }
        }

        $has_continue = true;
        if (count($list_berita) == 0) $has_continue = false;

        if (!$internet_error) {
            echo json_encode([
                'has_continue' => $has_continue,
                'scraped' => $scraped,
                'message' => $message,
            ]);
        } else {
            echo json_encode([
                'internet_error' => true,
                'swal' => [
                    'icon' => "warning",
                    'title' => 'Error',
                    'html' => 'Internet Error',
                ]
            ]);
        }
    }

    public function test()
    {
        $link_berita = "https://news.detik.com/berita-jawa-timur/d-4981890/penjual-nasgor-positif-corona-yang-mudik-ke-blitar-terpapar-dari-pasar-ppi-surabaya";
        $source = 1;

        $this->load->library('scraper');
        $arr_kalimat = $this->scraper->konten_detik($link_berita, "detikNews");
        dd($arr_kalimat);
    }
}
