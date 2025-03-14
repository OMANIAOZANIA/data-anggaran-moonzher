<?php
$PROTOCOL = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$ROOT = $PROTOCOL . "://" . $_SERVER['HTTP_HOST'];
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

// Cek apakah ajuan masih pending
$stmt = $conn->prepare("SELECT status FROM anggaran WHERE kode_anggaran = ? AND user_anggaran = ?");
$stmt->bind_param("ss", $kode, $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    header("Location: daftar.php?error=Ajuan tidak ditemukan.");
    exit();
}

if ($row['status'] !== 'pending') {
    header("Location: daftar.php?error=Ajuan yang sudah diproses tidak dapat dihapus.");
    exit();
}

// Hapus ajuan
$stmt = $conn->prepare("DELETE FROM anggaran WHERE kode_anggaran = ?");
$stmt->bind_param("s", $kode);
if ($stmt->execute()) {
    header("Location: daftar.php?success=Ajuan berhasil dihapus.");
} else {
    header("Location: daftar.php?error=Gagal menghapus ajuan.");
}
exit();
