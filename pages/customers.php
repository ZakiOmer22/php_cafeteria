<?php
include_once '../includes/header.php';
include_once '../includes/sidebar.php';
include_once '../includes/db.php';
?>

<style>
    /* same styles as before */
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

    .menu-table {
        width: 100%;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .menu-table th,
    .menu-table td {
        padding: 12px 20px;
        text-align: left;
    }

    .menu-table th {
        background: #e9eff4;
        font-size: 14px;
        font-weight: 600;
        color: #333;
    }

    .menu-table tr:nth-child(even) {
        background-color: #f7f9fa;
    }

    .menu-table a {
        margin-right: 10px;
        color: #1a374d;
        font-weight: 500;
    }
</style>

<div id="main-content">
    <h2 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 700; font-size: 2.4rem; color: #1a374d;">Customers</h2>
    <p>Manage registered customers in the system.</p>

    <div class="analytics-cards">
        <div class="card">
            <h3>
                <?php
                $count = mysqli_query($conn, "SELECT COUNT(*) AS total FROM customers");
                echo mysqli_fetch_assoc($count)['total'];
                ?>
            </h3>
            <p>Total Customers</p>
        </div>
    </div>

    <a href="../modules/add_customer.php" class="add-btn">+ Add New Customer</a>

    <table class="menu-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM customers ORDER BY id DESC");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['id']) . "</td>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>" . htmlspecialchars($row['email']) . "</td>
                        <td>" . htmlspecialchars($row['phone']) . "</td>
                        <td>
                            <a href='../modules/edit_customer.php?id=" . $row['id'] . "'>Edit</a>
                            <a href='../modules/delete_customer.php?id=" . $row['id'] . "' onclick=\"return confirm('Delete this customer?')\">Delete</a>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include_once '../includes/footer.php'; ?>