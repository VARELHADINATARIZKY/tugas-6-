<?php
include "auth/cek_login.php";
include "auth/cek_admin.php";
include "koneksi.php";


if ($_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

if (!isset($_GET['nim'])) {
    header("Location: index.php");
    exit;
}

$nim = $_GET['nim'];

mysqli_query($koneksi, "DELETE FROM mahasiswa WHERE nim='$nim'");

header("Location: index.php");
exit;
?>
