<?php
include 'config.php';
header('Content-Type: application/json');
$response = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['category_id']) && !empty($_POST['category_id'])) {
        $category_id = intval($_POST['category_id']);
        $query = "SELECT id, sub_category_name FROM tbl_sub_categories WHERE category_id = ?";
        $stmt = $conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param("i", $category_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $subcategories = [];
            while ($row = $result->fetch_assoc()) {
                $subcategories[] = [
                    'id' => htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'),
                    'name' => htmlspecialchars($row['sub_category_name'], ENT_QUOTES, 'UTF-8')
                ];
            }
            $response = [
                "status" => "success",
                "message" => count($subcategories) > 0 ? "Subcategories retrieved successfully." : "No Subcategories Available",
                "data" => $subcategories
            ];
        } else {
            $response = ["status" => "error", "message" => "Database error: " . $conn->error];
        }
        $stmt->close();
    } 
    elseif (isset($_POST['subcategory_id'], $_POST['new_subcategory_name'])) {
        $subcategory_id = intval($_POST['subcategory_id']);
        $new_subcategory_name = trim($_POST['new_subcategory_name']);
        if (!empty($new_subcategory_name)) {
            $updateQuery = "UPDATE tbl_sub_categories SET sub_category_name = ? WHERE id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            if ($updateStmt) {
                $updateStmt->bind_param("si", $new_subcategory_name, $subcategory_id);
                if ($updateStmt->execute()) {
                    $response = ["status" => "success", "message" => "Subcategory updated successfully!"];
                } else {
                    $response = ["status" => "error", "message" => "Error updating subcategory: " . $conn->error];
                }
                $updateStmt->close();
            } else {
                $response = ["status" => "error", "message" => "Database error: " . $conn->error];
            }
        } else {
            $response = ["status" => "error", "message" => "New subcategory name cannot be empty."];
        }
    } else {
        $response = ["status" => "error", "message" => "Invalid request parameters."];
    }
} else {
    $response = ["status" => "error", "message" => "Invalid request method."];
}

echo json_encode($response);
$conn->close();
?>
