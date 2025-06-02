<?php
include '../cek_login.php';
include '../koneksi/koneksi.php';

$id_pemilik = $_SESSION['id_pemilik'];
$nama_pemilik = $_SESSION['nama_pemilik'];
$password_pemilik = $_SESSION['password_pemilik'];
$no_hp_pemilik = $_SESSION['no_hp_pemilik'];
$jenis_kelamin = $_SESSION['jenis_kelamin'];
$foto_pemilik = $_SESSION['foto_pemilik'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nama_pemilik = $_POST['nama_pemilik'];
  $password_pemilik = md5($_POST['password_pemilik']); // Enkripsi password menggunakan md5
  $no_hp_pemilik = $_POST['no_hp_pemilik'];
  $jenis_kelamin = $_POST['jenis_kelamin'];

  if ($_FILES['foto']['name'] != "") {
    $foto_name = $_FILES['foto']['name'];
    $foto_tmp = $_FILES['foto']['tmp_name'];
    $foto_path = "../images/faces/" . $foto_name;

    move_uploaded_file($foto_tmp, $foto_path);

    $update = mysqli_query($koneksi, "UPDATE pemilik SET 
      nama_pemilik='$nama_pemilik', 
      password_pemilik='$password_pemilik', 
      no_hp_pemilik='$no_hp_pemilik', 
      jenis_kelamin='$jenis_kelamin',
      foto_pemilik='$foto_name' 
      WHERE id_pemilik='$id_pemilik'");

    $_SESSION['foto_pemilik'] = $foto_name;
  } else {
    $update = mysqli_query($koneksi, "UPDATE pemilik SET 
      nama_pemilik='$nama_pemilik', 
      password_pemilik='$password_pemilik', 
      no_hp_pemilik='$no_hp_pemilik', 
      jenis_kelamin='$jenis_kelamin'
      WHERE id_pemilik='$id_pemilik'");
  }

  // Update session
  $_SESSION['nama_pemilik'] = $nama_pemilik;
  $_SESSION['password_pemilik'] = $password_pemilik;
  $_SESSION['no_hp_pemilik'] = $no_hp_pemilik;
  $_SESSION['jenis_kelamin'] = $jenis_kelamin;

  header("Location: profil_pemilik.php?status=edit_berhasil");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Pengguna - Bude Ari</title>
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
$warna = 'primary'; // default

if ($status === 'edit_berhasil') {
    $pesan = 'Profil pemilik berhasil diperbarui!';
    $warna = 'inverse-success';
} elseif ($status === 'batal_edit') {
    $pesan = 'Perubahan profil pemilik dibatalkan.';
    $warna = 'inverse-warning';
}

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
    <!-- partial:partials/_navbar.html -->
    <?php include 'partials/navbar.php'; ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <?php include 'partials/sidebar.php'; ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
          <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Profil pemilik</h4>
                  <form class="forms-sample" method="POST" enctype="multipart/form-data" action="">
                        <div class="d-flex align-items-start align-items-sm-center gap-4 mb-4">
                          <?php
                          $foto = mysqli_query($koneksi, "SELECT * FROM pemilik WHERE id_pemilik='$id_pemilik'");
                          $foto = mysqli_fetch_assoc($foto);
                          ?>
                          <?php
                            if ($foto_pemilik == "") {
                            ?>
                              <img src="../images/faces/face6.jpg" alt="user-avatar" class="d-block rounded" height="100" width="100">
                            <?php } else { ?>
                              <img src="../images/faces/<?php echo $foto_pemilik; ?>" alt="user-avatar" class="d-block rounded" height="100" width="100">
                            <?php } ?>
                          <div class="button-wrapper">
                            <label for="upload" class="btn btn-inverse-info me-2 mb-4" tabindex="0">
                              <span class="d-none d-sm-block">Upload Foto Baru</span>
                              <i class="bx bx-upload d-block d-sm-none"></i>
                              <input type="file" id="upload" class="account-file-input" hidden
                                accept="image/png, image/jpeg" name="foto" />
                            </label>
                            <p class="text-muted mb-0">Abaikan Jika Tidak Ingin Ganti</p>
                          </div>
                        </div>
                    <div class="form-group">
                      <label for="exampleInputName1">Nama</label>
                      <input type="text" name="nama_pemilik" class="form-control" value="<?php echo $nama_pemilik; ?>">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Password</label>
                      <input type="password" name="password_pemilik" class="form-control" placeholder="**********" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword4">Nomor HP</label>
                      <input type="text" name="no_hp_pemilik" class="form-control" value="<?php echo $no_hp_pemilik; ?>">
                    </div>
                    <div class="form-group">
                      <label for="exampleSelectGender">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                          <option value="Laki-laki" <?php if ($jenis_kelamin == "Laki-laki") echo "selected"; ?>>Laki-laki</option>
                          <option value="Perempuan" <?php if ($jenis_kelamin == "Perempuan") echo "selected"; ?>>Perempuan</option>
                        </select>
                      </div>
                    <button type="submit" class="btn btn-inverse-success me-2">Edit</button>
                    <a href="dashboard.php?status=batal_edit" class="btn btn-inverse-danger">Cancel</a>
                  </form>
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
                    <strong class="me-auto">Profil pemilik</strong>
                    <small>Baru saja</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <!-- Pesan toast akan ditampilkan di sini -->
                    Hello, world! This is a toast message.
                </div>
            </div>
          </div>

        <!-- partial:partials/_footer.html -->
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

