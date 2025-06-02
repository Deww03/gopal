<?php
include '../cek_login.php';  // Pastikan kasir sudah login
include '../koneksi/koneksi.php';

// Ambil data dari form
$id_pelanggan = $_POST['id_pelanggan'];
$jumlah_utang = $_POST['jumlah_utang'];

// Ambil ID kasir dari session yang sudah login
$id_kasir = $_SESSION['id_kasir']; // ID kasir dari sesi
$tanggal = date('Y-m-d'); // Tanggal hari ini
$jatuh_tempo = date('Y-m-d', strtotime('+1 days')); // 60 hari setelah tanggal hari ini
$status = 'belum_lunas'; // Status default

// Cek apakah data yang diperlukan sudah diisi
if (empty($id_pelanggan) || empty($jumlah_utang)) {
    die("Semua data harus diisi.");
}

// Cek apakah pelanggan punya utang belum lunas dan jatuh tempo sudah lewat
$cek_utang = mysqli_query($koneksi, 
    "SELECT COUNT(*) as total FROM utang 
     WHERE id_pelanggan = '$id_pelanggan' 
     AND status = 'belum_lunas' 
     AND jatuh_tempo < CURDATE()");

$data_cek = mysqli_fetch_assoc($cek_utang);

if ($data_cek['total'] > 0) {
    // Redirect ke halaman sebelumnya dengan pesan error
    header("Location: semua_utang.php?status=gagal_utang_lama");
    exit();
}

// Query untuk menyimpan data utang
mysqli_query($koneksi, 
    "INSERT INTO utang (id_pelanggan, id_kasir, tanggal, jatuh_tempo, jumlah_utang, status) 
     VALUES ('$id_pelanggan', '$id_kasir', '$tanggal', '$jatuh_tempo', '$jumlah_utang', '$status')")
or die(mysqli_error($koneksi));

// Redirect ke halaman data utang dengan pesan sukses
header("Location: semua_utang.php?status=tambah_berhasil");
exit();
?>
