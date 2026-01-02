<?php
require_once __DIR__ . '/../../config/koneksi.php';

$id = $_GET['id_sekretaris'];

$query = mysqli_query($conn, "
    SELECT id_sekretaris, nik_sekretaris, username, role 
    FROM sekretaris_rt_rw
    WHERE id_sekretaris = '$id'
");

$data = mysqli_fetch_assoc($query);

echo json_encode($data);
