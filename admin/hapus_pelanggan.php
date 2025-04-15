<?php
include '../koneksi/koneksi.php';

if (isset($_POST['id_pelanggan'])) {
    $id = $_POST['id_pelanggan'];
    $query = mysqli_query($koneksi, "DELETE FROM pelanggan WHERE id_pelanggan = '$id'");

    if ($query) {
        // Simpan status sukses ke session
        session_start();
        $_SESSION['toast'] = [
            'pesan' => 'Data pelanggan berhasil dihapus!',
            'tipe' => 'success'
        ];
    } else {
        session_start();
        $_SESSION['toast'] = [
            'pesan' => 'Gagal menghapus data pelanggan!',
            'tipe' => 'danger'
        ];
    }

    // Kembali ke halaman utama
    header("Location: pelanggan.php?status=hapus_berhasil");
    exit;
}
?>
