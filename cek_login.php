<?php
session_start();

if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: ../index.php");
    exit();
}

$showToast = false;
if (isset($_SESSION['login_success'])) {
  $showToast = true;
  unset($_SESSION['login_success']); // Hanya sekali tampil
}
?>
