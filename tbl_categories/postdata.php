<?php
include '../config.php'; // Include the database connection

session_start(); // Start session at the beginning

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and sanitize input
    $c_name = trim($_POST['category_name']);
    $c_description = trim($_POST['c_description']);

    // Check if fields are not empty
    if (!empty($c_name) && !empty($c_description)) {
        // Use prepared statements to prevent SQL injection
        $sql = "INSERT INTO tbl_categories (category_name, c_description) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("ss", $c_name, $c_description); // "ss" means two string parameters

            if ($stmt->execute()) {
                $_SESSION["success"] = "added";
                $stmt->close();
                $conn->close();
                header("Location: manageCategory.php");
                exit; // Ensure no further execution after redirection
            } else {
                $_SESSION["error"] = "Error adding category: " . $stmt->error;
            }
        } else {
            $_SESSION["error"] = "Database error: " . $conn->error;
        }
    } else {
        $_SESSION["error"] = "All fields are required!";
    }
}

// Redirect back if there's an error
header("Location: manageCategory.php");
exit;

?>
