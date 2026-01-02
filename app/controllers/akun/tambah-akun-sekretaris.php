<?php
session_start();
require_once __DIR__ . '/../../config/koneksi.php';

$nik       = $_POST['nik'];
$nama      = $_POST['nama'];
$telepon   = $_POST['telp'];
$kk        = $_POST['kk'];
$alamat    = $_POST['alamat'];
$rt        = $_POST['no_rt'];
$rw        = $_POST['no_rw'];
$username  = $_POST['username'];
$password  = $_POST['password'];
$confirm   = $_POST['confirm_password'];
$role      = $_POST['role'];
$roleSekre = $_SESSION['role']; // role sekretaris login

if (preg_match('/\s/', $username)) {
    echo "<script>
            alert('Username tidak boleh mengandung spasi!');
            history.back();
         </script>";
    exit();
}

if (preg_match('/\s/', $password)) {
    echo "<script>
            alert('Password tidak boleh mengandung spasi!');
            history.back();
         </script>";
    exit();
}

if (!preg_match('/^[a-z0-9._]+$/', $username)) {
    echo "<script>
            alert('Username hanya boleh huruf kecil, angka, titik, dan underscore!');
            history.back();
         </script>";
    exit();
}

// 1. Validasi Password
if ($password !== $confirm) {
    echo "<script>alert('Password tidak sama!'); history.back();</script>";
    exit;
}
// 2. Menambah data akun sekretaris
$query = "
    INSERT INTO sekretaris_rt_rw (nama_sekretaris, nik_sekretaris, kk_sekretaris, alamat_sekretaris, no_telp, no_rt, no_rw, username, password, role) 
    VALUES ('$nama', '$nik', '$kk', '$alamat', '$telepon', '$rt', '$rw', '$username', '$password', '$role')
";

if (mysqli_query($conn, $query)) {
    echo "<script>alert('Akun berhasil ditambahkan!'); window.location='../../views/akun/halaman-akun-sekretaris.php';</script>";
} else {
    echo "<script>alert('Gagal menambahkan akun'); history.back();</script>";
}
