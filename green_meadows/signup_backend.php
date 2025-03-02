<?php
require 'db_connection.php'; // Ensure you include your database connection file

session_start(); // Start session to store messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Error messages array
    $errors = [];

    // Validate username (alphanumeric and between 4-20 chars)
    if (empty($username) || !preg_match("/^[a-zA-Z0-9]{4,20}$/", $username)) {
        $errors[] = "Username must be 4-20 characters long and contain only letters and numbers.";
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Validate password complexity
    if (
        strlen($password) < 8 ||
        !preg_match('/[A-Z]/', $password) ||   // At least one uppercase letter
        !preg_match('/[a-z]/', $password) ||   // At least one lowercase letter
        !preg_match('/\d/', $password) ||      // At least one number
        !preg_match('/[^a-zA-Z\d]/', $password) // At least one special character
    ) {
        $errors[] = "Password must be at least 8 characters long, contain an uppercase letter, lowercase letter, a number, and a special character.";
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // If there are errors, return to the form with error messages
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: index.php"); // Redirect back to the index form
        exit();
    }

    // Hash the password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Check if email or username already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['errors'] = ["Username or Email already exists."];
        header("Location: index.php");
        exit();
    }

    // Insert new user
    $role_id = 2; // Default role
    $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash, role_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $username, $email, $password_hash, $role_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Signup successful! You can now log in.";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['errors'] = ["Error: " . $stmt->error];
        header("Location: index.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>