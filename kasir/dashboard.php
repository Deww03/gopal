<?php
include '../cek_login.php';
include '../koneksi/koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Dashboard - Bude Ari</title>
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
// Total Utang (jumlah baris utang)
$total_utang = $koneksi->query("SELECT COUNT(*) as total FROM utang")->fetch_assoc()['total'];

// Utang Lunas
$utang_lunas = $koneksi->query("SELECT COUNT(*) as lunas FROM utang WHERE status='sudah_lunas'")->fetch_assoc()['lunas'];

// Utang Belum Lunas
$utang_belum_lunas = $koneksi->query("SELECT COUNT(*) as belum FROM utang WHERE status='belum_lunas'")->fetch_assoc()['belum'];

// Nominal Utang Total
$nominal_utang = $koneksi->query("SELECT SUM(jumlah_utang) as total_nominal FROM utang")->fetch_assoc()['total_nominal'];

// Sudah Dibayar (ambil dari tabel bayar)
$dibayar = $koneksi->query("SELECT SUM(jumlah_bayar) as lunas_nominal FROM bayar")->fetch_assoc()['lunas_nominal'];

// Belum Dibayar
$belum_dibayar = $nominal_utang - $dibayar;

// Ambil tanggal hari ini
$today = date('Y-m-d');

// Minggu ini (Senin - Minggu minggu ini)
$startOfThisWeek = date('Y-m-d', strtotime('monday this week'));
$endOfThisWeek = date('Y-m-d', strtotime('sunday this week'));

// Minggu lalu
$startOfLastWeek = date('Y-m-d', strtotime('monday last week'));
$endOfLastWeek = date('Y-m-d', strtotime('sunday last week'));

// Buat array default 0 untuk setiap hari
$hariMap = ["Monday" => 0, "Tuesday" => 0, "Wednesday" => 0, "Thursday" => 0, "Friday" => 0, "Saturday" => 0, "Sunday" => 0];

// Fungsi ambil data utang mingguan
function getUtangMingguan($koneksi, $startDate, $endDate) {
    global $hariMap;
    $result = $hariMap;

    $query = "SELECT DAYNAME(tanggal) AS hari, SUM(jumlah_utang) AS total_utang
              FROM utang
              WHERE tanggal BETWEEN '$startDate' AND '$endDate'
              GROUP BY DAYNAME(tanggal)";
    $data = mysqli_query($koneksi, $query);

    while ($row = mysqli_fetch_assoc($data)) {
        $result[$row['hari']] = (int)$row['total_utang'];
    }

    return $result;
}

// Ambil data utang minggu ini & minggu lalu
$mingguIniRaw = getUtangMingguan($koneksi, $startOfThisWeek, $endOfThisWeek);
$mingguLaluRaw = getUtangMingguan($koneksi, $startOfLastWeek, $endOfLastWeek);

// Ubah urutan jadi Senin -> Minggu
$urutanHari = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
$mingguIni = [];
$mingguLalu = [];

foreach ($urutanHari as $hari) {
    $mingguIni[] = $mingguIniRaw[$hari];
    $mingguLalu[] = $mingguLaluRaw[$hari];
}
?>

<script>
    var mingguIni = <?= json_encode($mingguIni) ?>;
    var mingguLalu = <?= json_encode($mingguLalu) ?>;
    console.log("Minggu Ini:", mingguIni);
    console.log("Minggu Lalu:", mingguLalu);
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php
// Data Status Summary: Total utang lunas per hari minggu ini
$statusSummaryData = $hariMap;

$queryStatus = "SELECT DAYNAME(tanggal) as hari, SUM(jumlah_utang) as total
                FROM utang 
                WHERE status='sudah_lunas' 
                AND tanggal BETWEEN '$startOfThisWeek' AND '$endOfThisWeek'
                GROUP BY DAYNAME(tanggal)";

$dataStatus = mysqli_query($koneksi, $queryStatus);

while ($row = mysqli_fetch_assoc($dataStatus)) {
    $statusSummaryData[$row['hari']] = (int)$row['total'];
}

$statusSummaryOrdered = [];
foreach ($urutanHari as $hari) {
    $statusSummaryOrdered[] = $statusSummaryData[$hari];
}

$queryLunasMingguIni = "
    SELECT SUM(jumlah_utang) as total 
    FROM utang 
    WHERE status='sudah_lunas' 
    AND tanggal BETWEEN '$startOfThisWeek' AND '$endOfThisWeek'
";
$closedValue = $koneksi->query($queryLunasMingguIni)->fetch_assoc()['total'] ?? 0;
?>

<script>
    var statusSummaryData = <?= json_encode($statusSummaryOrdered) ?>;
</script>

