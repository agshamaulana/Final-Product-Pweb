<?php
// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "teavou_db");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Terima data dari AJAX
$itemId = $_POST['item_id'];
$newQuantity = $_POST['quantity'];

// Mendapatkan harga satuan dari item
$sql = "SELECT harga FROM keranjang WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $itemId);
$stmt->execute();
$stmt->bind_result($unitPrice);
$stmt->fetch();
$stmt->close();

if ($unitPrice) {
    // Hitung harga total baru berdasarkan quantity baru
    $newTotalPrice = $unitPrice * $newQuantity;

    // Update quantity dan total harga di database
    $sql = "UPDATE keranjang SET quantity = ?, total_harga = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("idi", $newQuantity, $newTotalPrice, $itemId);

    $response = array();

    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Jumlah item dan harga total berhasil diupdate.';
        $response['new_total_price'] = $newTotalPrice;
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error: ' . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Item tidak ditemukan'
    );
}

$conn->close();

echo json_encode($response);
?>