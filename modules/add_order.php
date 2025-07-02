<?php
include_once '../includes/header.php';
include_once '../includes/sidebar.php';
include_once '../includes/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer = trim($_POST['customer']);
    $total = floatval($_POST['total']);

    if ($customer === '' || $total <= 0) {
        $error = 'Please fill in all fields correctly.';
    } else {
        $customer = mysqli_real_escape_string($conn, $customer);
        $total = mysqli_real_escape_string($conn, $total);

        $sql = "INSERT INTO orders (customer, total) VALUES ('$customer', '$total')";

        if (mysqli_query($conn, $sql)) {
            $success = 'Order added successfully.';
        } else {
            $error = 'Error saving order: ' . mysqli_error($conn);
        }
    }
}
?>

<div id="main-content">
    <h2 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 700; font-size: 2.4rem; color: #1a374d;">Add New Order</h2>
    <p style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #555; margin-bottom: 30px;">
        Fill out the form below to create a new order.
    </p>

    <div class="form-container">
        <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error); ?></div>
        <?php elseif ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="customer">Customer Name</label>
            <input type="text" id="customer" name="customer" required placeholder="e.g. John Doe">

            <label for="total">Total ($)</label>
            <input type="number" step="0.01" id="total" name="total" required placeholder="e.g. 25.50">

            <button type="submit">➕ Add Order</button>
        </form>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?>