<script>
  // Ambil data dari PHP
  var totalUtang = <?= $total_utang ?>;
  var totalLunas = <?= $utang_lunas ?>;
  var totalBelumLunas = <?= $utang_belum_lunas ?>;

  // Hitung persentase (dalam bentuk 0.0 - 1.0)
  var persentaseLunas = totalUtang > 0 ? totalLunas / totalUtang : 0;
  var persentaseBelumLunas = totalUtang > 0 ? totalBelumLunas / totalUtang : 0;
</script>

<?php
// Ambil tahun dari URL atau default tahun ini
$tahun_aktif = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

// Inisialisasi array 12 bulan dengan nilai 0
$utangData = array_fill(0, 12, 0);
$bayarData = array_fill(0, 12, 0);

// Query total utang per bulan
$query_utang = "SELECT MONTH(tanggal) AS bulan, SUM(jumlah_utang) AS total_utang 
                FROM utang 
                WHERE YEAR(tanggal) = '$tahun_aktif'
                GROUP BY bulan";
$result_utang = mysqli_query($koneksi, $query_utang);
while ($row = mysqli_fetch_assoc($result_utang)) {
    $bulan = (int)$row['bulan'] - 1; // array index 0-11
    $utangData[$bulan] = (int)$row['total_utang'];
}

// Query total bayar per bulan
$query_bayar = "SELECT MONTH(tanggal_bayar) AS bulan, SUM(jumlah_bayar) AS total_bayar 
                FROM bayar 
                WHERE YEAR(tanggal_bayar) = '$tahun_aktif'
                GROUP BY bulan";
$result_bayar = mysqli_query($koneksi, $query_bayar);
while ($row = mysqli_fetch_assoc($result_bayar)) {
    $bulan = (int)$row['bulan'] - 1;
    $bayarData[$bulan] = (int)$row['total_bayar'];
}

// Kirim data ke JavaScript
echo "<script>
    var utangData = ".json_encode($utangData).";
    var bayarData = ".json_encode($bayarData).";
</script>";
?>

<?php
// Ambil total utang
$q1 = $koneksi->query("SELECT SUM(jumlah_utang) AS total_jumlah_utang FROM utang")->fetch_assoc();

// Ambil total bayar
$q2 = $koneksi->query("SELECT SUM(jumlah_bayar) AS total_bayar FROM bayar")->fetch_assoc();

// Ambil total utang yang sudah lunas
$q3 = $koneksi->query("SELECT SUM(jumlah_utang) AS lunas FROM utang WHERE status = 'sudah_lunas'")->fetch_assoc();

$total_jumlah_utang = (int)($q1['total_jumlah_utang'] ?? 0);
$total_bayar = (int)($q2['total_bayar'] ?? 0);
$total_lunas = (int)($q3['lunas'] ?? 0);
$sisa_utang = $total_jumlah_utang - $total_bayar;
?>

<script>
  const chartData = {
    labels: ['Total Utang', 'Total Pembayaran', 'Sisa Utang', 'Sudah Lunas'],
    data: [<?= $total_jumlah_utang ?>, <?= $total_bayar ?>, <?= $sisa_utang ?>, <?= $total_lunas ?>]
  };
