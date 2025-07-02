<?php
include_once '../includes/header.php';
include_once '../includes/sidebar.php';
include_once '../includes/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    if ($username && $password && $role) {
        $username = mysqli_real_escape_string($conn, $username);
        $role = mysqli_real_escape_string($conn, $role);
        $hashed = mysqli_real_escape_string($conn, password_hash($password, PASSWORD_BCRYPT));

        $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed', '$role')";

        if (mysqli_query($conn, $sql)) {
            $success = "User added successfully.";
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    } else {
        $error = "Please fill all fields.";
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
    <h2 style="font-family:'Segoe UI'; font-weight: 700; font-size: 2rem; color: #1a374d;">Add New User</h2>

    <div class="form-container">
        <?php if (!empty($error)): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php elseif (!empty($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <label for="role">Role:</label>
            <input type="text" name="role" id="role" required>

            <button type="submit">➕ Add User</button>
        </form>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?>