<?php
include '../cek_login.php';
include '../koneksi/koneksi.php';

// Ambil parameter pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Ambil data pelanggan
$pelanggan_result = mysqli_query($koneksi, "SELECT id_pelanggan, nama_pelanggan FROM pelanggan");

// Tanggal hari ini dan jatuh tempo
$today = date('Y-m-d');
$due_date = date('Y-m-d', strtotime('+60 days'));

// Nama admin dari session
$nama_admin = isset($_SESSION['nama_admin']) ? $_SESSION['nama_admin'] : 'Admin';

$id_pelanggan = isset($_GET['id_pelanggan']) ? $_GET['id_pelanggan'] : '';
$id_utang     = isset($_GET['id_utang']) ? $_GET['id_utang'] : '';

// Ambil daftar pelanggan
$pelanggan_result = mysqli_query($koneksi, "SELECT * FROM pelanggan");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Data Utang - Gopal</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../vendors/feather/feather.css">
  <link rel="stylesheet" href="../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="../vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="../js/select.dataTables.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../images/favicon.png" />
</head>
<body>
  <?php

  $status = $_GET['status'] ?? null;
  $pesan = '';
  $warna = 'primary'; // default warna toast

  if ($status === 'tambah_berhasil') {
      $pesan = 'Data Utang berhasil ditambahkan!';
      $warna = 'inverse-primary';
  } elseif ($status === 'bayar_berhasil') {
      $pesan = 'Utang berhasil dibayar!';
      $warna = 'inverse-success';
  } elseif ($status === 'gagal_jumlah_berlebih') {
      $pesan = 'Utang gagal dibayar karna jumlah berlebih!';
      $warna = 'inverse-warning';
  } elseif ($status === 'error') {
      $pesan = 'Terjadi kesalahan!';
      $warna = 'inverse-danger';
  }

  // ✅ Simpan ke session agar persist
  if (!empty($pesan)) {
      $_SESSION['notifikasi'][] = [
          'pesan' => $pesan,
          'warna' => $warna,
          'waktu' => date('H:i:s')
      ];
  }
  ?>

  <?php if (!empty($pesan)): ?>
  <script>
  document.addEventListener('DOMContentLoaded', () => {
      const toastEl = document.getElementById('liveToast');
      toastEl.classList.remove('bg-primary', 'bg-success', 'bg-warning', 'bg-danger', 'inverse-primary', 'inverse-success', 'inverse-warning', 'inverse-danger');
      toastEl.classList.add('bg-<?= $warna ?>');
      document.querySelector('.toast-body').innerText = "<?= $pesan ?>";
      const toast = new bootstrap.Toast(toastEl);
      toast.show();
  });
  </script>
  <?php endif; ?>

  <div class="container-scroller"> 

  <?php include 'partials/navbar.php'; ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <?php include 'partials/sidebar.php'; ?>
      <!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0">Laporan Utang</h4>
                        </div>

                        <!-- Form Pencarian -->
