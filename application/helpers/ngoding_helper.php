<?php

function d($var)
{
    echo "<pre>";
    var_dump($var);
    echo "</pre><hr>";
}

function dd($var)
{
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    die();
}

function dd_2dim($var)
{
    echo '<table border="1">';
    $is_first = true;
    foreach ($var as $key => $value) {
        if ($is_first) {
            $is_first = false;
            echo "<tr>";
            echo "<td>" . $key . "</td>";
            foreach ($value as $k => $v) {
                echo "<td>" . $k . "</td>";
            }
            echo "</tr>";
        }
        echo "<tr>";
        echo "<td>" . $key . "</td>";
        foreach ($value as $k => $v) {
            echo "<td>" . $v . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}
/*
by Aldhan :D 
hapus kalau sudah tidak digunakan
pastikan terlebih dahulu helper ngoding 
tidak ada pada autoload yang berada 
pada config/autoload section helper
*/
