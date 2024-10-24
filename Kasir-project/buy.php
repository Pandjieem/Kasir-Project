<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header('Location: index.php');
    exit();
}

include 'ayamgoreng.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['buy_product'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];


    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product && $product['stock'] >= $quantity) {
        $total_price = $quantity * $product['price']; // ngitung total harga
        $new_stock = $product['stock'] - $quantity;   // update tok setelah dibeli

        // update stok di database
        if ($new_stock <= 0) {
            // kalau stok habis bakal di tambah 50
            $new_stock = 50;
        }

        $sql_update = "UPDATE products SET stock = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ii", $new_stock, $product_id);

        if ($stmt_update->execute()) {
           
            $sql_history = "INSERT INTO purchase_history (username, product_id, product_name, quantity, total_price) 
                            VALUES (?, ?, ?, ?, ?)";
            $stmt_history = $conn->prepare($sql_history);
            $stmt_history->bind_param("sisid", $_SESSION['username'], $product_id, $product['name'], $quantity, $total_price);
            $stmt_history->execute();


            echo "<div id='berhasilbeli'><p>Pembelian berhasil! Total harga: Rp" . number_format($total_price, 2) . "</p>"; echo'</div>';
        } else {
            echo "Error: " . $stmt_update->error;
        }
    } else {
        echo "Stok tidak cukup!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="gado-gado.css">
    <title>Beli Produk - Kasir</title>
</head>
<body>

<div class="navbar">
    <a href="buy.php" class="header">Produk</a>
    <a href="status_pembelian.php" class="header">Status</a>
    <a href="logout.php" class="header">Logout</a>
</div>

<div class="wrapperrumah">
    <h2>Selamat datang, <?php echo $_SESSION['username']; ?>!</h2>

    <h3>Beli Produk</h3>
    <form method="POST">
        <select name="product_id" class="inputrumah" required>
            <option value="">Pilih Produk</option>
            <?php
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . " - Stok: " . $row['stock'] . "</option>";
                }
            }
            ?>
        </select><br>
        <input type="number" name="quantity" placeholder="Jumlah" class="inputrumah" required><br>
        <input type="hidden" name="buy_product">
        <button type="submit" class="tombolpanji">Beli</button>
    </form>
</div>

<h3 class="tengahwir">Daftar Produk</h3>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Harga</th>
        <th>Stok</th>
    </tr>
    <?php
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "
            <tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['name'] . "</td>
                <td>Rp" . number_format($row['price'], 2) . "</td>
                <td>" . $row['stock'] . "</td>
            </tr>
            ";
        }
    } else {
        echo "<tr><td colspan='4'>Tidak ada produk</td></tr>";
    }
    ?>
</table>
</body>
</html>
