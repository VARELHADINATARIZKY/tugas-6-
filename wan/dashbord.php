<?php
session_start();
include 'auth/cek_login.php';  // pastikan hanya user login yang bisa akses

$title = "Dashboard";
include 'templates/header.php';
?>

<h1 class="h3 mb-4 text-gray-800">Selamat datang, <?php echo $_SESSION['username']; ?>!</h1>
<p>Ini halaman dashboard.</p>

<?php include 'templates/footer.php'; ?>