</script>

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
            <div class="col-sm-12">
              <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                </div>
                <div class="tab-content tab-content-basic">
                  <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview"> 
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="statistics-details d-flex align-items-center justify-content-between">
                          <div>
                            <p class="statistics-title">Total Utang</p>
                            <h3 class="rate-percentage"><?= $total_utang ?></h3>
                          </div>
                          <div>
                            <p class="statistics-title">Utang Lunas</p>
                            <h3 class="rate-percentage"><?= $utang_lunas ?></h3>
                          </div>
                          <div>
                            <p class="statistics-title">Utang Belum Lunas</p>
                            <h3 class="rate-percentage"><?= $utang_belum_lunas ?></h3>
                          </div>
                          <div class="d-none d-md-block">
                            <p class="statistics-title">Nominal Utang</p>
                            <h3 class="rate-percentage">Rp <?= number_format($nominal_utang, 0, ',', '.') ?></h3>
                          </div>
                          <div class="d-none d-md-block">
                            <p class="statistics-title">Sudah Dibayar</p>
                            <h3 class="rate-percentage">Rp <?= number_format($dibayar, 0, ',', '.') ?></h3>
                          </div>
                          <div class="d-none d-md-block">
                            <p class="statistics-title">Belum Dibayar</p>
                            <h3 class="rate-percentage">Rp <?= number_format($belum_dibayar, 0, ',', '.') ?></h3>
                          </div>
                        </div>
                      </div>
                    </div> 
                    <div class="row">
                      <div class="col-lg-8 d-flex flex-column">
                        <div class="row flex-grow">
                          <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-start">
                                  <div>
                                   <h4 class="card-title card-title-dash">Grafik Nominal Utang</h4>
                                   <h5 class="card-subtitle card-subtitle-dash">Dalam 2 minggu terakhir</h5>
                                  </div>
                                  <div id="performance-line-legend"></div>
                                </div>
                                <div class="chartjs-wrapper mt-5">
                                  <canvas id="performaneLine"></canvas>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4 d-flex flex-column">
                        <div class="row flex-grow">
                          <div class="col-md-6 col-lg-12 grid-margin stretch-card">
                            <div class="card bg-primary card-rounded">
                              <div class="card-body pb-0">
                                <h4 class="card-title card-title-dash text-white mb-4">Lunas Minggu ini</h4>
                                <div class="row">
                                  <div class="col-sm-4">
                                    <p class="status-summary-ight-white mb-1">Nominal :</p>
                                    <h4 class="text-info">Rp <?= number_format($closedValue, 0, ',', '.') ?></h4>
                                  </div>
                                  <div class="col-sm-8">
                                    <div class="status-summary-chart-wrapper pb-4">
                                      <canvas id="status-summary"></canvas>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6 col-lg-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-sm-6">
                                    <div class="d-flex justify-content-between align-items-center mb-2 mb-sm-0">
                                      <div class="circle-progress-width">
                                        <div id="totalVisitors" class="progressbar-js-circle pr-2"></div>
                                      </div>
                                      <div>
                                        <p class="text-small mb-2">Belum Lunas</p>
                                        <h4 class="mb-0 fw-bold" id="textBelumLunas"><?= number_format(($total_utang > 0 ? ($utang_belum_lunas / $total_utang * 100) : 0), 2) ?>%</h4>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-sm-6">
                                    <div class="d-flex justify-content-between align-items-center">
                                      <div class="circle-progress-width">
                                        <div id="visitperday" class="progressbar-js-circle pr-2"></div>
                                      </div>
                                      <div>
                                        <p class="text-small mb-2">Sudah Lunas</p>
                                        <h4 class="mb-0 fw-bold" id="textSudahLunas"><?= number_format(($total_utang > 0 ? ($utang_lunas / $total_utang * 100) : 0), 2) ?>%</h4>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-8 d-flex flex-column">
                        <div class="row flex-grow">
                          <div class="col-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-start">
                                  <div>
                                    <h4 class="card-title card-title-dash">Utang dibayar</h4>
                                    <p class="card-subtitle card-subtitle-dash">Utang dibayar setiap bulannya</p>
                                  </div>
                                  <div>
                                    <div class="dropdown">
                                      <button class="btn btn-secondary dropdown-toggle toggle-dark btn-lg mb-0 me-0" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?= $tahun_aktif ?>
                                      </button>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                        <h6 class="dropdown-header">Tahun</h6>
                                        <div class="dropdown-divider"></div>
                                        <?php
                                        for ($tahun = 2020; $tahun <= date('Y'); $tahun++) {
                                            echo '<a class="dropdown-item" href="?tahun='.$tahun.'">'.$tahun.'</a>';
                                        }
                                        ?>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="d-sm-flex align-items-center mt-1 justify-content-between">
                                  <div class="d-sm-flex align-items-center mt-4">
                                    <h2 class="me-2 fw-bold">Rp <?= number_format(array_sum($bayarData), 0, ',', '.') ?></h2>
                                    <h4 class="me-2">Total Bayar</h4>
                                  </div>
                                  <div class="me-3">
                                    <div id="marketing-overview-legend"></div>
                                  </div>
                                </div>
                                <div class="chartjs-bar-wrapper mt-3">
                                  <canvas id="marketingOverview" height="150"></canvas>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4 d-flex flex-column">
                        <div class="row flex-grow">
                          <div class="col-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-lg-12">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                      <h4 class="card-title card-title-dash">Keseluruhan</h4>
                                    </div>
                                    <canvas class="my-auto" id="doughnutChart" height="200"></canvas>
                                    <div id="doughnut-chart-legend" class="mt-5 text-center"></div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <?php include 'partials/footer.php'; ?>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- Toast Container -->
<div id="toastContainer" class="position-fixed bottom-0 end-0 p-3 d-flex flex-column-reverse gap-2" style="z-index: 1055;">
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    <?php if (!empty($_SESSION['toasts'])): ?>
      const toastData = <?= json_encode($_SESSION['toasts']) ?>;
      const container = document.getElementById('toastContainer');

      toastData.forEach(t => {
        const wrapper = document.createElement('div');
        wrapper.className = `toast text-white ${t.warna} border-0`; // warna dari PHP (misal 'bg-warning')
        wrapper.setAttribute('role', 'alert');
        wrapper.setAttribute('aria-live', 'assertive');
        wrapper.setAttribute('aria-atomic', 'true');

        wrapper.innerHTML = `
          <div class="toast-header">
            <i class="mdi mdi-bell-ring me-2"></i>
            <strong class="me-auto">Data</strong>
            <small>Baru saja</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
          <div class="toast-body">
            ${t.pesan}
          </div>
        `;

        container.appendChild(wrapper);
        new bootstrap.Toast(wrapper).show();
      });

      <?php unset($_SESSION['toasts']); ?>
    <?php endif; ?>
  });
</script>

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

