<?php
include '../config.php';
session_start(); // Ensure session starts at the beginning

// Validate ID from GET request
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION["error"] = "Invalid subcategory ID!";
    header("Location: manageSubCategory.php");
    exit();
}

$id = (int)$_GET['id']; // Ensure ID is an integer

// Fetch the existing subcategory details securely
$sql = "SELECT * FROM tbl_sub_categories WHERE id = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows !== 1) {
        $_SESSION["error"] = "Subcategory not found!";
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
    $category_id = isset($_POST['category_id']) ? trim($_POST['category_id']) : '';
    $sub_category_name = isset($_POST['sub_category_name']) ? trim($_POST['sub_category_name']) : '';
    $c_description = isset($_POST['s_c_description']) ? trim($_POST['s_c_description']) : '';

    // Validate inputs
    if (empty($category_id) || empty($sub_category_name) || empty($c_description)) {
        $_SESSION["error"] = "All fields are required!";
        header("Location: editProduct.php?id=" . $id);
        exit();
    }

    // Ensure category_id is numeric
    if (!is_numeric($category_id)) {
        $_SESSION["error"] = "Invalid category ID!";
        header("Location: editProduct.php?id=" . $id);
        exit();
    }

    // Update query using prepared statement
    $update_sql = "UPDATE tbl_sub_categories SET category_id = ?, sub_category_name = ?, s_c_description = ? WHERE id = ?";

    if ($stmt = $conn->prepare($update_sql)) {
        $stmt->bind_param("issi", $category_id, $sub_category_name, $c_description, $id);

        if ($stmt->execute()) {
            $_SESSION["success"] = "Subcategory updated successfully!";
            header("Location: manageSubCategory.php");
            exit();
        } else {
            $_SESSION["error"] = "Error updating record: " . $stmt->error;
            header("Location: editProduct.php?id=" . $id);
            exit();
        }

        $stmt->close();
    } else {
        $_SESSION["error"] = "Database error: " . $conn->error;
        header("Location: editProduct.php?id=" . $id);
        exit();
    }
}

// Close the database connection
$conn->close();
?>
