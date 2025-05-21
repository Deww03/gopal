<?php
include '../koneksi/koneksi.php';

$bulan = $_GET['bulan'] ?? '';
$tahun = $_GET['tahun'] ?? '';
$status = $_GET['status'] ?? '';

// Buat filter query
$query = "SELECT utang.*, pelanggan.nama_pelanggan, admin.nama_admin, 
          IFNULL(SUM(bayar.jumlah_bayar), 0) AS jumlah_bayar
          FROM utang
          LEFT JOIN pelanggan ON utang.id_pelanggan = pelanggan.id_pelanggan
          LEFT JOIN admin ON utang.id_admin = admin.id_admin
          LEFT JOIN bayar ON utang.id_utang = bayar.id_utang
          WHERE 1";

if (!empty($bulan)) {
    $query .= " AND MONTH(utang.tanggal) = '$bulan'";
}
if (!empty($tahun)) {
    $query .= " AND YEAR(utang.tanggal) = '$tahun'";
}
if (!empty($status) && $status !== 'semua') {
    $query .= " AND utang.status = '" . ($status == 'lunas' ? 'sudah_lunas' : $status) . "'";
}



$query .= " GROUP BY utang.id_utang ORDER BY utang.tanggal DESC";
$result = mysqli_query($koneksi, $query);

$total_utang = 0;
$total_bayar = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan Utang</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
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

<h2>Laporan Data Utang</h2>
<p><strong>Periode:</strong>
    <?= !empty($bulan) ? date("F", mktime(0, 0, 0, $bulan, 10)) : 'Semua Bulan' ?>
    <?= !empty($tahun) ? $tahun : '' ?>
</p>
<p><strong>Status:</strong>
    <?= $status == 'lunas' ? 'Lunas' : ($status == 'belum_lunas' ? 'Belum Lunas' : 'Semua') ?>
</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama Pelanggan</th>
            <th>Nama Admin</th>
            <th>Jatuh Tempo</th>
            <th>Jumlah Utang</th>
            <th>Jumlah Bayar</th>
            <th>Sisa</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php $no = 1; ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <?php
                    $jumlah_utang = $row['jumlah_utang'];
                    $jumlah_bayar = $row['jumlah_bayar'];
                    $sisa = $jumlah_utang - $jumlah_bayar;
                    $total_utang += $jumlah_utang;
                    $total_bayar += $jumlah_bayar;
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['tanggal']); ?></td>
                    <td><?= htmlspecialchars($row['nama_pelanggan']); ?></td>
                    <td><?= htmlspecialchars($row['nama_admin']); ?></td>
                    <td><?= htmlspecialchars($row['jatuh_tempo']); ?></td>
                    <td>Rp <?= number_format($jumlah_utang, 0, ',', '.'); ?></td>
                    <td>Rp <?= number_format($jumlah_bayar, 0, ',', '.'); ?></td>
                    <td>Rp <?= number_format($sisa, 0, ',', '.'); ?></td>
                    <td><?= $row['status'] == 'sudah_lunas' ? 'Lunas' : 'Belum Lunas'; ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="9">Data tidak ditemukan</td></tr>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="5">Total</th>
            <th>Rp <?= number_format($total_utang, 0, ',', '.'); ?></th>
            <th>Rp <?= number_format($total_bayar, 0, ',', '.'); ?></th>
            <th colspan="2">Rp <?= number_format($total_utang - $total_bayar, 0, ',', '.'); ?></th>
        </tr>
    </tfoot>
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
