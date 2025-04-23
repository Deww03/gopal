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

	header("location:admin/dashboard.php");
} else {
	header("location:login.php?alert=gagal");
}