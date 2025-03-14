<?php
$PROTOCOL = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$ROOT = $PROTOCOL . "://" . $_SERVER['HTTP_HOST'];
session_start();
date_default_timezone_set('Asia/Jakarta');

if ($_SESSION['role'] !== "user") {
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="dashboard-container">
        <h1><?php echo $greeting; ?></h1>
        <p class="time"><?php echo $time_now; ?></p>
        <a href="ajuan.php" class="btn btn-dashboard"><i class="fa-solid fa-plus"></i> Ajukan Anggaran</a>
        <a href="daftar.php" class="btn btn-dashboard"><i class="fa-solid fa-list"></i> Daftar Ajuan</a>
        <form method="POST">
            <button type="submit" name="logout" class="btn btn-logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
        </form>
    </div>
</body>
</html>