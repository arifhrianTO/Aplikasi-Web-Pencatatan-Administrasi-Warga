<?php
require_once __DIR__ . '/../../config/koneksi.php';

$id_surat = $_GET['id_surat'];

$query = mysqli_query($conn, "
   SELECT 
        w.*, 
        s.tujuan_pengajuan,
        s.id_surat,
        r.tanggal_selesai
    FROM surat_pengantar s
    JOIN warga w 
        ON s.nik = w.nik
    JOIN riwayat_administrasi r 
        ON r.id_surat = s.id_surat
    WHERE s.id_surat = '$id_surat'
");

$data = mysqli_fetch_assoc($query);

$id_surat = $data['id_surat'];
$no_rt = $data['no_rt'];
$no_rw = $data['no_rw'];

$bulan = date('m');
$tahun = date('Y');

$nomor_surat = sprintf("%03d/SP-%s-%s/%s/%s", $id_surat, $no_rt, $no_rw, $bulan, $tahun);

?>
<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12pt;
        }

        .header-table td {
            padding: 2px 0;
        }

        .title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 10px;
            text-decoration: underline;
        }

        .nomor {
            text-align: center;
            margin-bottom: 20px;
        }

        .data-table td {
            padding: 3px 0;
        }

        .ttd-table {
            width: 100%;
            margin-top: 40px;
            text-align: center;
        }
    </style>
</head>

<body>

    <!-- KOP SURAT -->
    <table style="width:100%; border-bottom:2px solid black; padding-bottom:10px; margin-bottom:10px;">
        <tr>
            <td style="width:100px; text-align:center;">
                <img src="../../../public/Image/logo perumahan PBL.png" width="90">
            </td>

            <td style="text-align:center;">
                <div style="font-size:14pt; font-weight:bold;">
                    KETUA RT. <?= $data['no_rt']; ?> / RW. <?= $data['no_rw']; ?>
                </div>

                <div style="font-size:12pt; font-weight:bold; margin-top:3px;">
                    KELURAHAN BALOI PERMAI - KECAMATAN BATAM KOTA
                </div>

                <div style="font-size:12pt; font-weight:bold; margin-top:3px;">
                    KOTA BATAM
                </div>

                <div style="font-size:11pt; margin-top:3px;">
                    PERUMAHAN GRAHA LEGENDA MALAKA BLOK F
                </div>

                <div style="font-size:10pt; margin-top:3px;">
                    KODE POS 29435
                </div>
            </td>
        </tr>
    </table>


    <div class="title">SURAT PENGANTAR RT/RW</div>

    <div class="nomor">No: <?= $nomor_surat ?></div>

    <p>
        Ketua Rukun Tetangga (RT) <?= $data['no_rt']; ?> Rukun Warga (RW) <?= $data['no_rw']; ?> perumahan
        Perumahan Graha Legenda Malaka Blok F dengan ini menerangkan bahwa :
    </p>

    <table class="data-table">
        <tr>
            <td width="180">Nama Lengkap</td>
            <td>: <?= $data['nama']; ?></td>
        </tr>
        <tr>
            <td width="180">Jenis Kelamin</td>
            <td>: <?= $data['jenis_kelamin']; ?></td>
        </tr>
        <tr>
            <td>Tempat & Tanggal Lahir</td>
            <td>: <?= $data['tempat_lahir']; ?>, <?= date('d-m-Y', strtotime($data['tanggal_lahir'])); ?></td>
        </tr>
        <tr>
            <td>Nama Ibu Kandung</td>
            <td>: <?= $data['ibu']; ?></td>
        </tr>
        <tr>
            <td>Nama Ayah Kandung</td>
            <td>: <?= $data['ayah']; ?></td>
        </tr>
        <tr>
            <td>Alamat Sekarang</td>
            <td>: <?= $data['alamat']; ?></td>
        </tr>
        <tr>
            <td>Kewarganegaraan</td>
            <td>: <?= $data['kewarganegaraan']; ?></td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>: <?= $data['agama']; ?></td>
        </tr>
        <tr>
            <td>Pendidikan Terahkir</td>
            <td>: <?= $data['pendidikan']; ?></td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>: <?= $data['pekerjaan']; ?></td>
        </tr>
        <tr>
            <td>Status Perkawinan</td>
            <td>: <?= $data['kawin']; ?></td>
        </tr>
        <tr>
            <td>No. KTP</td>
            <td>: <?= $data['nik']; ?></td>
        </tr>
        <tr>
            <td>No. Kartu Keluarga</td>
            <td>: <?= $data['NO_KK']; ?></td>
        </tr>
    </table>

    <p>
        Adalah benar Penduduk RT <?= $data['no_rt']; ?>/ RW <?= $data['no_rw'] ?> Perumahan Graha Legenda Malaka Blok F, Kelurahan Baloi Permai, Kecamatan Batam Kota, Kota Batam
    </p>

    <p>
        Surat Keterangan ini diberikan kepada yang bersangkutan untuk keperluan : <br>
        <?= $data['tujuan_pengajuan']; ?>
    </p>

    <table class="ttd-table">
        <tr>
            <td>Mengetahui</td>
            <td>Batam,
                <?php
                $tanggal = $data['tanggal_selesai'];

                $bulan = [
                    1 => 'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember'
                ];

                $time = strtotime($tanggal);
                echo date('d', $time) . ' ' .
                    $bulan[date('n', $time)] . ' ' .
                    date('Y', $time);
                ?>
            </td>
        </tr>
        <tr>
            <td><strong>Ketua RT <?= $data['no_rt']; ?></strong></td>
            <td><strong>Ketua RW <?= $data['no_rw']; ?></strong></td>
        </tr>
        <tr>
            <td style="height:110px; text-align:center;">
                <img src="../../../storage/qr/rt/qr_rt_<?= $id_surat ?>.png" width="90">
            </td>
            <td style="height:110px; text-align:center;">
                <img src="../../../storage/qr/rw/qr_rw_<?= $id_surat ?>.png" width="90">
            </td>
        </tr>

        <tr>
            <td style="text-align:center;">
                (<?= $nama_rt ?>)
            </td>
            <td style="text-align:center;">
                (<?= $nama_rw ?>)
            </td>
        </tr>
    </table>

</body>

</html>