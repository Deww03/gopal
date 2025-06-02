<?php
// menghubungkan dengan koneksi
include 'koneksi/koneksi.php';

// menangkap data yang dikirim dari form
$nama_admin = mysqli_real_escape_string($koneksi, $_POST['nama_admin']);
$password_admin = mysqli_real_escape_string($koneksi, md5($_POST['password_admin']));

$login = mysqli_query($koneksi, "SELECT * FROM admin WHERE nama_admin='$nama_admin' AND password_admin='$password_admin'");
$cek = mysqli_num_rows($login);

if ($cek > 0) {
	session_start();
	$data = mysqli_fetch_assoc($login);
	$_SESSION['id_admin'] = $data['id_admin'];
	$_SESSION['nama_admin'] = $data['nama_admin'];
	$_SESSION['password_admin'] = $data['password_admin'];
	$_SESSION['no_hp_admin'] = $data['no_hp_admin'];
	$_SESSION['jenis_kelamin'] = $data['jenis_kelamin'];
	$_SESSION['foto_admin'] = $data['foto_admin'];
	$_SESSION['status'] = "login";
	$_SESSION['login_success'] = true;
	$_SESSION['notifikasi'][] = [
        'pesan' => 'Login berhasil. Selamat datang, ' . $_SESSION['nama_admin'] . '!',
        'waktu' => date('H:i'),
        'warna' => 'success'
    ];

	// Cek utang yang akan jatuh tempo 3 hari ke depan
	$hari_ini = date('Y-m-d');
	$tiga_hari_ke_depan = date('Y-m-d', strtotime('+3 days'));

	// Query dengan JOIN ke tabel pelanggan
	$query_utang = mysqli_query($koneksi, "
		SELECT utang.*, pelanggan.nama_pelanggan 
		FROM utang 
		JOIN pelanggan ON utang.id_pelanggan = pelanggan.id_pelanggan
		WHERE utang.jatuh_tempo BETWEEN '$hari_ini' AND '$tiga_hari_ke_depan' 
		AND utang.status = 'belum_lunas'
		AND utang.id_admin = " . $_SESSION['id_admin']);

	$jumlah_utang_jatuh_tempo = 0;

	while ($utang = mysqli_fetch_assoc($query_utang)) {
		$jumlah_utang_jatuh_tempo++;
		$tanggal_jatuh_tempo = date('d M Y', strtotime($utang['jatuh_tempo']));
		$_SESSION['notifikasi'][] = [
			'pesan' => "Utang atas nama " . $utang['nama_pelanggan'] . " akan jatuh tempo pada $tanggal_jatuh_tempo!",
			'waktu' => date('H:i'),
			'warna' => 'warning'
		];
	}

	$_SESSION['toasts'][] = [
	'pesan' => 'Login berhasil. Selamat datang, ' . $_SESSION['nama_admin'] . '!',
	'warna' => 'bg-inverse-success'
	];

	if ($jumlah_utang_jatuh_tempo > 0) {
		$_SESSION['toasts'][] = [
			'pesan' => "Ada $jumlah_utang_jatuh_tempo utang yang jatuh tempo dalam 3 hari!",
			'warna' => 'bg-inverse-warning'
		];
	}

	// Cek utang yang sudah lewat jatuh tempo tetapi belum lunas
	$query_utang_terlambat = mysqli_query($koneksi, "
	SELECT utang.*, pelanggan.nama_pelanggan 
	FROM utang 
	JOIN pelanggan ON utang.id_pelanggan = pelanggan.id_pelanggan
	WHERE utang.jatuh_tempo < '$hari_ini'
	AND utang.status = 'belum_lunas'
	AND utang.id_admin = " . $_SESSION['id_admin']);

	$jumlah_utang_terlambat = 0;

	while ($utang_terlambat = mysqli_fetch_assoc($query_utang_terlambat)) {
	$jumlah_utang_terlambat++;
	$tanggal_jatuh_tempo = date('d M Y', strtotime($utang_terlambat['jatuh_tempo']));
	$_SESSION['notifikasi'][] = [
		'pesan' => "Utang atas nama " . $utang_terlambat['nama_pelanggan'] . " sudah jatuh tempo sejak $tanggal_jatuh_tempo dan belum dilunasi!",
		'waktu' => date('H:i'),
		'warna' => 'danger'
	];
	}

	if ($jumlah_utang_terlambat > 0) {
	$_SESSION['toasts'][] = [
		'pesan' => "Ada $jumlah_utang_terlambat utang yang sudah lewat jatuh temponya dan belum lunas!",
		'warna' => 'bg-inverse-danger'
	];
	}

	header("location:admin/dashboard.php");
} else {
	header("location:index.php?alert=gagal");
}