<?php
include '../koneksi/koneksi.php';

$nama = $_POST['nama_pelanggan'];
$no_hp = $_POST['no_hp_pelanggan'];
$alamat = $_POST['alamat_pelanggan']; 

// Cek apakah nama pelanggan sudah ada
$cek = mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE nama_pelanggan = '$nama'");
if (mysqli_num_rows($cek) > 0) {
    header("Location: pelanggan.php?status=nama_sudah_ada");
    exit();
}

// Tambah pelanggan baru
mysqli_query($koneksi, "INSERT INTO pelanggan (nama_pelanggan, no_hp_pelanggan, alamat_pelanggan) VALUES ('$nama', '$no_hp', '$alamat')") or die(mysqli_error($koneksi));

header("Location: pelanggan.php?status=tambah_berhasil");
exit();
?>
