<?php
session_start();
include 'db.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Handle search
$search = '';
if (isset($_POST['search_query'])) { // Ganti 'search' dengan 'search_query'
    $search = mysqli_real_escape_string($conn, $_POST['search_query']);
}

// Fetch plants from database with search filter
$query = "SELECT * FROM plants WHERE jenis_tanaman LIKE '%$search%' 
          OR asal_benih LIKE '%$search%' 
          OR lokasi LIKE '%$search%' 
          OR tanggal_sapih LIKE '%$search%'"; // Tambahkan asal_benih, lokasi, dan tanggal_sapih dalam pencarian
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
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
        <h1>Dashboard Admin</h1>
        <p>Selamat datang, Admin <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>

        <h2>Daftar Tanaman</h2>
        <form method="POST" action="">
            <div class="form-group">
                <input type="text" class="form-control" name="search_query" placeholder="Cari tanaman, asal benih, lokasi, atau tanggal sapih" value="<?php echo htmlspecialchars($search); ?>"> <!-- Ubah name jadi 'search_query' -->
            </div>
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>No</th> <!-- Kolom No untuk nomor urut -->
                    <th>Jenis Tanaman</th>
                    <th>Asal Benih</th>
                    <th>Lokasi</th>
                    <th>Tanggal Sapih</th>
                    <th>Jumlah</th> <!-- Tambahkan kolom jumlah -->
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $no = 1; // Inisialisasi nomor urut
            while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $no++; ?></td> <!-- Nomor urut bertambah -->
                    <td><?php echo htmlspecialchars($row['jenis_tanaman']); ?></td>
                    <td><?php echo htmlspecialchars($row['asal_benih']); ?></td>
                    <td><?php echo htmlspecialchars($row['lokasi']); ?></td>
                    <td><?php echo htmlspecialchars($row['tanggal_sapih']); ?></td>
                    <td><?php echo htmlspecialchars($row['jumlah']); ?></td> <!-- Tampilkan kolom jumlah -->
                    <td>
                        <a href="edit_plant.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                        <a href="delete_plant.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

        <a href="add_plant.php" class="btn btn-success">Tambah Tanaman</a>
        <a href="logout.php" class="btn btn-secondary">Logout</a>
    </div>
</body>
</html>
