<?php
include '../koneksi/koneksi.php';
$nama = $_POST['nama_pelanggan'];
$no_hp = $_POST['no_hp_pelanggan'];

mysqli_query($koneksi, "INSERT INTO pelanggan (nama_pelanggan, no_hp_pelanggan) VALUES ('$nama', '$no_hp')") or die(mysqli_error($koneksi));
header("Location: pelanggan.php?status=tambah_berhasil");
exit();
?>