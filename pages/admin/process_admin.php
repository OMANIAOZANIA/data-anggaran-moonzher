<?php
$ROOT = "http://".$_SERVER['HTTP_HOST']."/data-anggaran";
session_start();
date_default_timezone_set('Asia/Jakarta');
require $_SERVER['DOCUMENT_ROOT'].'/data-anggaran/config/db.php';

if ($_SESSION['role'] !== "admin") {
    header("Location: $ROOT/pages/index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $kode_anggaran = $_POST['kode_anggaran'];
    $response = trim($_POST['response']);

    if (empty($response)) {
        header("Location: response.php?kode_anggaran=$kode_anggaran&error=Response tidak boleh kosong.");
        exit();
    }

    if (isset($_POST['approve'])) {
        $status = "approved";
    } elseif (isset($_POST['reject'])) {
        $status = "rejected";
    } else {
        header("Location: admin.php?error=Terjadi kesalahan.");
        exit();
    }

    $stmt = $conn->prepare("UPDATE anggaran SET status=?, response=? WHERE kode_anggaran=?");
    $stmt->bind_param("sss", $status, $response, $kode_anggaran);

    if ($stmt->execute()) {
        header("Location: admin.php?success=Ajuan berhasil diperbarui.");
    } else {
        header("Location: admin.php?error=Gagal memperbarui ajuan.");
    }
    exit();
}
?>
