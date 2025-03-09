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
    <title>Admin - Detail Ajuan</title>
    <link rel="stylesheet" href="/styles/dashboard.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <h2>Detail Ajuan</h2>
        <div class="table-container">
            <table class="table">
                <tr><th><i class="fa-solid fa-hashtag"></i> Kode Anggaran</th><td><?php echo htmlspecialchars($row['kode_anggaran']); ?></td></tr>
                <tr><th><i class="fa-solid fa-user"></i> Nama User</th><td><?php echo htmlspecialchars($row['user_anggaran']); ?></td></tr>
                <tr><th><i class="fa-solid fa-cubes-stacked"></i> Nama Kegiatan</th><td><?php echo htmlspecialchars($row['nama_kegiatan']); ?></td></tr>
                <tr><th><i class="fa-solid fa-calendar"></i> Tanggal</th><td><?php echo htmlspecialchars($row['tanggal']); ?></td></tr>
                <tr><th><i class="fa-solid fa-money-bill"></i> Jumlah</th><td><?php echo number_format($row['jumlah'], 2, ',', '.'); ?></td></tr>
                <tr><th><i class="fa-solid fa-circle-info"></i> Keterangan</th><td><?php echo nl2br(htmlspecialchars($row['keterangan'])); ?></td></tr>
                <tr><th><i class="fa-solid fa-circle-check"></i> Status</th><td class="<?= ($row['status'] === 'approved') ? 'approved' : 'rejected'; ?>">
                    <?= ucfirst($row['status']); ?>
                </td></tr>
                <tr><th><i class="fa-solid fa-reply"></i> Response</th><td><?php echo nl2br(htmlspecialchars($row['response'])); ?></td></tr>
            </table>
        </div>
        <a href="review.php" class="btn btn-danger"><i class="fa-solid fa-caret-left"></i> Kembali</a>
    </div>
</body>
</html>
