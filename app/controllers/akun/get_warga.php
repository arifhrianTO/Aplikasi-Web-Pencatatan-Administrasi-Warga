<?php
require_once __DIR__ . '/../../config/koneksi.php';

if (isset($_GET['nik'])) {
    $nik = $_GET['nik'];

    $q = mysqli_query($conn, "SELECT * FROM warga WHERE nik = '$nik'");
    $data = mysqli_fetch_assoc($q);

    echo json_encode($data);
}
?>
