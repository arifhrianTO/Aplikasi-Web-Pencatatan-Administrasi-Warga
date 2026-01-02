<?php
session_start();
require_once __DIR__ . '/../../config/koneksi.php';

if (
  !isset($_SESSION['role']) ||
  !in_array($_SESSION['role'], ['rw']) ||
  !isset($_SESSION['nik_sekretaris'])
) {
  header("Location: ../halaman_login/halaman-login.php");
  exit;
}

$nik_sekretaris = $_SESSION['nik_sekretaris'];

$sekre = mysqli_query($conn, "
          SELECT * FROM sekretaris_rt_rw 
          WHERE nik_sekretaris = '$nik_sekretaris'
          ");

$data = mysqli_fetch_assoc($sekre);

// FILTER DATA BERDASARKAN ROLE

$result = mysqli_query($conn, "
    SELECT * FROM sekretaris_rt_rw 
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
  <link rel="stylesheet" href="../../../public/css/halaman-akun-sekretaris.css">
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
        <h2>Data Akun Sekretaris</h2>
        <button class="button-tambah" id="openPopup">
          <img src="../../../public/Image/logo-tambah.png" alt=""> Tambah Akun
        </button>
      </div>

      <!-- contoh tabel -->
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>NIK Sekretaris</th>
              <th>KK Sekretaris</th>
              <th>Nama Sekretaris</th>
              <th>Alamat</th>
              <th>Nomor Telepon</th>
              <th>No RT</th>
              <th>No RW</th>
              <th>Role</th>
              <th colspan="2">Aksi</th>
            </tr>
          </thead>
          <?php
          $no = 1;
          while ($row = mysqli_fetch_assoc($result)) { ?>
            <tbody>
              <tr data-id="<?= $row['id_sekretaris'] ?>">
                <td><?= $no++ ?></td>
                <td><?= $row['nik_sekretaris'] ?></td>
                <td><?= $row['kk_sekretaris'] ?></td>
                <td><?= $row['nama_sekretaris'] ?></td>
                <td><?= $row['alamat_sekretaris'] ?></td>
                <td><?= $row['no_telp'] ?></td>
                <td><?= $row['no_rt'] ?></td>
                <td><?= $row['no_rw'] ?></td> 
                <td><?= $row['role'] ?></td>

                <td>
                  <div class="valdiasi"></div>
                  <div class="button-update" onclick="openUpdate(this)"><span class="material-symbols-outlined">docs</span>Update</div>
                  <div class="valdiasi"></div>
                </td>
                  <td>
                    <div class="validasi">
                      <div class="button-delete"
                        onclick="openDelete('<?= $row['nik_sekretaris'] ?>')">
                        <span class="material-symbols-outlined">delete</span>
                        Delete
                      </div>
                    </div>
                  </td>
              </tr>
            </tbody>
          <?php } ?>
        </table>
      </div>
    </main>
  </div>


  <!--Tambah-->
  <div class="overlay" id="popupOverlay">
    <div class="popup">
      <div class="close-btn" id="closePopup">&times;</div>
      <h1>Tambah Akun Sekretaris</h1>

      <form id="formTambah" action="../../controllers/akun/tambah-akun-sekretaris.php" method="POST">
        <div class="form-column">
          <label for="nik">NIK Sekretaris</label>
          <input type="number" id="nik" name="nik" placeholder="Masukkan NIK" required>

          <label for="nama">Nama Sekretaris</label>
          <input type="text" id="nama" name="nama" placeholder="Masukkan Nama Sekretaris" readonly>

          <label for="telp">No Telepon</label>
          <input type="text" id="telp" name="telp" placeholder="Masukkan No Telepon" readonly>

          <label for="username">Username</label>
          <input type="text" id="username" name="username" placeholder="Masukkan Username" required>

          <label for="password">Password</label>
          <input type="text" id="password" name="password" placeholder="Masukkan Password" required>
        </div>


        <div class="form-column">
          <label for="kk">KK Sekretaris</label>
          <input type="text" id="kk" name="kk" placeholder="Masukkan Nomor KK" readonly>

          <label for="alamat">Alamat Sekretaris</label>
          <input type="text" id="alamat" name="alamat" placeholder="Masukkan Alamat" readonly>

          <label for="rt_rw">No RT/RW</label>
          <input type="text" id="rt_rw" name="rt_rw" placeholder="Masukkan No RT/RW" readonly>

          <input type="hidden" id="no_rt" name="no_rt">
          <input type="hidden" id="no_rw" name="no_rw">

          <label for="role">Role</label>
          <select class="font-input" name="role" required>
            <option>- Pilih -</option>
            <option>rw</option>
            <option>rt1</option>
            <option>rt2</option>
            <option>rt3</option>
          </select>

          <label for="ulang">Ulangi Password</label>
          <input type="password" id="ulang" name="confirm_password" placeholder="Ulangi Password" required>
        </div>

        <div class="btn-container">
          <button type="submit">Buat Akun</button>
        </div>
      </form>
    </div>
  </div>

  <!-- update -->
  <div class="overlay" id="updatePopup">
    <div class="popup-update">
      <div class="close-btn" onclick="closeUpdate()">&times;</div>
      <h1>Update Akun Sekretaris</h1>

      <form id="formUpdate" action="../../controllers/akun/update-akun-sekretaris.php" method="POST">

        <input type="hidden" name="id_sekretaris" id="idUpdate">
        <input type="hidden" id="nikUpdate" name="nik">

        <!-- Username -->
        <label>Username</label>
        <input type="text" id="usernameUpdate" name="username">

        <!-- Role -->
        <label>Role</label>
        <select name="role" id="roleUpdate" required>
          <option value="">-- Pilih Role --</option>
          <option>rt1</option>
          <option>rt2</option>
          <option>rt3</option>
          <option>rw</option>
        </select>

        <!-- Password -->
        <label>Password</label>
        <input type="password" id="passwordUpdate" name="password" placeholder="Masukkan password baru (opsional)">

        <!-- Konfirmasi -->
        <label>Konfirmasi Password</label>
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
      <h2>Hapus Akun Sekretaris</h2>
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

  <script src="../../../public/js/halaman-akun-sekretaris.js"></script>

</body>

</html>