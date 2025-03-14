<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $subject = trim($_POST["subject"]);
    $message = trim($_POST["message"]);

    // Validate required fields
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        die("All fields are required.");
    }

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Prevent header injection
    if (preg_match("/\r|\n/", $name) || preg_match("/\r|\n/", $email) || preg_match("/\r|\n/", $subject)) {
        die("Invalid input detected.");
    }

    // Sanitize input to prevent XSS
    $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
    $subject = htmlspecialchars($subject, ENT_QUOTES, 'UTF-8');
    $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

    // Email recipient
    $to = "sampathkommi4101@gmail.com"; // Replace with your actual email
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    $fullMessage = "Name: $name\nEmail: $email\nSubject: $subject\nMessage:\n$message";

    // Send email
    if (mail($to, $subject, $fullMessage, $headers)) {
        echo "Message sent successfully.";
    } else {
        echo "Error sending message. Please try again later.";
    }
} else {
    die("Invalid request.");
}
?>
