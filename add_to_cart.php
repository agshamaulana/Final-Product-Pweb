<?php
// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "teavou_db");

// cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Mendapatkan data dari form
$item = $_POST['item'];
$harga = $_POST['harga'];
$quantity = $_POST['quantity'];
$total_harga = $_POST['total_harga'];

// Menyiapkan dan mengeksekusi pernyataan SQL
$sql = "INSERT INTO keranjang (item, harga, quantity, total_harga) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sdid", $item, $harga, $quantity, $total_harga); // "sdid" berarti string, double, integer, double

if ($stmt->execute()) {
    echo json_encode(array("status" => "success", "message" => "Item berhasil ditambahkan ke keranjang."));
} else {
    echo json_encode(array("status" => "error", "message" => "Error: " . $sql . "<br>" . $conn->error));
}

// Menutup koneksi
$stmt->close();
$conn->close();
?>
