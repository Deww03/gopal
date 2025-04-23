<?php
session_start();
// Hapus semua session
session_unset();
// Hapus session id
session_destroy();
// Redirect ke halaman login
header("Location: index.php");
exit();
?>