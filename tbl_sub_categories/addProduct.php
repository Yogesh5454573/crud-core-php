<?php
include '../config.php';
$sql = "SELECT id, category_name FROM tbl_categories";
$result = $conn->query($sql);
if (!$result) {
    die("Database Query Failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Sub-Category</title>
    <link rel="stylesheet" href="../asset/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../asset/css/theme.css">
    <link rel="stylesheet" href="../asset/images/icons/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
            display: none;
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
                                <h3>Add Sub-Category</h3>
                                <div style="text-align: right; margin-top: -25px;">
                                    <a href="manageSubCategory.php" class="btn btn-success">Sub-Categories</a>
                                </div>
                            </div>
                            <div class="module-body">
                                <form id="subCategoryForm" class="form-horizontal row-fluid" method="POST" action="postdata.php" novalidate>
                                    <div class="control-group">
                                        <label class="control-label">Select Category</label>
                                        <div class="controls">
                                            <select id="category_id" name="category_id" class="span8">
                                                <option value="">-- Select Category --</option>
                                                <?php 
                                                while ($row = $result->fetch_assoc()) { 
                                                    echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['category_name']) . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <span class="error-message">Please select a category.</span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Sub-category Name</label>
                                        <div class="controls">
                                            <input type="text" id="sub_category_name" name="sub_category_name" placeholder="Enter Sub-category Name" class="span8">
                                            <span class="error-message">Sub-category Name is required.</span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Sub-category Description</label>
                                        <div class="controls">
                                            <textarea id="s_c_description" class="span8" rows="5" name="s_c_description" placeholder="Enter Sub-category Details"></textarea>
                                            <span class="error-message">Sub-category Description is required.</span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <button type="submit" class="btn btn-primary">Submit</button>
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
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("subCategoryForm");
        form.addEventListener("submit", function (event) {
            let isValid = true;
            function validateField(input, message) {
                const errorSpan = input.nextElementSibling;
                if (input.value.trim() === "") {
                    errorSpan.style.display = "block";
                    input.classList.add("has-error");
                    isValid = false;
                } else {
                    errorSpan.style.display = "none";
                    input.classList.remove("has-error");
                }
            }
            validateField(document.getElementById("category_id"), "*Please select a category.");
            validateField(document.getElementById("sub_category_name"), "*Sub-category Name is required.");
            validateField(document.getElementById("s_c_description"), "*Sub-category Description is required.");
            if (!isValid) {
                event.preventDefault();
            }
        });
        document.querySelectorAll("input, textarea, select").forEach(input => {
            input.addEventListener("input", function () {
                input.nextElementSibling.style.display = "none";
                input.classList.remove("has-error");
            });
            input.addEventListener("change", function () {
                input.nextElementSibling.style.display = "none";
                input.classList.remove("has-error");
            });
        });
    });
    </script>
</body>
</html>
