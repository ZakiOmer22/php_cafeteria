<?php
include_once '../includes/header.php';
include_once '../includes/sidebar.php';
include_once '../includes/db.php';

$error = '';
$success = '';

$id = (int)($_GET['id'] ?? 0);

if ($id > 0) {
    $query = "SELECT * FROM order_items WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $item = mysqli_fetch_assoc($result);

    if (!$item) {
        $error = 'Order item not found.';
    }
} else {
    $error = 'Invalid item ID.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = (int)$_POST['order_id'];
    $menu_id = (int)$_POST['menu_id'];
    $qty = (int)$_POST['qty'];
    $price = (float)$_POST['price'];

    if ($order_id && $menu_id && $qty > 0 && $price > 0) {
        $stmt = $conn->prepare("UPDATE order_items SET order_id = ?, menu_id = ?, qty = ?, price = ? WHERE id = ?");
        $stmt->bind_param("iiidi", $order_id, $menu_id, $qty, $price, $id);

        if ($stmt->execute()) {
            $success = "Order item updated successfully.";
            // Reload updated values
            $item['order_id'] = $order_id;
            $item['menu_id'] = $menu_id;
            $item['qty'] = $qty;
            $item['price'] = $price;
        } else {
            $error = "Update failed: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "Please fill all fields correctly.";
    }
}

// Fetch for dropdowns
$orders = mysqli_query($conn, "SELECT id FROM orders ORDER BY id DESC");
$menus = mysqli_query($conn, "SELECT id, name FROM menu ORDER BY name ASC");
?>

<div id="main-content">
    <h2 style="font-family: 'Segoe UI'; font-weight: 700; font-size: 2.4rem; color: #1a374d;">Edit Order Item</h2>

    <?php if ($error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error); ?></div>
    <?php elseif ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <?php if (!empty($item)): ?>
        <div class="form-container wide">
            <form method="POST">
                <label for="order_id">Order ID:</label>
                <select name="order_id" id="order_id" required>
                    <?php while ($o = mysqli_fetch_assoc($orders)): ?>
                        <option value="<?= $o['id'] ?>" <?= ($o['id'] == $item['order_id']) ? 'selected' : '' ?>>
                            <?= $o['id'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <label for="menu_id">Menu Item:</label>
                <select name="menu_id" id="menu_id" required>
                    <?php while ($m = mysqli_fetch_assoc($menus)): ?>
                        <option value="<?= $m['id'] ?>" <?= ($m['id'] == $item['menu_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($m['name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <label for="qty">Quantity:</label>
                <input type="number" name="qty" id="qty" min="1" value="<?= htmlspecialchars($item['qty']) ?>" required>

                <label for="price">Price:</label>
                <input type="number" name="price" id="price" step="0.01" value="<?= htmlspecialchars($item['price']) ?>" required>

                <button type="submit">💾 Save Changes</button>
            </form>
        </div>
    <?php endif; ?>
</div>

<?php include_once '../includes/footer.php'; ?>