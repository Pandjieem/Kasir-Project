<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

include 'ayamgoreng.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $base_price = $_POST['price'];  
    $profit_margin = $_POST['profit_margin'];

 
    $final_price = $base_price + ($base_price * ($profit_margin / 100));


    $sql = "INSERT INTO products (name, price, profit_margin) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdi", $name, $final_price, $profit_margin);

    if ($stmt->execute()) {
        $message = "Produk berhasil ditambahkan!";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
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
    <title>Tambah Produk</title>
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
    <h2>Tambah Produk</h2>

    <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="name">Nama Produk:</label>
        <input type="text" name="name" required>

        <label for="price">Harga Dasar:</label>
        <input type="number" name="price" step="0.01" required>

        <label for="profit_margin">Kenaikan Harga Keuntungan (%):</label>
        <input type="number" name="profit_margin" step="0.01" required>

        <input type="submit" name="add_product" class="tombolpanji" value="Tambah Produk">
    </form>
</div>
</body>
</html>
