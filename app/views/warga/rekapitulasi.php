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

$sekre = mysqli_query($conn, "
          SELECT * FROM sekretaris_rt_rw 
          WHERE nik_sekretaris = '$nik_sekretaris'
          ");

$data = mysqli_fetch_assoc($sekre);

$rt_filter = ""; // Default tidak filter (khusus RW)

if ($data['role'] == "rt1") {
  $rt_filter = "01";
} elseif ($data['role'] == "rt2") {
  $rt_filter = "02";
} elseif ($data['role'] == "rt3") {
  $rt_filter = "03";
}

$query = "SELECT * FROM warga WHERE 1=1";

// Jika sekretaris RT
if ($rt_filter !== "") {
  $query .= " AND no_rt = '$rt_filter'";
}

$query .= " ORDER BY id ASC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rekapitulasi Data Warga</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=search" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <link rel="stylesheet" href="../../../public/css/halaman-rekapitulasi-data-warga.css">
  <link rel="icon" href="../../../public/Image/logo.png">
</head>

<body>

  <button class="toggle-btn" onclick="toggleSidebar()">☰</button>

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
      <div class="title-search">
        <h2>Rekapitulasi Data Warga</h2>


      </div>

      <div class="border-select">
        <div class="semuaumur">

          <select name="semuaumur" id="semuaumur" class="dropdown">
            <option value="Semua Umur">Semua Umur</option>
            <option value="0-5">0-5</option>
            <option value="6-12">6-12</option>
            <option value="13-17">13-17</option>
            <option value="18-25">18-25</option>
            <option value="26-45">26-45</option>
            <option value="45-65">45-65</option>
            <option value=">65">>65</option>
          </select>

          <select name="gender" id="gender" class="dropdown">
            <option value="all">Semua Gender</option>
            <option value="Laki-Laki">Laki-Laki</option>
            <option value="Perempuan">Perempuan</option>
          </select>

          <?php if ($data['role'] == "rw") { ?>
            <select name="NoRT" id="NoRT" class="dropdown">
              <option value="all">Semua No RT</option>
              <option value="01">01</option>
              <option value="02">02</option>
              <option value="03">03</option>
            </select>
          <?php } else { ?>
            <!-- Jika RT: hidden dropdown -->
            <input type="hidden" id="NoRT" value="<?= $rt_filter ?>">
          <?php } ?>

          <select name="status" id="status" class="dropdown">
            <option value="all">Semua Status</option>
            <option value="Aktif">Aktif</option>
            <option value="Pindah">Pindah</option>
            <option value="Meninggal">Meninggal</option>
          </select>
        </div>
        <div class="tombol-cetak">
          <button class="button-cetak" id="btnCetakPDF" onclick="cetakPDF()">
            <img src="../../../public/Image/logo-cetak.png" class="logo-tombol">
            Cetak Data
          </button>
        </div>



      </div>
      <br>

      <div class="table-container">
        <div class="shadow-table">
          <table>
            <thead>
              <tr>
                <th>No</th>
                <th>NIK</th>
                <th>No KK</th>
                <th>Nama</th>
                <th>Gender</th>
                <th>Agama</th>
                <th>Umur</th>
                <th>Tempat Tanggal Lahir</th>
                <th>No Telepon</th>
                <th>No RT</th>
                <th>No RW</th>
                <th>Alamat</th>
                <th>Status</th>
              </tr>
            </thead>

            <tbody>
              <?php
              $no = 1;
              while ($row = mysqli_fetch_assoc($result)) {
              ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= $row['nik']; ?></td>
                  <td><?= $row['NO_KK']; ?></td>
                  <td><?= $row['nama']; ?></td>
                  <td><?= $row['jenis_kelamin']; ?></td>
                  <td><?= $row['agama']; ?></td>
                  <td><?= $row['umur']; ?></td>
                  <td><?= $row['tempat_lahir'] . ", " . date("d-m-Y", strtotime($row['tanggal_lahir'])); ?></td>
                  <td><?= $row['no_telp']; ?></td>
                  <td>RT <?= $row['no_rt']; ?></td>
                  <td>RW <?= $row['no_rw']; ?></td>
                  <td><?= $row['alamat']; ?></td>
                  <td><?= $row['status'] ?? ''; ?></td>
                </tr>
              <?php } ?>
            </tbody>

          </table>
        </div>
      </div>

    </main>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
<script src="../../../public/js/halaman-rekapitulasi-data-warga.js"></script>

</html>