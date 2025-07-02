<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header("Location: pages/login.php");
    exit();
}

header("Location: pages/dashboard.php");
exit();
?>