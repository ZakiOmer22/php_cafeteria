<?php
include_once '../includes/header.php';
include_once '../includes/sidebar.php';
include_once '../includes/db.php';

$error = '';
$success = '';
$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    header("Location: /pages/menu.php");
    exit;
}

$id = (int)$id;
$id = mysqli_real_escape_string($conn, $id);
$result = mysqli_query($conn, "SELECT * FROM menu WHERE id = '$id'");
$menuItem = mysqli_fetch_assoc($result);

if (!$menuItem) {
    header("Location: /pages/menu.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $available = $_POST['available'] === '1' ? 1 : 0;

    if ($name === '' || $price <= 0) {
        $error = 'Please fill in all fields correctly.';
    } else {
        $name = mysqli_real_escape_string($conn, $name);
        $price = mysqli_real_escape_string($conn, $price);
        $available = mysqli_real_escape_string($conn, $available);

        $sql = "UPDATE menu SET name = '$name', price = '$price', available = '$available' WHERE id = '$id'";

        if (mysqli_query($conn, $sql)) {
            $success = 'Menu item updated successfully.';
            header("Location: ../pages/menu.php");
            $menuItem['name'] = $name;
            $menuItem['price'] = $price;
            $menuItem['available'] = $available;
        } else {
            $error = 'Error updating item: ' . mysqli_error($conn);
        }
    }
}
?>

<div id="main-content">
    <h2 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 700; font-size: 2.4rem; color: #1a374d;">Edit Menu Item</h2>
    <p>Edit the details of the menu item below.</p>

    <div class="form-container">
        <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php elseif ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="name">Item Name:</label>
            <input type="text" id="name" name="name" required value="<?= htmlspecialchars($menuItem['name']) ?>">

            <label for="price">Price ($):</label>
            <input type="number" step="0.01" id="price" name="price" required value="<?= htmlspecialchars($menuItem['price']) ?>">

            <label for="available">Available:</label>
            <select id="available" name="available" required>
                <option value="1" <?= $menuItem['available'] ? 'selected' : '' ?>>Yes</option>
                <option value="0" <?= !$menuItem['available'] ? 'selected' : '' ?>>No</option>
            </select>

            <button type="submit">Update Item</button>
        </form>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?>