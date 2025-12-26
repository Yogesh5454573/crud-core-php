<?php
include 'config.php';
$categoryQuery = "SELECT id, category_name FROM tbl_categories";
$categoryResult = $conn->query($categoryQuery);
if (!$categoryResult) {
    die("Category Query Failed: " . $conn->error);
}
$subCategoryQuery = "SELECT id, sub_category_name, category_id FROM tbl_sub_categories";
$subCategoryResult = $conn->query($subCategoryQuery);
if (!$subCategoryResult) {
    die("Sub-Category Query Failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edmin - Add Product</title>
    <link rel="stylesheet" type="text/css" href="asset/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="asset/bootstrap/css/bootstrap-responsive.min.css">
    <link rel="stylesheet" type="text/css" href="asset/css/theme.css">
    <link rel="stylesheet" type="text/css" href="asset/images/icons/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    .error-message {
        color: red;
        font-size: 14px;
        margin-top: 5px;
    }
    </style>
    <script>
    $(document).ready(function() {
        $("#category_id").change(function() {
            var category_name = $(this).val();
            var $subCategory = $("#sub_category_name");

            if (category_name !== "") {
                $.ajax({
                    url: "fetch_subcategories.php",
                    type: "POST",
                    data: {
                        category_id: category_name
                    },
                    beforeSend: function() {
                        $subCategory.html('<option>Loading...</option>').prop("disabled",
                            true);
                    },
                    success: function(response) {
                        console.log("Response from PHP:", response); 
                        $subCategory.html(response).prop("disabled", false);
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                        $subCategory.html(
                                '<option value="">Error loading subcategories</option>')
                            .prop("disabled", true);
                    }
                });
            } else {
                $subCategory.html('<option value="">-- Select Subcategory --</option>').prop("disabled",
                    true);
            }
        });
    });
    </script>
</head>

<body>
    <?php include('commen/header.php'); ?>
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <?php include('commen/sidebar.php'); ?>
                <div class="span9">
                    <div class="content">
                        <div class="module">
                            <div class="module-head">
                                <h3>Add Product</h3>
                            </div>
                            <div style="text-align: right; margin-top: -35px;">
                                <a href="manageProduct.php">
                                    <button class="btn btn-success">Manage Product</button>
                                </a>
                            </div>
                            <div class="module-body">
                                <form id="productForm" class="form-horizontal row-fluid" method="POST"
                                    action="postdata.php">
                                    <div class="control-group">
                                        <label class="control-label">Select Category</label>
                                        <div class="controls">
                                            <select id="category_id" name="category_name" class="span8">
                                                <option value="">-- Select Category --</option>
                                                <?php while ($row = $categoryResult->fetch_assoc()) { ?>
                                                <option value="<?= htmlspecialchars($row['category_name']) ?>">
                                                    <?= htmlspecialchars($row['category_name']) ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Select Sub-Category</label>
                                        <div class="controls">
                                            <select id="sub_category_name" name="sub_category_name" class="span8"
                                                disabled>
                                                <option value="">-- Select Subcategory --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Product Name</label>
                                        <div class="controls">
                                            <input type="text" id="product_name" name="product_name"
                                                placeholder="Enter Product Name" class="span8">
                                            <span class="error-message"></span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Product Details</label>
                                        <div class="controls">
                                            <textarea id="product_details" class="span8" rows="5" name="product_details"
                                                placeholder="Enter Product Details"></textarea>
                                            <span class="error-message"></span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Select Product Color</label>
                                        <div class="controls">
                                            <label class="radio"><input type="radio" name="product_color" value="Red">
                                                Red</label>
                                            <label class="radio"><input type="radio" name="product_color" value="Green">
                                                Green</label>
                                            <label class="radio"><input type="radio" name="product_color" value="Black">
                                                Black</label>
                                            <span class="error-message"></span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Product Price</label>
                                        <div class="controls">
                                            <input type="number" id="product_price" name="product_price"
                                                placeholder="5000" class="span8" step="0.01" min="1">
                                            <span class="error-message"></span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <a href="manageProduct.php" class="btn btn-danger">Cancel</a>
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
    <?php include 'commen/footer.php'; ?>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById("productForm");
        form.addEventListener("submit", function(event) {
            let isValid = true;
            function showError(input, message) {
                let errorSpan = input.parentElement.querySelector(".error-message");
                if (!errorSpan) {
                    errorSpan = document.createElement("span");
                    errorSpan.classList.add("error-message");
                    input.parentElement.appendChild(errorSpan);
                }
                errorSpan.textContent = message;
                errorSpan.style.display = "block";
                input.classList.add("has-error");
                isValid = false;
            }
            function clearError(input) {
                let errorSpan = input.parentElement.querySelector(".error-message");
                errorSpan.textContent = "";
                input.classList.remove("has-error");
            }
            const requiredFields = ["category_id", "sub_category_name", "product_name",
                "product_details", "product_price"
            ];
            requiredFields.forEach(id => {
                const input = document.getElementById(id);
                if (input.value.trim() === "") {
                    showError(input, "*This field is required.");
                } else {
                    clearError(input);
                }
            });
            const productColor = document.querySelectorAll("input[name='product_color']");
            if (![...productColor].some(radio => radio.checked)) {
                showError(productColor[0].parentElement, "*Please select a product color.");
            } else {
                clearError(productColor[0].parentElement);
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
        document.querySelectorAll("input, textarea, select").forEach(input => {
            input.addEventListener("input", function() {
                clearError(input);
            });
            input.addEventListener("change", function() {
                clearError(input);
            });
        });
    });
    </script>
</body>

</html>