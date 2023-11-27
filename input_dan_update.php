<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $query = "SELECT * FROM tbl_data";
    $stmt = $koneksi->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    parse_str(file_get_contents('php://input'), $_PUT);

    $id = $_PUT['id'];
    $nama = $_PUT['nama'];
    $umur = $_PUT['umur'];

    $query = "UPDATE tabel_data SET nama = :nama, umur = :umur WHERE id = :id";

    $stmt = $koneksi->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nama', $nama);
    $stmt->bindParam(':umur', $umur);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Data berhasil diupdate']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal mengupdate data']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode request tidak diizinkan']);
}
?>
