<?php
require_once __DIR__ . '/../../config/koneksi.php';

if(isset($_POST['nik']) && isset($_POST['alasan'])){
    $nik = mysqli_real_escape_string($conn, $_POST['nik']);
    $alasan = mysqli_real_escape_string($conn, $_POST['alasan']);

    // Hapus data utama
    $hapus = mysqli_query($conn, " UPDATE warga set status='$alasan' WHERE nik='$nik'");

    if(!$hapus){
        echo "<script>alert('Gagal menghapus data!'); window.location.href='../../views/warga/halaman-data-warga.php';</script>";
        exit;
    }
    echo "<script>
            alert('Data berhasil dihapus. Alasan: $alasan');
            window.location.href='../../views/warga/halaman-data-warga.php';
          </script>";

} else {
    echo "<script>
            alert('Data tidak lengkap!');
            window.location.href='../../views/warga/halaman-data-warga.php';
          </script>";
}
?>
