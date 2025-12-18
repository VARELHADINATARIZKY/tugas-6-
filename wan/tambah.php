<?php
include "auth/cek_login.php";
include "auth/cek_admin.php";
include "koneksi.php";


// error_reporting(E_ALL);
// ini_set('display_errors', 1);

if (isset($_POST['simpan'])) {
    $nim    = trim($_POST['nim']);
    $nama   = trim($_POST['nama']);
    $prodi  = trim($_POST['prodi']);
    $alamat = trim($_POST['alamat']);

    $gambar = "";
    if (!empty($_FILES['gambar']['name']) && is_uploaded_file($_FILES['gambar']['tmp_name'])) {
        $orig = basename($_FILES['gambar']['name']);
        $safe = preg_replace('/[^A-Za-z0-9._-]/', '_', $orig);
        $nama_file = time() . "_" . $safe;
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], __DIR__ . "/img/" . $nama_file)) {
            $gambar = "img/" . $nama_file;
        }
    }

    // Use prepared statement to insert
    $stmt = mysqli_prepare($koneksi, "INSERT INTO mahasiswa (nim,nama,prodi,alamat,gambar) VALUES (?,?,?,?,?)");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'sssss', $nim, $nama, $prodi, $alamat, $gambar);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location: index.php");
        exit;
    } else {
        $error = "Gagal menyimpan data.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tambah Mahasiswa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/sb-admin-2.min.css">
</head>
<body id="page-top" class="bg-gradient-light">

<div id="wrapper">
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Tambah Mahasiswa</h1>
                    <a href="index.php" class="btn btn-sm btn-secondary">Kembali</a>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Form Tambah Mahasiswa</h6>
                            </div>
                            <div class="card-body">
                                <?php if (!empty(
                                    isset($error) ? $error : null
                                )): ?>
                                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                                <?php endif; ?>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>NIM</label>
                                        <input type="text" name="nim" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" name="nama" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Prodi</label>
                                        <select name="prodi" class="form-control" required>
                                            <option value="">Pilih Prodi</option>
                                            <option value="TI">Teknik Informatika</option>
                                            <option value="SI">Sistem Informasi</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <input type="text" name="alamat" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Gambar</label>
                                        <input type="file" name="gambar" class="form-control-file">
                                    </div>
                                    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>

</body>
</html>
