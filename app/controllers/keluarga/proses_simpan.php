<?php
require_once __DIR__ . '/../../config/koneksi.php';

$no_kk = $_POST['no_kk'];

$pendidikan = $_POST['pendidikan'];
$pekerjaan = $_POST['pekerjaan'];
$status = $_POST['status'];
$hubungan = $_POST['hubungan'];
$kewarganegaraan = $_POST['kewarganegaraan'];
$paspor = $_POST['paspor'];
$kitas = $_POST['kitas'];
$ayah = $_POST['ayah'];
$ibu = $_POST['ibu'];

$queryWarga = mysqli_query($conn, "SELECT nik FROM warga WHERE NO_KK='$no_kk'");

$i = 0;

while ($row = mysqli_fetch_assoc($queryWarga)) {

    $nik = $row['nik'];

    mysqli_query($conn, "
        UPDATE warga SET
            pendidikan = '".$pendidikan[$i]."',
            pekerjaan = '".$pekerjaan[$i]."',
            kawin = '".$status[$i]."',
            hubungan = '".$hubungan[$i]."',
            kewarganegaraan = '".$kewarganegaraan[$i]."',
            no_paspor = '".$paspor[$i]."',
            KITAS = '".$kitas[$i]."',
            ayah = '".$ayah[$i]."',
            ibu = '".$ibu[$i]."'
        WHERE nik='$nik'
    ");

    $i++;
}



$resultKK = mysqli_query($conn, "
    SELECT nama 
    FROM warga 
    WHERE NO_KK='$no_kk' AND hubungan='Kepala Keluarga'
    LIMIT 1
");

if (mysqli_num_rows($resultKK) > 0) {

    $dataKK = mysqli_fetch_assoc($resultKK);
    $namaKK = $dataKK['nama'];

    mysqli_query($conn, "
        UPDATE keluarga 
        SET kepala_keluarga = '$namaKK'
        WHERE no_kk = '$no_kk'
    ");
}

header("Location: ../../views/keluarga/data-keluarga.php");
exit();
?>
