<?php
$userRole = $_SESSION['user']['role'] ?? 'Visitor';
$currentPage = basename($_SERVER['PHP_SELF']);

function isActive($page)
{
    global $currentPage;
    return $currentPage === $page ? 'active-link' : '';
}
?>
<aside id="sidebar" class="sidebar expanded">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <img src="../assets/logo.jpg" alt="Logo" class="sidebar-logo-img" />
        </div>
        <button id="collapse-btn" aria-label="Collapse sidebar" title="Collapse sidebar">
            <i class="fas fa-angle-left"></i>
        </button>
    </div>

    <nav class="sidebar-nav">
        <a href="../pages/dashboard.php" class="<?= isActive('dashboard.php') ?>">
            <i class="fas fa-house-user sidebar-icon"></i>
            <span class="nav-text">Dashboard</span>
        </a>
        <a href="../pages/menu.php" class="<?= isActive('menu.php') ?>">
            <i class="fas fa-burger sidebar-icon"></i>
            <span class="nav-text">Menu</span>
        </a>
        <a href="../pages/customers.php" class="<?= isActive('customers.php') ?>">
            <i class="fas fa-users sidebar-icon"></i>
            <span class="nav-text">Customers</span>
        </a>
        <a href="../pages/orders.php" class="<?= isActive('orders.php') ?>">
            <i class="fas fa-receipt sidebar-icon"></i>
            <span class="nav-text">Orders</span>
        </a>
        <a href="../pages/order_items.php" class="<?= isActive('order_items.php') ?>">
            <i class="fas fa-box sidebar-icon"></i>
            <span class="nav-text">Order Items</span>
        </a>
        <a href="../pages/users.php" class="<?= isActive('users.php') ?>">
            <i class="fas fa-user-friends sidebar-icon"></i>
            <span class="nav-text">Users</span>
        </a>
        <a href="../modules/profile.php" class="<?= isActive('profile.php') ?>">
            <i class="fas fa-user-cog sidebar-icon"></i>
            <span class="nav-text">Profile</span>
        </a>
        <!-- <a href="../pages/manual.php" class="<?= isActive('manual.php') ?>">
            <i class="fas fa-book sidebar-icon"></i>
            <span class="nav-text">Project Manual</span>
        </a> -->
        <a href="../pages/settings.php" class="<?= isActive('settings.php') ?>">
            <i class="fas fa-sliders-h sidebar-icon"></i>
            <span class="nav-text">Settings</span>
        </a>
    </nav>

    <div class="sidebar-role">
        Role: <strong><?= htmlspecialchars($user['role']) ?></strong>
    </div>
</aside>