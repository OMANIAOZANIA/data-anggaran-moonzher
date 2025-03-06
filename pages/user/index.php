<?php
$ROOT = "http://".$_SERVER['HTTP_HOST']."/data-anggaran";
session_start();
if ($_SESSION['role'] === "user") {
    // balik ke login.php kalo belom ada sesi
    header("Location: ./dashboard.php");
    exit();
} else {
    header("Location: $ROOT/login.php");
    exit();
}
?>
