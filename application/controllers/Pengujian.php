<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengujian extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        user_allow([1]);
    }

    public function index()
    {
        $view_data = [
            'title'     => 'Pengujian',
            'cname'     => 'Pengujian',
            'page'      => 'pengujian/index',
            'script'    => 'pengujian/script'
        ];
        $view_data['bobot_data'] = $this->db->get('bobot')->result();
        $this->load->view('layout/dashboard', $view_data);
    }


    public function getData()
    {
        $data['data'] = $this->db->order_by('tanggal', 'desc')->get('berita')->result();

        foreach ($data['data'] as $key => $value) {
            $data['data'][$key]->tanggal = date("d-m-Y H:i", strtotime($value->tanggal));
        }

        echo json_encode($data);
    }


    public function getPengujian()
    {
        $db_bobot = $this->db->get('bobot')->result();
        $data_bobot = [];

        $data_class = [
            'primary',
            'success',
            'info',
            'warning'
        ];

        foreach ($db_bobot as $key => $value) {
            $data_bobot[$value->id] = "<span class='badge badge-pill btn-outline-" . $data_class[($key % 4)] . "'>" . $value->nama . "</span>";
        }

        $db_pengujian = $this->db->get('pengujian')->result();

        foreach ($db_pengujian as $key => $value) {
            $db_pengujian[$key]->berita = count(explode(",", $value->list_berita));
            $db_pengujian[$key]->status_text = ($value->status == 1 ? "<span class='badge badge-warning'>Belum</span>" : "<span class='badge badge-primary'>Sudah</span>");
        }

        $data['data'] = $db_pengujian;

        foreach ($data['data'] as $key => $value) {
            $data['data'][$key]->tanggal = date("d-m-Y", strtotime($value->tanggal));
        }
        echo json_encode($data);
    }

    public function pengujian_action()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('jenis_sample', 'Jenis', 'required');

        if ($this->input->post('jenis_sample') == "random") {
            $this->form_validation->set_rules('jumlah_berita', 'jumlah_berita', 'required');
        } else {
            $this->form_validation->set_rules('list_berita', 'list_berita', 'required');
        }
        if ($this->form_validation->run() == true) {
            if ($this->input->post('jenis_sample') == "random") {
                $jumlah_berita = $this->input->post('jumlah_berita');
                $keys_berita = $this->db->select('berita.id')
                    ->join('berita_kalimat', 'berita_kalimat.fk_berita=berita.id')
                    ->where('berita_kalimat.f1 !=', null)
                    ->group_by('berita.id')
                    ->get('berita')->result();
                $rand_keys = array_rand($keys_berita, $jumlah_berita);

                $sample_berita = [];
                foreach ($rand_keys as $key => $value) {
                    $sample_berita[] = $keys_berita[$value]->id;
                }
            } else {
                $sample_berita = explode(",", $this->input->post('list_berita'));
            }

            $set_pengujian = [
                'tanggal' => date("Y-m-d"),
                'list_berita' => implode(",", $sample_berita),
                'status' => 1
            ];
            $this->db->insert('pengujian', $set_pengujian);
            $id_pengujian = $this->db->insert_id();

            foreach ($sample_berita as $id_berita) {

                $set_detail = [
                    'fk_pengujian' => $id_pengujian,
                    'fk_berita' => $id_berita,
                    'manual' => ""
                ];
                $this->db->insert('pengujian_detail', $set_detail);
            }

            echo json_encode([
                'swal' => [
                    'title' => "Berhasil",
                    'text' => "Tambah Pengujian Berhasil dengah jumlah sample " . count($sample_berita),
                    'icon' => "success"
                ],
            ]);
        } else {
            echo json_encode([
                'swal' => [
                    'title' => "Gagal",
                    'html' => "Tentukan Jumlah Berita, dan pilih setidaknya satu bobot<br>" . validation_errors("", ""),
                    'icon' => "error"
                ],
            ]);
        }
    }

    public function deleteBatch()
    {
        $list_pengujian = $this->input->post('list_pengujian');

        $count_success = 0;
        $count_failed = 0;

        foreach ($list_pengujian as $key => $value) {

            $delete = $this->db
                ->where('id', $value)
                ->delete('pengujian');

            if ($delete) {
                $count_success++;
            } else {
                $count_failed++;
            }
        }


        echo json_encode([
            'swal' => [
                'icon' => 'success',
                'title' => "Hapus Batch Berhasil",
                'html' => "Hapus berhasil berjumlah : " . $count_success . "<br> Hapus gagal berjumlah : " . $count_failed,
            ],
        ]);
    }

    public function getBobot()
    {
        $db_bobot = $this->db->get('bobot')->result();
        $data_bobot = [];
        $data_bobot[] = "Tanpa Tanda";
        foreach ($db_bobot as $key => $value) {
            $data_bobot[$value->id] = $value->nama;
        }
        $data['bobot'] = $data_bobot;
        echo json_encode($data);
    }

    public function download_excel($id_pengujian, $id_bobot)
    {
        $this->load->library('excelreader');
        $this->load->library('summarizer');

        $data_pengujian = $this->db->where('id', $id_pengujian)->get('pengujian')->row(0);

        $db_berita = $this->db
            ->select("*,(select nama from sumber where id=berita.fk_sumber) nama_sumber")
            ->where_in('id', explode(",", $data_pengujian->list_berita))
            ->get('berita')->result();

        $db_berita_kalimat = $this->db
            ->where_in('fk_berita', explode(",", $data_pengujian
                ->list_berita))
            ->get('berita_kalimat')->result();

        $data_berita_kalimat = [];
        foreach ($db_berita_kalimat as $key => $value) {
            $data_berita_kalimat[$value->fk_berita][] = $value;
        }

        $data_bobot = $this->db->where('id', $id_bobot)->get('bobot')->row(0);


        //choose format
        $inputFileName = './storage/format/export_pengujian_sample.xlsx';
        $inputFileType = 'xls';
        $is_error = false;
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
            $is_error = true;
            $data['error_info'] = 'Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage();
        }

        if (!$is_error) {
            $sheet = $objPHPExcel->getSheet(0);

            #set header
            $sheet->setCellValueByColumnAndRow(0, 3, "ID PENGUJIAN");
            $sheet->setCellValueByColumnAndRow(1, 3, $data_pengujian->id);
            $sheet->setCellValueByColumnAndRow(1, 4, PHPExcel_Shared_Date::PHPToExcel($data_pengujian->tanggal));
            $sheet->getStyleByColumnAndRow(1, 4)->getNumberFormat()->setFormatCode("dd/mm/yyyy");



            #detail header
            $column = 6;
            $detail_first_column = $column;
            ##Sumber
            $sheet->setCellValueByColumnAndRow($column, 7, "Sumber");
            $column++;
            ##Kategori
            $sheet->setCellValueByColumnAndRow($column, 7, "Kategori");
            $column++;
            ##Link
            $sheet->setCellValueByColumnAndRow($column, 7, "Link");
            $column++;
            ##index
            $sheet->setCellValueByColumnAndRow($column, 7, "Index");
            $column++;


            #set
            $string_column_left = PHPExcel_Cell::stringFromColumnIndex($detail_first_column);
            $string_column_right = PHPExcel_Cell::stringFromColumnIndex($column - 1);
            $range = $string_column_left . "6:" . $string_column_right . "6";
            $sheet->mergeCells($range);
            $sheet->setCellValueByColumnAndRow($detail_first_column, 6, "DETAIL");

            $row = 8;
            foreach ($db_berita as $key => $value) {

                $sheet->setCellValueByColumnAndRow(0, $row, ($key + 1));
                $sheet->setCellValueByColumnAndRow(1, $row, $value->judul);
                $sheet->setCellValueByColumnAndRow(2, $row, count($data_berita_kalimat[$value->id]));

                #bobot
                $column = 6;

                #Sumber
                $sheet->setCellValueByColumnAndRow($column, $row, $value->nama_sumber);
                $column++;
                ##Kategori
                $sheet->setCellValueByColumnAndRow($column, $row, $value->kategori);
                $column++;
                ##Link
                $sheet->setCellValueByColumnAndRow($column, $row, $value->link);
                $column++;


                if ($id_bobot != 0)
                    $auto_summarize = $this->summarizer->process($data_berita_kalimat[$value->id], $data_bobot);



                foreach ($data_berita_kalimat[$value->id] as $k => $v) {
                    #no kalimat
                    $sheet->setCellValueByColumnAndRow(3, $row, ($v->index_kalimat + 1));
                    #kalimat
                    $sheet->setCellValueByColumnAndRow(4, $row, $v->kalimat);
                    ##index
                    $sheet->setCellValueByColumnAndRow($column, $row, $value->id . "-" . $v->index_kalimat);

                    #marker
                    if ($id_bobot != 0)
                        if (isset($auto_summarize[$k])) {
                            $column_text = PHPExcel_Cell::stringFromColumnIndex(5);

                            $sheet->getStyle($column_text . $row)->applyFromArray(
                                array(
                                    'fill' => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => 'e3ffff')
                                    )
                                )
                            );
                        }

                    $row++;
                }

                $row++;
            }
            $sheet->getStyle('E1:E' . $row)
                ->getAlignment()->setWrapText(true);

            #style 
            $column = PHPExcel_Cell::stringFromColumnIndex(9);
            $row = $row - 1;
            $end_cell = $column . $row;

            $allborder = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );

            $sheet->getStyle('A6:' . $end_cell)->applyFromArray($allborder);

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            header('Content-type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="pengujian' . date("dmY", strtotime($data_pengujian->tanggal)) . '.xlsx"');
            $objWriter->save('php://output');
        } else {
            echo $data['error_info'];
        }
    }

    public function import_pengujian()
    {
        $config['upload_path']          = './storage/excel_tmp/';
        $config['allowed_types']        = 'xls|xlsx';
        $config['max_size']             = 2000;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('excel')) {
            echo json_encode([
                'type' => "error",
                'text' => $this->upload->display_errors('', ''),
                'title' => "Import"
            ]);
        } else {
            $file_name = $this->upload->data('file_name');

            $this->load->library('excelreader');

            //choose format
            $inputFileName = './storage/excel_tmp/' . $file_name;
            $inputFileType = 'xls';
            $is_error = false;
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);

                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                unlink($inputFileName);

                #get_data_pengujian
                $id_pengujian = $sheet->getCellByColumnAndRow(1, 3)->getValue();

                if ($this->input->post('id_pengujian') != $id_pengujian) {
                    echo json_encode([
                        'icon' => "error",
                        'text' => "Data dokumen tidak sesuai",
                        'title' => "Import Gagal"
                    ]);
                    return;
                }
                $data_pengujian = $this->db
                    ->where('id', $id_pengujian)
                    ->get('pengujian')->row(0);


                #array bobot : index

                $fetch_excel = $sheet->rangeToArray("F8:J" . $highestRow, NULL, TRUE, FALSE);


                ##get

                $data_berita = [];
                foreach ($fetch_excel as $key => $value) {
                    if ($value[4] == null) {
                        continue;
                    }
                    $ex_index = explode("-", $value[4]);
                    $id_berita = $ex_index[0];
                    $index_kalimat = $ex_index[1];

                    $kalimat = [];
                    if ($value[0] != null)
                        $data_berita[$id_berita][] = $index_kalimat;
                }

                #update_db
                $this->db->where('id', $id_pengujian)->update('pengujian', ['status' => 2]);

                foreach ($data_berita as $id_berita => $ringkasan) {
                    $string_ringkasan = implode(",", $ringkasan);

                    $set_detail = [
                        'fk_pengujian' => $data_pengujian->id,
                        'fk_berita' => $id_berita,
                    ];
                    if ($this->db->where($set_detail)->get("pengujian_detail")->num_rows() == 0) {
                        $set_detail['manual'] = $string_ringkasan;
                        $this->db->insert('pengujian_detail', $set_detail);
                    } else {
                        $this->db->where($set_detail)->update('pengujian_detail', ['manual' => $string_ringkasan]);
                    }
                }

                echo json_encode([
                    'icon' => "success",
                    'text' => "Berhasil melakukan pengujian",
                    'title' => "Import Berhasil",
                ]);
            } catch (Exception $e) {
                $is_error = true;
                $data['error_info'] = 'Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage();

                echo json_encode([
                    'icon' => "error",
                    'text' => $data['error_info'],
                    'title' => "Import"
                ]);
            }
        }
    }

    ##================================================:: DETAIL ::============================================================================================================

    public function getBobotData()
    {
        $id_bobot = $this->input->post("id_bobot");
        $db_bobot = $this->db->where('id', $id_bobot)->get('bobot')->row(0);
        echo json_encode($db_bobot);
    }

    public function calculateAccuracy()
    {

        $this->load->library('summarizer');

        $fk_bobot = $this->input->post("fk_bobot");
        if ($fk_bobot != -1) {
            $db_bobot = $this->db->where('id', $fk_bobot)->get('bobot')->row(0);
        } else {
            $db_bobot = new stdClass;
            $db_bobot->f1 = $this->input->post('f1');
            $db_bobot->f2 = $this->input->post('f2');
            $db_bobot->f3 = $this->input->post('f3');
            $db_bobot->f4 = $this->input->post('f4');
            $db_bobot->f5 = $this->input->post('f5');
            $db_bobot->f6 = $this->input->post('f6');
            $db_bobot->kompresi = $this->input->post('kompresi');
        }

        $id_pengujian = $this->input->post('id_pengujian');

        $data_class = [
            'primary',
            'success',
            'info',
            'warning'
        ];


        $data_pengujian = $this->db
            ->where('id', $id_pengujian)
            ->get('pengujian')->row(0);

        $data_pengujian_detail = $this->db
            ->where('fk_pengujian', $id_pengujian)
            ->get("pengujian_detail")->result();

        $berita_summarize = [];
        foreach ($data_pengujian_detail as $key => $value) {
            $data_kalimat = $this->db->where('fk_berita', $value->fk_berita)->get('berita_kalimat')->result();

            $auto_summarize = array_keys($this->summarizer->process($data_kalimat, $db_bobot));

            $accuracy = $this->summarizer->accuracy($auto_summarize,explode(",", $value->manual));

            $berita_summarize[$value->fk_berita]['auto'] = $auto_summarize;
            $berita_summarize[$value->fk_berita]['manual'] = explode(",", $value->manual);
            $berita_summarize[$value->fk_berita]['accuracy']['precision'] = $accuracy->precision;
            $berita_summarize[$value->fk_berita]['accuracy']['recall'] = $accuracy->recall;
            $berita_summarize[$value->fk_berita]['accuracy']['f_measure'] = $accuracy->fmeasure;
        }


        $tabel_berita = [];
        $chart_berita = [];
        $arr_precision = [];
        $arr_recall = [];
        $arr_f_measure = [];
        $no_berita = 1;
        foreach ($berita_summarize as $key => $value) {
            $db_berita = $this->db->where('id', $key)->get('berita')->row(0);

            $row_data = new stdClass;
            $row_data->no = $no_berita;
            $row_data->id = $db_berita->id;
            $row_data->judul = $db_berita->judul;
            $row_data->kategori = $db_berita->kategori;
            $row_data->fk_sumber = $db_berita->fk_sumber;

            $auto_no_kalimat = [];
            foreach ($value['auto'] as $k => $v) {
                $auto_no_kalimat[] = $v + 1;
            }
            $manual_no_kalimat = [];
            foreach ($value['manual'] as $k => $v) {
                $manual_no_kalimat[] = $v + 1;
            }

            $row_data->auto = implode(",", $auto_no_kalimat);
            $row_data->manual = implode(",", $manual_no_kalimat);

            $pers_precision = 100 * $value['accuracy']['precision'];
            $pers_recall = 100 * $value['accuracy']['recall'];
            $pers_f_measure = 100 * $value['accuracy']['f_measure'];

            $row_data->precision = number_format($pers_precision, 2);
            $row_data->recall = number_format($pers_recall, 2);
            $row_data->f_measure = number_format($pers_f_measure, 2);

            $tabel_berita[] = $row_data;


            $chart_berita['label'][] = "Berita " . ($no_berita);
            $chart_berita['precision'][] = number_format($pers_precision, 2);
            $chart_berita['recall'][] = number_format($pers_recall, 2);
            $chart_berita['f_measure'][] = number_format($pers_f_measure, 2);


            $arr_precision[] = $pers_precision;
            $arr_recall[] = $pers_recall;
            $arr_f_measure[] = $pers_f_measure;

            $no_berita++;
        }

        $avg_precision = array_sum($arr_precision) / count($arr_precision);
        $avg_recall = array_sum($arr_recall) / count($arr_recall);
        $avg_f_measure = array_sum($arr_f_measure) / count($arr_f_measure);

        $ret_data = [
            'accuracy' => [
                'precision' => number_format($avg_precision, 2),
                'recall' => number_format($avg_recall, 2),
                'f_measure' => number_format($avg_f_measure, 2),
            ],
            'tabel' => $tabel_berita,
            'chart' => $chart_berita,
        ];

        echo json_encode($ret_data);
    }

    public function doResetPengujian()
    {
        $id_pengujian = $this->input->post('id_pengujian');

        $this->db->where('id', $id_pengujian)->update('pengujian', ['status' => 1]);

        $this->db->where('fk_pengujian', $id_pengujian)->delete('pengujian_detail');

        echo json_encode([
            'swal' => [
                'icon' => 'success',
                'title' => "Reset Pengujian",
                'html' => "Reset data pengujian berhasil",
            ],
        ]);
    }

    public function modalDetailBerita()
    {
        $id_berita = $this->input->post('id_berita');
        $auto = explode(",", $this->input->post('auto'));
        $manual = explode(",", $this->input->post('manual'));


        $data_berita_kalimat = $this->db
            ->where('fk_berita', $id_berita)
            ->get('berita_kalimat')
            ->result();

        foreach ($data_berita_kalimat as $key => $value) {
            if (in_array($value->index_kalimat, $auto) && in_array($value->index_kalimat, $manual)) {
                $data_berita_kalimat[$key]->class = "text-primary";
            } else if (in_array($value->index_kalimat, $auto)) {
                $data_berita_kalimat[$key]->class = "text-info";
            } else if (in_array($value->index_kalimat, $manual)) {
                $data_berita_kalimat[$key]->class = "text-success";
            } else {
                $data_berita_kalimat[$key]->class = "text-dark";
            }
        }

        $view_data['data_berita_kalimat'] = $data_berita_kalimat;
        $this->load->view('pages/pengujian/modal_detail', $view_data);
    }

    public function testing()
    {
        $this->load->library('summarizer');
        $db_bobot = (object) [
            'f1' => 1,
            'f2' => 1,
            'f3' => 1,
            'f4' => 1,
            'f5' => 1,
            'f6' => 1,
            'kompresi' => 50,
        ];

        $id_pengujian = [2,4,5];

        $data_pengujian_detail = $this->db
            ->where_in('fk_pengujian', $id_pengujian)
            ->get("pengujian_detail")->result();

        $data_penelitian = [];

        $largest = 0;

        foreach ($db_bobot as $key_bobot => $value_bobot) {
            if ($key_bobot == "kompresi") {
                continue;
            }

            $new_db_bobot = $db_bobot;
            $index = 0;
            for ($featurec = -3; $featurec <= 3; $featurec += 0.25) {
                $new_db_bobot->$key_bobot = $featurec;
                $berita_summarize = [];

                $data_f_measure = [];
                foreach ($data_pengujian_detail as $key => $value) {
                    $data_kalimat = $this->db->where('fk_berita', $value->fk_berita)->get('berita_kalimat')->result();

                    $auto_summarize = array_keys($this->summarizer->process($data_kalimat, $new_db_bobot));

                    $berita_summarize[$value->fk_berita]['auto'] = $auto_summarize;
                    $berita_summarize[$value->fk_berita]['manual'] = explode(",", $value->manual);

                    $auto_intersect_manual = array_intersect($berita_summarize[$value->fk_berita]['auto'], $berita_summarize[$value->fk_berita]['manual']);

                    $count_auto_intersect_manual = count($auto_intersect_manual);

                    $count_auto = count($berita_summarize[$value->fk_berita]['auto']);
                    $count_manual = count($berita_summarize[$value->fk_berita]['manual']);

                    $precision = $count_auto_intersect_manual / $count_auto;
                    $recall = $count_auto_intersect_manual / $count_manual;

                    if (($precision + $recall) != 0)
                        $f_measure = 2 * (($precision * $recall) / ($precision + $recall));
                    else
                        $f_measure = 0;

                    $berita_summarize[$value->fk_berita]['accuracy']['precision'] = $precision;
                    $berita_summarize[$value->fk_berita]['accuracy']['recall'] = $recall;
                    $berita_summarize[$value->fk_berita]['accuracy']['f_measure'] = $f_measure;

                    $data_f_measure[] = $f_measure;
                }
                $data_penelitian['key'][$index] = $featurec;
                $data_penelitian[$key_bobot][$index] = number_format((array_sum($data_f_measure) / count($data_f_measure) * 100), 2, ",", ".");
                $index++;

                if ((array_sum($data_f_measure) / count($data_f_measure) * 100) > $largest) {
                    $largest = (array_sum($data_f_measure) / count($data_f_measure) * 100);
                    d($new_db_bobot);
                    d($largest);
                }
            }

            $key = array_keys($data_penelitian[$key_bobot], max($data_penelitian[$key_bobot]))[0];
            $best_bobot = $data_penelitian['key'][$key];
            $db_bobot->$key_bobot = $best_bobot;
        }
        echo number_format($largest, 2, ",", ".") . "<br>";
        dd_2dim($data_penelitian);
    }
}
