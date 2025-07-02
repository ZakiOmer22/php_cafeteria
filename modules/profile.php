<?php
include_once '../includes/header.php';
include_once '../includes/sidebar.php';
include_once '../includes/db.php';

session_start();

$user_id = $_SESSION['user']['id'] ?? null;
if (!$user_id) {
    header("Location: /pages/login.php");
    exit;
}

$error = '';
$success = '';

// Get current profile pic from DB for preview
$stmt = $conn->prepare("SELECT profile_pic FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($currentProfilePic);
$stmt->fetch();
$stmt->close();

// Fallback if no profile pic set
if (!$currentProfilePic) {
    $currentProfilePic = 'cafeteria-system/uploads/profile_pics/default-profile.jpg';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_pic'])) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $file = $_FILES['profile_pic'];

    if ($file['error'] === UPLOAD_ERR_OK) {
        if (in_array($file['type'], $allowedTypes)) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = 'profile_' . $user_id . '_' . time() . '.' . $ext;

            $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/cafeteria-system/uploads/profile_pics/';
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            $targetFile = $targetDir . $filename;

            if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                // Store relative path WITHOUT leading slash, so URL works correctly
                $relativePath = 'cafeteria-system/uploads/profile_pics/' . $filename;

                $stmt = $conn->prepare("UPDATE users SET profile_pic = ? WHERE id = ?");
                $stmt->bind_param("si", $relativePath, $user_id);

                if ($stmt->execute()) {
                    $success = "Profile picture updated successfully.";
                    $_SESSION['user']['profile_pic'] = $relativePath;
                    $currentProfilePic = $relativePath; // update preview immediately
                } else {
                    $error = "Database update failed: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $error = "Failed to move uploaded file.";
            }
        } else {
            $error = "Only JPG, PNG, and GIF images are allowed.";
        }
    } else {
        $error = "File upload error: " . $file['error'];
    }
}
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

    .form-container {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        max-width: 600px;
        margin-top: 30px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #1a374d;
    }

    input[type="file"] {
        width: 100%;
        padding: 8px;
        border-radius: 6px;
        border: 1px solid #ccc;
        margin-bottom: 20px;
    }

    button {
        background: #1a374d;
        color: white;
        padding: 12px 25px;
        border-radius: 6px;
        border: none;
        font-weight: 700;
        cursor: pointer;
    }

    button:hover {
        background: #16314e;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 6px;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }

    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
    }

    .profile-pic-preview {
        max-width: 200px;
        max-height: 200px;
        border-radius: 10px;
        margin-bottom: 20px;
        object-fit: cover;
        border: 2px solid #1a374d;
        display: block;
    }
</style>

<div id="main-content">
    <h2>Update Profile Picture</h2>
    <p>
        Manage your user profile picture here. You can see your current profile image below, and upload a new picture to update it instantly.
        The preview will show the selected image before you submit it, ensuring you upload the correct photo.
    </p>
    <?php if ($error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <img
        id="preview-img"
        src="/<?= htmlspecialchars($currentProfilePic) ?>"
        alt="Current Profile Picture"
        class="profile-pic-preview" />

    <form method="POST" enctype="multipart/form-data" class="form-container">
        <label for="profile_pic">Choose Image (JPG, PNG, GIF):</label>
        <input type="file" name="profile_pic" id="profile_pic" accept="image/*" required />

        <button type="submit">Upload</button>
    </form>
</div>

<script>
    const inputFile = document.getElementById('profile_pic');
    const previewImg = document.getElementById('preview-img');

    inputFile.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const objectUrl = URL.createObjectURL(file);
            previewImg.src = objectUrl;
        } else {
            previewImg.src = "/<?= htmlspecialchars($currentProfilePic) ?>";
        }
    });
</script>

<?php include_once '../includes/footer.php'; ?>