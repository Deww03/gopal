<?php
include '../koneksi/koneksi.php';

$id_pelanggan = $_GET['id_pelanggan'] ?? '';
$id_utang = $_GET['id_utang'] ?? '';

if (empty($id_pelanggan) || empty($id_utang)) {
    echo "Data tidak lengkap.";
    exit;
}

// Ambil nama pelanggan
$pelanggan_query = mysqli_query($koneksi, "SELECT nama_pelanggan FROM pelanggan WHERE id_pelanggan = '$id_pelanggan'");
$pelanggan = mysqli_fetch_assoc($pelanggan_query);

// Ambil total utang
$utang_query = mysqli_query($koneksi, "SELECT jumlah_utang FROM utang WHERE id_utang = '$id_utang'");
$utang = mysqli_fetch_assoc($utang_query);
$jumlah_utang = $utang['jumlah_utang'];

// Ambil riwayat bayar
$query = "SELECT bayar.*, admin.nama_admin 
          FROM bayar 
          LEFT JOIN admin ON bayar.id_admin = admin.id_admin 
          WHERE bayar.id_utang = '$id_utang'
          ORDER BY bayar.tanggal_bayar ASC";
$result = mysqli_query($koneksi, $query);

// Hitung total bayar
$total_bayar = 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cetak Riwayat Pembayaran</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2, p { margin: 0; }
    </style>
    <style>
        @media print {
            body {
                margin-bottom: 150px;
            }
            .footer-info {
                position: fixed;
                bottom: 30px;
                width: 100%;
                text-align: center;
                font-size: 14px;
            }
        }
    </style>
</head>
<body onload="window.print()">

<h2>Riwayat Pembayaran</h2>
<p><strong>Nama Pelanggan:</strong> <?= htmlspecialchars($pelanggan['nama_pelanggan']); ?></p>
<p><strong>Total Utang:</strong> Rp <?= number_format($jumlah_utang, 0, ',', '.'); ?></p>

<table>
    <thead>
        <tr>
            <th>Tanggal Bayar</th>
            <th>Nama Admin</th>
            <th>Jumlah Bayar</th>
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <?php $total_bayar += $row['jumlah_bayar']; ?>
                <tr>
                    <td><?= htmlspecialchars($row['tanggal_bayar']); ?></td>
                    <td><?= htmlspecialchars($row['nama_admin']); ?></td>
                    <td>Rp <?= number_format($row['jumlah_bayar'], 0, ',', '.'); ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="3">Belum ada pembayaran</td></tr>
        <?php endif; ?>
    </tbody>
    <?php if ($total_bayar > 0): ?>
        <tfoot>
            <tr>
                <th colspan="2">Total Pembayaran</th>
                <th>Rp <?= number_format($total_bayar, 0, ',', '.'); ?></th>
            </tr>
            <tr>
                <th colspan="2">Sisa Utang</th>
                <th>Rp <?= number_format(max($jumlah_utang - $total_bayar, 0), 0, ',', '.'); ?></th>
            </tr>
            <tr>
                <th colspan="2">Status</th>
                <th>
                    <?php
                    $status = ($total_bayar >= $jumlah_utang) ? 'Lunas' : 'Belum Lunas';
                    echo $status;
                    ?>
                </th>
            </tr>
        </tfoot>
    <?php endif; ?>
</table>
<!-- Info Nama Toko -->
<div class="footer-info">
    <hr style="width: 50%;">
    <strong>Warung Bude Ari</strong><br>
    Telagasari Rt 05 / Rw 02 Cikupa Tangerang<br>
    Telepon: 0812-3456-7890
</div>
</body>
</html>
