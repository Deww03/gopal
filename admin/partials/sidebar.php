    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="dashboard.php">
              <i class="mdi mdi-home menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item nav-category">Hutang</li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="menu-icon mdi mdi-book-open-page-variant"></i>
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
              <i class="menu-icon mdi mdi-human-greeting"></i>
              <span class="menu-title">Pengguna</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a class="nav-link" href="pelanggan.php">Pelanggan</a></li>
                <li class="nav-item"><a class="nav-link" href="profil_admin.php">Admin</a></li>
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