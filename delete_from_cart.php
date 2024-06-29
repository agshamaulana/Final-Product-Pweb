<?php
// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "teavou_db");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Terima data dari AJAX
$itemId = $_POST['item_id'];

// Query untuk menghapus item dari database
$sql = "DELETE FROM keranjang WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $itemId);

$response = array();

if ($stmt->execute()) {
    $response['status'] = 'success';
    $response['message'] = 'Item berhasil dihapus dari keranjang.';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Error: ' . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>
