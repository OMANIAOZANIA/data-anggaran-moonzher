<?php
$PROTOCOL = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$ROOT = $PROTOCOL . "://" . $_SERVER['HTTP_HOST'];
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
