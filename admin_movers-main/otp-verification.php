<?php
session_start();

// Process the OTP here (you might use email or SMS to send OTP)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp = $_POST['otp'];

    // Validate the OTP (this would usually check against a stored OTP in your DB or session)
    if ($otp == $_SESSION['generated_otp']) {
        echo "OTP verified successfully!";
        // Redirect to the next page after OTP verification
    } else {
        echo "Invalid OTP.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
</head>
<body>
    <div>
        <h2>Enter OTP</h2>
        <form method="POST">
            <label for="otp">OTP:</label>
            <input type="text" id="otp" name="otp" required>
            <button type="submit">Verify OTP</button>
        </form>
    </div>
</body>
</html>
