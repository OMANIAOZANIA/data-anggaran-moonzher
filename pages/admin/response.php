<?php
$PROTOCOL = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$ROOT = $PROTOCOL . "://" . $_SERVER['HTTP_HOST'];
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

$stmt = $conn->prepare("SELECT * FROM anggaran WHERE kode_anggaran = ?");
$stmt->bind_param("s", $kode_anggaran);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Ajuan tidak ditemukan.");
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Response Ajuan</title>
    <link rel="stylesheet" href="/styles/dashboard.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <h2>Response Ajuan</h2>
        <label for="response">Detail Ajuan:</label>
        <div class="table-container">
            <table class="table">
                <tr><th><i class="fa-solid fa-hashtag"></i> Kode Anggaran</th><td><?php echo htmlspecialchars($row['kode_anggaran']); ?></td></tr>
                <tr><th><i class="fa-solid fa-user"></i> Nama User</th><td><?php echo htmlspecialchars($row['user_anggaran']); ?></td></tr>
                <tr><th><i class="fa-solid fa-cubes-stacked"></i> Nama Kegiatan</th><td><?php echo htmlspecialchars($row['nama_kegiatan']); ?></td></tr>
                <tr><th><i class="fa-solid fa-calendar"></i> Tanggal</th><td><?php echo htmlspecialchars($row['tanggal']); ?></td></tr>
                <tr><th><i class="fa-solid fa-money-bill"></i> Jumlah</th><td><?php echo number_format($row['jumlah'], 2, ',', '.'); ?></td></tr>
                <tr><th><i class="fa-solid fa-circle-info"></i> Keterangan</th><td><?php echo nl2br(htmlspecialchars($row['keterangan'])); ?></td></tr>
            </table>
        </div>

        <form action="process_admin.php" method="POST">
            <input type="hidden" name="kode_anggaran" value="<?php echo $kode_anggaran; ?>">

            <label for="response">Response:</label>
            <textarea name="response" id="response" required></textarea>

            <button type="submit" name="approve" class="btn btn-approve"><i class="fa-solid fa-check"></i> Approve</button>
            <button type="submit" name="reject" class="btn btn-reject"><i class="fa-solid fa-xmark"></i> Reject</button>
        </form>
        <br>
        <a href="review.php" class="btn btn-back btn-danger"><i class="fa-solid fa-caret-left"></i> Kembali</a>
    </div>
</body>
</html>
