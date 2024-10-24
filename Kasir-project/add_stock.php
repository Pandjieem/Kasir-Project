<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

include 'ayamgoreng.php';


$sql = "SELECT id, name, price, profit_margin, stock FROM products";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_stock'])) {
    $product_id = $_POST['product_id'];
    $add_stock = $_POST['add_stock']; 

    $sql_update_stock = "UPDATE products SET stock = stock + ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update_stock);
    $stmt_update->bind_param("ii", $add_stock, $product_id);

    if ($stmt_update->execute()) {
        $message = "Stok berhasil diperbarui!";
    } else {
        $message = "Error: " . $stmt_update->error;
    }

    $stmt_update->close();
}
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
    <style>
        table tr td{
            padding: -20px;
        }
    </style>
<div class="navbar">
    <a href="admin_dashboard.php" class="header">Dashboard</a>
    <a href="status_pembelian_admin.php" class="header">Status Pembelian</a>
    <a href="add_product.php" class="header">Tambah Produk</a>
    <a href="add_stock.php" class="header ">Tambah Stok</a>
    <a href="report_profit.php" class="header">Status Penjualan</a>
    <a href="logout.php" class="header">Logout</a>
</div>

<div class="wrapperrumah">
    <h2>Selamat datang, <?php echo $_SESSION['username']; ?>!</h2> 

    <h3>Daftar Produk</h3>

    <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <table border="1">
        <tr>
            <th>ID Produk</th>
            <th>Nama Produk</th>
            <th>Harga (Rp)</th>
            <th>Kenaikan Harga Keuntungan (%)</th>
            <th>Stok</th>
            <th>Tambah Stok</th> 
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "
                <tr id='tabelstock'>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>Rp" . number_format($row['price'], 2) . "</td>
                    <td>" . number_format($row['profit_margin'], 2) . "%</td>
                    <td>" . $row['stock'] . "</td>
                    <td>
                        <form method='POST' action=''>
                            <input type='hidden' name='product_id' value='" . $row['id'] . "'>
                            <input type='number' name='add_stock' min='1' required>
                            <input type='submit' name='update_stock' value='Tambah' class='tombolpanji'>
                        </form>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Tidak ada produk</td></tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
