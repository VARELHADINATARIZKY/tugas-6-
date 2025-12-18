<?php
include "auth/cek_login.php";
include "auth/cek_admin.php";
include "koneksi.php";


if (!isset($_GET['nim'])) {
    die("NIM tidak ditemukan");
}

$nim = $_GET['nim'];
$data = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE nim='$nim'");
$d = mysqli_fetch_assoc($data);

if (!$d) {
    die("Data tidak ditemukan");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Mahasiswa</title>
</head>
<body>

<h2>Edit Mahasiswa</h2>

<form method="post" enctype="multipart/form-data">

NIM:<br>
<input type="text" name="nim" value="<?= $d['nim']; ?>" readonly><br><br>

Nama:<br>
<input type="text" name="nama" value="<?= $d['nama']; ?>" required><br><br>

Prodi:<br>
<select name="prodi" required>
    <option value="">Pilih Prodi</option>
    <option value="Teknik Informatika" <?= ($d['prodi']=="Teknik Informatika") ? "selected" : ""; ?>>
        Teknik Informatika
    </option>
    <option value="Sistem Informasi" <?= ($d['prodi']=="Sistem Informasi") ? "selected" : ""; ?>>
        Sistem Informasi
    </option>
</select><br><br>

Alamat:<br>
<textarea name="alamat" required><?= $d['alamat']; ?></textarea><br><br>

Gambar Baru:<br>
<input type="file" name="gambar"><br><br>

<button type="submit" name="update">Update</button>
<a href="index.php">Kembali</a>

</form>

</body>
</html>

<?php
if (isset($_POST['update'])) {
    $nama   = $_POST['nama'];
    $prodi  = $_POST['prodi'];
    $alamat = $_POST['alamat'];

    if (!empty($_FILES['gambar']['name'])) {
        $namaFile = time() . "_" . $_FILES['gambar']['name'];
        $tmp      = $_FILES['gambar']['tmp_name'];
        $path     = "img/" . $namaFile;

        move_uploaded_file($tmp, $path);

        mysqli_query($koneksi, "
            UPDATE mahasiswa SET
            nama='$nama',
            prodi='$prodi',
            alamat='$alamat',
            gambar='$path'
            WHERE nim='$nim'
        ");
    } else {
        mysqli_query($koneksi, "
            UPDATE mahasiswa SET
            nama='$nama',
            prodi='$prodi',
            alamat='$alamat'
            WHERE nim='$nim'
        ");
    }

    header("Location: index.php");
    exit;
}
?>
