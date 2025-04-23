<?php
date_default_timezone_set('Asia/Jakarta');

$koneksi = mysqli_connect("localhost", "root", "", "gopaldb");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>