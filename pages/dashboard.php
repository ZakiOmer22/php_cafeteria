<?php
include_once '../includes/header.php';
include_once '../includes/sidebar.php';
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
</style>

<div id="main-content">
  <h2 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 700; font-size: 2.4rem; color: #1a374d;">Dashboard</h2>
  <p>Welcome to the Cafeteria dashboard!</p>
</div>

<?php include_once '../includes/footer.php'; ?>