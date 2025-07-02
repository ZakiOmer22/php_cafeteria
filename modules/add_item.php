<?php
include_once '../includes/header.php';
include_once '../includes/sidebar.php';
include_once '../includes/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $available = isset($_POST['available']) ? 1 : 0;

    if ($name === '' || $price <= 0) {
        $error = 'Please fill in all fields correctly.';
    } else {
        $name = mysqli_real_escape_string($conn, $name);
        $price = mysqli_real_escape_string($conn, $price);
        $available = mysqli_real_escape_string($conn, $available);

        $sql = "INSERT INTO menu (name, price, available) VALUES ('$name', '$price', '$available')";

        if (mysqli_query($conn, $sql)) {
            $success = 'Menu item added successfully.';
        } else {
            $error = 'Error saving item: ' . mysqli_error($conn);
        }
    }
}
?>

<link rel="stylesheet" href="../includes/css/form_module.css">

<div id="main-content">
    <h2 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 700; font-size: 2.4rem; color: #1a374d;">Add New Menu Item</h2>
    <p>Fill out the form below to add a new item to the menu.</p>

    <div class="form-container wide">
        <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php elseif ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="name">Item Name:</label>
            <input type="text" id="name" name="name" required placeholder="e.g. Chicken Sandwich">

            <label for="price">Price ($):</label>
            <input type="number" step="0.01" id="price" name="price" required placeholder="e.g. 4.99">

            <label>
                <input type="checkbox" name="available" checked>
                Available
            </label>

            <button type="submit">➕ Add Item</button>
        </form>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?>