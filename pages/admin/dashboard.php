<?php
$ROOT = "https://".$_SERVER['HTTP_HOST'];
session_start();
date_default_timezone_set('Asia/Jakarta');

if ($_SESSION['role'] !== "admin") {
    header("Location: $ROOT/pages/index.php");
    exit();
}

$username = $_SESSION['nama'];
$greeting = "Hello, $username!";
$time_now = date('l, d F Y - H:i:s');

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: $ROOT/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="/styles/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <h1><?php echo $greeting; ?></h1>
        <p class="time"><?php echo $time_now; ?></p>
        <a href="review.php" class="btn">Review Ajuan</a>
        <a href="daftar.php" class="btn">Rekapitulasi Dana</a>
        <form method="POST">
            <button type="submit" name="logout" class="btn btn-logout">Logout</button>
        </form>
    </div>
</body>
</html>