<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

include 'ayamgoreng.php';

// Mengambil daftar produk dan menghitung total keuntungan
$sql = "SELECT pr.id, pr.name, pr.price, pr.profit_margin, 
               COALESCE(SUM(ph.quantity), 0) AS total_quantity,
               COALESCE(SUM(ph.quantity * pr.price), 0) AS total_sold,
               COALESCE(SUM(ph.quantity * (pr.price * (pr.profit_margin / 100))), 0) AS total_profit
        FROM products pr
        LEFT JOIN purchase_history ph ON pr.id = ph.product_id
        GROUP BY pr.id";

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
    <title>Laporan Keuntungan</title>
    <link rel="stylesheet" href="gado-gado.css">
</head>
<body>
<div class="navbar">
    <a href="admin_dashboard.php" class="header">Dashboard</a>
    <a href="status_pembelian_admin.php" class="header">Status Pembelian</a>
    <a href="add_product.php" class="header">Tambah Produk</a>
    <a href="add_stock.php" class="header">Tambah Stok</a>
    <a href="report_profit.php" class="header">Status Penjualan</a>
    <a href="logout.php" class="header">Logout</a>
</div>

<div class="wrapperrumah">
    <h2>Laporan Keuntungan</h2>

    <table border="1">
        <tr>
            <th>ID Produk</th>
            <th>Nama Produk</th>
            <th>Harga (Rp)</th>
            <th>Kenaikan Harga Keuntungan (%)</th>
            <th>Total Terjual (Rp)</th>
            <th>Total Kuantitas Terjual</th>
            <th>Total Keuntungan (Rp)</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "
                <tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>Rp" . number_format($row['price'], 2) . "</td>
                    <td>" . number_format($row['profit_margin'], 2) . "%</td>
                    <td>Rp" . number_format($row['total_sold'], 2) . "</td>
                    <td>" . $row['total_quantity'] . "</td>
                    <td>Rp" . number_format($row['total_profit'], 2) . "</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Tidak ada data keuntungan</td></tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
