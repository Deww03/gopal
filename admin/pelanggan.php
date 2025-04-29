<?php
include '../cek_login.php';
include '../koneksi/koneksi.php';

// Ambil parameter pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Pelanggan - Gopal</title>
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
      $pesan = 'Data Pelanggan berhasil ditambahkan!';
      $warna = 'inverse-primary';
  } elseif ($status === 'edit_berhasil') {
      $pesan = 'Data Pelanggan berhasil diedit!';
      $warna = 'inverse-success';
  } elseif ($status === 'hapus_berhasil') {
      $pesan = 'Data Pelanggan berhasil dihapus!';
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
                        <h4 class="mb-0">Data Pelanggan</h4>
                        <button 
                        type="button" 
                        class="btn btn-inverse-primary" 
                        data-bs-toggle="modal" 
                        data-bs-target="#addRowModal">
                        Tambah Pelanggan
                        </button>
                    </div>

                    <!-- 🔍 Input Pencarian -->
                    <form method="GET" class="d-flex align-items-center gap-2 mb-3" style="max-width: 100%;">
                      <input 
                          type="text" 
                          id="searchInput" 
                          name="search"
                          class="form-control form-control-sm w-auto" 
                          placeholder="Cari pelanggan..." 
                          value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" 
                          style="max-width: 350px; padding: 0.5rem;"
                      >

                      <?php if (!empty($_GET['search'])) { ?>
                          <button type="submit" class="btn btn-inverse-info" style="padding: 0.5rem 1rem;">
                              Cari
                          </button>
                          <a href="pelanggan.php" class="btn btn-inverse-danger" style="padding: 0.5rem 1rem;">
                              Batal Cari
                          </a>
                      <?php } else { ?>
                          <button type="submit" class="btn btn-inverse-info" style="padding: 0.5rem 1rem;">
                              Cari
                          </button>
                      <?php } ?>
                  </form>

                    <!-- Modal Tambah Pelanggan -->
                    <div
                      class="modal fade"
                      id="addRowModal"
                      tabindex="-1"
                      role="dialog"
                      aria-hidden="true"
                    >
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">
                              <span class="fw-mediumbold">Pelanggan Baru</span>
                            </h5>
                            <button type="button" class="btn-inverse-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <p>
                              Isikan data pelanggan baru pada form di bawah
                              ini.
                            </p>
                            <form action="tambah_pelanggan.php" method="POST">
                              <div class="row">
                                <div class="col-sm-12">
                                  <div class="form-group form-group-default">
                                    <label>Nama</label>
                                    <input
                                      type="text"
                                      class="form-control"
                                      placeholder="Isikan nama pelanggan"
                                      required="required"
                                      name="nama_pelanggan"
                                    />
                                  </div>
                                </div>
                                <div class="col-sm-12">
                                <div class="form-group form-group-default">
                                    <label>Nomor HP</label>
                                    <input
                                    type="tel"
                                    class="form-control"
                                    placeholder="Isikan nomor HP pelanggan"
                                    name="no_hp_pelanggan"
                                    required
                                    pattern="[0-9]{10,13}"
                                    title="Nomor HP hanya boleh berisi angka (10-13 digit)"
                                    />
                                </div>
                                </div>                            
                              </div>
                            </div>
                            <div class="modal-footer border-0">
                              <button
                                type="submit"
                                id="addRowButton"
                                class="btn btn-inverse-primary"
                              >
                                Tambah
                              </button>
                              <button
                                type="button"
                                class="btn btn-inverse-danger"
                                data-bs-dismiss="modal"
                              >
                                Batal
                              </button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <!-- End Modal Tambah Pelanggan -->
                     
                    <!-- Tabel Pelanggan -->
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Nama</th>
                          <th>No. HP</th>
                          <th style="width: 21%;">Tindakan</th>
                        </tr>
                      </thead>
                      <tbody id="pelangganTable">
                      <?php
                          // Tentukan jumlah data per halaman
                          $limit = 5;
                          
                          // Ambil halaman saat ini dari URL, jika tidak ada, set ke 1
                          $page = isset($_GET['page']) ? $_GET['page'] : 1;
                          $start = ($page - 1) * $limit; // Data awal dari halaman saat ini
                          
                          if ($search != '') {
                              // Jika ada pencarian
                              $query_total = "SELECT COUNT(*) FROM pelanggan WHERE nama_pelanggan LIKE '%$search%' OR no_hp_pelanggan LIKE '%$search%'";
                              $result_total = mysqli_query($koneksi, $query_total);
                              $row_total = mysqli_fetch_array($result_total);
                              $total_records = $row_total[0];
                          
                              // Ambil semua data hasil pencarian tanpa limit
                              $query = "SELECT * FROM pelanggan WHERE nama_pelanggan LIKE '%$search%' OR no_hp_pelanggan LIKE '%$search%'";
                              $result = mysqli_query($koneksi, $query);
                          
                              // Untuk menampilkan "Menampilkan x sampai y"
                              $start_range = 1;
                              $end_range = $total_records;
                          
                          } else {
                              // Jika tidak ada pencarian
                              $query_total = "SELECT COUNT(*) FROM pelanggan";
                              $result_total = mysqli_query($koneksi, $query_total);
                              $row_total = mysqli_fetch_array($result_total);
                              $total_records = $row_total[0];
                          
                              $total_pages = ceil($total_records / $limit);
                          
                              // Ambil data terbatas dengan limit
                              $query = "SELECT * FROM pelanggan LIMIT $start, $limit";
                              $result = mysqli_query($koneksi, $query);
                          
                              // Hitung range tampil
                              $start_range = $start + 1;
                              $end_range = min($start + $limit, $total_records);
                          }
                          
                          // Menampilkan data dalam tabel
                          while ($row = mysqli_fetch_array($result)) {
                            $id = $row['id_pelanggan'];
                            $name = $row['nama_pelanggan'];
                            $no_hp = $row['no_hp_pelanggan'];
                            echo "<tr>";
                            echo "<td>$name</td>";
                            echo "<td>$no_hp</td>";
                            echo "<td>";
                            echo "<div class='form-button-action'>";
                            echo "<button type='button' class='btn btn-inverse-success me-2' data-bs-toggle='modal' data-bs-target='#editRowModal$id'>";
                            echo "Edit";
                            echo "</button>";
                            echo "<button type='button' class='btn btn-inverse-danger' data-bs-toggle='modal' data-bs-target='#deleteRowModal$id'>";
                            echo "Hapus";
                            echo "</button>";
                            echo "</div>";
                            echo "</td>";
                            echo "</tr>";
                          }

                          // Menghitung jumlah total data
                          $query_total = "SELECT COUNT(*) FROM pelanggan";
                          $result_total = mysqli_query($koneksi, $query_total);
                          $row_total = mysqli_fetch_array($result_total);
                          $total_records = $row_total[0];
                          
                          // Menghitung total halaman
                          $total_pages = ceil($total_records / $limit);
                          
                          // Menentukan rentang data yang ditampilkan
                          $start_range = ($page - 1) * $limit + 1;
                          $end_range = min($page * $limit, $total_records);
                          ?>    
                      </tbody>
                    </table>

                    <?php
                    // Reset ulang hasil query untuk loop kedua
                    mysqli_data_seek($result, 0); 

                    while ($row = mysqli_fetch_array($result)) {
                      $id = $row['id_pelanggan'];
                      $name = $row['nama_pelanggan'];
                      $no_hp = $row['no_hp_pelanggan'];

                      // Cek apakah pelanggan memiliki utang
                      $query_check_utang = "SELECT COUNT(*) FROM utang WHERE id_pelanggan = '$id'";
                      $result_check_utang = mysqli_query($koneksi, $query_check_utang);
                      $row_check_utang = mysqli_fetch_array($result_check_utang);
                      $has_utang = $row_check_utang[0] > 0;
                    ?>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="editRowModal<?php echo $id; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $id; ?>" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form action="edit_pelanggan.php" method="POST">
                            <div class="modal-header">
                              <h5 class="modal-title" id="editModalLabel<?php echo $id; ?>">Edit Data Pelanggan</h5>
                              <button type="button" class="btn-inverse-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <input type="hidden" name="id_pelanggan" value="<?php echo $id; ?>">
                              <div class="form-group form-group-default">
                                <label>Nama</label>
                                <input type="text" name="nama_pelanggan" class="form-control" value="<?php echo $name; ?>">
                              </div>
                              <div class="form-group form-group-default">
                                <label>No HP</label>
                                <input type="text" name="no_hp_pelanggan" class="form-control" value="<?php echo $no_hp; ?>">
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-inverse-primary">Simpan</button>
                              <button type="button" class="btn btn-inverse-danger" data-bs-dismiss="modal">Batal</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>

                    <!-- Modal Hapus -->
                    <div class="modal fade" id="deleteRowModal<?php echo $id; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $id; ?>" aria-hidden="true">
                      <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                          <form action="hapus_pelanggan.php" method="POST">
                            <div class="modal-header">
                              <h5 class="modal-title" id="deleteModalLabel<?php echo $id; ?>">Hapus Data</h5>
                              <button type="button" class="btn-inverse-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <input type="hidden" name="id_pelanggan" value="<?php echo $id; ?>">
                              <?php if ($has_utang): ?>
                                <p><strong><?php echo $name; ?></strong> memiliki utang dan tidak dapat dihapus.</p>
                              <?php else: ?>
                                <p>Yakin ingin menghapus data <strong><?php echo $name; ?></strong>?</p>
                              <?php endif; ?>
                            </div>
                            <div class="modal-footer">
                              <?php if (!$has_utang): ?>
                                <button type="submit" class="btn btn-inverse-danger">Hapus</button>
                              <?php endif; ?>
                              <button type="button" class="btn btn-inverse-info" data-bs-dismiss="modal">Batal</button>
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

