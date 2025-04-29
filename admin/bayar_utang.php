<?php
include '../koneksi/koneksi.php';

$id_utang = $_POST['id_utang'];
$jumlah_bayar = $_POST['jumlah_bayar'];

// Ambil data utang saat ini
$query = mysqli_query($koneksi, "SELECT jumlah FROM utang WHERE id_utang = '$id_utang'");
$data = mysqli_fetch_assoc($query);

$sisa_utang = $data['jumlah'] - $jumlah_bayar;

// Validasi: jumlah bayar tidak boleh lebih dari utang
if ($jumlah_bayar > $data['jumlah']) {
    header("Location: semua_utang.php?status=gagal_jumlah_berlebih");
    exit();
}

// Tentukan status baru
$status = ($sisa_utang <= 0) ? 'sudah_lunas' : 'belum_lunas';

// Update utang: jumlah diubah jadi sisa, status diperbarui
mysqli_query($koneksi, "UPDATE utang SET jumlah = '$sisa_utang', status = '$status' WHERE id_utang = '$id_utang'") 
    or die(mysqli_error($koneksi));

header("Location: semua_utang.php?status=bayar_berhasil");
exit();
?>
