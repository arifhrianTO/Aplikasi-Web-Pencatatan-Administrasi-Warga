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

// ambil data sekretaris
$sekre_q = mysqli_query($conn, "
    SELECT * FROM sekretaris_rt_rw 
    WHERE nik_sekretaris = '" . mysqli_real_escape_string($conn, $nik_sekretaris) . "'
");
$data = mysqli_fetch_assoc($sekre_q);

// tentukan no_rt
$no_rt = null;
if (!empty($data['no_rt'])) {
  $no_rt = $data['no_rt'];
} else {
  if (strpos($role, 'rt') === 0) {
    $no_rt = intval(str_replace('rt', '', $role));
  }
}

if ($role === 'rw') {

  // RW melihat surat yang sudah disetujui RT
  $query = mysqli_query($conn, "
        SELECT s.*, w.nama, w.no_rt
        FROM surat_pengantar s
        JOIN warga w ON s.nik = w.nik
        WHERE s.status_pengajuan = 'Disetujui RT'
        ORDER BY s.tanggal_pengajuan DESC
    ");
} else {

  $nr = mysqli_real_escape_string($conn, $no_rt);

  // RT melihat surat milik warga RT tersebut
  $query = mysqli_query($conn, "
        SELECT s.*, w.nama, w.no_rt
        FROM surat_pengantar s
        JOIN warga w ON s.nik = w.nik
        WHERE s.status_pengajuan = 'Diajukan'
        AND w.no_rt = '$nr'
        ORDER BY s.tanggal_pengajuan DESC
    ");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Persetujuan Dokumen Administrasi</title>
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=search" />
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <link rel="stylesheet" href="../../../public/css/halaman-persetujuan.css">
  <link rel="icon" href="../../../public/image/logo.png">
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
      <div class="note">
        <h2>Persetujuan Dokumen Administrasi:</h2>
        <div class="info-box">
          <img src="../../../public/Image/info.png" alt="Info" class="info-icon">

          <div class="info-content">
            <div class="info-row">
              <img src="../../../public/Image/centang.png" alt="Setuju" class="icon">
              <p class="font-info">Untuk Menyetujui permohonan dokumen Administrasi</p>
            </div>

            <div class="info-row">
              <img src="../../../public/Image/silang.png" alt="Tolak" class="icon">
              <p class="font-info">Untuk Menolak permohonan dokumen Administrasi</p>
            </div>
          </div>
        </div>
      </div>
      <div class="table-container">
        <table>
          <tr>
            <th>NO</th>
            <th>NAMA</th>
            <th>TUJUAN BERKAS</th>
            <th>TANGGAL PENGAJUAN</th>
            <th>FOTOCOPY KTP</th>
            <th>FOTOCOPY KK</th>
            <th colspan="2">AKSI</th>
          </tr>
          <?php
          $no = 1;
          while ($row = mysqli_fetch_assoc($query)) {
          ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= htmlspecialchars($row['nama']) ?></td>
              <td><?= htmlspecialchars($row['tujuan_pengajuan']) ?></td>
              <td><?= htmlspecialchars($row['tanggal_pengajuan']) ?></td>
              <td>
                <?php if (!empty($row['fc_ktp'])): ?>
                  <button class="button1" onclick="window.open('../Halaman_Pengajuan_Dokumen_warga/<?= $row['fc_ktp'] ?>', '_blank')">Lihat KTP</button>
                <?php endif; ?>
              </td>
              <td>
                <?php if (!empty($row['fc_kk'])): ?>
                  <button class="button1" onclick="window.open('../Halaman_Pengajuan_Dokumen_warga/<?= $row['fc_kk'] ?>', '_blank')">Lihat KK</button>
                <?php endif; ?>
              </td>
              <td class="actions">
                <!-- FORM Setuju (POST) -->
                <form style="display:inline" method="POST" action="../../controllers/surat_pengantar/proses-status.php">
                  <input type="hidden" name="id_surat" value="<?= htmlspecialchars($row['id_surat']) ?>">
                  <?php if ($role === 'rw'): ?>
                    <input type="hidden" name="aksi" value="setuju_rw">
                    <button type="submit" class="check" title="Setujui RW">
                      <img src="../../../public/Image/centang.png" alt="Setuju" />
                    </button>
                  <?php else: ?>
                    <input type="hidden" name="aksi" value="setuju_rt">
                    <button type="submit" class="check" title="Setujui RT">
                      <img src="../../../public/Image/centang.png" alt="Setuju" />
                    </button>
                  <?php endif; ?>
                </form>
              </td>
              <td class="actions">
                <!-- Tombol Tolak: buka modal -->
                <div>
                  <button class="check" onclick="openTolakModal('<?= htmlspecialchars($row['id_surat']) ?>')">
                    <img src="../../../public/Image/silang.png" alt="Tolak" />
                  </button>
                </div>
              </td>
            </tr>
          <?php } ?>
        </table>
        </section>
      </div>
    </main>
  </div>

  <!-- MODAL TOLAK (otomatis isi aksi berdasarkan role login) -->
  <div id="modalTolak" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h1>Alasan Penolakan</h1>
      <form method="POST" action="proses-status.php">
        <input type="hidden" name="id_surat" id="idSuratTolak">
        <input type="hidden" name="aksi" value="<?= ($role === 'rw') ? 'tolak_rw' : 'tolak_rt' ?>">

        <select name="alasan" id="alasan" class="input-alasan" required>
          <option value="">-- Pilih Alasan --</option>
          <option value="Data tidak lengkap">Data tidak lengkap</option>
          <option value="Dokumen tidak sesuai">Dokumen tidak sesuai</option>
          <option value="Kesalahan pengisian">Kesalahan pengisian</option>
          <option value="Lainnya">Lainnya</option>
        </select>

        <div class="button-group">
          <h1>Apakah anda yakin ingin menolak pengajuan ini?</h1>
          <input type="submit" value="YA" id="ya" class="input1">
          <input type="reset" value="TIDAK" id="btnTidak" class="input2">
        </div>
      </form>
    </div>
  </div>

  </main>
</body>

<script src="../../../public/js/halaman-persetujuan.js"></script>

</html>