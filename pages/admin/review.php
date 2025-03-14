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

// Ambil semua ajuan dari database
$sql = "SELECT * FROM anggaran ORDER BY tanggal DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Review Ajuan</title>
    <link rel="stylesheet" href="/styles/dashboard.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body>

<div class="container daftar-container">
    <h1>Review Ajuan Anggaran</h1>

    <?php if (isset($_GET['success'])) { echo "<p class='success'>" . $_GET['success'] . "</p>"; } ?>
    <?php if (isset($_GET['error'])) { echo "<p class='error'>" . $_GET['error'] . "</p>"; } ?>

    <div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>User</th>
                <th>Nama Kegiatan</th>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <?php while ($row = $result->fetch_assoc()) { ?>
        <tbody>
            <tr>
                <td><?php echo $row['kode_anggaran']; ?></td>
                <td><?php echo $row['user_anggaran']; ?></td>
                <td><?php echo $row['nama_kegiatan']; ?></td>
                <td><?php echo $row['tanggal']; ?></td>
                <td>Rp <?php echo number_format($row['jumlah'], 2, ',', '.'); ?></td>
                <td><?php echo $row['keterangan']; ?></td>
                <td class="<?= $row['status']; ?>"><?= ucfirst($row['status']); ?></td>
                <td>
                    <?php if ($row['status'] == 'pending') { ?>
                        <a href="response.php?kode_anggaran=<?php echo $row['kode_anggaran']; ?>" class="btn btn-medium btn-caution"><i class="fa-solid fa-magnifying-glass"></i>  Review</a>
                    <?php } else { ?>
                        <a href="details.php?kode_anggaran=<?php echo $row['kode_anggaran']; ?>" class="btn btn-medium"><i class="fa-solid fa-circle-info"></i>  Details</a>
                    <?php } ?>
                </td>
            </tr>
        </tbody>
        <?php } ?>
    </table>
    </div>
    
    <a href="dashboard.php" class="btn btn-back btn-danger"><i class="fa-solid fa-caret-left"></i> Kembali</a>
</div>

</body>
</html>
