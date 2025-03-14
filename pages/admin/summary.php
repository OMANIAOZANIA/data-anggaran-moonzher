<?php
$ROOT = "https://".$_SERVER['HTTP_HOST'];
session_start();
date_default_timezone_set('Asia/Jakarta');
require $_SERVER['DOCUMENT_ROOT'].'/config/db.php';

if ($_SESSION['role'] !== "admin") {
    header("Location: $ROOT/pages/index.php");
    exit();
}

// Query: Total submitted budget (all ajuan)
$query_total = "SELECT SUM(jumlah) AS total_diajukan FROM anggaran";
$result_total = $conn->query($query_total);
$total_diajukan = $result_total->fetch_assoc()['total_diajukan'] ?? 0;

// Query: Total approved budget
$query_approved = "SELECT SUM(jumlah) AS total_approved FROM anggaran WHERE status = 'approved'";
$result_approved = $conn->query($query_approved);
$total_approved = $result_approved->fetch_assoc()['total_approved'] ?? 0;

// Query: Fetch all budget submissions
$query_list = "SELECT kode_anggaran, nama_kegiatan, tanggal, jumlah, status FROM anggaran ORDER BY tanggal DESC";
$result_list = $conn->query($query_list);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Ringkasan Anggaran</title>
    <link rel="stylesheet" href="/styles/dashboard.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container summary-container">
        <h2><i class="fa-solid fa-list-check"></i> Ringkasan Anggaran</h2>

        <div class="summary">
            <div class="card total-diajukan">
                <h3 class="no-margin-top">Total Anggaran Diajukan</h3>
                <p>IDR <?= number_format($total_diajukan, 2, ',', '.'); ?></p>
            </div>
            <div class="card total-approved">
                <h3 class="no-margin-top">Total Anggaran Disetujui</h3>
                <p>IDR <?= number_format($total_approved, 2, ',', '.'); ?></p>
            </div>
        </div>

        <h2><i class="fa-solid fa-list"></i> Daftar Ajuan Anggaran</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Kode Anggaran</th>
                        <th>Nama Kegiatan</th>
                        <th>Tanggal</th>
                        <th>Jumlah (IDR)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_list->fetch_assoc()) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['kode_anggaran']); ?></td>
                            <td><?= htmlspecialchars($row['nama_kegiatan']); ?></td>
                            <td><?= date('d M Y', strtotime($row['tanggal'])); ?></td>
                            <td><?= number_format($row['jumlah'], 2, ',', '.'); ?></td>
                            <td class="<?= $row['status']; ?>"><?= ucfirst($row['status']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <a href="dashboard.php" class="btn btn-back btn-danger"><i class="fa-solid fa-caret-left"></i> Kembali</a>
    </div>
</body>
</html>
