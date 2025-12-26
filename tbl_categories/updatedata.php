<?php
include '../config.php';
session_start(); // Ensure session is started

// Validate ID from GET request
if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $_SESSION["error"] = "Invalid request!";
    header("Location: manageSubCategory.php");
    exit();
}

$id = (int)$_GET['id']; // Securely cast to integer

// Fetch existing category details securely
$sql = "SELECT * FROM tbl_categories WHERE id = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows !== 1) {
        $_SESSION["error"] = "Category not found!";
        header("Location: manageSubCategory.php");
        exit();
    }
    
    $row = $result->fetch_assoc();
    $stmt->close();
} else {
    $_SESSION["error"] = "Database error: " . $conn->error;
    header("Location: manageSubCategory.php");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $category_name = htmlspecialchars(trim($_POST['category_name']));
    $c_description = htmlspecialchars(trim($_POST['c_description']));

    // Validate inputs
    if (empty($category_name) || empty($c_description)) {
        $_SESSION["error"] = "All fields are required!";
        header("Location: editCategory.php?id=" . $id);
        exit();
    }

    // Update query using prepared statement
    $update_sql = "UPDATE tbl_categories SET category_name = ?, c_description = ? WHERE id = ?";
    
    if ($stmt = $conn->prepare($update_sql)) {
        $stmt->bind_param("ssi", $category_name, $c_description, $id);
        
        if ($stmt->execute()) {
            $_SESSION["success"] = "updated";
            header("Location: manageCategory.php");
            exit();
        } else {
            $_SESSION["error"] = "Error updating record: " . $stmt->error;
            header("Location: editCategory.php?id=" . $id);
            exit();
        }
        
        $stmt->close();
    } else {
        $_SESSION["error"] = "Database error: " . $conn->error;
        header("Location: editCategory.php?id=" . $id);
        exit();
    }
}

// Close the database connection
$conn->close();
?>
