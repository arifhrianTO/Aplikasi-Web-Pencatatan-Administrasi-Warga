<?php
require_once __DIR__ . '/../../config/koneksi.php';

if (!isset($_GET['nik'])) {
    echo "<script>alert('NIK tidak ditemukan'); history.back();</script>";
    exit;
}

$nik = $_GET['nik'];

$query = "DELETE FROM akun_warga WHERE nik='$nik'";
$delete = mysqli_query($conn, $query);

if ($delete) {
    echo "<script>
            alert('Akun berhasil dihapus!');
            window.location='../../views/akun/halaman-akun-warga.php';
          </script>";
} else {
    echo "<script>
            alert('Gagal menghapus akun!');
            history.back();
          </script>";
}
?>
