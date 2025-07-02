<?php
include_once '../includes/db.php';

$id = (int)($_GET['id'] ?? 0);

if ($id > 0) {
    $conn->query("DELETE FROM order_items WHERE id = $id");
}

header("Location: ../pages/order_items.php");
exit;
