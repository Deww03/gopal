<?php
session_start();
unset($_SESSION['notifikasi']); // hapus semua notifikasi

echo json_encode(['success' => true]);
?>