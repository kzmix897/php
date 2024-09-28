<?php
include 'db.php';

// Daftar 10 jenis bunga
$flowers = [
    'Rose', 'Tulip', 'Lily', 'Sunflower', 'Daisy',
    'Orchid', 'Carnation', 'Peony', 'Marigold', 'Iris'
];

foreach ($flowers as $flower) {
    $query = "INSERT INTO flowers (name, quantity) VALUES ('$flower', 0)";
    if (!mysqli_query($conn, $query)) {
        echo "Error: " . mysqli_error($conn);
    }
}

echo "Jenis bunga berhasil ditambahkan";
?>
