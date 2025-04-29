<?php
include '../cek_login.php';  // Pastikan admin sudah login

include '../koneksi/koneksi.php';

// Ambil data dari form
$id_pelanggan = $_POST['id_pelanggan'];
$jumlah = $_POST['jumlah'];

// Ambil ID admin dari session yang sudah login
$id_admin = $_SESSION['id_admin']; // ID admin dari sesi
$tanggal = date('Y-m-d'); // Tanggal hari ini
$jatuh_tempo = date('Y-m-d', strtotime('+60 days')); // 60 hari setelah tanggal hari ini
$status = 'belum_lunas'; // Status default

// Cek apakah data yang diperlukan sudah diisi
if (empty($id_pelanggan) || empty($jumlah)) {
    die("Semua data harus diisi.");
}

// Query untuk menyimpan data utang
mysqli_query($koneksi, "INSERT INTO utang (id_pelanggan, id_admin, tanggal, jatuh_tempo, jumlah, status) 
                         VALUES ('$id_pelanggan', '$id_admin', '$tanggal', '$jatuh_tempo', '$jumlah', '$status')")
or die(mysqli_error($koneksi));

// Redirect ke halaman data utang dengan pesan sukses
header("Location: semua_utang.php?status=tambah_berhasil");
exit();
?>
