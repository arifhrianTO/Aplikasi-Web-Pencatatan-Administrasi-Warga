<?php
require_once __DIR__ . '/../../config/koneksi.php';

$no_kk = $_GET['no_kk'];

$queryKeluarga = mysqli_query(
  $conn,
  "SELECT * FROM keluarga WHERE no_kk='$no_kk'"
);
$dataKeluarga = mysqli_fetch_assoc($queryKeluarga);

$queryWarga = mysqli_query(
  $conn,
  "SELECT * FROM warga WHERE NO_KK='$no_kk'"
);
$telpon = mysqli_query($conn, "SELECT no_telp FROM warga WHERE NO_KK='$no_kk' and hubungan='kepala keluarga'");
$no_telp = mysqli_fetch_assoc($telpon);
?>
<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Data Keluarga</title>
  <link rel="icon" href="../../../public/Image/logo.png">
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../../public/css/halaman-kartu-keluarga.css">
</head>

<body>
  <div class="kk">
    <div class="kk-header">
      <img src="../../../public/Image/fotogaruda.png" alt="logo" class="logo-garuda">
      <div class="header-left">
        <div class="logo"></div>
        <div>
          <h1>KARTU KELUARGA</h1>
          <p>REPUBLIK INDONESIA</p>
          <p>Desa/Kelurahan: <b>Sungai langkai</b> — Kecamatan: Sagulung
        </div>
      </div>
      <div class="kk-no">
        Nomor KK:
        <b><?php echo $dataKeluarga['no_kk']; ?></b>
      </div>
    </div>

    <div class="info">
      <div class="col">
        <div class="label">Nama Kepala Keluarga</div>
        <div class="value"><?php echo $dataKeluarga['kepala_keluarga']; ?></div>
      </div>
      <div class="col">
        <div class="label">Alamat</div>
        <div class="value">
          <?php
          echo $dataKeluarga['alamat_domisil'];
          ?>
        </div>
      </div>
      <div class="col">
        <div class="label">Kode Pos / Provinsi</div>
        <div class="value">12345 / Kepulauan Riau</div>
      </div>
      <div class="col">
        <div class="label">Telepon</div>
        <div class="value"><?php echo $no_telp['no_telp'];  ?></php>
        </div>
      </div>
    </div>

    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th class="center" style="width:35px;">No</th>
            <th>Nama Lengkap</th>
            <th>NIK</th>
            <th>Jenis Kelamin</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Agama</th>
            <th>Pendidikan</th>
            <th>Jenis Pekerjaan</th>
            <th>Status Perkawinan</th>
            <th>Hubungan Dalam Keluarga</th>
            <th>Kewarganegaraan</th>
            <th>No. Paspor</th>
            <th>No. KITAS/KITAP</th>
            <th>Nama Ayah</th>
            <th>Nama Ibu</th>
          </tr>
        </thead>
        <tbody>
          <form action="../../controllers/keluarga/proses_simpan.php" method="POST">
            <input type="hidden" name="no_kk" value="<?= $no_kk ?>">
            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($queryWarga)) {
            ?>
              <tr>
                <td class="center"><?= $no++ ?></td>

                <td><?= $row['nama'] ?></td>

                <td><?= $row['nik'] ?></td>

                <td><?= $row['jenis_kelamin'] ?></td>

                <td><?= $row['tempat_lahir'] ?></td>

                <td><?= $row['tanggal_lahir'] ?></td>

                <td><?= $row['agama'] ?></td>

                <td>
                  <select name="pendidikan[]">
                    <option value="SD" <?= $row['pendidikan'] == 'SD' ? 'selected' : '' ?>>SD</option>
                    <option value="SMP" <?= $row['pendidikan'] == 'SMP' ? 'selected' : '' ?>>SMP</option>
                    <option value="SMA" <?= $row['pendidikan'] == 'SMA' ? 'selected' : '' ?>>SMA</option>
                    <option value="S1" <?= $row['pendidikan'] == 'S1' ? 'selected' : '' ?>>S1</option>
                    <option value="S2" <?= $row['pendidikan'] == 'S2' ? 'selected' : '' ?>>S2</option>
                    <option value="S3" <?= $row['pendidikan'] == 'S3' ? 'selected' : '' ?>>S3</option>
                  </select>
                </td>

                <td><input type="text" name="pekerjaan[]" value="<?= $row['pekerjaan'] ?>"></td>

                <td>
                  <select name="status[]">
                    <option value="Kawin" <?= $row['kawin'] == 'Kawin' ? 'selected' : '' ?>>Kawin</option>
                    <option value="Belum Kawin" <?= $row['kawin'] == 'Belum Kawin' ? 'selected' : '' ?>>Belum Kawin</option>
                  </select>
                </td>

                <td>
                  <select name="hubungan[]">
                    <option value="Kepala Keluarga" <?= $row['hubungan'] == 'Kepala Keluarga' ? 'selected' : '' ?>>Kepala Keluarga</option>
                    <option value="Istri" <?= $row['hubungan'] == 'Istri' ? 'selected' : '' ?>>Istri</option>
                    <option value="Anak" <?= $row['hubungan'] == 'Anak' ? 'selected' : '' ?>>Anak</option>
                  </select>
                </td>

                <td>
                  <select name="kewarganegaraan[]">
                    <option value="WNI" <?= $row['kewarganegaraan'] == 'WNI' ? 'selected' : '' ?>>WNI</option>
                    <option value="WNA" <?= $row['kewarganegaraan'] == 'WNA' ? 'selected' : '' ?>>WNA</option>
                  </select>
                </td>

                <td><input type="text" name="paspor[]" value="<?= $row['no_paspor'] ?>"></td>
                <td><input type="text" name="kitas[]" value="<?= $row['KITAS'] ?>"></td>
                <td><input type="text" name="ayah[]" value="<?= $row['ayah'] ?>"></td>
                <td><input type="text" name="ibu[]" value="<?= $row['ibu'] ?>"></td>

              </tr>
            <?php } ?>
        </tbody>

      </table>
    </div>

    <div class="footer">
      <div class="button-box">
        <button type="reset" class="btn-cancel" onclick="document.location.href='data-keluarga.php'">Cancel</button>
        <button type="submit" class="btn-submit" onclick="document.location.href='data-keluarga.php'">Submit</button>
      </div>
    </div>
    </form>
</body>

</html>