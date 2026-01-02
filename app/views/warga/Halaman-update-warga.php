<?php
session_start();
require_once __DIR__ . '/../../config/koneksi.php';

if (
  !isset($_SESSION['role']) ||
  !in_array($_SESSION['role'], ['rt1', 'rt2', 'rt3', 'rw']) ||
  !isset($_SESSION['nik_sekretaris'])
) {
  header("Location: ../auth/halaman-login.php");
  exit;
}

$nik_sekretaris = $_SESSION['nik_sekretaris'];
$role = $_SESSION['role'];

$sekre = mysqli_query($conn, "
          SELECT * FROM sekretaris_rt_rw 
          WHERE nik_sekretaris = '$nik_sekretaris'
          ");

$datas = mysqli_fetch_assoc($sekre);


$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM warga WHERE id='$id'");
$data = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Data Warga</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=search" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <link rel="stylesheet" href="../../../public/css/halaman-update-warga.css">
  <link rel="icon" href="../../../public/Image/logo.png">
</head>

<body>

  <!-- Tombol buka/tutup sidebar -->
  <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
  <!-- SIDEBAR -->
  <aside id="sidebar">
    <div>
      <div class="logo">
        <div class="logo-circle"></div>
      </div>

      <ul>
        <li onclick="document.location='../warga/halaman-data-warga.php'"><img src="../../../public/Image/logo-datawarga.png" alt="">
          <p>Data Warga</p>
        </li>
        <li onclick="document.location='../keluarga/data-keluarga.php'"><img src="../../../public/Image/logo-keluarga.png" alt="">
          <p>Data Keluarga</p>
        </li>
        <li onclick="document.location='../surat_pengantar/halaman-persetujuan.php'"><img src="../../../public/Image/logo-persetujuan.png" alt="">
          <p>Persetujuan</p>
        </li>
        <li onclick="document.location='../akun/halaman-akun-warga.php'"><img src="../../../public/Image/logo-akunwarga.png" alt="">
          <p>Akun Warga</p>
        </li>
        <li onclick="document.location='../surat_pengantar/halaman-riwayat-sekretaris.php'"><img src="../../../public/Image/logo-riwayat.png" alt="">
          <p>Riwayat</p>
        </li>
        <li onclick="document.location='../warga/rekapitulasi.php'"><img src="../../../public/Image/logo-rekapitulasi.png" alt="">
          <p>Rekapitulasi</p>
        </li>
        <?php if ($_SESSION['role'] === 'rw') { ?>
          <li onclick="document.location='../akun/halaman-akun-sekretaris.php'"><img src="../../../public/Image/logo-akunwarga.png" alt="">
            <p>Akun Sekretaris</p>
          </li>
        <?php } ?>
      </ul>
    </div>


    <div class="footer">
      <h3>SIWa 4.0</h3>
      <p>© 2025 All Rights Reserved</p>
    </div>
  </aside>

  <!-- ISI HALAMAN -->
  <div class="container">
    <main id="main">
      <header>
        <div class="header-left">
          <img src="../../../public/Image/logo.png" alt="Logo" width="40">
          <div class="text-head">
            <h1 class="judul">Perumahan Legenda</h1>
            <p class="subjudul">[<?= $datas['username'] ?>]</p>
          </div>
        </div>
        <div class="profile-container">
          <div class="profile-logo" onclick="toggleProfile()"></div>
          <div class="profile-popup" id="profilePopup">
            <div class="profile-header">
              <div class="photo"></div>
              <div class="info">
                <strong><?= $datas['username'] ?></strong>
                <small>NIK: <?= $datas['nik_sekretaris'] ?></small>
              </div>
            </div>
            <div class="profile-body">
              <p>Nama: <?= $datas['nama_sekretaris'] ?></p>
              <p>NIK: <?= $datas['nik_sekretaris'] ?></p>
              <p>No KK: <?= $datas['kk_sekretaris'] ?></p>
              <p>Alamat: <?= $datas['alamat_sekretaris'] ?></p>
              <p>No telp: <?= $datas['no_telp'] ?></p>
              <p>No RT: <?= $datas['no_rt'] ?></p>
              <p>No RW: <?= $datas['no_rw'] ?></p>
              <button class="btn" onclick="document.location='../../controllers/login/logout.php'">
                <span class="material-symbols-outlined">Logout</span>
                Logout
              </button>
            </div>
          </div>
        </div>
      </header>



      <h2>Perbarui Data Warga</h2>
      <div class="container1">
        <form class="formTambah" action="../../controllers/warga/edit_data_warga.php" method="POST">

          <input type="hidden" name="id" value="<?= $data['id'] ?>">

          <div class="form-row">
            <div class="form-group">
              <p><strong>1. Nama</strong></p>
              <input type="text" placeholder="Masukkan nama" class="font_input" name="nama" value="<?= $data['nama'] ?>" required>
            </div>
            <div class="form-group">
              <p><strong>2. NIK</strong></p>
              <input type="number" placeholder="Masukkan No NIK" class="font_input" name="NIK" value="<?= $data['nik'] ?>" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <p><strong>3. No. KK:</strong></p>
              <input type="number" placeholder="Masukkan No KK" class="font_input" name="KK" value="<?= $data['NO_KK'] ?>" required>
            </div>
            <div class="form-group">
              <p><strong>4. Tempat Lahir:</strong></p>
              <input type="text" placeholder="Masukkan Tempat Lahir" class="font_input" name="tempat" value="<?= $data['tempat_lahir'] ?>" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <p><strong>5. Tanggal Lahir:</strong></p>
              <input type="date" class="font_input" name="tanggal" id="tanggal_lahir" value="<?= $data['tanggal_lahir'] ?>" required>
            </div>
            <div class="form-group">
              <p><strong>6. Alamat:</strong></p>
              <input type="text" placeholder="Masukkan Alamat" class="font_input" name="alamat" value="<?= $data['alamat'] ?>" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <p><strong>7. Agama:</strong></p>
              <select class="font_input" name="agama" required>
                <option>- Pilih -</option>
                <option value="Islam" <?= $data['agama'] == 'Islam' ? 'selected' : '' ?>>Islam</option>
                <option value="Kristen" <?= $data['agama'] == 'Kristen' ? 'selected' : '' ?>>Kristen</option>
                <option value="Katolik" <?= $data['agama'] == 'Katolik' ? 'selected' : '' ?>>Katolik</option>
                <option value="Hindu" <?= $data['agama'] == 'Hindu' ? 'selected' : '' ?>>Hindu</option>
                <option value="Buddha" <?= $data['agama'] == 'Buddha' ? 'selected' : '' ?>>Buddha</option>
                <option value="Konghucu" <?= $data['agama'] == 'Konghucu' ? 'selected' : '' ?>>Konghucu</option>
              </select>
            </div>
            <div class="form-group">
              <p><strong>8. No. RT:</strong></p>
              <select class="font_input" name="rt" required>
                <option>-- Pilih --</option>
                <?php if ($role == 'rt1') : ?>
                  <option value="01" <?= $data['no_rt'] == '01' ? 'selected' : '' ?>>RT 01</option>
                <?php elseif ($role == 'rt2') : ?>
                  <option value="02" <?= $data['no_rt'] == '02' ? 'selected' : '' ?>>RT 02</option>
                <?php elseif ($role == 'rt3') : ?>
                  <option value="03" <?= $data['no_rt'] == '03' ? 'selected' : '' ?>>RT 03</option>
                <?php else : ?>
                  <option value="01" <?= $data['no_rt'] == '01' ? 'selected' : '' ?>>RT 01</option>
                  <option value="02" <?= $data['no_rt'] == '02' ? 'selected' : '' ?>>RT 02</option>
                  <option value="03" <?= $data['no_rt'] == '03' ? 'selected' : '' ?>>RT 03</option>
                <?php endif; ?>
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <p><strong>9. No. RW:</strong></p>
              <select class="font_input" name="rw" required>
                <option>- Pilih -</option>
                <option value="01" <?= $data['no_rw'] == '01' ? 'selected' : '' ?>>RW 01</option>
              </select>
            </div>
            <div class="form-group">
              <p><strong>10. Umur:</strong></p>
              <input type="text" placeholder="Masukkan Umur" class="font_input" name="umur" id="umur" value="<?= $data['umur'] ?>" required readonly>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <p><strong>11. Gender:</strong></p>
              <select class="font_input" name="gender" required>
                <option value="Laki-Laki" <?= $data['jenis_kelamin'] == 'Laki-Laki' ? 'selected' : '' ?>>Laki-Laki</option>
                <option value="Perempuan" <?= $data['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
              </select>
            </div>
            <div class="form-group">
              <p><strong>12. No. Telepon:</strong></p>
              <input type="text" placeholder="Masukkan Nomor Telepon" class="font_input" name="telepon" value="<?= $data['no_telp'] ?>" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <p><strong>13. Status Kepemilikan:</strong></p>
              <select class="font_input" name="status_kepemilikan" required>
                <option>- Pilih -</option>
                <option value="Warga Mengontrak" <?= $data['status_kepemilikan'] == 'Warga Mengontrak' ? 'selected' : '' ?>>Warga Mengontrak</option>
                <option value="Warga Permanen" <?= $data['status_kepemilikan'] == 'Warga Permanen' ? 'selected' : '' ?>>Warga Permanen</option>
              </select>
            </div>
            <div class="form-group">
              <p><strong>14. Kepemilikan:</strong></p>
              <input type="text" placeholder="Masukkan Nama Kepemilikan Rumah" class="font_input" name="kepemilikan" value="<?= $data['kepemilikan'] ?>" required>
            </div>
          </div>

          <div class="submit">
            <button type="button" value="Cancel" class="button1" onclick="window.location.href='halaman-data-warga.php'">Cancel</button>
            <button type="submit" value="Submit" class="button2">Submit</button>
          </div>
        </form>
      </div>
</body>
<script src="../../../public/js/halaman-update-warga.js"></script>
<script>
  document.getElementById('tanggal_lahir').addEventListener('change', function() {
    const tgl = new Date(this.value);
    const today = new Date();

    let umur = today.getFullYear() - tgl.getFullYear();
    const month = today.getMonth() - tgl.getMonth();

    if (month < 0 || (month === 0 && today.getDate() < tgl.getDate())) {
      umur--;
    }

    document.getElementById('umur').value = umur;
  });
</script>

</html>