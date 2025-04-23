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
            <h1 class="welcome-text">Hallo, <span class="text-black fw-bold"><?php echo $_SESSION['nama_admin']; ?></span></h1>
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
            <a class="nav-link count-indicator" id="countDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="icon-bell"></i>
              <span class="count"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list pb-0" aria-labelledby="countDropdown">
            <a class="dropdown-item py-3">
                <p class="mb-0 font-weight-medium float-left">Notifikasi</p>
              </a>
              <ul class="dropdown-menu-list mb-0 px-2 py-2" id="notifDropdown" style="list-style: none;">
                <?php if (!empty($_SESSION['notifikasi'])): ?>
                  <?php foreach (array_reverse($_SESSION['notifikasi']) as $n): ?>
                    <li class="py-2 border-bottom">
                      <div class="d-flex justify-content-between align-items-center text-nowrap">
                        <span class="text-<?= str_replace('inverse-', '', $n['warna']) ?>">
                          <?= $n['pesan'] ?>
                        </span>
                        <small class="text-muted ms-2"><?= $n['waktu'] ?></small>
                      </div>
                    </li>
                  <?php endforeach; ?>
                <?php else: ?>
                  <li class="py-2 text-muted text-center">Belum ada notifikasi</li>
                <?php endif; ?>
              </ul>
              <div class="dropdown-item text-center">
                <?php if (!empty($_SESSION['notifikasi'])): ?>
                  <button class="btn btn-inverse-danger" style="width: 150px;" onclick="hapusSemuaNotifikasi()">
                    Hapus Semua
                  </button>
                <?php endif; ?>
              </div>
            </div>
          </li>
          <script>
            function hapusSemuaNotifikasi() {
              fetch('hapus_notifikasi.php', {
                method: 'POST'
              })
              .then(response => response.json())
              .then(data => {
                if (data.success) {
                  // Kosongkan isi notifikasi di HTML
                  document.getElementById('notifDropdown').innerHTML = '<li class="py-2 text-muted text-center">Belum ada notifikasi</li>';
                }
              });
            }
            </script>
          <li class="nav-item dropdown d-none d-lg-block user-dropdown">
            <a class="nav-link" id="UserDropdown" href="../#" data-bs-toggle="dropdown" aria-expanded="false">
              <?php
                $id_admin = $_SESSION['id_admin'];
                $foto_admin = $_SESSION['foto_admin'];
                $foto = mysqli_query($koneksi, "SELECT * FROM admin WHERE id_admin='$id_admin'");
                $foto = mysqli_fetch_assoc($foto);
              ?>
              <?php
              if ($foto_admin == "") {
              ?>
              <img class="img-xs rounded-circle" src="../images/faces/face6.jpg" alt="Profile image">
              <?php } else { ?>
              <img class="img-xs rounded-circle" src="../images/faces/<?php echo $foto_admin; ?>" alt="Profile image" >
              <?php } ?>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
              <div class="dropdown-header text-center">
                <?php
                if ($foto_admin == "") {
                ?>
                <img class="img-xs rounded-circle" src="../images/faces/face6.jpg" alt="Profile image">
                <?php } else { ?>
                <img class="img-xs rounded-circle" src="../images/faces/<?php echo $foto_admin; ?>" alt="Profile image" >
                <?php } ?>
                <p class="mb-1 mt-3 font-weight-semibold"><?php echo $_SESSION['nama_admin']; ?></p>
                <p class="fw-light text-muted mb-0">Admin</p>
              </div>
              <a class="dropdown-item" href="profil_admin.php"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i>Profil Saya</a>
              <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutModal"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Keluar</a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>

    <!-- logout modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="logoutModalLabel">Keluar</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Apakah Anda yakin ingin keluar?</p>
          </div>
          <div class="modal-footer">
            <a href="../logout_admin.php" class="btn btn-inverse-danger">Keluar</a>
            <button type="button" class="btn btn-inverse-info" data-bs-dismiss="modal">Batal</button>
          </div>
        </div>
      </div>
    </div>