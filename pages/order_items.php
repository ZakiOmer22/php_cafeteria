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

    .orderitems-table {
        width: 100%;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .orderitems-table th,
    .orderitems-table td {
        padding: 12px 20px;
        text-align: left;
    }

    .orderitems-table th {
        background: #e9eff4;
        font-size: 14px;
        font-weight: 600;
        color: #333;
    }

    .orderitems-table tr:nth-child(even) {
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
    <h2 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 700; font-size: 2.4rem; color: #1a374d;">Order Items</h2>
    <p>View each item ordered by customers. This includes quantity and item details per order.</p>

    <div class="analytics-cards">
        <div class="card">
            <h3>
                <?php
                $itemsCount = mysqli_query($conn, "SELECT COUNT(*) AS total FROM order_items");
                echo mysqli_fetch_assoc($itemsCount)['total'] ?? 0;
                ?>
            </h3>
            <p>Total Order Items</p>
        </div>

        <div class="card">
            <h3>
                <?php
                $qtyResult = mysqli_query($conn, "SELECT SUM(qty) AS total_qty FROM order_items");
                echo mysqli_fetch_assoc($qtyResult)['total_qty'] ?? 0;
                ?>
            </h3>
            <p>Total Quantity Ordered</p>
        </div>

        <div class="card">
            <h3>
                <?php
                $totalRevenue = mysqli_query($conn, "SELECT SUM(qty * price) AS revenue FROM order_items");
                echo '$' . number_format(mysqli_fetch_assoc($totalRevenue)['revenue'] ?? 0, 2);
                ?>
            </h3>
            <p>Total Revenue</p>
        </div>

        <div class="card">
            <h3>
                <?php
                $distinctItems = mysqli_query($conn, "SELECT COUNT(DISTINCT menu_id) AS unique_items FROM order_items");
                echo mysqli_fetch_assoc($distinctItems)['unique_items'] ?? 0;
                ?>
            </h3>
            <p>Distinct Menu Items Ordered</p>
        </div>
    </div>

    <a href="../modules/add_order_item.php" class="add-btn">+ Add Order Item</a>

    <table class="orderitems-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Order ID</th>
                <th>Menu Item</th>
                <th>Qty</th>
                <th>Price ($)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT oi.id, oi.order_id, m.name AS menu_name, oi.qty, oi.price
                      FROM order_items oi
                      LEFT JOIN menu m ON oi.menu_id = m.id
                      ORDER BY oi.id DESC";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $orderId = $row['order_id'];
                $itemName = htmlspecialchars($row['menu_name'] ?? 'Unknown');
                $qty = $row['qty'];
                $price = number_format($row['price'], 2);

                echo "<tr>
                        <td>$id</td>
                        <td>$orderId</td>
                        <td>$itemName</td>
                        <td>$qty</td>
                        <td>\$$price</td>
                        <td class='action-links'>
                            <a href='../modules/edit_order_items.php?id=$id'>Edit</a>
                            <a href='../modules/delete_order_items.php?id=$id' onclick=\"return confirm('Delete this item?')\">Delete</a>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include_once '../includes/footer.php'; ?>