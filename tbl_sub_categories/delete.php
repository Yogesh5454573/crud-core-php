<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("config.php"); // Database connection

// Check if 'id' is set and is a valid integer
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "Invalid category ID."; // Handle missing/invalid ID
    header("Location: manageSubCategory.php");
    exit();
}

$id = intval($_GET['id']); // Convert to integer

// Prepare and execute SQL statement
$stmt = $conn->prepare("DELETE FROM tbl_sub_categories WHERE id = ?");
if ($stmt) {
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "deleted"; // Success message
    } else {
        $_SESSION['error'] = "Error deleting category: " . htmlspecialchars($stmt->error);
    }

    $stmt->close(); // Close statement
} else {
    $_SESSION['error'] = "Database error: " . htmlspecialchars($conn->error);
}

$conn->close(); // Close database connection

// Redirect back to manageProduct.php
header("Location: manageSubCategory.php");
exit(); // Ensure script stops here
?>
