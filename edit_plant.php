<?php
session_start();
include 'db.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Dapatkan ID tanaman dari URL
$plant_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch plant data berdasarkan plant_id yang diberikan
$query = "SELECT * FROM plants WHERE id = $plant_id LIMIT 1"; 
$result = mysqli_query($conn, $query);

// Debugging: Tampilkan kesalahan jika query gagal
if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}

$plant = mysqli_fetch_assoc($result);

if (!$plant) {
    die("Tanaman tidak ditemukan.");
}

// Handle form submission
if (isset($_POST['submit'])) {
    // Mengambil dan membersihkan data input
    $jenis_tanaman = mysqli_real_escape_string($conn, $_POST['jenis_tanaman']);
    $asal_benih = mysqli_real_escape_string($conn, $_POST['asal_benih']);
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $tanggal_sapih = mysqli_real_escape_string($conn, $_POST['tanggal_sapih']);
    $jumlah = intval($_POST['jumlah']); // Pastikan data jumlah sebagai integer

    // Query update untuk memperbarui data tanaman (termasuk kolom jumlah)
    $updateQuery = "UPDATE plants SET 
                    jenis_tanaman = '$jenis_tanaman', 
                    asal_benih = '$asal_benih', 
                    lokasi = '$lokasi', 
                    tanggal_sapih = '$tanggal_sapih', 
                    jumlah = $jumlah 
                    WHERE id = $plant_id";
    
    // Menjalankan query dan mengecek apakah berhasil
    if (mysqli_query($conn, $updateQuery)) {
        // Redirect ke dashboard dengan pesan sukses
        header("Location: admin_dashboard.php?success=updated");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tanaman</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Tanaman</h2>
        
        <form method="POST">
            <div class="form-group">
                <label for="jenis_tanaman">Jenis Tanaman</label>
                <input type="text" class="form-control" id="jenis_tanaman" name="jenis_tanaman" value="<?php echo htmlspecialchars($plant['jenis_tanaman']); ?>" required>
            </div>
            <div class="form-group">
                <label for="asal_benih">Asal Benih</label>
                <input type="text" class="form-control" id="asal_benih" name="asal_benih" value="<?php echo htmlspecialchars($plant['asal_benih']); ?>" required>
            </div>
            <div class="form-group">
                <label for="lokasi">Lokasi</label>
                <input type="text" class="form-control" id="lokasi" name="lokasi" value="<?php echo htmlspecialchars($plant['lokasi']); ?>" required>
            </div>
            <div class="form-group">
                <label for="tanggal_sapih">Tanggal Sapih</label>
                <input type="date" class="form-control" id="tanggal_sapih" name="tanggal_sapih" value="<?php echo htmlspecialchars($plant['tanggal_sapih']); ?>" required>
            </div>
            <div class="form-group">
                <label for="jumlah">Jumlah</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?php echo htmlspecialchars($plant['jumlah']); ?>" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="admin_dashboard.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
