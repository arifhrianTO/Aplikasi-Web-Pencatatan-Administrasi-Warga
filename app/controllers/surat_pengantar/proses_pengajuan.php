<?php
require_once __DIR__ . '/../../config/koneksi.php';

session_start();

$nik = $_SESSION['nik'];
$tujuan = $_POST['tujuan'];
$tanggal = $_POST['tanggal'];
$status = "Diajukan";

/* KTP */
$ktp_name = $_FILES['ktp']['name'];
$ktp_size = $_FILES['ktp']['size'];
$ktp_tmp  = $_FILES['ktp']['tmp_name'];
$ktp_ext  = strtolower(pathinfo($ktp_name, PATHINFO_EXTENSION));
$allowed_ktp = ['jpg', 'jpeg', 'png', 'pdf'];
$ktp_path = "../../../storage/fotocopy/KTP/" . $ktp_name;

/* KK */
$kk_name = $_FILES['kk']['name'];
$kk_size = $_FILES['kk']['size'];
$kk_tmp  = $_FILES['kk']['tmp_name'];
$kk_ext  = strtolower(pathinfo($kk_name, PATHINFO_EXTENSION));
$allowed_kk = ['jpg', 'jpeg', 'png', 'pdf'];
$kk_path  = "../../../storage/fotocopy/KK/" . $kk_name;

$status = "Diajukan";

/* VALIDASI */
if (in_array($ktp_ext, $allowed_ktp) && $ktp_size <= 2000000) {
    if (in_array($kk_ext, $allowed_kk) && $kk_size <= 2000000) {

        move_uploaded_file($ktp_tmp, $ktp_path);
        move_uploaded_file($kk_tmp, $kk_path);

        // contoh insert ke database
        $query = mysqli_query($conn, "
             INSERT INTO surat_pengantar (nik, tujuan_pengajuan, tanggal_pengajuan, fc_ktp, fc_kk, status_pengajuan)
        VALUES ('$nik', '$tujuan', '$tanggal', '$ktp_path', '$kk_path', '$status')
        ");

        if ($query) {
            echo "
            <script>
                alert('Pengajuan Berkas Berhasil');
                window.location='../../views/surat_pengantar/halaman-pengajuan.php';
            </script>";
        } else {
            echo "
            <script>
                alert('Gagal megajukan berkas!');
                window.location='../../views/surat_pengantar/halaman-pengajuan.php';
             </script>";
        }
    } else {
        echo "<script>alert('File KK tidak valid atau terlalu besar');window.history.back();</script>";
    }
} else {
    echo "<script>alert('File KTP tidak valid atau terlalu besar');window.history.back();</script>";
}
