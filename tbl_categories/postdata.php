<?php
include '../config.php';
session_start(); 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $c_name = trim($_POST['category_name']);
    $c_description = trim($_POST['c_description']);
    if (!empty($c_name) && !empty($c_description)) {
        $sql = "INSERT INTO tbl_categories (category_name, c_description) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ss", $c_name, $c_description);
            if ($stmt->execute()) {
                $_SESSION["success"] = "added";
                $stmt->close();
                $conn->close();
                header("Location: manageCategory.php");
                exit;
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
header("Location: manageCategory.php");
exit;
?>
