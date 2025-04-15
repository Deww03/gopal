<?php
include '../koneksi/koneksi.php';

// Ambil data dari form
$id       = $_POST['id_pelanggan'];
$nama     = $_POST['nama_pelanggan'];
$no_hp    = $_POST['no_hp_pelanggan'];
$alamat   = $_POST['alamat_pelanggan'];

// Update data di database
$query = "UPDATE pelanggan SET 
            nama_pelanggan = '$nama',
            no_hp_pelanggan = '$no_hp',
            alamat_pelanggan = '$alamat' 
          WHERE id_pelanggan = '$id'";

if (mysqli_query($koneksi, $query)) {
    header("Location: pelanggan.php?status=edit_berhasil");
} else {
    header("Location: pelanggan.php?status=error");
}
?>
