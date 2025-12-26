<?php
include '../config/config.php';
session_start(); 
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id']; 
    $sql = "SELECT * FROM products WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
        } else {
            $_SESSION['error'] = "Product not found!";
            header("Location: manageProduct.php");
            exit;
        }
        $stmt->close();
    } else {
        die("Error fetching product: " . $conn->error);
    }
} else {
    $_SESSION['error'] = "Invalid request!";
    header("Location: manageProduct.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_name = trim($_POST['category_name'] ?? '');
    $sub_category_name = trim($_POST['sub_category_name'] ?? '');
    $product_name = trim($_POST['product_name'] ?? '');
    $product_details = trim($_POST['product_details'] ?? '');
    $product_color = trim($_POST['product_color'] ?? '');
    $product_price = trim($_POST['product_price'] ?? '');
    if (!is_numeric($product_price) || $product_price < 0) {
        $_SESSION["error"] = "Invalid product price.";
        header("Location: editProduct.php?id=" . $id);
        exit;
    }
    $update_sql = "UPDATE products SET 
        category_name = ?, 
        sub_category_name = ?, 
        product_name = ?, 
        product_details = ?, 
        product_color = ?, 
        product_price = ?
        WHERE id = ?";
    if ($stmt = $conn->prepare($update_sql)) {
        $stmt->bind_param("sssssdi", $category_name, $sub_category_name, $product_name, $product_details, $product_color, $product_price, $id);
        if ($stmt->execute()) {
            $_SESSION["success"] = "updated";
            header("Location: manageProduct.php");
            exit();
        } else {
            echo "Error updating record: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $_SESSION["error"] = "Error preparing query: " . $conn->error;
    }
}
$conn->close();
?>
