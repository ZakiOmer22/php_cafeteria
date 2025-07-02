<?php
include_once '../includes/header.php';
include_once '../includes/sidebar.php';
include_once '../includes/db.php';

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header('Location: ../pages/orders.php');
    exit;
}

$id = (int)$id;

$error = '';
$success = '';

$orderRes = mysqli_query($conn, "SELECT * FROM orders WHERE id = '$id'");
$order = mysqli_fetch_assoc($orderRes);
if (!$order) {
    header('Location: ../pages/orders.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer = trim($_POST['customer']);
    $total = floatval($_POST['total']);

    if ($customer === '' || $total <= 0) {
        $error = 'Please fill in all fields correctly.';
    } else {
        $customer = mysqli_real_escape_string($conn, $customer);
        $total = mysqli_real_escape_string($conn, $total);

        $sql = "UPDATE orders SET customer = '$customer', total = '$total' WHERE id = '$id'";

        if (mysqli_query($conn, $sql)) {
            $success = "Order updated successfully.";
        } else {
            $error = "Error updating order: " . mysqli_error($conn);
        }
    }
}
?>

<div id="main-content">
    <h2 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 700; font-size: 2.4rem; color: #1a374d;">Edit Order #<?= htmlspecialchars($order['id']); ?></h2>
    <p style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #555; margin-bottom: 30px;">
        Update the customer and total amount details of the selected order below.
    </p>

    <div class="form-container">
        <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error); ?></div>
        <?php elseif ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="customer">Customer Name</label>
            <input type="text" id="customer" name="customer" required value="<?= htmlspecialchars($order['customer']); ?>">

            <label for="total">Total ($)</label>
            <input type="number" step="0.01" id="total" name="total" required value="<?= number_format($order['total'], 2); ?>">

            <button type="submit">Update Order</button>
        </form>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?>