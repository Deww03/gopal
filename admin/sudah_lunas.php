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
                        <h4 class="mb-0">Utang yang sudah lunas</h4>
                    </div>

                    <!-- 🔍 Input Pencarian -->
                    <form method="GET" class="d-flex align-items-center gap-2 mb-3" style="max-width: 100%;">
                      <input 
                          type="text" 
                          id="searchInput" 
                          name="search"
                          class="form-control form-control-sm w-auto" 
                          placeholder="Cari utang..." 
                          value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" 
                          style="max-width: 350px; padding: 0.5rem;"
                      >

                      <?php if (!empty($_GET['search'])) { ?>
                          <button type="submit" class="btn btn-inverse-info" style="padding: 0.5rem 1rem;">
                              Cari
                          </button>
                          <a href="sudah_lunas.php" class="btn btn-inverse-danger" style="padding: 0.5rem 1rem;">
                              Batal Cari
                          </a>
                      <?php } else { ?>
                          <button type="submit" class="btn btn-inverse-info" style="padding: 0.5rem 1rem;">
                              Cari
                          </button>
                      <?php } ?>
                    </form>
                     
                    <!-- Tabel Utang -->
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Admin</th>
                            <th>Jatuh Tempo</th>
                            <th>Jumlah Utang</th>
                            <th>Jumlah Bayar</th>
                            <th>Sisa Utang</th>
                            <th>Status</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody id="pelangganTable">
                        <?php
                          // Ambil keyword pencarian jika ada
                          $search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';

                          // Pagination setup
                          $limit = 5;
                          $page = isset($_GET['page']) ? $_GET['page'] : 1;
                          $start = ($page - 1) * $limit;

                          if (!empty($search)) {
                              // Query total jika pencarian
                              $query_total = "SELECT COUNT(*) 
                                              FROM utang 
                                              LEFT JOIN pelanggan ON utang.id_pelanggan = pelanggan.id_pelanggan
                                              LEFT JOIN admin ON utang.id_admin = admin.id_admin
                                              WHERE utang.status = 'sudah_lunas' AND (
                                                  pelanggan.nama_pelanggan LIKE '%$search%' OR 
                                                  admin.nama_admin LIKE '%$search%' OR
                                                  utang.tanggal LIKE '%$search%' OR
                                                  utang.jumlah_utang LIKE '%$search%'
                                              )";
                              $result_total = mysqli_query($koneksi, $query_total);
                              $row_total = mysqli_fetch_array($result_total);
                              $total_records = $row_total[0];

                              $query = "SELECT utang.*, pelanggan.nama_pelanggan, admin.nama_admin,
                                              IFNULL(SUM(bayar.jumlah_bayar), 0) AS jumlah_bayar
                                        FROM utang
                                        LEFT JOIN pelanggan ON utang.id_pelanggan = pelanggan.id_pelanggan
                                        LEFT JOIN admin ON utang.id_admin = admin.id_admin
                                        LEFT JOIN bayar ON utang.id_utang = bayar.id_utang
                                        WHERE utang.status = 'sudah_lunas' AND (
                                            pelanggan.nama_pelanggan LIKE '%$search%' OR 
                                            admin.nama_admin LIKE '%$search%' OR
                                            utang.tanggal LIKE '%$search%' OR
                                            utang.jumlah_utang LIKE '%$search%'
                                        )
                                        GROUP BY utang.id_utang
                                        ORDER BY utang.id_utang DESC
                                        LIMIT $start, $limit
                                        ";

                              $result = mysqli_query($koneksi, $query);
                              $start_range = 1;
                              $end_range = $total_records;

                          } else {
                              // Query total jika tidak ada pencarian
                              $query_total = "SELECT COUNT(*) 
                                              FROM utang 
                                              WHERE status = 'sudah_lunas'";
                              $result_total = mysqli_query($koneksi, $query_total);
                              $row_total = mysqli_fetch_array($result_total);
                              $total_records = $row_total[0];
                              $total_pages = ceil($total_records / $limit);

                              $query = "SELECT utang.*, pelanggan.nama_pelanggan, admin.nama_admin,
                                        IFNULL(SUM(bayar.jumlah_bayar), 0) AS jumlah_bayar
                                        FROM utang
                                        LEFT JOIN pelanggan ON utang.id_pelanggan = pelanggan.id_pelanggan
                                        LEFT JOIN admin ON utang.id_admin = admin.id_admin
                                        LEFT JOIN bayar ON utang.id_utang = bayar.id_utang
                                        WHERE utang.status = 'sudah_lunas'
                                        GROUP BY utang.id_utang
                                        ORDER BY utang.id_utang DESC
                                        LIMIT $start, $limit
                                        ";
                                        $result = mysqli_query($koneksi, $query);

                              $start_range = $start + 1;
                              $end_range = min($start + $limit, $total_records);
                          }

                          // Tampilkan data
                          while ($row = mysqli_fetch_assoc($result)) {
                            $jumlah_bayar = $row['jumlah_bayar']; // Sudah dari tabel bayar
                            $sisa_utang = $row['jumlah_utang'] - $jumlah_bayar;
                        
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['tanggal']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nama_pelanggan']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nama_admin']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['jatuh_tempo']) . "</td>";
                            echo "<td>Rp " . number_format($row['jumlah_utang'], 0, ',', '.') . "</td>";
                            echo "<td>Rp " . number_format($jumlah_bayar, 0, ',', '.') . "</td>";
                            echo "<td>Rp " . number_format($sisa_utang, 0, ',', '.') . "</td>";
                            
                            $status_label = $row['status'] == 'sudah_lunas'
                                            ? '<label class="badge badge-success">Lunas</label>'
                                            : '<label class="badge badge-danger">Belum Lunas</label>';
                            echo "<td>$status_label</td>";
                            echo "<td>
                                    <div class='dropdown'>
                                      <button class='btn btn-sm btn-inverse-warning dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                        Aksi
                                      </button>
                                      <ul class='dropdown-menu'>
                                        <li><a class='dropdown-item' href='#' data-bs-toggle='modal' data-bs-target='#editRowModal{$row['id_utang']}'>Bayar</a></li>
                                        <li><a class='dropdown-item' href='riwayat_bayar.php?id_pelanggan={$row['id_pelanggan']}&id_utang={$row['id_utang']}'>Riwayat</a></li>
                                      </ul>
                                    </div>
                                  </td>";
                            echo "</tr>";
                        }
                        
                          ?>

                        </tbody>
                      </table>

                      <?php
                        mysqli_data_seek($result, 0); 

                        while ($row = mysqli_fetch_array($result)) {
                          $id = $row['id_utang'];
                          $tanggal = $row['tanggal'];
                          $nama_pelanggan = $row['nama_pelanggan'];
                          $jumlah_utang = $row['jumlah_utang'];
                          $status = $row['status'];
                          $total_bayar = $row['jumlah_bayar'];
                          $sisa_utang = $jumlah_utang - $total_bayar;
                        ?>

                        <!-- Modal Bayar Utang -->
                        <div class="modal fade" id="editRowModal<?php echo $id; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $id; ?>" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <form action="bayar_utang.php" method="POST">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="editModalLabel<?php echo $id; ?>">Bayar Utang</h5>
                                  <button type="button" class="btn-inverse-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <input type="hidden" name="id_utang" value="<?php echo $id; ?>">

                                  <div class="form-group form-group-default mb-2">
                                    <label>Tanggal</label>
                                    <input type="text" class="form-control" value="<?php echo $tanggal; ?>" readonly>
                                  </div>

                                  <div class="form-group form-group-default mb-2">
                                    <label>Nama Pelanggan</label>
                                    <input type="text" class="form-control" value="<?php echo $nama_pelanggan; ?>" readonly>
                                  </div>

                                  <div class="form-group form-group-default mb-2">
                                    <label>Total Utang</label>
                                    <input type="text" class="form-control" value="Rp <?php echo number_format($jumlah_utang, 0, ',', '.'); ?>" readonly>
                                  </div>

                                  <?php if ($status == 'sudah_lunas'): ?>
                                    <div class="alert alert-success mt-3 mb-0">
                                      Utang ini sudah lunas dan tidak dapat dibayar lagi.
                                    </div>
                                  <?php else: ?>
                                    <div class="form-group form-group-default mb-2">
                                      <label>Jumlah Bayar</label>
                                      <input type="number" name="jumlah_bayar"
                                        max="<?php echo $row['jumlah_utang'] - $row['jumlah_bayar']; ?>"
                                        class="form-control"
                                        placeholder="Masukkan jumlah yang dibayar"
                                        required>
                                    </div>
                                  <?php endif; ?>
                                </div>
                                <div class="modal-footer">
                                  <?php if ($status != 'sudah_lunas'): ?>
                                    <button type="submit" class="btn btn-inverse-success">Bayar</button>
                                  <?php endif; ?>
                                  <button type="button" class="btn btn-inverse-danger" data-bs-dismiss="modal">Tutup</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>

                        <?php } ?>


                      <?php if ($search == '') { ?>
                      <!-- Teks dan Pagination terpisah di 2 kolom -->
                      <div class="d-flex justify-content-between align-items-center mt-3">
                        <!-- Teks di kiri -->
                        <div>
                          <p class="mb-0">
                            Menampilkan <?php echo $start_range; ?> sampai <?php echo $end_range; ?> dari <?php echo $total_records; ?> data.
                          </p>
                        </div>

                        <!-- Pagination di kanan -->
                        <div>
                          <nav aria-label="Page navigation">
                            <ul class="pagination mb-0">
                              <!-- Tombol Previous -->
                              <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                                <a class="page-link" href="?page=<?php echo $page - 1; ?>">Sebelumnya</a>
                              </li>

                              <!-- Nomor halaman -->
                              <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                  <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                              <?php } ?>

                              <!-- Tombol Next -->
                              <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                                <a class="page-link" href="?page=<?php echo $page + 1; ?>">Selanjutnya</a>
                              </li>
                            </ul>
                          </nav>
                        </div>
                      <?php } ?>
                  </div>
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

