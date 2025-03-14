<?php
$PROTOCOL = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$ROOT = $PROTOCOL . "://" . $_SERVER['HTTP_HOST'];
session_start();
require $_SERVER['DOCUMENT_ROOT'].'/config/db.php';

if ($_SESSION['role'] !== "user") {
    header("Location: $ROOT/pages/index.php");
    exit();
}

$username = $_SESSION['username'];

// Ambil daftar ajuan berdasarkan user
$stmt = $conn->prepare("SELECT kode_anggaran, nama_kegiatan, tanggal, jumlah, keterangan, status, response FROM anggaran WHERE user_anggaran = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$pending = [];
$completed = [];

while ($row = $result->fetch_assoc()) {
    if ($row['status'] === 'pending') {
        $pending[] = $row;
    } else {
        $completed[] = $row;
    }
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Ajuan</title>
    <link rel="stylesheet" href="/styles/dashboard.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="daftar-container">
        <h2>Daftar Ajuan Anggaran</h2>

        <?php if (isset($_GET['success'])): ?>
            <p class="success"><?= $_GET['success']; ?></p>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <p class="error"><?= $_GET['error']; ?></p>
        <?php endif; ?>

        <!-- Tabel Ajuan Pending -->
        <h3><i class="fa-solid fa-hourglass-half"></i> Ajuan Pending</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Kegiatan</th>
                        <th>Tanggal</th>
                        <th>Jumlah (IDR)</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pending)) : ?>
                        <tr><td colspan="6">Tidak ada ajuan pending.</td></tr>
                    <?php else : ?>
                        <?php foreach ($pending as $row) : ?>
                            <tr>
                                <td><?= $row['kode_anggaran']; ?></td>
                                <td><?= $row['nama_kegiatan']; ?></td>
                                <td><?= $row['tanggal']; ?></td>
                                <td><?= number_format($row['jumlah'], 2, ',', '.'); ?></td>
                                <td><?= $row['keterangan']; ?></td>
                                <td>
                                    <a href="edit_ajuan.php?kode=<?= $row['kode_anggaran']; ?>" class="btn btn-small btn-caution"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                    <a href="hapus_ajuan.php?kode=<?= $row['kode_anggaran']; ?>" class="btn btn-small btn-danger" onclick="return confirm('Yakin ingin menghapus?')"><i class="fa-solid fa-trash"></i> Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Tabel Ajuan Approved / Rejected -->
        <h3><i class="fa-solid fa-star"></i> Ajuan Approved / Rejected</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Kegiatan</th>
                        <th>Tanggal</th>
                        <th>Jumlah (IDR)</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th>Response</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($completed)) : ?>
                        <tr><td colspan="7">Tidak ada ajuan yang disetujui atau ditolak.</td></tr>
                    <?php else : ?>
                        <?php foreach ($completed as $row) : ?>
                            <tr>
                                <td><?= $row['kode_anggaran']; ?></td>
                                <td><?= $row['nama_kegiatan']; ?></td>
                                <td><?= $row['tanggal']; ?></td>
                                <td><?= number_format($row['jumlah'], 2, ',', '.'); ?></td>
                                <td><?= $row['keterangan']; ?></td>
                                <td class="<?= ($row['status'] === 'approved') ? 'approved' : 'rejected'; ?>">
                                    <?= ucfirst($row['status']); ?>
                                </td>
                                <td><?= $row['response']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <a href="dashboard.php" class="btn btn-back btn-danger"><i class="fa-solid fa-caret-left"></i> Kembali</a>
    </div>
</body>
</html>