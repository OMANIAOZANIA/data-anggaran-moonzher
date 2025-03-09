<?php
$ROOT = "https://".$_SERVER['HTTP_HOST'];
session_start();
if (!isset($_SESSION['username'])) {
    // balik ke login.php kalo belom ada sesi
    header("Location: $ROOT/login.php");
    exit();
} else {
    if ($_SESSION['role'] === "admin") {
        header("Location: $ROOT/pages/admin/index.php");
    } elseif ($_SESSION['role'] === "user") {
        header("Location: $ROOT/pages/user/index.php");
    } else {
        header("Location: $ROOT/login.php");
    }
    exit();
}
?>
