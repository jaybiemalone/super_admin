<?php
@include 'config.php';

session_start();

// Secure session handling
session_regenerate_id(true);

$defaultEmail = "superadmin@gmail.com";
$defaultPassword = "123456789";
$hashedDefaultPassword = password_hash($defaultPassword, PASSWORD_BCRYPT);

// Check if the default superadmin exists
$checkAdmin = $conn->prepare("SELECT * FROM user_form WHERE email = ?");
$checkAdmin->bind_param("s", $defaultEmail);
$checkAdmin->execute();
$resultAdmin = $checkAdmin->get_result();

if ($resultAdmin->num_rows === 0) {
    // Insert default superadmin
    $insertAdmin = $conn->prepare("INSERT INTO user_form (name, email, password, user_type, account_status) VALUES (?, ?, ?, ?, ?)");
    $name = "Super Admin";
    $user_type = "superadmin";
    $account_status = "active";
    $insertAdmin->bind_param("sssss", $name, $defaultEmail, $hashedDefaultPassword, $user_type, $account_status);
    $insertAdmin->execute();
    $insertAdmin->close();
}
$checkAdmin->close();

// Handle login request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    if (!isset($_POST['email'], $_POST['password'])) {
        $error = "Please fill in all fields!";
    } else {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM user_form WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result && $row = $result->fetch_assoc()) {
            // Verify password
            if (password_verify($password, $row['password'])) {
                if ($row['account_status'] == 'disabled') {
                    $error = "Your account is disabled. Please contact admin.";
                } else {
                    $_SESSION['user_name'] = $row['name'];
                    
                    // Redirect based on user type
                    switch ($row['user_type']) {
                        case 'superadmin':
                            $_SESSION['admin_name'] = $row['name'];
                            header('Location: dashboard.php');
                            break;
                        case 'logistic':
                            header('Location: logistic.php');
                            break;
                        case 'finance':
                            header('Location: finance.php');
                            break;
                        case 'admin':
                            header('Location: ./admin_movers-main/dashbord.php');
                            break;
                        default:
                            header('Location: dashboard.php'); // Default redirect
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
        body{
            background: url(./asset/loginbackground.png );
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
