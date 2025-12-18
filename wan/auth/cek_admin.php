<?php
if ($_SESSION['role'] != 'admin') {
    die("Akses ditolak. Hanya admin.");
}
