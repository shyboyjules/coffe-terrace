<?php
session_start();
include(__DIR__ . '/../dB/config.php');

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    $_SESSION['message'] = "Login to access the dashboard!";
    $_SESSION['code'] = "warning";
    header("Location: ../../login.php");
    exit();
}

// 🚨 Prevent normal users from accessing admin pages
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../../view/users/index.php");
    exit();
}
?>
