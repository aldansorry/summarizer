<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
digunakan untuk mengalihkan halaman

401 need authentication : harus login terlebih dahulu jika ingin akses
403 need authorization : harus memiliki akses jika ingin mengakses halaman
404 tidak ada halaman

*/
class ErrorPage extends CI_Controller
{

    public function error401()
    {
        $view_data = [
            'title' => "401",
            'error_no' => '401',
            'error_title' => 'Unauthorized error',
            'error_description' => "Login terlebih dahulu",
            'error_redirect_text' => "Login",
            'error_redirect_url' => base_url('Login'),
        ];
        $this->load->view('layout/errorpage',$view_data);
    }
    public function error403()
    {
        $view_data = [
            'title' => "403",
            'error_no' => '403',
            'error_title' => 'Access Denied',
            'error_description' => "Tidak dapat mengakses halaman ini",
            'error_redirect_text' => "Kembali ke halaman Dashboard",
            'error_redirect_url' => base_url('Dashboard'),
        ];
        $this->load->view('layout/errorpage',$view_data);
    }

    public function error404()
    {
        $view_data = [
            'title' => "404",
            'error_no' => '404',
            'error_title' => 'Page Not Found',
            'error_description' => "Halaman tidak ada",
            'error_redirect_text' => "Go Back",
            'error_redirect_url' => 'javascript: history.go(-1)',
        ];
        $this->load->view('layout/errorpage',$view_data);
    }
}
