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

  $data = mysqli_fetch_assoc($sekre);

  $filter = "";
  if ($role !== "rw") {
    $rtNumber = str_replace("rt", "0", $role);
    $filter = "WHERE w.no_rt = '$rtNumber'";
  }

  $query = mysqli_query($conn, "
      SELECT r.*, s.tanggal_pengajuan, w.no_rt
      FROM riwayat_administrasi r
      JOIN surat_pengantar s ON s.id_surat = r.id_surat
      JOIN warga w ON w.nik = s.nik
      $filter
  ");
  ?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Adminitrasi</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=search" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../../../public/css/halaman-riwayat-sekre.css">
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
              <p class="subjudul">[<?= $data['username'] ?>]</p>
            </div>
          </div>
          <div class="profile-container">
            <div class="profile-logo" onclick="toggleProfile()"></div>
            <div class="profile-popup" id="profilePopup">
              <div class="profile-header">
                <div class="photo"></div>
                <div class="info">
                  <strong><?= $data['username'] ?></strong>
                  <small>NIK: <?= $data['nik_sekretaris'] ?></small>
                </div>
              </div>
              <div class="profile-body">
                <p>Nama: <?= $data['nama_sekretaris'] ?></p>
                <p>NIK: <?= $data['nik_sekretaris'] ?></p>
                <p>No KK: <?= $data['kk_sekretaris'] ?></p>
                <p>Alamat: <?= $data['alamat_sekretaris'] ?></p>
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
          <h2>Riwayat Pengajuan Berkas</h2>
        </div>




        <div class="table-container">
          <table id="dataWarga">
            <thead>
              <tr class="header-yellow">
                <th colspan="5">SURAT PENGANTAR RT/RW</th>
              </tr>
              <tr class="header-blue">
                <th>Nama</th>
                <th>Tanggal Pengajuan</th>
                <th>Tanggal Disetujui</th>
                <th>Tanggal Ditolak</th>
                <th>Tanggal Selesai</th>
              </tr>
            </thead>

            <tbody>
              <?php while ($row = mysqli_fetch_assoc($query)) { ?>
                <tr>
                  <td><?= $row['nama_pengaju'] ?></td>
                  <td><?= $row['tanggal_pengajuan'] ?></td>
                  <td><?= $row['tanggal_setuju'] ?></td>
                  <td><?= $row['tanggal_tolak'] ?></td>
                  <td><?= $row['tanggal_selesai'] ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>

      </main>
  </body>


  <script src="../../../public/js/halaman-riwayat-sekre.js"></script>

  </html>