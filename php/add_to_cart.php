<?php
$servername = "localhost";
$username = 'root';
$password = "fp123";
$dbname = "teavoudb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];

    $stmt = $conn->prepare("INSERT INTO cart (nama_produk, harga) VALUES (?, ?)");
    
    if ($stmt === false) {
        die("Prepare gagal: " . $conn->error);
    }
    
    $stmt->bind_param("sdi", $nama_produk, $harga,);

    if ($stmt->execute()) {
        echo "Berhasil menambahkan ke keranjang";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
