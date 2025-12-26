<?php
session_start(); 
include '../config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
    $sub_category_name = trim($_POST['sub_category_name']);
    $s_c_description = trim($_POST['s_c_description']);
    if (empty($category_id) || empty($sub_category_name) || empty($s_c_description)) {
        $_SESSION["error"] = "All fields are required!";
        header("Location: addSubCategory.php");
        exit();
    }
    $sql = "INSERT INTO tbl_sub_categories (category_id, sub_category_name, s_c_description) VALUES (?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("iss", $category_id, $sub_category_name, $s_c_description);
        if ($stmt->execute()) {
            $_SESSION["success"] = "Sub-category added successfully!";
            header("Location: manageSubCategory.php"); 
            exit();
        } else {
            $_SESSION["error"] = "Database error: " . $stmt->error;
            header("Location: addSubCategory.php");
            exit();
        }
        $stmt->close();
    } else {
        $_SESSION["error"] = "Database error: " . $conn->error;
        header("Location: addSubCategory.php");
        exit();
    }
}
$conn->close(); 
?>
