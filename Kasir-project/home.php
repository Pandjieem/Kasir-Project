<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

include 'ayamgoreng.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $sql = "INSERT INTO products (name, price, stock) VALUES ('$name', '$price', '$stock')";
    if ($conn->query($sql) === TRUE) {
        echo "Produk berhasil ditambahkan!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_stock'])) {
    $product_id = $_POST['product_id'];
    $additional_stock = $_POST['additional_stock'];


    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc();

    if ($product) {
        $new_stock = $product['stock'] + $additional_stock;

    
        $sql = "UPDATE products SET stock = $new_stock WHERE id = $product_id";
        if ($conn->query($sql) === TRUE) {
            echo "<p id='panji'>Stok berhasil ditambah! Stok baru : " . $new_stock; echo" </p>";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Produk tidak ditemukan!";
    }
}


$sql = "SELECT * FROM products";
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
    <title>Kasir</title>
    <link rel="stylesheet" href="gado-gado.css">
</head>
<body>
<div class="navbar">
    <a href="buy.php" class="header">Produk</a>
    <a href="status_pembelian.php" class="header">Status</a>
    <a href="logout.php" class="header">Logout</a>
</div>

  <div class="wrapperrumah">
    <h2>Selamat datang, <?php echo $_SESSION['username']; ?>!</h2> 

    <h3>Tambah Produk</h3>
    <form method="POST">
        <input type="hidden" name="add_product">
        <input type="text" name="name" placeholder="Nama Produk" class="inputrumah nama buyinput" required><br>
        <input type="number" name="price" placeholder="Harga" class="inputrumah harga buyinput" required><br>
        <input type="number" name="stock" placeholder="Stok" class="inputrumah stok buyinput" required><br>
        <button type="submit" class="tombolpanji">Tambah</button>
    </form>
    </div>
    
    <h3 id="ngantuk">Daftar Produk</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Tambah Stok</th>
        </tr>
         <!-- <div class="kembali">kembali</div> keatas page  -->
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "
                <div class='tables'>
                <tbody>
                <tr>
                        <td>" . $row['id'] . "</td>
                        <td>" . $row['name'] . "</td>
                        <td>Rp" . number_format($row['price'], 2) . "</td>
                        <td>" . $row['stock'] . "</td>
                        <td>
                            <form method='POST' style='display: inline;'>
                                <input type='hidden' name='product_id' value='" . $row['id'] . "'>
                                <input type='number' name='additional_stock' placeholder='Tambah Stok' id='stokss' required>
                                <input type='hidden' class='stoks' name='update_stock' ' >
                                <button type='submit' class='tombolpanji'>Tambah</button>
                            </form>
                        </td>
                      </tr>
                      </div>
                      </tbody>";
                      
            }
        } else {
            echo "<tr><td colspan='5'>Tidak ada produk</td></tr>";
        }
        ?>
    </table>
    </div>
</body>
</html>

