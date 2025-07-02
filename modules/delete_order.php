<?php
include_once '../includes/db.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $id = (int)$id;
    mysqli_query($conn, "DELETE FROM order_items WHERE order_id = $id");
    mysqli_query($conn, "DELETE FROM orders WHERE id = $id");
}

header('Location: ../pages/orders.php');
exit;
