<?php
require_once __DIR__ . '/../../config/koneksi.php';
session_start();

$username = $_POST["username"];
$password = $_POST["password"];

// 1. Cek akun warga
$sqlWarga = mysqli_query($conn, "
    SELECT * FROM akun_warga 
    WHERE username='$username' 
      AND password='$password'
");
$warga = mysqli_fetch_assoc($sqlWarga);

if ($warga) {
    if($warga['password']!==$password){
        $_SESSION['error'] = 'Password Salah !';
        header("Location: ../../views/auth/halaman-login.php");
    }
    $_SESSION['role']     = 'user';
    $_SESSION['username'] = $warga['username'];
    $_SESSION['nik']      = $warga['nik'];


    header("Location:../../views/surat_pengantar/halaman-pengajuan.php");
    exit;

}

$sqlSekre = mysqli_query($conn, "SELECT * FROM sekretaris_rt_rw
    WHERE username='$username'"); 


$sekre = mysqli_fetch_assoc($sqlSekre);

if ($sekre) {
    if ($sekre['password'] !== $password) {
        $_SESSION['error'] = "Password Salah !";
        header("Location: ../../views/auth/halaman-login.php");
        exit;
    }
    $_SESSION['role']            = $sekre['role'];
    $_SESSION['id_sekretaris']   = $sekre['id_sekretaris'];
    $_SESSION['nik_sekretaris']  = $sekre['nik_sekretaris'];
    $_SESSION['username']        = $sekre['username'];

    header("Location: ../../views/warga/halaman-data-warga.php");
    exit;
}



$_SESSION['error'] = "Username belum terdaftar !";
header(header: "Location:../../views/auth/halaman-login.php");
exit;
