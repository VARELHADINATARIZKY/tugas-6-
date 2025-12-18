<?php
include "auth/cek_login.php";
include "koneksi.php";

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="" crossorigin="anonymous">
        <link rel="stylesheet" href="css/sb-admin-2.min.css">
</head>
<body>
<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">SIKA</div>
        </a>

        <hr class="sidebar-divider my-0">

        <li class="nav-item active">
            <a class="nav-link" href="index.php">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">Data</div>

        <li class="nav-item">
            <a class="nav-link" href="tambah.php">
                <i class="fas fa-fw fa-user-plus"></i>
                <span>Tambah Mahasiswa</span></a>
        </li>

        <hr class="sidebar-divider d-none d-md-block">

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="auth/logout.php">
                            <i class="fas fa-sign-out-alt fa-lg mr-2"></i>
                            <strong>Logout</strong>
                        </a>
                    </li>
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                <?php
                                if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                                    echo 'Welcome Admin, ' . htmlspecialchars($_SESSION['username']);
                                } else {
                                    echo 'Welcome Mahasiswa, ' . htmlspecialchars($_SESSION['username']);
                                }
                                ?>
                            </span>
                            <?php
                            // Try to find a profile image for the logged in user in img/ directory
                            $profileImg = 'img/undraw_profile.svg';
                            if (!empty($_SESSION['username'])) {
                                $u = preg_replace('/[^A-Za-z0-9._-]/', '_', strtolower($_SESSION['username']));
                                $exts = ['png','jpg','jpeg','gif','svg','webp'];
                                foreach ($exts as $e) {
                                    $p = __DIR__ . '/img/' . $u . '.' . $e;
                                    if (file_exists($p)) {
                                        $profileImg = 'img/' . $u . '.' . $e;
                                        break;
                                    }
                                }
                                if ($profileImg === 'img/undraw_profile.svg') {
                                    // try prefix matches like username_123.jpg
                                    $matches = glob(__DIR__ . '/img/' . $u . '_*.*');
                                    if (!empty($matches)) {
                                        $profileImg = 'img/' . basename($matches[0]);
                                    }
                                }
                            }
                            ?>
                            <img class="img-profile rounded-circle" src="<?php echo htmlspecialchars($profileImg); ?>">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <div class="dropdown-header d-flex align-items-center">
                                <div class="dropdown-user-img mr-3">
                                    <img class="img-profile rounded-circle" src="<?php echo htmlspecialchars($profileImg); ?>" style="width:48px;height:48px;object-fit:cover;">
                                </div>
                                <div>
                                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                        <div class="small text-gray-700 font-weight-bold">W</div>
                                    <?php else: ?>
                                        <div class="small text-gray-700 font-weight-bold">Welcome Mahasiswa</div>
                                    <?php endif; ?>
                                    <div class="small text-muted"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Data Mahasiswa</h1>
                    <?php if ($_SESSION['role'] == 'admin') { ?>
                        <a href="tambah.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data</a>
                    <?php } ?>
                </div>

                <!-- Centered welcome message per role -->
                <div class="row mb-3">
                    <div class="col">
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <h2 class="text-center text-primary display-4 mb-0">Welcome Admin</h2>
                        <?php else: ?>
                            <h2 class="text-center text-primary display-4 mb-0">Welcome Mahasiswa</h2>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Search above full-width Table -->
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Daftar Mahasiswa</h6>
                                <form class="form-inline" method="get" action="index.php">
                                    <div class="input-group">
                                        <input type="search" name="q" class="form-control" placeholder="Cari NIM, Nama, Prodi, Alamat..." value="<?php echo htmlspecialchars(isset($_GET['q'])? $_GET['q'] : ''); ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i> Cari</button>
                                            <a href="index.php" class="btn btn-light">Reset</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>NIM</th>
                                                <th>Nama</th>
                                                <th>Prodi</th>
                                                <th>Alamat</th>
                                                <th>Gambar</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        // Search handling: if q present, use prepared statement with LIKE
                                        $q = isset($_GET['q']) ? trim($_GET['q']) : '';
                                        if ($q !== '') {
                                            $like = "%" . $q . "%";
                                            $stmt = mysqli_prepare($koneksi, "SELECT * FROM mahasiswa WHERE nim LIKE ? OR nama LIKE ? OR prodi LIKE ? OR alamat LIKE ? ORDER BY nama ASC");
                                            if ($stmt) {
                                                mysqli_stmt_bind_param($stmt, 'ssss', $like, $like, $like, $like);
                                                mysqli_stmt_execute($stmt);
                                                $data = mysqli_stmt_get_result($stmt);
                                            } else {
                                                $data = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE nama LIKE '" . mysqli_real_escape_string($koneksi, $like) . "' ORDER BY nama ASC");
                                            }
                                        } else {
                                            $data = mysqli_query($koneksi, "SELECT * FROM mahasiswa ORDER BY nama ASC");
                                        }
                                        while ($d = mysqli_fetch_assoc($data)) {
                                        ?>
                                            <tr>
                                                <td><?= htmlspecialchars($d['nim']); ?></td>
                                                <td><?= htmlspecialchars($d['nama']); ?></td>
                                                <td><?= htmlspecialchars($d['prodi']); ?></td>
                                                <td><?= htmlspecialchars($d['alamat']); ?></td>
                                                <td>
                                                    <?php if ($d['gambar'] != "") { ?>
                                                        <img src="<?= htmlspecialchars($d['gambar']); ?>" width="80">
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if ($_SESSION['role'] == 'admin') { ?>
                                                        <a href="edit.php?nim=<?= urlencode($d['nim']); ?>" class="btn btn-sm btn-warning">Edit</a>
                                                        <a href="hapus.php?nim=<?= urlencode($d['nim']); ?>" onclick="return confirm('Hapus data?')" class="btn btn-sm btn-danger">Hapus</a>
                                                    <?php } else { ?>
                                                        -
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>© SIka - <?php echo date('Y'); ?></span>
                </div>
            </div>
        </footer>