<form method="GET" class="mb-3">
    <div class="d-flex flex-wrap align-items-end gap-2">

        <!-- Dropdown Bulan -->
        <select name="bulan" class="form-select form-select-sm" style="max-width: 150px;">
            <option value="">-- Pilih Bulan --</option>
            <option value="01" <?= isset($_GET['bulan']) && $_GET['bulan'] == '01' ? 'selected' : '' ?>>Januari</option>
            <option value="02" <?= isset($_GET['bulan']) && $_GET['bulan'] == '02' ? 'selected' : '' ?>>Februari</option>
            <option value="03" <?= isset($_GET['bulan']) && $_GET['bulan'] == '03' ? 'selected' : '' ?>>Maret</option>
            <option value="04" <?= isset($_GET['bulan']) && $_GET['bulan'] == '04' ? 'selected' : '' ?>>April</option>
            <option value="05" <?= isset($_GET['bulan']) && $_GET['bulan'] == '05' ? 'selected' : '' ?>>Mei</option>
            <option value="06" <?= isset($_GET['bulan']) && $_GET['bulan'] == '06' ? 'selected' : '' ?>>Juni</option>
            <option value="07" <?= isset($_GET['bulan']) && $_GET['bulan'] == '07' ? 'selected' : '' ?>>Juli</option>
            <option value="08" <?= isset($_GET['bulan']) && $_GET['bulan'] == '08' ? 'selected' : '' ?>>Agustus</option>
            <option value="09" <?= isset($_GET['bulan']) && $_GET['bulan'] == '09' ? 'selected' : '' ?>>September</option>
            <option value="10" <?= isset($_GET['bulan']) && $_GET['bulan'] == '10' ? 'selected' : '' ?>>Oktober</option>
            <option value="11" <?= isset($_GET['bulan']) && $_GET['bulan'] == '11' ? 'selected' : '' ?>>November</option>
            <option value="12" <?= isset($_GET['bulan']) && $_GET['bulan'] == '12' ? 'selected' : '' ?>>Desember</option>
        </select>

        <!-- Dropdown Tahun -->
        <select name="tahun" class="form-select form-select-sm" style="max-width: 150px;">
            <option value="">-- Pilih Tahun --</option>
            <?php
            $current_year = date("Y");
            for ($i = $current_year; $i >= 2000; $i--) {
                echo "<option value='$i' " . (isset($_GET['tahun']) && $_GET['tahun'] == $i ? 'selected' : '') . ">$i</option>";
            }
            ?>
        </select>

        <!-- Dropdown Status -->
        <select name="status" class="form-select form-select-sm" style="max-width: 150px;">
            <option value="semua" <?= isset($_GET['status']) && $_GET['status'] == 'semua' ? 'selected' : '' ?>>-- Semua Status --</option>
            <option value="lunas" <?= isset($_GET['status']) && $_GET['status'] == 'lunas' ? 'selected' : '' ?>>Lunas</option>
            <option value="belum_lunas" <?= isset($_GET['status']) && $_GET['status'] == 'belum_lunas' ? 'selected' : '' ?>>Belum Lunas</option>
        </select>

        <!-- Tombol Cari -->
        <button class="btn btn-primary btn-sm">Cari</button>

        <!-- Tombol Refresh -->
        <a href="laporan_utang.php" class="btn btn-warning btn-sm">Refresh</a>

        <!-- Tombol Cetak (muncul hanya jika semua dropdown terisi) -->
        <?php if (!empty($_GET['bulan']) && !empty($_GET['tahun']) && isset($_GET['status']) && $_GET['status'] !== ''): ?>
            <a href="javascript:void(0);" onclick="openPrintWindow('<?= $_GET['bulan']; ?>', '<?= $_GET['tahun']; ?>', '<?= $_GET['status'] == 'semua' ? 'semua' : $_GET['status']; ?>')" class="btn btn-success btn-sm">Cetak</a>

            <script>
            function openPrintWindow(bulan, tahun, status) {
                var url = 'cetak_laporan_utang.php?bulan=' + bulan + '&tahun=' + tahun + '&status=' + status;
                var printWindow = window.open(url, 'printWindow', 'width=800,height=600');
                printWindow.onload = function () {
                    printWindow.print();
                };
            }
            </script>
        <?php endif; ?>

    </div>
</form>


                        <?php
                        // Periksa apakah semua filter telah dipilih
                        $bulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
                        $tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
                        $status = isset($_GET['status']) ? $_GET['status'] : '';

                        if (!empty($bulan) && !empty($tahun)) :
                        ?>

                        <!-- Tabel Utang -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Nama Admin</th>
                                        <th>Jatuh Tempo</th>
                                        <th>Jumlah Utang</th>
                                        <th>Jumlah Bayar</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Query untuk filter berdasarkan bulan, tahun, dan status
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

// Periksa apakah status adalah "semua", jika iya maka abaikan filter status
if ($status !== 'semua' && !empty($status)) {
    $status_condition = ($status == 'lunas') ? " AND utang.status = 'sudah_lunas'" : " AND utang.status = 'belum_lunas'";
    $query .= $status_condition;
}

$query .= " GROUP BY utang.id_utang ORDER BY utang.id_utang DESC";

// Eksekusi query
$result = mysqli_query($koneksi, $query);


                                    // Menampilkan data
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $jumlah_bayar = $row['jumlah_bayar']; // Sudah dari tabel bayar
                                        $sisa_utang = $row['jumlah_utang'] - $jumlah_bayar;

                                        // Status pembayaran
                                        $status_label = ($sisa_utang <= 0)
                                            ? '<label class="badge badge-success">Lunas</label>'
                                            : '<label class="badge badge-danger">Belum Lunas</label>';

                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['tanggal']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['nama_pelanggan']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['nama_admin']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['jatuh_tempo']) . "</td>";
                                        echo "<td>Rp " . number_format($row['jumlah_utang'], 0, ',', '.') . "</td>";
                                        echo "<td>Rp " . number_format($jumlah_bayar, 0, ',', '.') . "</td>";
                                        echo "<td>$status_label</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <?php endif; // End if filter ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content-wrapper ends -->
 </div>


        <!-- Toast Container -->
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <i class="mdi mdi-bell-ring me-2"></i>
                    <strong class="me-auto">Data Pelanggan</strong>
                    <small>Baru saja</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <!-- Pesan toast akan ditampilkan di sini -->
                    Hello, world! This is a toast message.
                </div>
            </div>
        </div>

        <!-- Footer -->
        <!-- partial:../../partials/_footer.html -->
        <?php include 'partials/footer.php'; ?>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="../vendors/chart.js/Chart.min.js"></script>
  <script src="../vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <script src="../vendors/progressbar.js/progressbar.min.js"></script>

  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="../js/off-canvas.js"></script>
  <script src="../js/hoverable-collapse.js"></script>
  <script src="../js/template.js"></script>
  <script src="../js/settings.js"></script>
  <script src="../js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../js/dashboard.js"></script>
  <script src="../js/Chart.roundedBarCharts.js"></script>
  <!-- End custom js for this page-->
</body>

</html>

