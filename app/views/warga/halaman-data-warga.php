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
$role           = $_SESSION['role'];

$sekre = mysqli_query($conn, "
          SELECT * FROM sekretaris_rt_rw 
          WHERE nik_sekretaris = '$nik_sekretaris'
          ");

$data = mysqli_fetch_assoc($sekre);

$keyword = "";

if (isset($_POST['keyword'])) {
  $keyword = $_POST['keyword'];

  $_SESSION['keyword'] = $keyword;
  header("Location: halaman-data-warga.php");
  exit;
}

if (isset($_SESSION['keyword'])) {
  $keyword = $_SESSION['keyword'];
  unset($_SESSION['keyword']);
}

$query = "SELECT * FROM warga WHERE status='Aktif'";

// Role-based access
if ($data['role'] == 'rt1') {
  $query .= " AND no_rt = '01'";
} elseif ($data['role'] == 'rt2') {
  $query .= " AND no_rt = '02'";
} elseif ($data['role'] == 'rt3') {
  $query .= " AND no_rt = '03'";
}

// Pencarian
if ($keyword != '') {
  $query .= " AND (
        nama LIKE '%$keyword%' OR
        nik = '$keyword' OR
        no_rt = '$keyword'
    )";
}

$query .= " ORDER BY id ASC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Data Warga Perumahan Legenda</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=search" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <link rel="stylesheet" href="../../../public/css/halaman-data-warga.css">
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

      <div class="title-search">
        <h2>Data Warga</h2>
        <form method="POST" action="">
          <div class="search">
            <span class="search-icon material-symbols-outlined">search</span>
            <input type="search" class="search-input" name="keyword" id="searchInput" placeholder="Cari Nama/NIK/RT/RW">
          </div>
        </form>
        <button class="button-tambah" onclick="document.location='Halaman-tambah-warga.php'">
          <img src="../../../public/Image/logo-tambah.png" class="logo-tombol">
          Tambah Data
        </button>
      </div>
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>NIK</th>
              <th>No. KK</th>
              <th>Nama</th>
              <th>Jenis Kelamin</th>
              <th>Agama</th>
              <th>Umur</th>
              <th style="width: 50px;">Tempat Tanggal Lahir</th>
              <th>No. Telepon</th>
              <th>No. RT</th>
              <th>No. RW</th>
              <th>Alamat</th>
              <th>Status Kepemilikan</th>
              <th>Kepemilikan</th>
              <th colspan="2">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nik'] ?></td>
                <td><?= $row['NO_KK'] ?></td>
                <td><?= $row['nama']  ?></td>
                <td><?= $row['jenis_kelamin'] ?></td>
                <td><?= $row['agama'] ?></td>
                <td><?= $row['umur'] ?></td>
                <td><?= $row['tempat_lahir'] . ", " . date("d-m-Y", strtotime($row['tanggal_lahir'])) ?></td>
                <td><?= $row['no_telp'] ?></td>
                <td><?= $row['no_rt'] ?></td>
                <td><?= $row['no_rw'] ?></td>
                <td><?= $row['alamat'] ?></td>
                <td><?= $row['status_kepemilikan'] ?></td>
                <td><?= $row['kepemilikan'] ?></td>
                <td>
                  <div class="button-update"
                    onclick="document.location.href='Halaman-update-warga.php?id=<?= $row['id'] ?>'">
                    <span class="material-symbols-outlined">docs</span> Update
                  </div>
                </td>


                <td>
                  <div onclick="openPopup('<?= $row['nik'] ?>')" class="button-delete"><span class="material-symbols-outlined">Delete</span> Delete</div>
                </td>
              </tr>
            <?php } ?>
      </div>
      </tbody>
      </table>
  </div>


  <!--pop up-->
  <div id="myModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>

      <h1>Apa alasan anda menghapus data ini?</h1>

      <select id="alasanSelect" class="input-alasan">
        <option value="">- PILIH -</option>
        <option value="Pindah">Pindah</option>
        <option value="Meninggal">Meninggal</option>
      </select>

      <div class="button-group">
        <form id="hapusForm" method="POST" action="../../controllers/warga/hapus_data_warga.php">
          <input type="hidden" name="nik" id="nikInput">
          <input type="hidden" name="alasan" id="alasanInput">

          <h1>Apakah anda yakin ingin menghapus data ini?</h1>
          <input type="submit" value="YA" id="ya" class="input1">
          <input type="reset" value="TIDAK" id="btnTidak" class="input2">
        </form>
      </div>
    </div>
  </div>
  </div>
  </main>


</body>

<script src="../../../public/js/halaman-data-warga.js"></script>

</html>