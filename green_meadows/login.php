<?php

session_start();
include 'db_connection.php';

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT user_id, password_hash, role_id FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password_hash'])) {
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['role_id'] = $user['role_id'];

    switch ($user['role_id']) {
        case 1: header("Location: superadmin_dashboard.php"); break;
        case 2: header("Location: admin_dashboard.php"); break;
        case 3: header("Location: hr_dashboard.php"); break;
        case 4: header("Location: accounting_dashboard.php"); break;
        case 5: header("Location: attendance.php"); break;
        default: header("Location: login.php?error=invalid_role");
    }
    exit();
} else {
    header("Location: login.php?error=invalid_credentials");
}

?>