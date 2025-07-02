<?php
session_start();

$user = $_SESSION['user'] ?? [
  'username' => 'Guest',
  'profile_pic' => 'assets/default-profile.jpg',
  'role' => 'Visitor'
];

// Base URL for your project (adjust as needed)
$baseURL = 'http://localhost:8080/';  // Change this to your actual localhost URL and port if different

$profilePicPath = $user['profile_pic'] ?? 'assets/default-profile.jpg';

// If profile picture path is relative, prepend base URL
if (strpos($profilePicPath, 'http') !== 0) {
  $profilePicPath = $baseURL . $profilePicPath;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cafeteria System</title>

  <!-- Google Font: Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />

  <!-- FontAwesome -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <link rel="stylesheet" href="../includes/css/header.css" />
  <link rel="stylesheet" href="../includes/css/sidebar.css" />
  <link rel="stylesheet" href="../includes/css/menu.css" />
  <link rel="stylesheet" href="../includes/css/add_item.css" />
  <link rel="stylesheet" href="../includes/css/edit_item.css" />
  <script defer src="../includes/js/sidebarToggle.js"></script>
</head>

<body>
  <header class="header-bar">
    <div class="project-title">Cafeteria System</div>
    <button id="sidebar-toggle" aria-label="Toggle sidebar" class="sidebar-toggle-btn" title="Toggle sidebar"></button>
    <div class="profile-logout-container">
      <img src="<?= htmlspecialchars($profilePicPath); ?>" alt="Profile Picture" class="profile-pic" />
      <div class="user-details">
        <span class="username"><?= htmlspecialchars($user['username']); ?></span>
        <span class="user-role"><?= htmlspecialchars($user['role']); ?></span>
        <form action="../logout.php" method="POST" class="logout-form">
          <button type="submit" class="logout-btn">Sign Out</button>
        </form>
      </div>
    </div>
  </header>
  <main class="main-content">