<?php
include 'config.php';
if (isset($_POST['category_id'])) {
    $category_name = $_POST['category_id'];
    $categoryQuery = "SELECT id FROM tbl_categories WHERE category_name = ?";
    $stmt = $conn->prepare($categoryQuery);
    $stmt->bind_param("s", $category_name);
    $stmt->execute();
    $result = $stmt->get_result(); 
    if ($row = $result->fetch_assoc()) {
        $category_id = $row['id'];
        $subCategoryQuery = "SELECT sub_category_name FROM tbl_sub_categories WHERE category_id = ?";
        $stmt2 = $conn->prepare($subCategoryQuery);
        $stmt2->bind_param("i", $category_id);
        $stmt2->execute();
        $subCategoryResult = $stmt2->get_result();
        echo '<option value="">-- Select Subcategory --</option>';
        while ($subRow = $subCategoryResult->fetch_assoc()) {
            echo '<option value="' . htmlspecialchars($subRow['sub_category_name']) . '">' . htmlspecialchars($subRow['sub_category_name']) . '</option>';
        }
    } else {
        echo '<option value="">No subcategories found</option>';
    }
}
?>
