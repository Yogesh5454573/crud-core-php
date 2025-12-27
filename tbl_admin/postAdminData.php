<?php
session_start();
include '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $mobile   = trim($_POST['mobile'] ?? '');
    $password = trim($_POST['password'] ?? '');

    /* ================= VALIDATION ================= */
    if (empty($name) || empty($email) || empty($mobile) || empty($password)) {
        $_SESSION["error"] = "All fields are required!";
        header("Location: addAdmin.php");
        exit();
    }

    /* ================= PASSWORD HASH ================= */
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    /* ================= INSERT QUERY ================= */
    $sql = "INSERT INTO tbl_admin (name, email, mobile, password) VALUES (?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {

        $stmt->bind_param("ssss", $name, $email, $mobile, $hashedPassword);

        if ($stmt->execute()) {
            $_SESSION["success"] = "User added successfully!";
            header("Location: manageAdmin.php");
            exit();
        } else {
            $_SESSION["error"] = "Database error: " . $stmt->error;
            header("Location: addAdmin.php");
            exit();
        }

        $stmt->close();
    } else {
        $_SESSION["error"] = "Prepare failed: " . $conn->error;
        header("Location: addAdmin.php");
        exit();
    }
}

$conn->close();
