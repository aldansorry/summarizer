<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('berita_link')) {
    function berita_link($tanggal,$judul)
    {
        $tanggal = new DateTime($tanggal);
        $judul_encode = str_replace([",", ".", ":", "/", "%","[","]","|"], "", str_replace(" ", "-", strtolower(trim($judul))));
        $link = base_url("Home/berita/") . $tanggal->format("Y/m/d") . "/" . $judul_encode;
        return $link;
    }
}
