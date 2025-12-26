<?php
session_start(); 
include("../config/config.php");
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM tbl_categories WHERE id = ?");
    $stmt->bind_param("i", $id); 
    if ($stmt->execute()) {
        $_SESSION['success'] = "deleted"; 
    } else {
        $_SESSION['error'] = "Error deleting product."; 
    }
    $stmt->close();
} else {
    $_SESSION['error'] = "Invalid product ID."; 
}
$conn->close();
header("Location: manageCategory.php");
exit; 
?>
