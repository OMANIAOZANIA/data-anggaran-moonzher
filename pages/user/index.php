<?php
$ROOT = "https://".$_SERVER['HTTP_HOST'];
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
