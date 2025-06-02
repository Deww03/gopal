<?php
date_default_timezone_set('Asia/Jakarta');

$koneksi = mysqli_connect("localhost", "root", "", "bude_ari_db");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>