<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("../config/config.php"); 
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "Invalid category ID."; 
    header("Location: manageSubCategory.php");
    exit();
}
$id = intval($_GET['id']);
$stmt = $conn->prepare("DELETE FROM tbl_sub_categories WHERE id = ?");
if ($stmt) {
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['success'] = "deleted";
    } else {
        $_SESSION['error'] = "Error deleting category: " . htmlspecialchars($stmt->error);
    }
    $stmt->close();
} else {
    $_SESSION['error'] = "Database error: " . htmlspecialchars($conn->error);
}

$conn->close();
header("Location: manageSubCategory.php");
exit();
?>
