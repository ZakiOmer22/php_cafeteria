<?php
include_once '../includes/header.php';
include_once '../includes/sidebar.php';
include_once '../includes/db.php';

$error = '';
$success = '';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    header('Location: ../pages/users.php');
    exit;
}

$user = null;
$result = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    $error = 'User not found.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'];
    $newPassword = $_POST['password'] ?? '';

    if ($role) {
        mysqli_query($conn, "UPDATE users SET role = '$role' WHERE id = $id");

        if (!empty($newPassword)) {
            $hashed = password_hash($newPassword, PASSWORD_BCRYPT);
            mysqli_query($conn, "UPDATE users SET password = '$hashed' WHERE id = $id");
        }

        $success = "User updated successfully.";
        $user['role'] = $role;
    } else {
        $error = "Please fill the required fields.";
    }
}
?>

<style>
    #main-content {
        margin-left: 250px;
        padding: 90px 40px 80px;
        background: #f0f4f8;
        min-height: 100vh;
    }

    body.sidebar-collapsed #main-content {
        margin-left: 80px;
    }

    .form-container {
        max-width: 600px;
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        margin-top: 30px;
    }

    .form-container label {
        display: block;
        font-weight: bold;
        margin-bottom: 6px;
        color: #1a374d;
    }

    .form-container input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        margin-bottom: 16px;
    }

    .form-container button {
        background: #1a374d;
        color: white;
        padding: 10px 20px;
        border-radius: 6px;
        border: none;
        font-weight: bold;
    }

    .alert {
        padding: 12px 20px;
        border-radius: 6px;
        margin-bottom: 15px;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }

    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
    }
</style>

<div id="main-content">
    <h2 style="font-family:'Segoe UI'; font-weight: 700; font-size: 2rem; color: #1a374d;">Edit User</h2>

    <div class="form-container">
        <?php if (!empty($error)): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php elseif (!empty($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <?php if ($user): ?>
            <form method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" value="<?= htmlspecialchars($user['username']) ?>" readonly>

                <label for="role">Role:</label>
                <input type="text" name="role" id="role" value="<?= htmlspecialchars($user['role']) ?>" required>

                <label for="password">New Password:</label>
                <input type="password" name="password" id="password">

                <button type="submit">💾 Update User</button>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?>