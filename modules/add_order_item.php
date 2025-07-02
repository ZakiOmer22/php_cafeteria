<?php
include_once '../includes/header.php';
include_once '../includes/sidebar.php';
include_once '../includes/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = (int)$_POST['order_id'];
    $menu_id = (int)$_POST['menu_id'];
    $qty = (int)$_POST['qty'];
    $price = (float)$_POST['price'];

    if ($order_id && $menu_id && $qty > 0 && $price > 0) {
        $order_id = mysqli_real_escape_string($conn, $order_id);
        $menu_id = mysqli_real_escape_string($conn, $menu_id);
        $qty = mysqli_real_escape_string($conn, $qty);
        $price = mysqli_real_escape_string($conn, $price);

        $sql = "INSERT INTO order_items (order_id, menu_id, qty, price) VALUES ('$order_id', '$menu_id', '$qty', '$price')";

        if (mysqli_query($conn, $sql)) {
            $success = 'Item added successfully';
        } else {
            $error = 'Insert failed: ' . mysqli_error($conn);
        }
    } else {
        $error = 'Fill all fields correctly';
    }
}

$orders = mysqli_query($conn, "SELECT id FROM orders ORDER BY id DESC");
$menus = mysqli_query($conn, "SELECT id, name FROM menu ORDER BY name ASC");
?>


<div id="main-content">
    <h2 style="font-family: 'Segoe UI'; font-weight: 700; font-size: 2.4rem; color: #1a374d;">Add Order Item</h2>

    <?php if ($error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error); ?></div>
    <?php elseif ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <div class="form-container wide">
        <form method="POST">
            <label for="order_id">Order ID:</label>
            <select name="order_id" id="order_id" required>
                <?php while ($o = mysqli_fetch_assoc($orders)): ?>
                    <option value="<?= $o['id'] ?>"><?= $o['id'] ?></option>
                <?php endwhile; ?>
            </select>

            <label for="menu_id">Menu Item:</label>
            <select name="menu_id" id="menu_id" required>
                <?php while ($m = mysqli_fetch_assoc($menus)): ?>
                    <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['name']) ?></option>
                <?php endwhile; ?>
            </select>

            <label for="qty">Quantity:</label>
            <input type="number" name="qty" id="qty" min="1" required>

            <label for="price">Price:</label>
            <input type="number" name="price" id="price" step="0.01" required>

            <button type="submit">➕ Add Item</button>
        </form>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?>