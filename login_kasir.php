<?php
// menghubungkan dengan koneksi
include 'koneksi/koneksi.php';

// menangkap data yang dikirim dari form
$nama_kasir = mysqli_real_escape_string($koneksi, $_POST['nama_kasir']);
$password_kasir = mysqli_real_escape_string($koneksi, md5($_POST['password_kasir']));

$login = mysqli_query($koneksi, "SELECT * FROM kasir WHERE nama_kasir='$nama_kasir' AND password_kasir='$password_kasir'");
$cek = mysqli_num_rows($login);

if ($cek > 0) {
	session_start();
	$data = mysqli_fetch_assoc($login);
	$_SESSION['id_kasir'] = $data['id_kasir'];
	$_SESSION['nama_kasir'] = $data['nama_kasir'];
	$_SESSION['password_kasir'] = $data['password_kasir'];
	$_SESSION['no_hp_kasir'] = $data['no_hp_kasir'];
	$_SESSION['jenis_kelamin'] = $data['jenis_kelamin'];
	$_SESSION['foto_kasir'] = $data['foto_kasir'];
	$_SESSION['status'] = "login";
	$_SESSION['login_success'] = true;
	$_SESSION['notifikasi'][] = [
        'pesan' => 'Login berhasil. Selamat datang, ' . $_SESSION['nama_kasir'] . '!',
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
		AND utang.id_kasir = " . $_SESSION['id_kasir']);

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
	'pesan' => 'Login berhasil. Selamat datang, ' . $_SESSION['nama_kasir'] . '!',
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
	AND utang.id_kasir = " . $_SESSION['id_kasir']);

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

	header("location:kasir/dashboard.php");
} else {
	header("location:index.php?alert=gagal");
}