<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../../libraries/phpqrcode/phpqrcode.php';

$id_surat = $_GET['id_surat'];

$query = mysqli_query($conn, "
    SELECT 
        w.*, 
        s.tujuan_pengajuan,
        r.tanggal_setuju,
        r.tanggal_selesai
    FROM surat_pengantar s
    JOIN warga w 
        ON s.nik = w.nik
    JOIN riwayat_administrasi r 
        ON r.id_surat = s.id_surat
    WHERE s.id_surat = '$id_surat'
");

$data = mysqli_fetch_assoc($query);


$q_rt = mysqli_query($conn, "
    SELECT nama_sekretaris
    FROM sekretaris_rt_rw
    WHERE role LIKE 'rt%'
      AND no_rt = '{$data['no_rt']}'
      AND no_rw = '{$data['no_rw']}'
    LIMIT 1
");

$rt = mysqli_fetch_assoc($q_rt);
$nama_rt = $rt['nama_sekretaris'] ?? '-';


$q_rw = mysqli_query($conn, "
    SELECT nama_sekretaris
    FROM sekretaris_rt_rw
    WHERE role = 'rw'
      AND no_rw = '{$data['no_rw']}'
    LIMIT 1
");

$rw = mysqli_fetch_assoc($q_rw);
$nama_rw = $rw['nama_sekretaris'] ?? '-';


$bulan = date('m');
$tahun = date('Y');

$nomor_surat = sprintf(
    "%03d/SP-%s-%s/%s/%s",
    $id_surat,
    $data['no_rt'],
    $data['no_rw'],
    $bulan,
    $tahun
);


$isi_qr_rt = "SURAT PENGANTAR RT/RW\n"
    . "No Surat            : $nomor_surat\n"
    . "Nama                : {$data['nama']}\n"
    . "RT                  : {$data['no_rt']}\n"
    . "RW                  : {$data['no_rw']}\n"
    . "Disetujui Oleh      : {$nama_rt}\n"
    . "Tanggal Disetujui   : {$data['tanggal_setuju']}";

$isi_qr_rw = "SURAT PENGANTAR RT/RW\n"
    . "No Surat             : $nomor_surat\n"
    . "Nama                 : {$data['nama']}\n"
    . "RW                   : {$data['no_rw']}\n"
    . "Disetujui Olek       : {$nama_rw}\n"
    . "Tanggal Disetujui    : {$data['tanggal_selesai']}";


$folder_rt = __DIR__ . "/../../../storage/qr/rt";
$folder_rw = __DIR__ . "/../../../storage/qr/rw";

if (!file_exists($folder_rt)) mkdir($folder_rt, 0777, true);
if (!file_exists($folder_rw)) mkdir($folder_rw, 0777, true);

$path_qr_rt = "$folder_rt/qr_rt_$id_surat.png";
$path_qr_rw = "$folder_rw/qr_rw_$id_surat.png";

QRcode::png($isi_qr_rt, $path_qr_rt, QR_ECLEVEL_H, 5);
QRcode::png($isi_qr_rw, $path_qr_rw, QR_ECLEVEL_H, 5);

ob_start();
include "surat_pengantar.php";
$html = ob_get_clean();

$mpdf = new \Mpdf\Mpdf([
    'tempDir' => __DIR__ . '/../../../storage/temp'
]);

$mpdf->WriteHTML($html);
$mpdf->Output("surat_pengantar_$id_surat.pdf", "I");