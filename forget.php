<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: index.php");
    exit();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

if (isset($_POST['request_otp'])) {
    $fileId = intval($_POST['file_id']);
    $email = trim($_POST['email']);
    
    $stmt = $conn->prepare("SELECT id, file_path FROM file_management WHERE id = ? AND email = ?");
    $stmt->bind_param("is", $fileId, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "File not found or email does not match.";
        exit();
    }

    $file = $result->fetch_assoc();
    $_SESSION['file_path'] = $file['file_path'];

    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['file_id'] = $fileId;
    $_SESSION['email'] = $email;

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'jaybiemalone3@gmail.com';
        $mail->Password = 'hcrm dmfa uqln igfo';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('your-email@gmail.com', 'File Access OTP');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your OTP for File Access';
        $mail->Body = "Your OTP for accessing the file is: <b>$otp</b>.";
        $mail->send();
        echo "OTP sent successfully. Check your email.";
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }
}

if (isset($_POST['verify_otp'])) {
    $enteredOtp = intval($_POST['otp']);
    
    if ($enteredOtp === $_SESSION['otp']) {
        unset($_SESSION['otp']); // Invalidate OTP after use
        $filePath = $_SESSION['file_path'];
        if (file_exists($filePath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);
            exit();
        } else {
            echo "File not found.";
        }
    } else {
        echo "Invalid OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="/admin_movers-main/Asset/favicon.ico" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <style>
    body {
        padding: 20px;
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        flex-direction: column;
        gap: 20px;
    }

    .container {
        background-color: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 400px;
    }
    input, button {
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    button {
        background-color: #007bff;
        color: white;
        cursor: pointer;
    }
    button:hover {
        background-color: #0056b3;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: center;
    }
    th {
        background-color: #007bff;
        color: white;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    </style>
</head>
<body>
    <div class="container">
    <form method="post">
        <input type="number" name="file_id" placeholder="File ID" required>
        <input type="email" name="email" placeholder="Email" required>
        <button type="submit" name="request_otp">Request OTP</button>
    </form>

    <form method="post">
        <input type="number" name="otp" placeholder="Enter OTP" required>
        <button type="submit" name="verify_otp">Verify OTP and Open File</button>
        <a href="file.php">Back?</a>
    </form>

    </div>
    <table id="userTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>File Name</th>
                <th>Document Title</th>
                <th>Department</th>
                <th>Uploaded At</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT id, email, file_name, document_title, department, uploaded_at FROM file_management WHERE file_password IS NOT NULL";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['file_name']}</td>
                            <td>{$row['document_title']}</td>
                            <td>{$row['department']}</td>
                            <td>{$row['uploaded_at']}</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No files with passwords found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
    $(document).ready(function() {
        $('#userTable').DataTable({
            "paging": true,
            "lengthMenu": [10], // Show only 10 rows per page
            "ordering": true,
            "info": false, 
            "searching": true
        });
    });

    $(document).ready(function () {
        $('#userTable').DataTable();
    });


    </script>
</body>
</html>

