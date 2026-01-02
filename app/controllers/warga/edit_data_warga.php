<?php
require_once __DIR__ . '/../../config/koneksi.php';

$id = $_POST['id'];
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
$status_kepemilikan = $_POST['status_kepemilikan'];
$kepemilikan = $_POST['kepemilikan'];

$cek = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM warga WHERE id='$id'"));

if (
  $cek['nama'] == $nama &&
  $cek['nik'] == $nik &&
  $cek['NO_KK'] == $KK &&
  $cek['tempat_lahir'] == $tempat &&
  $cek['tanggal_lahir'] == $tanggal &&
  $cek['alamat'] == $alamat &&
  $cek['agama'] == $agama &&
  $cek['no_rt'] == $rt &&
  $cek['no_rw'] == $rw &&
  $cek['umur'] == $umur &&
  $cek['jenis_kelamin'] == $gender &&
  $cek['no_telp'] == $telpon &&
  $cek['status_kepemilikan'] == $status_kepemilikan &&
  $cek['kepemilikan'] == $kepemilikan
) {
  echo "<script>
            alert('Data belum diubah!');
            window.location='../../views/warga/Halaman-update-warga.php?id=$id';
          </script>";
  exit;
}
$cekKK = mysqli_query($conn, "SELECT * FROM keluarga WHERE no_kk='$KK'");
if (mysqli_num_rows($cekKK) == 0) {
  echo "<script>
            alert('NO KK belum terdaftar!');
            window.location='../../views/warga/Halaman-update-warga.php?id=$id';
          </script>";
  exit;
}
if ($nik != $cek['nik']) {
  $cekNIK = mysqli_query($conn,"SELECT * FROM warga WHERE nik=$nik");
  if (mysqli_num_rows($cekNIK) > 0) {

  echo "<script> alert('NIK Sudah Terdaftar! ');
              window.location='../../views/warga/Halaman-update-warga.php?id=$id';
  </script>";
  exit;
}}

$query = "UPDATE warga SET
            nama='$nama',
            NIK='$nik',
            NO_KK='$KK',
            tempat_lahir='$tempat',
            tanggal_lahir='$tanggal',
            alamat='$alamat',
            agama='$agama',
            no_rt='$rt',
            no_rw='$rw',
            umur='$umur',
            jenis_kelamin='$gender',
            no_telp='$telpon',
            status_kepemilikan='$status_kepemilikan',
            kepemilikan='$kepemilikan'
          WHERE id='$id'";

$update = mysqli_query($conn, $query);

if ($update) {

  mysqli_query($conn, "
        UPDATE keluarga 
        SET alamat_domisil='$alamat'
        WHERE no_kk='$KK'
    ");

  echo "<script>
            alert('Data berhasil diperbarui!');
            window.location='../../views/warga/halaman-data-warga.php';
          </script>";
} else {
  echo "<script>
            alert('GAGAL memperbarui data!');
            window.location='edit_data_warga.php?id=$id';
          </script>";
}
