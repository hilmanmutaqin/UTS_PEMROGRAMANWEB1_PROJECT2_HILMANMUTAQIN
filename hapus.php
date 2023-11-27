<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    parse_str(file_get_contents('php://input'), $_DELETE);
    $id = isset($_DELETE['id']) ? $_DELETE['id'] : null;

    if ($id !== null) {
        // Query 
        $query = "DELETE FROM tbl_data WHERE id = :id";

        // Menyiapkan statement PDO
        $stmt = $koneksi->prepare($query);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil dihapus']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus data']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID tidak valid']);
    }
} else {
 // Formulir HTML
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Form Hapus Data</title>
    </head>
    <body>
    
        <h2>Form Hapus Data</h2>
    
        <form id="deleteForm">
            <label for="id">ID:</label>
            <input type="number" id="id" name="id" required>
    
            <button type="button" onclick="hapusData()">Hapus Data</button>
        </form>
    
        <script>
            function hapusData() {
                var id = document.getElementById("id").value;
    
                // Kirim permintaan DELETE dengan fetch API
                fetch('hapus.php', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'id=' + id,
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        </script>
    
    </body>
    </html>
    <?php
}
?>
