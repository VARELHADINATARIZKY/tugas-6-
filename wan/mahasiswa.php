<?php
session_start();
include 'auth/cek_admin.php';  // khusus admin

$title = "Data Mahasiswa";
include 'templates/header.php';
?>

<h1>Data Mahasiswa</h1>
<!-- Tabel atau form CRUD mahasiswa -->

<?php include 'templates/footer.php'; ?>
