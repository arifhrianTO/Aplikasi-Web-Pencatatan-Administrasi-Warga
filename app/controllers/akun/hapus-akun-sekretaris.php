<?php
require_once __DIR__ . '/../../config/koneksi.php';

if (!isset($_GET['nik_sekretaris'])) {
    echo "<script>alert('NIK tidak ditemukan'); history.back();</script>";
    exit;
}

$nik = $_GET['nik_sekretaris'];

$query = "DELETE FROM sekretaris_rt_rw WHERE nik_sekretaris='$nik'";
$delete = mysqli_query($conn, $query);

if ($delete) {
    echo "<script>
            alert('Akun berhasil dihapus!');
            window.location='../../views/akun/halaman-akun-sekretaris.php';
          </script>";
} else {
    echo "<script>
            alert('Gagal menghapus akun!');
            history.back();
          </script>";
}
?>
