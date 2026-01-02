<?php
session_start();
require_once __DIR__ . '/../../config/koneksi.php';

if (
  !isset($_SESSION['role']) ||
  !in_array($_SESSION['role'], ['rt1','rt2','rt3','rw']) ||
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

// FILTER DATA BERDASARKAN ROLE
$where = "";

if ($data['role'] == 'rt1') {
  $where = "WHERE w.no_rt = '01'";
} elseif ($data['role'] == 'rt2') {
  $where = "WHERE w.no_rt = '02'";
} elseif ($data['role'] == 'rt3') {
  $where = "WHERE w.no_rt = '03'";
} else {
  // RW bisa akses semuanya
  $where = "";
}

$result = mysqli_query($conn, "
    SELECT a.*, w.no_rt 
    FROM akun_warga a
    JOIN warga w ON a.nik = w.nik
    $where
");

?>
<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Akun Warga</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=search" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <link rel="stylesheet" href="../../../public/css/halaman-akun-warga.css">
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
        <h2>Data Akun Warga</h2>
        <button class="button-tambah" id="openPopup">
          <img src="../../../public/Image/logo-tambah.png" alt=""> Tambah Akun
        </button>
      </div>

      <!-- contoh tabel -->
<div class="table-container">
  <div class="shadow-table">
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>NIK</th>
        <th>Username</th>
        <th>Password</th>
        <th colspan="2">Aksi</th>
      </tr>
    </thead>

    <tbody>
      <?php
      $no = 1;
      while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= $row['nik'] ?></td>
          <td><?= $row['username'] ?></td>
          <td><?= $row['password'] ?></td>
          <td>
            <div class="button-update" onclick="openUpdate(this)">
              <span class="material-symbols-outlined">docs</span> Update
            </div>
          </td>
          <td>
            <div class="button-delete" onclick="openDelete('<?= $row['nik'] ?>')">
              <span class="material-symbols-outlined">delete</span> Delete
            </div>
          </td>
        </tr>
      <?php } ?>
    </tbody>

  </table>
  </div>
</div>




    </main>
  </div>


  <!--Tambah-->
  <div class="overlay" id="popupOverlay">
    <div class="popup">
      <div class="close-btn" id="closePopup">&times;</div>
      <h1>Tambah Akun Warga</h1>

      <form id="formTambah" action="../../controllers/akun/tambah-akun-warga.php" method="POST">
        <div class="form-column">
          <label for="nik">NIK</label>
          <input type="number" id="nik" name="nik" placeholder="Masukkan NIK" required>

          <label for="username">Username</label>
          <input type="text" id="username" name="username" placeholder="Masukkan Username" required>
        </div>

        <div class="form-column">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Masukkan Password" required>

          <label for="ulang">Ulangi Password</label>
          <input type="password" id="ulang" name="confirm_password" placeholder="Ulangi Password" required>
        </div>

        <div class="btn-container">
          <button type="submit">Buat Akun</button>
        </div>
      </form>
    </div>
  </div>

  <!--update-->
  <div class="overlay" id="updatePopup">
    <div class="popup-update">
      <div class="close-btn" onclick="closeUpdate()">&times;</div>
      <h1>Update Akun Warga</h1>
      <form id="formUpdate" action="../../controllers/akun/update-akun-warga.php" method="POST">
        <input type="hidden" name="id_akun" id="idAkunUpdate">
        <input type="hidden" id="nikUpdate" name="nik">
        <label>Username</label>
        <input type="text" id="usernameUpdate" name="username">
        <label>Password</label>
        <input type="text" id="passwordUpdate" name="password" placeholder="Masukkan password baru (optional)">
        <label>Konfirmasi Password:</label>
        <input type="password" name="confirm" placeholder="Ulangi password">
        <div class="btn-wrappper">
          <button type="submit">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>

  <!-- POPUP KONFIRMASI HAPUS -->
  <div class="overlay" id="deleteOverlay">
    <div class="dialog-box">
      <div class="close-btn" onclick="closeDelete()">&times;</div>
      <h2>Hapus Akun Warga</h2>
      <p>Apakah Anda yakin ingin menghapus akun ini? Akun akan dihapus secara permanen.</p>

      <input type="hidden" id="deleteNIK">

      <div class="dialog-footer">
        <div class="confirmation">
          <input type="radio" name="confirmDelete" id="confirmDelete">
          <label for="confirmDelete">Saya yakin</label>
        </div>

        <button class="delete-button" id="confirmDeleteBtn">
          Hapus
        </button>
      </div>
    </div>
  </div>

  <script src="../../../public/js/halaman-akun-warga.js"></script>

</body>

</html>