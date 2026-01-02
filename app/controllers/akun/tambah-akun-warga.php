<?php
session_start();
require_once __DIR__ . '/../../config/koneksi.php';


$nik = $_POST['nik'];
$username = $_POST['username'];
$password = $_POST['password'];
$role = "user";
$confirm = $_POST['confirm_password'];
$roleSekre = $_SESSION['role'];
$id_sekretaris = $_SESSION['id_sekretaris'];

// VALIDASI USERNAME
if (preg_match('/\s/', $username)) {
    echo "<script>
            alert('Username tidak boleh mengandung spasi!');
            history.back();
         </script>";
    exit();
}

if (!preg_match('/^[a-z0-9._]+$/', $username)) {
    echo "<script>
            alert('Username hanya boleh huruf kecil, angka, titik, dan underscore!');
            history.back();
         </script>";
    exit();
}

// 1. CEK password & konfirmasi
if ($password !== $confirm) {
    echo "<script>
            alert('Password dan Ulangi Password tidak sama!');
            history.back();
         </script>";
    exit();
}


// 2. CEK apakah NIK tersedia di tabel WARGA
$cekNik = mysqli_query($conn, "SELECT * FROM warga WHERE nik='$nik'");
$dataWarga = mysqli_fetch_assoc($cekNik);

if (!$dataWarga) {
    echo "<script>
            alert('NIK tidak terdaftar di data warga! Tidak bisa membuat akun.');
            history.back();
         </script>";
    exit();
}


// 3. CEK apakah NIK SUDAH DIPAKAI di akun_warga
$cekAkun = mysqli_query($conn, "SELECT * FROM akun_warga WHERE nik='$nik'");

if (mysqli_num_rows($cekAkun) > 0) {
    echo "<script>
            alert('NIK ini sudah memiliki akun!');
            history.back();
         </script>";
    exit();
}


// 4. CEK UMUR MINIMAL 17 TAHUN
$tglLahir = $dataWarga['tanggal_lahir'];
$umur = date_diff(date_create($tglLahir), date_create())->y;

if ($umur < 17) {
    echo "<script>
            alert('Tidak bisa membuat akun, usia warga masih $umur tahun! Minimal 17 tahun.');
            history.back();
         </script>";
    exit();
}


// 5. CEK RT HARUS SAMA -> KECUALI RW boleh semua
$rtWarga = (int) $dataWarga['no_rt']; // ambil RT dari tabel WARGA

if ($roleSekre != 'rw') {
    // Ambil angka RT dari role sekretaris, contoh 'rt1' -> 1
    $rtSekre = str_replace("rt", "", $roleSekre);

    if ($rtSekre != $rtWarga) {
        echo "<script>
                alert('Tidak bisa menambahkan akun warga RT $rtWarga! Anda adalah $roleSekre.');
                history.back();
             </script>";
        exit();
    }
}


// 6. INSERT jika semua valid
$query = "
    INSERT INTO akun_warga (nik, username, password, role, id_sekretaris)
    VALUES ('$nik', '$username', '$password', '$role', '$id_sekretaris')
";

$insert = mysqli_query($conn, $query);

if ($insert) {
    echo "<script>
            alert('Akun berhasil ditambahkan!');
            window.location='../../../views/akun/halaman-akun-warga.php';
          </script>";
} else {
    echo "<script>
            alert('Gagal menambahkan akun!');
            history.back();
          </script>";
}
?>