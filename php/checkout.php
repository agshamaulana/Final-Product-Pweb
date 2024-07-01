<?php
// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "teavou_db");

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Memulai transaksi
$conn->begin_transaction();

try {
    // Mendapatkan metode pembayaran dari permintaan POST
    $paymentMethod = $_POST['payment_method'];

    // Ambil data dari tabel keranjang
    $queryCart = "SELECT * FROM keranjang";
    $resultCart = $conn->query($queryCart);

    // Insert data ke tabel transactions
    while ($row = $resultCart->fetch_assoc()) {
        $queryTrans = "INSERT INTO transactions (item, harga, quantity, total_harga, payment_method) VALUES (?, ?, ?, ?, ?)";
        $stmtTrans = $conn->prepare($queryTrans);
        $stmtTrans->bind_param('sdiss', $row['item'], $row['harga'], $row['quantity'], $row['total_harga'], $paymentMethod);
        $stmtTrans->execute();
    }

    // Kosongkan tabel keranjang
    $queryClearCart = "DELETE FROM keranjang";
    $conn->query($queryClearCart);

    // Commit transaksi
    $conn->commit();

    $response = array('success' => true);
    echo json_encode($response);
} catch (Exception $e) {
    $conn->rollback();
    $response = array('success' => false, 'error' => $e->getMessage());
    echo json_encode($response);
}

$conn->close();
?>
