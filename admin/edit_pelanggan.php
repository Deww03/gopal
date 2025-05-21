<?php
include '../koneksi/koneksi.php';

$id       = $_POST['id_pelanggan'];
$nama     = $_POST['nama_pelanggan'];
$no_hp    = $_POST['no_hp_pelanggan'];

// Cek apakah nama digunakan oleh pelanggan lain
$cek = mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE nama_pelanggan = '$nama' AND id_pelanggan != '$id'");
if (mysqli_num_rows($cek) > 0) {
    header("Location: pelanggan.php?status=nama_sudah_ada");
    exit();
}

// Update data
$query = "UPDATE pelanggan SET nama_pelanggan='$nama', no_hp_pelanggan='$no_hp' WHERE id_pelanggan='$id'";
if (mysqli_query($koneksi, $query)) {
    header("Location: pelanggan.php?status=edit_berhasil");
} else {
    header("Location: pelanggan.php?status=error");
}
?>
