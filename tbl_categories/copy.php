<?php
session_start();
include 'config.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id']; // Ensure ID is an integer

    // Fetch existing category details
    $sql = "SELECT category_name, c_description FROM tbl_categories WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            
            // Prepare INSERT statement to duplicate category
            $insert_sql = "INSERT INTO tbl_categories (category_name, c_description) VALUES (?, ?)";

            if ($insert_stmt = $conn->prepare($insert_sql)) {
                $insert_stmt->bind_param("ss", 
                    $row['category_name'], 
                    $row['c_description']
                );

                if ($insert_stmt->execute()) {
                    $_SESSION["success"] = "copied";
                    header("Location: manageCategory.php");
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
