<?php
// db.php

$host = 'localhost'; // Atur sesuai konfigurasi server Anda
$user = 'root'; // Atur sesuai konfigurasi server Anda
$password = ''; // Atur sesuai konfigurasi server Anda
$dbname = 'my_database'; // Nama database yang Anda gunakan

// Membuat koneksi ke database
$conn = mysqli_connect($host, $user, $password, $dbname);

// Cek koneksi
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>
