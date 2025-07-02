<?php
include_once '../includes/header.php';
include_once '../includes/sidebar.php';
include_once '../includes/db.php';
?>

<style>
    #main-content {
        margin-left: 250px;
        padding: 90px 40px 80px;
        background: #f0f4f8;
        min-height: 100vh;
        transition: margin-left 0.3s ease;
    }

    body.sidebar-collapsed #main-content {
        margin-left: 80px;
    }

    .analytics-cards {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }

    .analytics-cards .card {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        flex: 1;
        text-align: center;
    }

    .orders-table {
        width: 100%;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .orders-table th,
    .orders-table td {
        padding: 12px 20px;
        text-align: left;
    }

    .orders-table th {
        background: #e9eff4;
        font-size: 14px;
        font-weight: 600;
        color: #333;
    }

    .orders-table tr:nth-child(even) {
        background-color: #f7f9fa;
    }

    .add-btn {
        display: inline-block;
        margin-bottom: 20px;
        background: #1a374d;
        color: white;
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
    }

    .action-links a {
        margin-right: 10px;
        color: #1a374d;
        font-weight: 500;
        text-decoration: none;
    }

    .action-links a:hover {
        text-decoration: underline;
    }
</style>

<div id="main-content">
    <h2 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 700; font-size: 2.4rem; color: #1a374d;">Orders</h2>
    <p>Manage cafeteria orders and view details below.</p>

    <div class="analytics-cards">
        <div class="card">
            <h3>
                <?php
                $totalOrders = mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders");
                echo mysqli_fetch_assoc($totalOrders)['total'] ?? 0;
                ?>
            </h3>
            <p>Total Orders</p>
        </div>

        <div class="card">
            <h3>
                <?php
                $totalRevenue = mysqli_query($conn, "SELECT SUM(total) AS revenue FROM orders");
                echo '$' . number_format(mysqli_fetch_assoc($totalRevenue)['revenue'] ?? 0, 2);
                ?>
            </h3>
            <p>Total Revenue</p>
        </div>
    </div>

    <a href="../modules/add_order.php" class="add-btn">+ Add New Order</a>

    <table class="orders-table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Total ($)</th>
                <th>Order Time</th>
                <th>Details</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $orders = mysqli_query($conn, "SELECT * FROM orders ORDER BY order_time DESC");
            while ($order = mysqli_fetch_assoc($orders)) {
                $orderId = htmlspecialchars($order['id']);
                $customer = htmlspecialchars($order['customer']);
                $total = number_format($order['total'], 2);
                $orderTime = date('Y-m-d H:i', strtotime($order['order_time']));

                $itemsResult = mysqli_query($conn, "SELECT oi.qty, oi.price, m.name FROM order_items oi LEFT JOIN menu m ON oi.menu_id = m.id WHERE oi.order_id = $orderId");
                $itemsSummary = [];
                while ($item = mysqli_fetch_assoc($itemsResult)) {
                    $name = htmlspecialchars($item['name'] ?? 'Unknown');
                    $qty = (int)$item['qty'];
                    $itemsSummary[] = "$qty × $name";
                }
                $itemsText = implode(', ', $itemsSummary);
            ?>
                <tr>
                    <td><?= $orderId ?></td>
                    <td><?= $customer ?></td>
                    <td>$<?= $total ?></td>
                    <td><?= $orderTime ?></td>
                    <td><?= $itemsText ?></td>
                    <td class="action-links">
                        <a href="../modules/edit_order.php?id=<?= $orderId ?>">Edit</a>
                        <a href="../modules/delete_order.php?id=<?= $orderId ?>" onclick="return confirm('Delete this order?');">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include_once '../includes/footer.php'; ?>