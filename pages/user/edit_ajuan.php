<?php
$ROOT = "https://".$_SERVER['HTTP_HOST'];
session_start();
require $_SERVER['DOCUMENT_ROOT'].'/config/db.php';

if ($_SESSION['role'] !== "user") {
    header("Location: ../index.php");
    exit();
}

if (!isset($_GET['kode'])) {
    header("Location: daftar.php");
    exit();
}

$kode = $_GET['kode'];
$username = $_SESSION['username'];

// Cek apakah ajuan masih pending
$stmt = $conn->prepare("SELECT * FROM anggaran WHERE kode_anggaran = ? AND user_anggaran = ?");
$stmt->bind_param("ss", $kode, $username);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    header("Location: daftar.php?error=Ajuan tidak ditemukan.");
    exit();
}

if ($data['status'] !== 'pending') {
    header("Location: daftar.php?error=Ajuan yang sudah diproses tidak dapat diedit.");
    exit();
}

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_kegiatan = $_POST['nama_kegiatan'];
    $tanggal = $_POST['tanggal'];
    $jumlah = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];

    $stmt = $conn->prepare("UPDATE anggaran SET nama_kegiatan = ?, tanggal = ?, jumlah = ?, keterangan = ? WHERE kode_anggaran = ?");
    $stmt->bind_param("ssdss", $nama_kegiatan, $tanggal, $jumlah, $keterangan, $kode);

    if ($stmt->execute()) {
        header("Location: daftar.php?success=Ajuan berhasil diperbarui.");
        exit();
    } else {
        header("Location: daftar.php?error=Gagal memperbarui ajuan.");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ajuan</title>
    <link rel="stylesheet" href="/styles/dashboard.css">
</head>
<body>
    <div class="container">
        <h2>Edit Ajuan</h2>
        <form method="POST">
            <div class="form-group">
                <label>Nama Kegiatan:</label>
                <input type="text" name="nama_kegiatan" value="<?= $data['nama_kegiatan']; ?>" required>
            </div>
            <div class="form-group">
                <label>Tanggal:</label>
                <input type="date" name="tanggal" value="<?= $data['tanggal']; ?>" required>
            </div>
            <div class="form-group">
                <label>Jumlah (IDR):</label>
                <input type="number" name="jumlah" value="<?= $data['jumlah']; ?>" step="0.01" required>
            </div>
            <div class="form-group">
                <label>Keterangan:</label>
                <textarea name="keterangan"><?= $data['keterangan']; ?></textarea>
            </div>
            <button type="submit" class="btn">Simpan</button>
            <a href="daftar.php" class="btn btn-danger">Batal</a>
        </form>
    </div>
</body>
</html>
