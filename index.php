<?php
require_once __DIR__ . '/app/config/koneksi.php';

$q1 = mysqli_query($conn, "SELECT COUNT(*) AS total FROM warga");
$warga = mysqli_fetch_assoc($q1)['total'];

$q2 = mysqli_query($conn, "SELECT COUNT(no_kk) AS total FROM keluarga");
$keluarga = mysqli_fetch_assoc($q2)['total'];

$q3 = mysqli_query($conn, "SELECT COUNT(alamat_domisil) AS total FROM keluarga");
$alamat = mysqli_fetch_assoc($q3)['total'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SIWa (Sistem Informasi Warga)</title>
    <link rel="stylesheet" href="public/css/halaman-landing-page.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="icon" href="public/Image/logo.png">
</head>
</head>

<body>
    <header>
        <div class="header-left"><img src="public/Image/logo.png" alt="Logo" class="logo-header">
            <h1>SIWa</h1>
        </div>
        <nav class="navlist">
            <a href="#beranda">Beranda</a>
            <a href="#tentang">Tentang</a>
            <a href="#fitur">Fitur</a>
            <a href="#kontak">Kontak</a>
            <button class="btn-login" onclick="document.location='app/views/auth/halaman-login.php'">Login</button>
        </nav>
        <div class="bx bx-menu" id="menu-icon"></div>
    </header>
    <section class="beranda" id="beranda">
        <div class="beranda-text">
            <h2>Aplikasi Web </h2>
            <h2>Sistem Informasi</h2>
            <p>Kelola administrasi data warga dengan lebih mudah & cepat dengan "SIWa"</p>
            <button onclick="document.location='app/views/auth/halaman-login.php'">Mulai Sekarang</button>
        </div>
        <img src="public/Image/gambar-landing-page.png">
    </section>
    <section class="tentang" id="tentang">
        <h3>Tentang</h3>
        <div class="Tentang-konten">
            <div class="box">
                <img src="public/Image/perumahan.png">
                <p>
                    SIWa (Sistem Informasi Warga) adalah aplikasi web yang dikembangkan untuk membantu pengurus dan
                    warga
                    <strong>Perumahan Legenda</strong> dalam mengelola data administrasi secara lebih efisien dan
                    terintegrasi. Melalui SIWa, seluruh proses seperti pendataan warga, pengajuan dokumen administrasi,
                    hingga rekapitulasi data warga dapat dilakukan secara digital, tanpa harus melalui proses manual
                    yang
                    memakan waktu.
                    Aplikasi ini hadir untuk mendukung tata kelola warga yang modern dan tertib dengan antarmuka yang
                    mudah
                    digunakan.
                </p>
            </div>
            <div class="box1">
                <div class="box1-konten">
                    <h2>Jumlah warga</h2>
                    <img src="public/Image/logo-datawarga.png">
                    <h1><?php echo $warga; ?></h1>
                </div>
                <div class="box1-konten">
                    <h2>Jumlah KK</h2>
                    <img src="public/Image/logo-kk.png">
                    <h1><?php echo $keluarga; ?></h1>
                </div>
                <div class="box1-konten">
                    <h2>Jumlah Rumah</h2>
                    <img src="public/Image/logo-rumah.png">
                    <h1><?php echo $alamat; ?></h1>
                </div>
            </div>
        </div>

    </section>

    <section class="fitur" id="fitur">
        <h3>Fitur Utama</h3>
        <div class="fitur-all">
            <div class="fitur-konten">
                <h4>Manajemen Data Warga</h4>
                <div class="logo-wrap">
                    <img src="public/Image/warga.png">
                </div>
                <p>Kelola seluruh data identitas warga dengan fitur CRUD yang mudah digunakan, memastikan informasi
                    selalu valid dan terupdate.</p>
            </div>
            <div class="fitur-konten">
                <h4>Manajemen Data Keluarga (KK)</h4>
                <img src="public/Image/keluarga.png">
                <p>Atur dan perbarui data keluarga serta hubungan antaranggota dengan sistem pencatatan yang rapi dan
                    terstruktur.</p>
            </div>
            <div class="fitur-konten">
                <h4>Pencarian Cepat NIK / Nama / RT</h4>
                <img src="public/Image/pencarian.png">
                <p>Temukan data warga secara instan melalui pencarian cerdas berdasarkan NIK, nama, atau wilayah RT.</p>
            </div>
        </div>
        <div class="fitur-all">
            <div class="fitur-konten">
                <h4>Riwayat Administrasi Warga</h4>
                <img src="public/Image/administrasi.png">
                <p>Lihat riwayat lengkap pengajuan surat dan dokumen administrasi yang tersimpan otomatis dalam sistem.
                </p>
            </div>
            <div class="fitur-konten">
                <h4>Rekap Data Berdasarkan Kategori</h4>
                <img src="public/Image/rekapitulasi.png">
                <p>Tampilkan ringkasan data berdasarkan usia, gender, dan RT untuk kebutuhan analisis dan laporan.</p>
            </div>
            <div class="fitur-konten">
                <h4>Cetak Laporan ke Format PDF</h4>
                <img src="public/Image/pdf.png">
                <p>Buat dan unduh laporan resmi dalam format PDF secara cepat dan praktis.</p>
            </div>
        </div>
        <section class="keunggulan-section" id="keunggulan">
            <h2 class="judul-keunggulan">Keunggulan Aplikasi</h2>

            <div class="keunggulan-container">

                <div class="keunggulan-item">
                    <div>
                        <img src="public/Image/aman.png" class="icon-circle">
                    </div>
                    <h3>Data Aman & Terstruktur</h3>
                    <p>Seluruh data warga disimpan dengan aman dan tertata rapi, memudahkan pengelolaan dan pencarian.
                    </p>
                </div>

                <div class="keunggulan-item">
                    <div>
                        <img src="public/Image/cepat.png" class="icon-circle">
                    </div>
                    <h3>Proses Cepat</h3>
                    <p>Pencarian data, input, dan update berjalan cepat tanpa proses manual yang rumit.</p>
                </div>

                <div class="keunggulan-item">
                    <div>
                        <img src="public/Image/responsif.png" class="icon-circle">
                    </div>
                    <h3>Responsif</h3>
                    <p>Dapat diakses dari komputer, tablet, maupun ponsel dengan tampilan yang tetap nyaman.</p>
                </div>

                <div class="keunggulan-item">
                    <div>
                        <img src="public/Image/cetak.png" class="icon-circle">
                    </div>
                    <h3>Cetak Laporan</h3>
                    <p>Laporan warga, keluarga, dan administrasi dapat dicetak langsung dalam format PDF.</p>
                </div>

            </div>
        </section>

    </section>

    <section class="faq-section" id="faq">
        <h2 class="judul-faq">FAQ</h2>

        <div class="faq-container">

            <div class="faq-item">
                <button class="faq-question">Apakah data warga aman?</button>
                <div class="faq-answer">
                    <p>Ya, data warga disimpan dengan sistem keamanan berlapis dan hanya dapat diakses oleh pengguna
                        yang memiliki izin.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">Apakah bisa digunakan di HP?</button>
                <div class="faq-answer">
                    <p>Aplikasi ini responsif dan dapat digunakan di semua perangkat, termasuk ponsel.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">Apakah ada fitur cetak laporan?</button>
                <div class="faq-answer">
                    <p>Ya, laporan seperti data warga, keluarga, dan riwayat administrasi bisa dicetak dalam format PDF.
                    </p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">Apakah aplikasi ini bisa multi-user?</button>
                <div class="faq-answer">
                    <p>Ya, terdapat sistem role dan akses untuk admin, operator, dan user lainnya.</p>
                </div>
            </div>

        </div>
    </section>
    <footer class="footer" id="kontak">
        <div class="footer-container">

            <!-- BRAND -->
            <div class="footer-col">
                <h1 class="footer-logo">SIWa</h1>
                <h2>Sistem Informasi Warga</h2><br>
                <p class="footer-desc">
                    Kelola administrasi data warga dengan lebih mudah & cepat dengan "SIWa"
                </p>
            </div>

            <!-- NAVIGASI -->
            <div class="footer-col">
                <ul>
                    <h2>Navigasi</h2>
                    <li><a href="#beranda">Beranda</a></li>
                    <li><a href="#tentang">Tentang</a></li>
                    <li><a href="#fitur">Fitur Utama</a></li>
                    <li><a href="#keunggulan">Keunggulan</a></li>
                    <li><a href="#faq">FAQ</a></li>
                </ul>
            </div>


            <!-- KONTAK -->
            <div class="footer-col">
                <ul>
                    <li>
                        <h2>Kontak</h2>
                        <h3>Email:</h3>
                    </li>
                    <li>
                        <p>admin@sistemwarga.com</p>
                    </li>
                    <li>
                        <h3>WhatsApp:</h3>
                    </li>
                    <li>
                        <p>0828 2930 3112</p>
                    </li>
                </ul>
            </div>

            <div class="footer-col">
                <ul class="alamat">
                    <li><img src="public/Image/map.png"></li>
                    <li>Jl. Kenanga Utama No. 27, Blok C3
                        Kelurahan Sukamaju, Kecamatan Mandala
                        Kota Batara Indah, Provinsi Nusantara 51234
                        Indonesia</li>

                </ul>
            </div>

        </div>

        <div class="copyright">
            © 2025 Sistem Warga. All rights reserved.
        </div>
    </footer>

    <script src="public/js/halaman-landing-page.js"></script>
</body>

</html>