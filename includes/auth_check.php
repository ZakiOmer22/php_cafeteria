<?php
session_start();

if (!isset($_SESSION['user']) || empty($_SESSION['user']['username'])) {
    header('Location: ../pages/login.php');
    exit();
}
