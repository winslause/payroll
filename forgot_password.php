<?php
// forgot_password.php

// Function to generate a random token
function generateRandomToken($length = 32) {
    // Generate random bytes
    $randomBytes = random_bytes($length);

    // Convert random bytes to a string of characters
    // Using bin2hex() for hexadecimal representation
    // or base64_encode() for a URL-safe representation
    $token = bin2hex($randomBytes);
    // $token = base64_encode($randomBytes);

    return $token;
}

// Start a session to store temporary data
session_start();

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Retrieve the user's email address from the form
    $email = $_POST['email'];

    // Validate the email address (you can add more validation if needed)
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Connect to your database (update with your database credentials)
        $conn = mysqli_connect('localhost', 'username', 'password', 'database_name');

        if ($conn) {
            // Check if the email exists in your database
            $query = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                // Generate a random reset token
                $resetToken = generateRandomToken();

                // Store the reset token and its expiration time in the database
                $expirationTime = date('Y-m-d H:i:s', strtotime('+1 hour'));
                $updateQuery = "UPDATE users SET reset_token = '$resetToken', reset_token_expiration = '$expirationTime' WHERE email = '$email'";
                mysqli_query($conn, $updateQuery);

                // Send the password reset link to the user's email
                $resetLink = "http://your_domain.com/reset_password.php?email=" . urlencode($email) . "&token=" . urlencode($resetToken);
                $subject = "Password Reset - Your Website Name";
                $message = "Hello,\n\nClick on the link below to reset your password:\n\n$resetLink\n\nThis link will expire in 1 hour.\n\nIf you did not request a password reset, please ignore this email.\n\nBest regards,\nYour Website Name";
                $headers = "From: Your Website Name <noreply@your_domain.com>\r\n";

                // Uncomment the line below to send the email (make sure your server is properly configured to send emails)
                // mail($email, $subject, $message, $headers);

                // For testing purposes, you can output the reset link instead of sending the email
                echo "Password reset link: $resetLink";

                // Display a success message to the user
                $_SESSION['success'] = "An email with a password reset link has been sent to your email address.";
                header("Location: forgot_password.php");
                exit();
            } else {
                // Email address not found in the database
                $_SESSION['error'] = "Email address not found.";
            }
        } else {
            // Database connection error
            $_SESSION['error'] = "Database connection error.";
        }
    } else {
        // Invalid email format
        $_SESSION['error'] = "Invalid email address.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Forgot Password - Your Website Name</title>
    <!-- Include your CSS stylesheets here -->
</head>

<body>
    <h2>Forgot Password</h2>
    <?php
    // Display success or error messages, if any
    if (isset($_SESSION['success'])) {
        echo '<div class="success">' . $_SESSION['success'] . '</div>';
        unset($_SESSION['success']);
    } elseif (isset($_SESSION['error'])) {
        echo '<div class="error">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']);
    }
    ?>

    <form method="post">
        <label for="email">Enter your email address:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit" name="submit">Reset Password</button>
    </form>
</body>

</html>
