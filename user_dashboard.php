<?php
session_start();
include 'db.php';

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Handle search
$search = '';
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
}

// Fetch plants from database with search filter
$query = "SELECT * FROM plants WHERE name LIKE '%$search%' OR location LIKE '%$search%'";
$result = mysqli_query($conn, $query);

// Cek apakah query berhasil
if (!$result) {
    die("Query Error: " . mysqli_error($conn)); // Tambahkan pesan error agar mudah dilacak
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }
        .container {
            max-width: 1200px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dashboard User</h1>
        <p>Selamat datang, User <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>

        <h2>Daftar Tanaman</h2>
        <form method="POST" action="">
            <div class="form-group">
                <input type="text" class="form-control" name="search" placeholder="Cari tanaman" value="<?php echo htmlspecialchars($search); ?>">
            </div>
            <button type="submit" class="btn btn-primary" name="search">Cari</button>
        </form>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Tanaman</th>
                    <th>Jenis Tanaman</th>
                    <th>Lokasi</th>
                    <th>Usia</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['plant_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['type']); ?></td>
                    <td><?php echo htmlspecialchars($row['location']); ?></td>
                    <td><?php echo htmlspecialchars($row['age']); ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

        <a href="logout.php" class="btn btn-secondary">Logout</a>
    </div>
</body>
</html>
