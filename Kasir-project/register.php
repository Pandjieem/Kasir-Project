<?php
include 'ayamgoreng.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    if ($conn->query($sql) === TRUE) {
        header('Location: index.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="gado-gado.css">
    <title>Register</title>
</head>
<body>
<div class="inputpanji">
    <h2>Register</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" class="nasipanji" required><br>
        <input type="password" name="password" placeholder="Password" class="ayampanji" required><br>
        <button type="submit" class="icikiwir">Register</button>
        <p>Sudah punya akun? <a href="index.php" id="daftar-panji">Login</a></p>
    </form></div>
</body>
</html>
