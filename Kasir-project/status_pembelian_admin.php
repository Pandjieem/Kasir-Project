<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

include 'ayamgoreng.php';

// ngambil daftar pembelian
$sql = "SELECT p.id, p.username, p.product_id, p.quantity, p.total_price, p.purchase_date, pr.name AS product_name, pr.price, pr.profit_margin
        FROM purchase_history p
        JOIN products pr ON p.product_id = pr.id";
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
    <a href="admin_dashboard.php" class="header">Dashboard</a>
    <a href="status_pembelian_admin.php" class="header">Status Pembelian</a>
    <a href="add_product.php" class="header">Tambah Produk</a>
    <a href="add_stock.php" class="header ">Tambah Stok</a>
    <a href="report_profit.php" class="header">Status Penjualan</a>
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
            <th>Keuntungan Total</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // ngitung keuntungan total dari produk yang dibeli
                $profit_per_unit = $row['price'] * ($row['profit_margin'] / 100);
                $total_profit = $profit_per_unit * $row['quantity'];

                echo "
                <tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['username'] . "</td>
                    <td>" . $row['product_name'] . "</td>
                    <td>" . $row['quantity'] . "</td>
                    <td>Rp" . number_format($row['total_price'], 2) . "</td>
                    <td>" . date('d-m-Y H:i:s', strtotime($row['purchase_date'])) . "</td>
                    <td>Rp" . number_format($total_profit, 2) . "</td> <!-- Menampilkan keuntungan total -->
                </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Tidak ada riwayat pembelian</td></tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
