
<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pastikan data yang diterima memiliki nilai
    $nama = isset($_POST['nama']) ? $_POST['nama'] : null;
    $umur = isset($_POST['umur']) ? $_POST['umur'] : null;

    if ($nama !== null && $umur !== null) {
        // Query untuk menambahkan data ke tabel
        $query = "INSERT INTO tbl_data (nama, umur) VALUES (:nama, :umur)";

        // Menyiapkan statement PDO
        $stmt = $koneksi->prepare($query);

        // Mengikat parameter
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':umur', $umur);

        // Mengeksekusi statement
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil ditambahkan']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan data']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
    }
} else {
    // Formulir HTML
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Form Tambah Data</title>
    </head>
    <body>
    
        <h2>Form Tambah Data</h2>
    
        <form action="tambah_data.php" method="post">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required>
    
            <label for="umur">Umur:</label>
            <input type="number" id="umur" name="umur" required>
    
            <button type="submit">Tambah Data</button>
        </form>
    
    </body>
    </html>
    <?php
}

