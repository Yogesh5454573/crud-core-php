<?php
session_start();
include '../config.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "SELECT category_id, sub_category_name, s_c_description FROM tbl_sub_categories WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $insert_sql = "INSERT INTO tbl_sub_categories (category_id, sub_category_name, s_c_description) VALUES (?, ?, ?)";
            if ($insert_stmt = $conn->prepare($insert_sql)) {
                $insert_stmt->bind_param(
                    "sss",
                    $row['category_id'],
                    $row['sub_category_name'],
                    $row['s_c_description']
                );
                if ($insert_stmt->execute()) {
                    $_SESSION["success"] = "copied";
                    header("Location: manageSubCategory.php");
                    exit();
                } else {
                    echo "Error copying category: " . $insert_stmt->error;
                }
                $insert_stmt->close();
            } else {
                echo "Error preparing insert statement: " . $conn->error;
            }
        } else {
            echo "Category not found!";
        }
        $stmt->close();
    } else {
        echo "Error preparing fetch statement: " . $conn->error;
    }
} else {
    echo "Invalid request!";
}
$conn->close();
