<?php
// menghubungkan dengan koneksi
include 'koneksi/koneksi.php';

// menangkap data yang dikirim dari form
$nama_pemilik = mysqli_real_escape_string($koneksi, $_POST['nama_pemilik']);
$password_pemilik = mysqli_real_escape_string($koneksi, md5($_POST['password_pemilik']));

// cek ke database
$login = mysqli_query($koneksi, "SELECT * FROM pemilik WHERE nama_pemilik='$nama_pemilik' AND password_pemilik='$password_pemilik'");
$cek = mysqli_num_rows($login);

if ($cek > 0) {
	session_start();
	$data = mysqli_fetch_assoc($login);

	// set session
	$_SESSION['id_pemilik'] = $data['id_pemilik'];
	$_SESSION['nama_pemilik'] = $data['nama_pemilik'];
    $_SESSION['password_pemilik'] = $data['password_pemilik'];
    $_SESSION['no_hp_pemilik'] = $data['no_hp_pemilik'];
    $_SESSION['foto_pemilik'] = $data['foto_pemilik'];
	$_SESSION['status'] = "login";
	$_SESSION['login_success'] = true;
	$_SESSION['toasts'][] = [
		'pesan' => 'Login berhasil. Selamat datang, ' . $_SESSION['nama_pemilik'] . '!',
		'warna' => 'bg-inverse-success'
	];
	$_SESSION['notifikasi'][] = [
		'pesan' => 'Login berhasil. Selamat datang, ' . $_SESSION['nama_pemilik'] . '!',
		'waktu' => date('H:i'),
		'warna' => 'success'
	];

	header("location:pemilik/dashboard.php");
} else {
	header("location:index.php?alert=gagal");
}
?>
