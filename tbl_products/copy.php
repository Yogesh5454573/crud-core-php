<?php
session_start();
include '../config/config.php';
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id']; 
    $sql = "SELECT category_name, sub_category_name, product_name, product_details, product_color, product_price FROM products WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $insert_sql = "INSERT INTO products (category_name, sub_category_name, product_name, product_details, product_color, product_price) VALUES (?, ?, ?, ?, ?, ?)";
            if ($insert_stmt = $conn->prepare($insert_sql)) {
                $insert_stmt->bind_param("sssssi", 
                    $row['category_name'],
                    $row['sub_category_name'], 
                    $row['product_name'],
                    $row['product_details'],
                    $row['product_color'],
                    $row['product_price']
                );
                if ($insert_stmt->execute()) {
                    $_SESSION["success"] = "copied";
                    header("Location: manageProduct.php");
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
?>
