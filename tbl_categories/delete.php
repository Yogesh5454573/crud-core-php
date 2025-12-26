<?php
session_start(); // Start session to store messages

include("../config.php");

// Check if 'id' is set and is a valid integer
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']); // Convert to integer to prevent injection

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM tbl_categories WHERE id = ?");
    $stmt->bind_param("i", $id); // Bind integer parameter

    if ($stmt->execute()) {
        $_SESSION['success'] = "deleted"; // Store success message in session
    } else {
        $_SESSION['error'] = "Error deleting product."; // Store error message
    }

    $stmt->close(); // Close statement
} else {
    $_SESSION['error'] = "Invalid product ID."; // Handle invalid or missing ID
}

$conn->close();

// Redirect back to manageProduct.php with session message
header("Location: manageCategory.php");
exit; // Ensure script stops here
?>
