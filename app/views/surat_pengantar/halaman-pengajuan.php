<?php
session_start();
require_once __DIR__ . '/../../config/koneksi.php';

if (
  !isset($_SESSION['role']) ||
  $_SESSION['role'] !== 'user' ||
  !isset($_SESSION['nik'])
) {
  header("Location: ../auth/halaman-login.php");
  exit;
}

$nik = $_SESSION['nik'];

$query = mysqli_query($conn, "
    SELECT w.*, a.* 
    FROM warga w 
    LEFT JOIN akun_warga a ON w.nik = a.nik
    WHERE w.nik = '$nik'
");

$data = mysqli_fetch_assoc($query);

$surat = mysqli_query($conn, "
          SELECT s.*, w.nama
          FROM surat_pengantar s
          JOIN warga w ON s.nik=w.nik
          WHERE s.nik = '$nik'
          ORDER BY s.id_surat DESC
");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pengajuan Surat Pengantar RT/RW</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
  <link rel="stylesheet" href="../../../public/css/halaman-pengajuan.css" />
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
              <div class="btn-row">
                <button class="btn" onclick="document.location='../../controllers/login/logout.php'">
                  <span class="material-symbols-outlined">Logout</span>
                  Logout
                </button>
              </div>
            </div>
          </div>
        </div>
      </header>

      <h2>Pengajuan Dokumen Administrasi</h2>

      <!-- Form Pengajuan Surat -->
      <div class="dropdown-box">
        <div class="dropdown-header" onclick="toggleDropdownA()">
          <span>Form Pengajuan Surat</span>
          <span class="material-symbols-outlined" id="arrow1">expand_less</span>
        </div>

        <div class="dropdown-content" id="formContent">
          <h3>a. Surat Pengantar RT/RW</h3>

          <form class="form" action="../../controllers/surat_pengantar/proses_pengajuan.php" method="POST" enctype="multipart/form-data">
            <div class="form-row">
              <div class="form-group">
                <label for="fotocopy-ktp">1. Tujuan Surat:</label>
                <select class="TujuanSurat" name="tujuan" required>
                  <option value="">-- Pilih --</option>
                  <option value="Pembuatan KTP">Pembuatan KTP</option>
                  <option value="Pembuatan SKCK">Pembuatan SKCK</option>
                  <option value="Perubahan KK">Pembuatan KK</option>
                  <option value="Pengurusan SKTM">Pengurusan SKTM</option>
                  <option value="Izin Nikah">Izin Nikah</option>
                  <option value="Surat Kematian">Surat Kematian</option>
                  <option value="Pegurusan Surat Domisili">Pengurusan Surat Domisili</option>
                </select>
              </div>
              <div class="form-group">
                <label for="nama">2. Tanggal:</label>
                <input type="date" name="tanggal" required />
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>3. Fotokopi KTP</label>
                <input type="file" name="ktp" required>
                <small class="text-muted">
                  Format file: PDF, JPG, JPEG, PNG (Maks. 2 MB)
                </small>
              </div>

              <div class="form-group">
                <label>4. Fotokopi KK</label>
                <input type="file" name="kk" required>
                <small class="text-muted">
                  Format file: PDF, JPG, JPEG, PNG (Maks. 2 MB)
                </small>
              </div>
            </div>

            <div class="button-box">
              <button type="button" class="btn-cancel">Cancel</button>
              <button type="submit" class="btn-submit">Submit</button>
            </div>
          </form>
        </div>
      </div>
      <!-- Status Pengajuan -->
      <div class="dropdown-box">
        <div class="dropdown-header" onclick="toggleDropdownB()">
          <span>Status Pengajuan Surat</span>
          <span class="material-symbols-outlined" id="arrow2">expand_more</span>
        </div>

        <div class="dropdown-content" id="statusContent">
          <h3>b. Status Surat Pengantar RT/RW</h3>
          <table>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Surat</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Catatan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($surat)) {
                ?>

                  <?php
                  if ($row['status_pengajuan'] == 'Diajukan') {
                    $class = "status-ajukan";
                    $icon_id = "simbol1";
                  } elseif (in_array($row['status_pengajuan'], ['Disetujui RT', 'Disetujui RW'])) {
                    $class = "status-setujui";
                    $icon_id = "simbol1";
                  } elseif ($row['status_pengajuan'] == 'selesai') {
                    $class = "status-selesai";
                    $icon_id = "simbol2";
                  } elseif (in_array($row['status_pengajuan'], ['Ditolak RT', 'Ditolak RW'])) {
                    $class = "status-tolak";
                    $icon_id = "simbol3";
                  }
                  ?>

                  <td><?= $no++ ?></td>
                  <td>Surat Pengantar RT/RW</td>
                  <td><?= $row['tanggal_pengajuan'] ?></td>
                  <td class="<?= $class ?>"><?= $row['status_pengajuan'] ?></td>
                  <td>
                    <?php if ($row['status_pengajuan'] == 'selesai'): ?>
                      <p class="catatan"><?= $row['catatan_selesai'] ?></p>
                    <?php elseif (in_array($row['status_pengajuan'], ['Ditolak RT', 'Ditolak RW'])): ?>
                      <p class="catatan-tolak"><?= $row['catatan_tolak'] ?></p>
                    <?php elseif ($row['status_pengajuan'] == 'Disetujui RT'): ?>
                      <p class="catatan-setuju"><?= $row['catatan_disetujui_rt'] ?></p>
                    <?php else: ?>
                      <p class="catatan">Tidak ada catatan</p>
                    <?php endif; ?>
                  </td>
                  <td class="<?= $class ?>">
                    <?php if ($row['status_pengajuan'] == 'selesai'): ?>
                      <!-- Icon aktif bisa di-klik -->
                      <a href="../../controllers/surat_pengantar/generate_surat.php?id_surat=<?= $row['id_surat']; ?>"
                        style="text-decoration:none; color:inherit;">
                        <span class="material-symbols-outlined" id="<?= $icon_id ?>" style="cursor:pointer;">
                          docs
                        </span>
                      </a>
                    <?php else: ?>
                      <!-- Icon nonaktif -->
                      <span class="material-symbols-outlined" id="<?= $icon_id ?>"
                        style="opacity:0.4; cursor:not-allowed;">
                        docs
                      </span>
                    <?php endif; ?>
                  </td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- 🔼 Akhir Dropdown -->
    </main>
  </div>


  <script src="../../../public/js/halaman-pengajuan.js"></script>
</body>

</html>