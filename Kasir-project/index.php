<?php
include 'ayamgoreng.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $admin_username = 'admin';
    $admin_password = 'admin#123';  

    if ($username == $admin_username && $password == $admin_password) {
        $_SESSION['role'] = 'admin';
        $_SESSION['username'] = $username;
        header('Location: admin_dashboard.php');
        exit();
    } else {

        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['role'] = 'user';
                $_SESSION['username'] = $username;
                header('Location: buy.php');
                exit();
            } else {
                echo "Password salah!";
            }
        } else {
            echo "Username tidak ditemukan!";
        }
    }
}
?>



<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="gado-gado.css">
    <title>Login</title>
</head>
<body>
    
    <form method="POST">
        <div class="inputpanji">
        <h1>Login</h1>
        <input type="text" name="username" placeholder="Username" class="nasipanji" required><br>
        <input type="password" name="password" placeholder="Password" class="ayampanji" required><br>
        <button type="submit" class="icikiwir">Login</button>
    </form>
    <p>Belum punya akun? <a href="register.php" id="daftar-panji">Daftar di sini</a></p>
    </div>
</body>
</html>
