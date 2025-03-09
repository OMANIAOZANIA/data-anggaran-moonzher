<?php
$ROOT = "https://".$_SERVER['HTTP_HOST'];
session_start();
date_default_timezone_set('Asia/Jakarta');
require $_SERVER['DOCUMENT_ROOT'].'/config/db.php';

if ($_SESSION['role'] !== "admin") {
    header("Location: $ROOT/pages/index.php");
    exit();
}

// Ambil kode anggaran dari URL
if (!isset($_GET['kode_anggaran'])) {
    header("Location: review.php?error=Ajuan tidak ditemukan.");
    exit();
}

$kode_anggaran = $_GET['kode_anggaran'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Response Ajuan</title>
    <link rel="stylesheet" href="/styles/dashboard.css">
</head>
<body>
    <div class="container">
        <h2>Response Ajuan</h2>
        <form action="process_admin.php" method="POST">
            <input type="hidden" name="kode_anggaran" value="<?php echo $kode_anggaran; ?>">

            <label for="response">Response:</label>
            <textarea name="response" id="response" required></textarea>

            <button type="submit" name="approve" class="btn btn-approve">Approve</button>
            <button type="submit" name="reject" class="btn btn-reject">Reject</button>
        </form>
        <br>
        <a href="review.php" class="btn btn-back btn-danger">Kembali</a>
    </div>
</body>
</html>
