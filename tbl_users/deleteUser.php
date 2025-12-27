<?php
session_start();
include '../config/config.php';

if (!isset($_GET['id'])) {
    header("Location: manageUser.php");
    exit();
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("DELETE FROM tbl_users WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $_SESSION['success'] = "User deleted successfully!";
} else {
    $_SESSION['error'] = "Failed to delete user!";
}

$stmt->close();
$conn->close();

header("Location: manageUser.php");
exit();
