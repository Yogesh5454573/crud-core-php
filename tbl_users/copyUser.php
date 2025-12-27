<?php
session_start();
include '../config/config.php';
if (!isset($_GET['id'])) {
    header("Location: manageUser.php");
    exit();
}
$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT name, email, mobile, password FROM tbl_users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    $_SESSION['error'] = "User not found!";
    header("Location: manageUser.php");
    exit();
}
$user = $result->fetch_assoc();
$stmt->close();
$newEmail = 'copy_' . time() . '_' . $user['email'];
$insert = $conn->prepare(
    "INSERT INTO tbl_users (name, email, mobile, password) VALUES (?, ?, ?, ?)"
);
$insert->bind_param(
    "ssss",
    $user['name'],
    $newEmail,
    $user['mobile'],
    $user['password']
);

if ($insert->execute()) {
    $_SESSION['success'] = "User copied successfully!";
} else {
    $_SESSION['error'] = "Failed to copy user!";
}

$insert->close();
$conn->close();

header("Location: manageUser.php");
exit();
