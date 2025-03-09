<?php
$ROOT = "https://".$_SERVER['HTTP_HOST'];
session_start();
date_default_timezone_set('Asia/Jakarta');
require $_SERVER['DOCUMENT_ROOT'].'/config/db.php';

if ($_SESSION['role'] !== "user") {
    header("Location: $ROOT/pages/index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode_anggaran = "AGR-" . uniqid(); // Generate unique code
    $user_anggaran = $_SESSION['username']; // Get logged-in user
    $nama_kegiatan = $_POST['nama_kegiatan'] ?? '';
    $tanggal = $_POST['tanggal'] ?? date('Y-m-d');
    $jumlah = $_POST['jumlah'] ?? 0;
    $keterangan = $_POST['keterangan'] ?? '';
    $status = 'pending';
    $response = 'Menunggu balasan Administrator.';

    $stmt = $conn->prepare("INSERT INTO anggaran (kode_anggaran, user_anggaran, nama_kegiatan, tanggal, jumlah, keterangan, status, response) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssisss", $kode_anggaran, $user_anggaran, $nama_kegiatan, $tanggal, $jumlah, $keterangan, $status, $response);

    if ($stmt->execute()) {
        $success = "Ajuan berhasil dikirim.";
    } else {
        $error = "Terjadi kesalahan. Silakan coba lagi.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Anggaran</title>
    <link rel="stylesheet" href="/styles/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Ajukan Anggaran</h1>
        <?php if (isset($success)) { echo "<p class='success'>$success</p>"; } ?>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form method="POST">
            <div class="form-group">
                <label for="nama_kegiatan">Nama Kegiatan:</label>
                <input type="text" id="nama_kegiatan" name="nama_kegiatan" required>
            </div>
            <div class="form-group">
                <label for="tanggal">Tanggal:</label>
                <input type="date" id="tanggal" name="tanggal" required>
            </div>
            <div class="form-group">
                <label>Jumlah (IDR):</label>
                <input type="text" id="jumlah" name="jumlah_formatted" required>
                <input type="hidden" id="jumlah_real" name="jumlah">
            </div>
            <div class="form-group">
                <label for="keterangan">Keterangan:</label>
                <textarea id="keterangan" name="keterangan"></textarea>
            </div>
            <button type="submit" class="btn">Ajukan</button>
        </form>
        <script>
            document.getElementById('jumlah').addEventListener('input', function (e) {
                let rawValue = e.target.value.replace(/\D/g, '');
                e.target.value = new Intl.NumberFormat('id-ID').format(rawValue);
                document.getElementById('jumlah_real').value = rawValue;
            });
        </script>
        <a href="dashboard.php" class="btn btn-danger">Kembali</a>
    </div>
</body>
</html>