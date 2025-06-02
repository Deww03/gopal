<?php
include '../koneksi/koneksi.php';
include '../cek_login.php';

$id_kasir = $_SESSION['id_kasir'];
$id_utang = $_POST['id_utang'];
$jumlah_bayar = $_POST['jumlah_bayar'];
$id_kasir = $_SESSION['id_kasir']; // Ambil dari sesi
$tanggal_bayar = date('Y-m-d');

// Ambil data utang
$query_utang = mysqli_query($koneksi, "SELECT jumlah_utang FROM utang WHERE id_utang = '$id_utang'");
$data_utang = mysqli_fetch_assoc($query_utang);

// Hitung total bayar sebelumnya
$query_total = mysqli_query($koneksi, "SELECT IFNULL(SUM(jumlah_bayar), 0) as total_bayar FROM bayar WHERE id_utang = '$id_utang'");
$data_total = mysqli_fetch_assoc($query_total);

$total_bayar = $data_total['total_bayar'];
$sisa_utang = $data_utang['jumlah_utang'] - $total_bayar;

// Validasi
if ($jumlah_bayar > $sisa_utang) {
    header("Location: semua_utang.php?status=gagal_jumlah_berlebih");
    exit();
}

// Simpan ke tabel bayar
mysqli_query($koneksi, "INSERT INTO bayar (id_utang, id_kasir, tanggal_bayar, jumlah_bayar)
VALUES ('$id_utang', '$id_kasir', '$tanggal_bayar', '$jumlah_bayar')") or die(mysqli_error($koneksi));

// Hitung ulang total bayar
$query_total2 = mysqli_query($koneksi, "SELECT IFNULL(SUM(jumlah_bayar), 0) as total_bayar FROM bayar WHERE id_utang = '$id_utang'");
$data_total2 = mysqli_fetch_assoc($query_total2);
$total_bayar_baru = $data_total2['total_bayar'];

// Update status jika lunas
$status = ($total_bayar_baru >= $data_utang['jumlah_utang']) ? 'sudah_lunas' : 'belum_lunas';
mysqli_query($koneksi, "UPDATE utang SET status = '$status' WHERE id_utang = '$id_utang'");

header("Location: semua_utang.php?status=bayar_berhasil");
exit();
?>
