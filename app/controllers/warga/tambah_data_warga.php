<?php
session_start();
require_once __DIR__ . '/../../config/koneksi.php';

$no_kk = $_POST['KK'];
$id_sekretaris = $_SESSION['id_sekretaris'];

$cek = mysqli_query($conn, "SELECT * FROM keluarga WHERE no_kk='$no_kk'");

$nik    = $_POST['NIK'];
$nama   = $_POST['nama'];
$KK     = $_POST['KK'];
$tempat = $_POST['tempat'];
$tanggal = $_POST['tanggal'];
$alamat   = $_POST['alamat'];
$agama    = $_POST['agama'];
$rt  = $_POST['rt'];
$rw = $_POST['rw'];
$umur   = $_POST['umur'];
$gender    = $_POST['gender'];
$telpon  = $_POST['telepon'];
$status = "Aktif";
$status_kepemilikan = $_POST['status_kepemilikan'];
$kepemilikan = $_POST['kepemilikan'];
$hubungan= "Kepala Keluarga";

$cek_nik= mysqli_query($conn, "SELECT * FROM warga where nik='$nik'");
if (mysqli_num_rows($cek_nik)>0){
echo "<script>
            alert('Nik Sudah terdaftar!');
            window.location='../../views/warga/Halaman-tambah-warga.php';
          </script>";
}

if (mysqli_num_rows($cek) == 0) {
  mysqli_query($conn, "
        INSERT INTO keluarga (no_kk, kepala_keluarga, alamat_domisil)
        VALUES ('$no_kk', '$nama', '$alamat')
    ");
}

$query = "INSERT INTO warga (nik, nama, umur, no_telp, no_rt, no_rw, alamat, agama, tempat_lahir, tanggal_lahir, jenis_kelamin, NO_KK, status, status_kepemilikan, kepemilikan,hubungan, id_sekretaris)
VALUES ('$nik' , '$nama', '$umur', '$telpon', '$rt', '$rw', '$alamat', '$agama', '$tempat', '$tanggal', '$gender' , '$KK','$status', '$status_kepemilikan', '$kepemilikan','$hubungan', '$id_sekretaris')
";
$insert = mysqli_query($conn, $query);

if ($insert) {
  echo "<script>
            alert('Data berhasil disimpan!');
            window.location='../../views/warga/halaman-data-warga.php';
          </script>";
} else {
  echo "<script>
            alert('Gagal menyimpan data!');
            window.location='../../views/warga/Halaman-tambah-warga.php';
          </script>";
}
