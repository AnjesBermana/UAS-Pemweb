<?php
include 'koneksi/koneksi.php';
session_start();

// Fungsi untuk mendeteksi browser
function getBrowser($userAgent) {
    $browsers = [
        'Edg' => 'Microsoft Edge',
        'Edge' => 'Microsoft Edge',
        'Chrome' => 'Google Chrome',
        'Firefox' => 'Mozilla Firefox',
        'Safari' => 'Safari',
    ];

    foreach ($browsers as $key => $browserName) {
        if (strpos($userAgent, $key) !== false) {
            return $browserName;
        }
    }

    return 'Browser Tidak Dikenali';
}

// Fungsi untuk mendapatkan IP Address
function getUserIp() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipArray = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        return trim($ipArray[0]);
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

if (isset($_SESSION['username'])) {
    header('Location: tampilan.php');
    exit();
}

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        if ($password == $data['password']) {
            // Deteksi IP dan Browser
            $ip_address = getUserIp();
            $browser_info = getBrowser($_SERVER['HTTP_USER_AGENT']);

            // Simpan IP dan browser ke database
            $update_sql = "UPDATE users SET ip_address='$ip_address', browser_info='$browser_info' WHERE username='$username'";
            mysqli_query($conn, $update_sql);

            // Set session dan redirect
            $_SESSION['username'] = $data['username'];
            header('Location: tampilan.php');
            exit();
        } else {
            header('Location: login.php?error=Password salah!');
            exit();
        }
    } else {
        header('Location: login.php?error=Username tidak ditemukan!');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/style_login.css">
</head>
<body>
    <div class="stars"></div>
    <div class="form-container">
        <form method="post">
            <h3>Login Here</h3>
            <?php
            if (isset($_GET['error'])) {
                echo "<div class='error'>" . htmlspecialchars($_GET['error']) . "</div>";
            }
            ?>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            <button type="submit" name="submit">Log In</button>
        </form>
    </div>
</body>
</html>