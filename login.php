<?php
session_start();
include_once 'includes/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                ];
                header('Location: pages/dashboard.php');
                exit;
            } else {
                $error = 'Invalid password.';
            }
        } else {
            $error = 'User not found.';
        }
        $stmt->close();
    } else {
        $error = 'Please fill all fields.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Login - Cafeteria System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            width: 350px;
        }

        h2 {
            color: #1a374d;
            margin-bottom: 20px;
            text-align: center;
        }

        label {
            display: block;
            margin: 12px 0 6px;
            font-weight: 600;
            color: #1a374d;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        button {
            margin-top: 20px;
            background: #1a374d;
            color: white;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-weight: 700;
            cursor: pointer;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Cafeteria Login</h2>
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="username">Username</label>
            <input id="username" name="username" type="text" required autofocus />

            <label for="password">Password</label>
            <input id="password" name="password" type="password" required />

            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>