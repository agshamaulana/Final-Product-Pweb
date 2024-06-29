<?php
// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "teavou_db");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data dari tabel keranjang
$sql = "SELECT * FROM keranjang";
$result = $conn->query($sql);

// Mengecek apakah hasil query mengembalikan data
if ($result->num_rows > 0) {
    // Menginisialisasi array untuk menyimpan data keranjang belanja
    $cartItems = array();

    // Mengambil setiap baris data dari hasil query
    while ($row = $result->fetch_assoc()) {
        // Menambahkan data ke dalam array $cartItems
        $cartItems[] = array(
            'id' => $row['id'],
            'item' => $row['item'],
            'harga' => $row['harga'],
            'quantity' => $row['quantity'],
            'total_harga' => $row['total_harga']
        );
    }

    // Mengirimkan respons dalam format JSON
    echo json_encode($cartItems);
} else {
    // Jika tidak ada data dalam keranjang belanja
    echo json_encode(array()); // Mengirim array kosong jika tidak ada data
}

// Menutup koneksi ke database
$conn->close();
?>
