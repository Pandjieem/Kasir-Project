<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

include 'ayamgoreng.php';


$sql = "SELECT id, name, price, profit_margin FROM products";
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
    <title>Admin Dashboard</title>
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
    <h2>Selamat datang, <?php echo $_SESSION['username']; ?>!</h2> 

    <h3>Daftar Produk</h3>
    <table border="1">
        <tr>
            <th>ID Produk</th>
            <th>Nama Produk</th>
            <th>Harga (Rp)</th>
            <th>Kenaikan Harga Keuntungan (%)</th>
            <th>Keuntungan (Rp)</th> 
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // ngitung keuntungan presentase
                $profit = $row['price'] * ($row['profit_margin'] / 100);
                echo "
                <tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>Rp" . number_format($row['price'], 2) . "</td>
                    <td>" . number_format($row['profit_margin'], 2) . "%</td>
                    <td>Rp" . number_format($profit, 2) . "</td> <!-- Menampilkan keuntungan -->
                </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Tidak ada produk</td></tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
