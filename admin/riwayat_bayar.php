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
                    <h4 class="mb-0">Riwayat Pembayaran</h4>
                </div>
                <!-- Form Pilihan Pelanggan dan Utang -->
                <form method="GET" class="mb-3">
                    <div class="d-flex flex-wrap align-items-end gap-2">
                        <!-- Dropdown Pelanggan -->
                        <select name="id_pelanggan" class="form-select form-select-sm" style="max-width: 250px; padding: 0.5rem;" onchange="this.form.submit()" <?= !empty($id_utang) ? 'disabled' : '' ?>>
                            <option value="">-- Pilih Pelanggan --</option>
                            <?php while ($row = mysqli_fetch_assoc($pelanggan_result)) { ?>
                                <option value="<?= $row['id_pelanggan']; ?>" <?= ($id_pelanggan == $row['id_pelanggan']) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($row['nama_pelanggan']); ?>
                                </option>
                            <?php } ?>
                        </select>

                        <?php if (!empty($id_pelanggan)) :
                        $utang_result = mysqli_query($koneksi, "SELECT * FROM utang WHERE id_pelanggan = '$id_pelanggan'");
                        ?>
                            <!-- Dropdown Utang -->
                            <select name="id_utang" class="form-select form-select-sm" style="max-width: 350px; padding: 0.5rem;" onchange="this.form.submit()" <?= !empty($id_utang) ? 'disabled' : '' ?>>
                                <option value="">-- Pilih Utang --</option>
                                <?php while ($utang = mysqli_fetch_assoc($utang_result)) { ?>
                                    <option value="<?= $utang['id_utang']; ?>" <?= ($id_utang == $utang['id_utang']) ? 'selected' : ''; ?>>
                                        <?= "Tanggal: " . htmlspecialchars($utang['tanggal']) . " | Jumlah: Rp " . number_format($utang['jumlah_utang'], 0, ',', '.'); ?>
                                    </option>
                                <?php } ?>
                            </select>

                            <!-- Tombol Bersihkan -->
                            <a href="riwayat_bayar.php" class="btn btn-inverse-warning" style="padding: 0.7rem;">
                                Refresh
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($id_pelanggan) && !empty($id_utang)) : ?>
                            <!-- Tombol Cetak -->
                            <a href="javascript:void(0);" onclick="openPrintWindow(<?= $id_pelanggan; ?>, <?= $id_utang; ?>)" class="btn btn-inverse-primary" style="padding: 0.7rem;">
                                Cetak
                            </a>

                            <script>
                            function openPrintWindow(idPelanggan, idUtang) {
                                var printWindow = window.open('cetak_riwayat.php?id_pelanggan=' + idPelanggan + '&id_utang=' + idUtang, 'printWindow', 'width=800,height=600');
                                printWindow.onload = function() {
                                    printWindow.print();
                                };
                            }
                            </script>
                        <?php endif; ?>
                    </div>
                </form>

                <!-- Tabel Riwayat Bayar -->
                <?php if (!empty($id_utang)) : ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Tanggal Bayar</th>
                                <th>Nama Admin</th>
                                <th style="width: 20%;">Jumlah Bayar</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            // Ambil jumlah total utang untuk perbandingan
                            $utang_query = "SELECT jumlah_utang FROM utang WHERE id_utang = '$id_utang'";
                            $utang_result = mysqli_query($koneksi, $utang_query);
                            $utang_row = mysqli_fetch_assoc($utang_result);
                            $jumlah_utang = $utang_row['jumlah_utang'];

                            // Query untuk riwayat pembayaran
                            $query = "SELECT bayar.*, admin.nama_admin
                                        FROM bayar
                                        LEFT JOIN admin ON bayar.id_admin = admin.id_admin
                                        WHERE bayar.id_utang = '$id_utang'
                                        ORDER BY bayar.tanggal_bayar DESC";
                            $result = mysqli_query($koneksi, $query);
                            $total_bayar = 0;

                            while ($row = mysqli_fetch_assoc($result)) {
                                $total_bayar += $row['jumlah_bayar'];
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['tanggal_bayar']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nama_admin']) . "</td>";
                                echo "<td>Rp " . number_format($row['jumlah_bayar'], 0, ',', '.') . "</td>";
                                echo "</tr>";
                            }

                            if (mysqli_num_rows($result) == 0) {
                                echo '<tr><td colspan="3" class="text-center text-muted">Belum ada pembayaran</td></tr>';
                            }
                            ?>
                            </tbody>
                            <?php if ($total_bayar > 0) : ?>
                                <tfoot>
                                <tr>
                                    <th colspan="2" class="text-end">Total Pembayaran</th>
                                    <th>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Rp <?= number_format($total_bayar, 0, ',', '.'); ?></span>
                                            <?php
                                            $status = ($total_bayar >= $jumlah_utang) ? 'Lunas' : 'Belum Lunas';
                                            $label_class = ($status === 'Lunas') ? 'badge badge-success' : 'badge badge-danger';
                                            ?>
                                            <span class="label <?= $label_class; ?>"><?= $status; ?></span>                                            
                                        </div>
                                    </th>
                                </tr>
                                </tfoot>
                            <?php endif; ?>
                        </table>
                    </div>
                <?php endif; ?>
                </div>
            </div>
          </div>
        </div>
        </div>
        <!-- content-wrapper ends -->

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

