<?php 
require_once __DIR__ . '/../../config/koneksi.php';

$id_akun = $_POST['id_akun'];
$nik = $_POST['nik'];
$username = $_POST['username'];
$password = $_POST['password'];
$confrim = $_POST['confirm'];

if(!empty($password)){
    if($password !=  $confrim){
         echo "<script>alert('Konfirmasi password tidak cocok!'); history.back();</script>";
        exit;
    }

    $query = "UPDATE akun_warga SET
              nik ='$nik',
              username = '$username',
              password = '$password'
              WHERE nik = '$nik'";
} else{
    $query = "UPDATE akun_warga SET 
              nik = '$nik',
              username = '$username'
              WHERE nik = '$nik'";
}

if(mysqli_query($conn, $query)){
     echo "<script>alert('Data akun berhasil diupdate!'); window.location='../../views/akun/halaman-akun-warga.php';</script>";
} else {
    echo "<script>alert('Gagal update akun!'); history.back();</script>";
}
?>