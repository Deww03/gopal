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
  <div class="container-scroller"> 
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <div class="me-3">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
            <span class="icon-menu"></span>
          </button>
        </div>
        <div>
          <a class="navbar-brand brand-logo" href="../index.html">
            <img src="../images/logo.svg" alt="logo" />
          </a>
          <a class="navbar-brand brand-logo-mini" href="../index.html">
            <img src="../images/logo-mini.svg" alt="logo" />
          </a>
        </div>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-top"> 
        <ul class="navbar-nav">
          <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
            <h1 class="welcome-text">Hallo, <span class="text-black fw-bold">Adam Kurniawan</span></h1>
            <h3 class="welcome-sub-text">Admin</h3>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item d-none d-lg-block">
            <div id="datepicker-popup" class="input-group date datepicker navbar-date-picker">
              <span class="input-group-addon input-group-prepend border-right">
                <span class="icon-calendar input-group-text calendar-icon"></span>
              </span>
              <input type="text" class="form-control">
            </div>
          </li>
          <li class="nav-item">
            <form class="search-form" action="#">
              <i class="icon-search"></i>
              <input type="search" class="form-control" placeholder="Search Here" title="Search here">
            </form>
          </li>
          <li class="nav-item dropdown"> 
            <a class="nav-link count-indicator" id="countDropdown" href="../#" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="icon-bell"></i>
              <span class="count"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="countDropdown">
              <a class="dropdown-item py-3">
                <p class="mb-0 font-weight-medium float-left">You have 7 unread mails </p>
                <span class="badge badge-pill badge-primary float-right">View all</span>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <img src="../images/faces/face10.jpg" alt="image" class="img-sm profile-pic">
                </div>
                <div class="preview-item-content flex-grow py-2">
                  <p class="preview-subject ellipsis font-weight-medium text-dark">Marian Garner </p>
                  <p class="fw-light small-text mb-0"> The meeting is cancelled </p>
                </div>
              </a>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <img src="../images/faces/face12.jpg" alt="image" class="img-sm profile-pic">
                </div>
                <div class="preview-item-content flex-grow py-2">
                  <p class="preview-subject ellipsis font-weight-medium text-dark">David Grey </p>
                  <p class="fw-light small-text mb-0"> The meeting is cancelled </p>
                </div>
              </a>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <img src="../images/faces/face1.jpg" alt="image" class="img-sm profile-pic">
                </div>
                <div class="preview-item-content flex-grow py-2">
                  <p class="preview-subject ellipsis font-weight-medium text-dark">Travis Jenkins </p>
                  <p class="fw-light small-text mb-0"> The meeting is cancelled </p>
                </div>
              </a>
            </div>
          </li>
          <li class="nav-item dropdown d-none d-lg-block user-dropdown">
            <a class="nav-link" id="UserDropdown" href="../#" data-bs-toggle="dropdown" aria-expanded="false">
              <img class="img-xs rounded-circle" src="../images/faces/face8.jpg" alt="Profile image"> </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
              <div class="dropdown-header text-center">
                <img class="img-md rounded-circle" src="../images/faces/face8.jpg" alt="Profile image">
                <p class="mb-1 mt-3 font-weight-semibold">Adam Kurniawan</p>
                <p class="fw-light text-muted mb-0">Admin</p>
              </div>
              <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i>Profil Saya</a>
              <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Keluar</a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="dashboard.php">
              <i class="mdi mdi-grid-large menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item nav-category">Hutang</li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="menu-icon mdi mdi-floor-plan"></i>
              <span class="menu-title">Data Hutang</span>
              <i class="menu-arrow"></i> 
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="semuaHutang.php">Semua Hutang</a></li>
                <li class="nav-item"> <a class="nav-link" href="sudahLunas.php">Sudah Lunas</a></li>
                <li class="nav-item"> <a class="nav-link" href="belumLunas.php">Belum Lunas</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item nav-category">Profil</li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
              <i class="menu-icon mdi mdi-card-text-outline"></i>
              <span class="menu-title">Pengguna</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a class="nav-link" href="pelanggan.php">Pelanggan</a></li>
              </ul>
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a class="nav-link" href="profilAdmin.php">Admin</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item nav-category">Dokumentasi</li>
          <li class="nav-item">
            <a class="nav-link" href="transaksi.php">
              <i class="menu-icon mdi mdi-file-document"></i>
              <span class="menu-title">Transaksi</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="laporanHutang.php">
              <i class="menu-icon mdi mdi-file-document"></i>
              <span class="menu-title">Laporan Hutang</span>
            </a>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">Pelanggan</h4>
                        <button 
                        type="button" 
                        class="btn btn-inverse-primary" 
                        data-bs-toggle="modal" 
                        data-bs-target="#addRowModal">
                        Tambah Pelanggan
                        </button>
                    </div>
                    <p>Berikut ini data data Pelanggan</p>
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
                                <div class="col-sm-12">
                                  <div class="form-group form-group-default">
                                    <label>Alamat</label>
                                    <input
                                      type="text"
                                      class="form-control"
                                      placeholder="Isikan alamat pelanggan"
                                      required="required"
                                      name="alamat_pelanggan"
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
                          <th>Alamat</th>
                          <th style="width: 21%;">Tindakan</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                          include "../koneksi/koneksi.php";
                          
                          // Tentukan jumlah data per halaman
                          $limit = 5;
                          
                          // Ambil halaman saat ini dari URL, jika tidak ada, set ke 1
                          $page = isset($_GET['page']) ? $_GET['page'] : 1;
                          $start = ($page - 1) * $limit; // Hitung data yang dimulai dari halaman tertentu
                          
                          // Query untuk mengambil data pelanggan dengan batasan
                          $query = "SELECT * FROM pelanggan LIMIT $start, $limit";
                          $result = mysqli_query($koneksi, $query);
                          
                          // Menampilkan data dalam tabel
                          while ($row = mysqli_fetch_array($result)) {
                            $id = $row['id_pelanggan'];
                            $name = $row['nama_pelanggan'];
                            $no_hp = $row['no_hp_pelanggan'];
                            $alamat = $row['alamat_pelanggan'];
                            echo "<tr>";
                            echo "<td>$name</td>";
                            echo "<td>$no_hp</td>";
                            echo "<td>$alamat</td>";
                            echo "<td>";
                            echo "<div class='form-button-action'>";
                            echo "<button type='button' class='btn btn-inverse-success me-2' data-bs-toggle='modal' data-bs-target='#editRowModal$id'>";
                            echo "<i class='fa fa-edit'></i> Edit";
                            echo "</button>";
                            echo "<button type='button' class='btn btn-inverse-danger' data-bs-toggle='modal' data-bs-target='#deleteRowModal$id'>";
                            echo "<i class='fa fa-times'></i> Hapus";
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
                        $alamat = $row['alamat_pelanggan'];
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
                                  <div class="form-group form-group-default">
                                    <label>Alamat</label>
                                    <input type="text" name="alamat_pelanggan" class="form-control" value="<?php echo $alamat; ?>">
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
                                  <p>Yakin ingin menghapus data <strong><?php echo $name; ?></strong>?</p>
                                </div>
                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-inverse-danger">Hapus</button>
                                  <button type="button" class="btn btn-inverse-info" data-bs-dismiss="modal">Batal</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>

                      <?php } ?>

                      
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
                    </div>
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

        <!-- Toast Notification for Status -->
        <?php
        $status = $_GET['status'] ?? null;
        $pesan = '';
        $warna = 'primary'; // default warna toast

        if ($status === 'tambah_berhasil') {
            $pesan = 'Data berhasil ditambahkan!';
            $warna = 'primary'; // warna untuk tambah
        } elseif ($status === 'edit_berhasil') {
            $pesan = 'Data berhasil diedit!';
            $warna = 'success'; // warna untuk edit
        } elseif ($status === 'hapus_berhasil') {
            $pesan = 'Data berhasil dihapus!';
            $warna = 'warning'; // warna untuk hapus
        } elseif ($status === 'error') {
            $pesan = 'Terjadi kesalahan!';
            $warna = 'danger'; // warna untuk error
        }

        if ($pesan):
        ?>
            <script>
            document.addEventListener('DOMContentLoaded', () => {
                const toastEl = document.getElementById('liveToast');
                toastEl.classList.remove('bg-primary', 'bg-success', 'bg-warning', 'bg-danger'); // reset semua warna
                toastEl.classList.add('bg-<?= $warna ?>'); // pasang warna sesuai status
                document.querySelector('.toast-body').innerText = "<?= $pesan ?>";
                const toast = new bootstrap.Toast(toastEl);
                toast.show();
            });
            </script>
        <?php endif; ?>
        <!-- End Toast Notification -->



        <!-- Footer -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Dibuat oleh <a href="#" target="_blank">Adam Kurniawan</a>.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © 2025. All rights reserved.</span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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

