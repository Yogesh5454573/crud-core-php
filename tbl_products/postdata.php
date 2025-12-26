<?php
session_start(); 
include '../config/config.php'; 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = trim(htmlspecialchars($_POST['category_name']));
    $sub_category_name = trim(htmlspecialchars($_POST['sub_category_name']));
    $product_name = trim(htmlspecialchars($_POST['product_name']));
    $product_details = trim(htmlspecialchars($_POST['product_details']));
    $product_type = trim(htmlspecialchars($_POST['product_type']));
    $product_color = trim(htmlspecialchars($_POST['product_color']));
    $product_price = floatval($_POST['product_price']); 
    $sql = "INSERT INTO products (category_name, sub_category_name, product_name, product_details, product_color, product_price) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sssssd", $category_name, $sub_category_name, $product_name, $product_details, $product_color, $product_price);
        if ($stmt->execute()) {
            $_SESSION["success"] = "added";
            header("Location: manageProduct.php");
            exit();
        } else {
            $_SESSION["error"] = "Error adding product: " . $stmt->error;
            header("Location: addProduct.php");
            exit();
        }
        $stmt->close();
    } else {
        $_SESSION["error"] = "Database error: " . $conn->error;
        header("Location: addProduct.php");
        exit();
    }
}
$conn->close();
?>
