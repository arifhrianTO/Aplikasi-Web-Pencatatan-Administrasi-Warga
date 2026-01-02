<?php
session_start();
require_once __DIR__ . '/../../config/koneksi.php';

if (!isset($_SESSION['nik'])) {
  header("Location: ../auth/halaman-login.php");
  exit;
}

$nik = $_SESSION['nik'];

$warga = mysqli_query($conn, "
    SELECT w.*, a.* 
    FROM warga w 
    LEFT JOIN akun_warga a ON w.nik = a.nik
    WHERE w.nik = '$nik'
");

$data = mysqli_fetch_assoc($warga);

$query = mysqli_query($conn, "
          SELECT s.*, sek.nama_sekretaris 
          FROM surat_pengantar s
          LEFT JOIN sekretaris_rt_rw sek ON s.id_sekretaris = sek.id_sekretaris
          WHERE s.nik = '$nik'")
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Riwayat Administrasi</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
  <link rel="stylesheet" href="../../../public/css/halaman-riwayat-warga.css" />
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
        <li onclick="document.location='halaman-pengajuan.php'">
          <img src="../../../public/Image/Logo pengajuan.png" alt="" />
          <p>Pengajuan Dokumen</p>
        </li>
        <li onclick="document.location='halaman-riwayat-warga.php'">
          <img src="../../../public/Image/logo-riwayat.png" alt="" />
          <p>Riwayat Dokumen</p>
        </li>
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
          <img src="../../../public/Image/logo.png" alt="Logo" width="40" />
          <div class="text-head">
            <h1 class="judul">Perumahan Legenda</h1>
            <p class="subjudul">warga [<?= $data['nama'] ?>]</p>
          </div>
        </div>
        <div class="profile-container">
          <div class="profile-logo" onclick="toggleProfile()"></div>
          <div class="profile-popup" id="profilePopup">
            <div class="profile-header">
              <div class="photo"></div>
              <div class="info">
                <strong><?= $data['username'] ?></strong>
                <small><?= $data['nik'] ?></small>
              </div>
            </div>
            <div class="profile-body">
              <p>Nama: <?= $data['nama'] ?></p>
              <p>NIK: <?= $data['nik'] ?></p>
              <p>No KK: <?= $data['NO_KK'] ?></p>
              <p>Alamat: <?= $data['alamat'] ?></p>
              <p>No telp: <?= $data['no_telp'] ?></p>
              <p>No RT: <?= $data['no_rt'] ?></p>
              <p>No RW: <?= $data['no_rw'] ?></p>
              <button class="btn" onclick="document.location='../../controllers/login/logout.php'">
                <span class="material-symbols-outlined">Logout</span>
                Logout
              </button>
            </div>
          </div>
        </div>
      </header>

      <div class="riwayatpengajuan">
        <h3>Riwayat Pengajuan Berkas</h3>
      </div>

      <div class="informasipengajuan">
        <img src="../../../public/Image/info.png">
        <h4>pengajuan surat pengantar RT apabila status nya di tolak
          maka ada prasyarat yang tidak terpenuhi atau tidak valid</h4>

      </div>


      <div class="table">
        <table id="dataWarga">
          <thead>
            <tr>
              <th>No</th>
              <th>Jenis Surat</th>
              <th>tujuan_pengajuan</th>
              <th>Tanggal Pengajuan</th>
              <th>Nama RT</th>
              <th>Aksi</th>
            </tr>
          </thead>

          <tbody>
            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($query)) {
            ?>
              <tr>
                <td><?= $no++ ?></td>
                <td>Surat Pengantar RT/RW</td>
                <td><?= $row['tujuan_pengajuan'] ?></td>
                <td><?= $row['tanggal_pengajuan'] ?></td>
                <td><?= $row['nama_sekretaris'] ?></td>
                <td><?= $row['status_pengajuan'] ?></td>
              </tr>
            <?php } ?>
      </div>



      </tbody>
      </table>
  </div>
  </main>

  <!-- 🔼 Akhir Dropdown -->
  </main>
  </div>


  <script src="../../../public/js/halaman-riwayat-warga.js"></script>
</body>

</html>