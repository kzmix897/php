<?php
session_start();
include 'db.php';

// Cek apakah user sudah login dan apakah role-nya admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Handle form submission
if (isset($_POST['add_plant'])) {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $location = $_POST['location'];
    $age = $_POST['age'];
    $quantity = $_POST['quantity']; // Perbaikan di sini (gunakan $_POST)

    $query = "INSERT INTO plants (name, type, location, age, quantity) VALUES ('$name', '$type', '$location', '$age', '$quantity')";
    
    if (mysqli_query($conn, $query)) {
        echo "Tanaman berhasil ditambahkan";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Tambah Tanaman</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }
        .container {
            max-width: 600px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Tanaman</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Nama Tanaman:</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nama Tanaman" required>
            </div>
            <div class="form-group">
                <label for="type">Jenis Tanaman:</label>
                <input type="text" class="form-control" id="type" name="type" placeholder="Jenis Tanaman" required>
            </div>
            <div class="form-group">
                <label for="location">Lokasi Tanaman:</label>
                <input type="text" class="form-control" id="location" name="location" placeholder="Lokasi Tanaman" required>
            </div>
            <div class="form-group">
                <label for="age">Usia Tanaman:</label>
                <input type="number" class="form-control" id="age" name="age" placeholder="Usia Tanaman" required>
            </div>
            <div class="form-group">
                <label for="quantity">Jumlah</label>
                <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Jumlah" required>
            </div>
            <button type="submit" class="btn btn-primary" name="add_plant">Tambah Tanaman</button>
        </form>
        <a href="admin_dashboard.php" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
    </div>
</body>
</html>
