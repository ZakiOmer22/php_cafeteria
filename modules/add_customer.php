<?php
include_once '../includes/header.php';
include_once '../includes/sidebar.php';
include_once '../includes/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if ($name && $email && $phone) {
        $name = mysqli_real_escape_string($conn, $name);
        $email = mysqli_real_escape_string($conn, $email);
        $phone = mysqli_real_escape_string($conn, $phone);

        $sql = "INSERT INTO customers (name, email, phone) VALUES ('$name', '$email', '$phone')";

        if (mysqli_query($conn, $sql)) {
            $success = "Customer added successfully.";
        } else {
            $error = "Database error: " . mysqli_error($conn);
        }
    } else {
        $error = "All fields are required.";
    }
}

?>

<style>
    /* Your provided styles */
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

    .form-container {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        max-width: 900px;
        margin-top: 30px;
        margin-left: 20px;
        box-sizing: border-box;
    }

    .form-container label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: #1a374d;
    }

    .form-container input[type="text"],
    .form-container input[type="number"],
    .form-container select,
    .form-container input[type="email"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        margin-bottom: 15px;
        box-sizing: border-box;
        font-size: 1rem;
        transition: border-color 0.2s ease;
    }

    .form-container input[type="text"]:focus,
    .form-container input[type="number"]:focus,
    .form-container select:focus,
    .form-container input[type="email"]:focus {
        border-color: #1a374d;
        outline: none;
    }

    .form-container button {
        background: #1a374d;
        color: white;
        padding: 12px 24px;
        border-radius: 6px;
        border: none;
        font-weight: bold;
        cursor: pointer;
        font-size: 1rem;
        transition: background-color 0.3s ease;
    }

    .form-container button:hover {
        background-color: #16314a;
    }

    .alert {
        padding: 12px 20px;
        border-radius: 6px;
        margin-bottom: 15px;
        font-weight: 600;
        font-size: 1rem;
        box-sizing: border-box;
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
    <h2>Add New Customer</h2>

    <?php if ($error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST" class="form-container">
        <label for="name">Full Name:</label>
        <input type="text" name="name" id="name" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" required value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">

        <button type="submit">Add Customer</button>
    </form>
</div>

<?php include_once '../includes/footer.php'; ?>