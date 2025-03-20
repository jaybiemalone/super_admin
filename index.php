<?php
@include 'config.php';

session_start();

// Secure session handling
session_regenerate_id(true);

if (!$conn) {
    die("Database connection failed!");
}

// 🔹 Default Superadmin Credentials
$defaultEmail = "superadmin@gmail.com";
$defaultPassword = "123456789";
$hashedDefaultPassword = password_hash($defaultPassword, PASSWORD_BCRYPT);

// 🔹 Check if the default superadmin exists
$checkAdmin = $conn->prepare("SELECT id FROM user_form WHERE email = ?");
$checkAdmin->bind_param("s", $defaultEmail);
$checkAdmin->execute();
$resultAdmin = $checkAdmin->get_result();

if ($resultAdmin->num_rows === 0) {
    // Insert default superadmin if not exists
    $insertAdmin = $conn->prepare("INSERT INTO user_form (name, email, password, user_type, account_status) VALUES (?, ?, ?, ?, ?)");
    $name = "Super Admin";
    $user_type = "superadmin";
    $account_status = "active";
    $insertAdmin->bind_param("sssss", $name, $defaultEmail, $hashedDefaultPassword, $user_type, $account_status);
    $insertAdmin->execute();
    $insertAdmin->close();
}
$checkAdmin->close();

// 🔹 Upgrade old passwords to bcrypt if needed
$result = $conn->query("SELECT id, password FROM user_form");

while ($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $currentPassword = $row['password'];

    // Detect weak passwords (MD5 or plaintext)
    if (!password_needs_rehash($currentPassword, PASSWORD_BCRYPT) && strlen($currentPassword) < 60) {
        $newHash = password_hash($currentPassword, PASSWORD_BCRYPT);

        // Update the database with the new hashed password
        $update = $conn->prepare("UPDATE user_form SET password = ? WHERE id = ?");
        $update->bind_param("si", $newHash, $id);
        $update->execute();
        $update->close();
    }
}

// 🔹 Handle login request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    if (!isset($_POST['email'], $_POST['password']) || empty($_POST['email']) || empty($_POST['password'])) {
        $error = "Please fill in all fields!";
    } else {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT id, name, password, user_type, account_status FROM user_form WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $row = $result->fetch_assoc()) {
            $hashedPassword = $row['password'];
            $isPasswordValid = false;

            // Check if password is bcrypt
            if (password_get_info($hashedPassword)['algo'] === PASSWORD_BCRYPT) {
                $isPasswordValid = password_verify($password, $hashedPassword);
            } 
            // If it's MD5, manually verify and rehash with bcrypt
            elseif (strlen($hashedPassword) === 32 && $hashedPassword === md5($password)) {
                $isPasswordValid = true;
                
                // 🔹 Upgrade to bcrypt
                $newHashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $update = $conn->prepare("UPDATE user_form SET password = ? WHERE id = ?");
                $update->bind_param("si", $newHashedPassword, $row['id']);
                $update->execute();
                $update->close();
            }

            if ($isPasswordValid) {
                if (empty($row['account_status'])) {
                    $error = "Your account is disabled. Please contact admin.";
                } elseif ($row['account_status'] === 'disabled') {
                    $error = "Your account is disabled. Please contact admin.";
                } else {
                    $_SESSION['user_name'] = $row['name'];

                    // Redirect based on user type
                    switch ($row['user_type']) {
                        case 'superadmin':
                            $_SESSION['admin_name'] = $row['name'];
                            header('Location: dashboard.php');
                            break;
                        case 'hr1':
                            header('Location: hr.php');
                            break;
                        case 'hr2':
                            header('Location: hr.php');
                            break;
                        case 'hr3':
                            header('Location: hr.php');
                            break;
                        case 'logistic1':
                            header('Location: logistic.php');
                            break;
                        case 'logistic2':
                            header('Location: logistic.php');
                            break;
                        case 'finance':
                            header('Location: finance.php');
                            break;
                        case 'admin':
                            header('Location: ./admin/admin-dashboard.php');
                            break;
                        default:
                            header('Location: dashboard.php');
                            break;
                    }
                    exit();
                }
            } else {
                $error = "Invalid email or password!";
            }
        } else {
            $error = "Invalid email or password!";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="style_user_level.css">
    <link rel="icon" href="/asset/favicon.ico" type="image/x-icon">
    <style>
        body {
            background: url(./asset/loginbackground.png);
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body>

<div class="form-container">
    <form action="" method="post">
        <h3><img src="./asset/logo.png" alt="" width="250">Login Now</h3>
        <?php if (!empty($error)) : ?>
            <p style="color: red; font-weight: bold;"><?php echo $error; ?></p>
        <?php endif; ?>
        <input type="email" name="email" required placeholder="Enter your email">
        <input type="password" name="password" required placeholder="Enter your password">
        <input type="submit" name="submit" value="Login Now" class="form-btn">
    </form>
</div>

</body>
</html>
