<?php
require_once __DIR__ . '/../../config/koneksi.php';

$id = $_POST['id_sekretaris'];
$nik = $_POST['nik'];
$username = $_POST['username'];
$password = $_POST['password'];
$confirm = $_POST['confirm'];
$role = $_POST['role'];

// CEK DUPLIKAT USERNAME (kecuali user ini sendiri)
$cek = mysqli_query($conn, "
    SELECT * FROM sekretaris_rt_rw 
    WHERE username = '$username' 
    AND id_sekretaris != '$id'
");

if (mysqli_num_rows($cek) > 0) {
    echo "<script>alert('Username sudah digunakan oleh akun lain!'); history.back();</script>";
    exit;
}

// VALIDASI PASSWORD
if (!empty($password)) {

    if ($password !== $confirm) {
        echo "<script>alert('Konfirmasi password tidak cocok!'); history.back();</script>";
        exit;
    }

    // UPDATE DENGAN PASSWORD
    $query = "
        UPDATE sekretaris_rt_rw SET
            username = '$username',
            password = '$password',
            role = '$role'
        WHERE id_sekretaris = '$id'
    ";
} else {

    // UPDATE TANPA PASSWORD
    $query = "
        UPDATE sekretaris_rt_rw SET
            username = '$username',
            role = '$role'
        WHERE id_sekretaris = '$id'
    ";
}

// EKSEKUSI QUERY
if (mysqli_query($conn, $query)) {
    echo "<script>alert('Akun berhasil diperbarui!'); window.location='../../views/akun/halaman-akun-sekretaris.php';</script>";
} else {
    echo "<script>alert('Gagal update!'); history.back();</script>";
}
?>