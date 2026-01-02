<?php
session_start();
require_once __DIR__ . '/../../config/koneksi.php';

// Pastikan login
if (
    !isset($_SESSION['role']) ||
    !isset($_SESSION['nik_sekretaris'])
) {
    header("Location: ../../views/auth/halaman-login.php");
    exit;
}

$role = $_SESSION['role'];       // rt1 / rt2 / rt3 / rw
$id_surat = $_POST['id_surat'] ?? null;
$aksi     = $_POST['aksi'] ?? null;
$alasan   = trim($_POST['alasan'] ?? "");
$nik      = $_SESSION['nik_sekretaris'];

$s = mysqli_query($conn, "SELECT id_sekretaris FROM sekretaris_rt_rw WHERE nik_sekretaris='$nik'");
$rose = mysqli_fetch_assoc($s);
$id_sekretaris = $rose['id_sekretaris'];

if (!$id_surat || !$aksi) {
    exit("<script>alert('Request tidak lengkap'); history.back();</script>");
}

$id_surat_esc = mysqli_real_escape_string($conn, $id_surat);

// Ambil nama pengaju
$q = mysqli_query($conn, "
    SELECT w.nama 
    FROM surat_pengantar s
    JOIN warga w ON s.nik = w.nik
    WHERE s.id_surat = '$id_surat_esc'
");

if (!$row = mysqli_fetch_assoc($q)) {
    exit("<script>alert('Surat tidak ditemukan'); history.back();</script>");
}

$nama_pengaju = mysqli_real_escape_string($conn, $row['nama']);

// =================== 1. RT SETUJU ===========================
if ($aksi === 'setuju_rt') {

    if (strpos($role, "rt") !== 0)
        exit("<script>alert('Aksi hanya untuk RT');history.back();</script>");

    // UPDATE SURAT
    mysqli_query($conn, "
        UPDATE surat_pengantar 
        SET status_pengajuan = 'Disetujui RT', id_sekretaris='$id_sekretaris', catatan_disetujui_rt='Menunggu Persetujuan RW'
        WHERE id_surat='$id_surat_esc'
    ");

    // INSERT RIWAYAT (manual)
    mysqli_query($conn, "
        INSERT INTO riwayat_administrasi
        (id_surat, nama_pengaju, tanggal_setuju)
        VALUES ('$id_surat_esc', '$nama_pengaju', NOW())
    ");

    exit("<script>alert('RT menyetujui surat.'); window.location='../../views/surat_pengantar/halaman-persetujuan.php';</script>");
}



// =================== 2. RT TOLAK ===========================
if ($aksi === 'tolak_rt') {

    if (strpos($role, "rt") !== 0)
        exit("<script>alert('Aksi hanya untuk RT');history.back();</script>");

    if ($alasan === "")
        exit("<script>alert('Alasan wajib diisi'); history.back();</script>");

    mysqli_query($conn, "
        UPDATE surat_pengantar 
        SET status_pengajuan='Ditolak RT', catatan_tolak='$alasan',
        id_sekretaris='$id_sekretaris'
        WHERE id_surat='$id_surat_esc'
    ");

    // INSERT RIWAYAT (manual)
    mysqli_query($conn, "
        INSERT INTO riwayat_administrasi
        (id_surat, nama_pengaju, tanggal_tolak)
        VALUES ('$id_surat_esc', '$nama_pengaju', NOW())
    ");

    exit("<script>alert('Surat ditolak RT'); window.location='../../views/surat_pengantar/halaman-persetujuan.php';</script>");
}



// =================== 3. RW SETUJU ===========================
if ($aksi === 'setuju_rw') {

    if ($role !== "rw")
        exit("<script>alert('Aksi hanya untuk RW');history.back();</script>");

    mysqli_query($conn, "
        UPDATE surat_pengantar 
        SET status_pengajuan='selesai', catatan_selesai='Silahkan Pilih aksi untuk mengunduh surat'
        WHERE id_surat='$id_surat_esc'
    ");

    // INSERT RIWAYAT (manual)
    mysqli_query($conn, "
        UPDATE riwayat_administrasi
        SET tanggal_selesai= NOW()
        WHERE id_surat='$id_surat_esc'
    ");

    exit("<script>alert('Surat selesai oleh RW'); window.location='../../views/surat_pengantar/halaman-persetujuan.php';</script>");
}



// =================== 4. RW TOLAK ===========================
if ($aksi === 'tolak_rw') {

    if ($role !== "rw")
        exit("<script>alert('Aksi hanya untuk RW');history.back();</script>");

    if ($alasan === "")
        exit("<script>alert('Alasan wajib diisi'); history.back();</script>");

    mysqli_query($conn, "
        UPDATE surat_pengantar 
        SET status_pengajuan='Ditolak RW'
        WHERE id_surat='$id_surat_esc'
    ");

    // INSERT RIWAYAT (manual)
    mysqli_query($conn, "
        INSERT INTO riwayat_administrasi
        (id_surat, nama_pengaju, tanggal_tolak)
        VALUES ('$id_surat_esc', '$nama_pengaju', NOW())
    ");

    exit("<script>alert('Surat ditolak RW'); window.location='../../views/surat_pengantar/halaman-persetujuan.php';</script>");
}


// =================== 5. DEFAULT (Aksi Tidak Dikenal) ===================
exit("<script>alert('Aksi tidak dikenali'); history.back();</script>");
?>