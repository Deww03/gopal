    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="dashboard.php">
              <i class="mdi mdi-home menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item nav-category">Transaksi</li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="menu-icon mdi mdi-book-open-page-variant"></i>
              <span class="menu-title">Data Utang</span>
              <i class="menu-arrow"></i> 
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="semua_utang.php">Semua Utang</a></li>
                <li class="nav-item"> <a class="nav-link" href="sudah_lunas.php">Sudah Lunas</a></li>
                <li class="nav-item"> <a class="nav-link" href="belum_lunas.php">Belum Lunas</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="bayar.php">
              <i class="menu-icon mdi mdi-cash-multiple"></i>
              <span class="menu-title">Pembayaran</span>
            </a>
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
            <a class="nav-link" href="laporan_utang.php">
              <i class="menu-icon mdi mdi-file-document"></i>
              <span class="menu-title">Laporan Utang</span>
            </a>
          </li>
        </ul>
      </nav>