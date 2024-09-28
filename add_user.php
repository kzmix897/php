<?php
include 'db.php';

// Contoh cara hash password saat menambah user
$passwordAdmin = password_hash('kazumi', PASSWORD_DEFAULT);
echo $passwordAdmin; // Debugging: tampilkan hash password

$passwordUser1 = password_hash('putra', PASSWORD_DEFAULT);
$passwordUser2 = password_hash('aboy', PASSWORD_DEFAULT);

// Masukkan pengguna ke database
$query = "INSERT INTO users (username, password, role) VALUES 
    ('kiiryu', '$passwordAdmin', 'admin'),
    ('baloy', '$passwordUser1', 'user'),
    ('aeron', '$passwordUser2', 'user')";

if (mysqli_query($conn, $query)) {
    echo "Pengguna berhasil ditambahkan";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
