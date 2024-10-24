<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

include 'ayamgoreng.php';

// cek role
if ($_SESSION['role'] === 'admin') {
    $sql = "SELECT p.id, p.username, p.product_id, p.quantity, p.total_price, p.purchase_date, pr.name AS product_name
            FROM purchase_history p
            JOIN products pr ON p.product_id = pr.id";
} else {
    $username = $_SESSION['username'];
    $sql = "SELECT p.id, p.product_id, p.quantity, p.total_price, p.purchase_date, pr.name AS product_name
            FROM purchase_history p
            JOIN products pr ON p.product_id = pr.id
            WHERE p.username = '$username'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Kasir">
    <meta name="keywords" content="Kasir, Produk, Penjualan, Pelanggan, HTML, CSS, JavaScript">
    <meta name="author" content="Pandjie">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pembelian</title>
    <link rel="stylesheet" href="gado-gado.css">
</head>
<body>
<div class="navbar">
    <a href="buy.php" class="header">Produk</a>
    <a href="status_pembelian.php" class="header">Status Pembelian</a>
    <a href="logout.php" class="header">Logout</a>
</div>

<div class="wrapperrumah">
    <h2>Status Pembelian</h2>
    
    <table border="1">
        <tr>
            <th>ID Pembelian</th>
            <th>Nama Pengguna</th>
            <th>Nama Produk</th>
            <th>Kuantitas</th>
            <th>Total Harga</th>
            <th>Tanggal Pembelian</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "
                <tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . ($row['username'] ?? $_SESSION['username']) . "</td>
                    <td>" . $row['product_name'] . "</td>
                    <td>" . $row['quantity'] . "</td>
                    <td>Rp" . number_format($row['total_price'], 2) . "</td>
                    <td>" . date('d-m-Y H:i:s', strtotime($row['purchase_date'])) . "</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Tidak ada riwayat pembelian</td></tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
