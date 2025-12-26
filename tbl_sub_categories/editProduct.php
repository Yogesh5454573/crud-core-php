<?php 
include("../config.php");

$categoryQuery = "SELECT id, category_name FROM tbl_categories";
$categoryResult = $conn->query($categoryQuery);
if (!$categoryResult) {
    die("Category Query Failed: " . $conn->error);
}
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM tbl_sub_categories WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            die("<div class='alert alert-danger'>Category not found!</div>");
        }
        $stmt->close();
    } else {
        die("<div class='alert alert-danger'>Database error: " . $conn->error . "</div>");
    }
} else {
    die("<div class='alert alert-danger'>Invalid request!</div>");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <link rel="stylesheet" href="../asset/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../asset/bootstrap/css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="../asset/css/theme.css">
    <link rel="stylesheet" href="../asset/images/icons/css/font-awesome.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <?php include('../commen/header.php'); ?>
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <?php include('../commen/sidebar.php'); ?>
                <div class="span9">
                    <div class="content">
                        <div class="module">
                            <div class="module-head">
                                <h3>Edit Sub-Category</h3>
                            </div>
                            <div class="module-body">
                                <form class="form-horizontal row-fluid needs-validation" id="updatedata"
                                    action="updatedata.php?id=<?php echo urlencode($id); ?>" method="POST" novalidate>
                                    <div class="control-group">
                                        <label class="control-label">Select Category</label>
                                        <div class="controls">
                                            <select name="category_id" class="span8" required>
                                                <option value="">-- Select Category --</option>
                                                <?php 
                                                while ($categoryRow = $categoryResult->fetch_assoc()) { 
                                                    $selected = ($row['category_id'] == $categoryRow['id']) ? 'selected' : '';
                                                    echo '<option value="' . intval($categoryRow['id']) . '" ' . $selected . '>' . htmlspecialchars($categoryRow['category_name']) . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Sub-Category Name:</label>
                                        <div class="controls">
                                            <input type="text" name="sub_category_name" placeholder="Enter Category Name"
                                                class="span8"
                                                value="<?php echo htmlspecialchars($row['sub_category_name']); ?>" required>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Category Description:</label>
                                        <div class="controls">
                                            <textarea class="span8" rows="5" name="s_c_description"
                                                placeholder="Enter Category Description"
                                                required><?php echo htmlspecialchars($row['s_c_description']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                            <a href="manageSubCategory.php" class="btn btn-danger">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   <?php include '../commen/footer.php'; ?>
    $conn->close();
    ?>
  <script>
document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("updatedata");
    form.addEventListener("submit", function(event) {
        let isValid = true;
        const categoryName = document.querySelector("select[name='category_name']");
        const subCategoryName = document.querySelector("input[name='sub_category_name']");
        const categoryDescription = document.querySelector("textarea[name='s_c_description']");
        document.querySelectorAll(".error-message").forEach(el => el.remove());
        if (!categoryName.value.trim()) {
            showError(categoryName, "*Please select a category.");
            isValid = false;
        }
        const subCategoryName = document.getElementById("sub_category_name");
        if (subCategoryName.value.trim() === "") {
            showError(subCategoryName, "*Sub-category Name is required.");
        } else {
            clearError(subCategoryName);
        }
        if (!categoryDescription.value.trim()) {
            showError(categoryDescription, "*Category description is required.");
            isValid = false;
        }
        if (!isValid) {
            event.preventDefault();
        }
    });
    function showError(inputElement, message) {
        if (!inputElement.parentNode.querySelector(".error-message")) {
            const errorMessage = document.createElement("div");
            errorMessage.className = "error-message text-danger";
            errorMessage.style.fontSize = "14px";
            errorMessage.textContent = message;
            inputElement.parentNode.appendChild(errorMessage);
        }
    }
});
</script>
</body>

</html>
