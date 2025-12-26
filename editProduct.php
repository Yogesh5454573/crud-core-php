<?php
include("config.php");
session_start();
$categoryQuery = "SELECT id, category_name FROM tbl_categories";
$categoryResult = $conn->query($categoryQuery);
if (!$categoryResult) {
    die("Category Query Failed: " . $conn->error);
}
$subCategoryQuery = "SELECT id, sub_category_name FROM tbl_sub_categories";
$subCategoryResult = $conn->query($subCategoryQuery);
if (!$subCategoryResult) {
    die("Sub-Category Query Failed: " . $conn->error);
}
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $productResult = $stmt->get_result();
    if ($productResult->num_rows > 0) {
        $productRow = $productResult->fetch_assoc();
    } else {
        $_SESSION["error"] = "Product not found!";
        header("Location: manageProduct.php");
        exit;
    }
} else {
    $_SESSION["error"] = "Invalid request!";
    header("Location: manageProduct.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Edmin</title>
    <link rel="stylesheet" href="asset/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="asset/bootstrap/css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="asset/css/theme.css">
    <link rel="stylesheet" href="asset/images/icons/css/font-awesome.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 15px;
        }
    </style>
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
                                <h3>Edit Product</h3>
                            </div>
                            <div class="module-body">
                                <form class="form-horizontal row-fluid needs-validation" id="updatedata"
                                    action="updatedata.php?id=<?php echo $id; ?>" method="POST" novalidate>
                                    <div class="control-group">
                                        <label class="control-label">Select Category</label>
                                        <div class="controls">
                                            <select name="category_name" class="span8" required>
                                                <option value="">-- Select Category --</option>
                                                <?php
                                                while ($categoryRow = $categoryResult->fetch_assoc()) {
                                                    $selected = ($productRow['category_name'] == $categoryRow['category_name']) ? 'selected' : '';
                                                    echo '<option value="' . htmlspecialchars($categoryRow['category_name']) . '" ' . $selected . '>' . htmlspecialchars($categoryRow['category_name']) . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Select Sub-Category</label>
                                        <div class="controls">
                                            <select name="sub_category_name" class="span8" required>
                                                <option value="">-- Select Sub-Category --</option>
                                                <?php
                                                while ($subCategoryRow = $subCategoryResult->fetch_assoc()) {
                                                    $selected = ($productRow['sub_category_name'] == $subCategoryRow['sub_category_name']) ? 'selected' : '';
                                                    echo '<option value="' . htmlspecialchars($subCategoryRow['sub_category_name']) . '" ' . $selected . '>' . htmlspecialchars($subCategoryRow['sub_category_name']) . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Product Name:</label>
                                        <div class="controls">
                                            <input type="text" name="product_name" class="span8"
                                                value="<?php echo htmlspecialchars($productRow['product_name']); ?>"
                                                required>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Product Details</label>
                                        <div class="controls">
                                            <textarea class="span8" rows="5" name="product_details"
                                                required><?php echo htmlspecialchars($productRow['product_details']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Select Product Color</label>
                                        <div class="controls">
                                            <?php
                                            $colors = ["Red", "Green", "Black"];
                                            foreach ($colors as $color) {
                                                $checked = ($productRow['product_color'] == $color) ? 'checked' : '';
                                                echo "<label class='radio'><input type='radio' name='product_color' value='$color' $checked> $color</label>";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Product Price</label>
                                        <div class="controls">
                                            <div class="input-append">
                                                <input type="number" name="product_price" class="span8" step="0.01"
                                                    value="<?php echo htmlspecialchars($productRow['product_price']); ?>"
                                                    required>
                                                <span class="add-on">$</span>
                                            </div>
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
    <?php include('commen/footer.php'); ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("updatedata");
            form.addEventListener("submit", function(event) {
                let isValid = true;

                function showError(input, message) {
                    let parent = input.closest(".controls"); 
                    let errorSpan = parent.querySelector(".error-message");
                    if (!errorSpan) {
                        errorSpan = document.createElement("span");
                        errorSpan.classList.add("error-message");
                        parent.appendChild(errorSpan);
                    }
                    errorSpan.textContent = message;
                    errorSpan.style.display = "block";
                    input.classList.add("has-error");
                    isValid = false;
                }

                function clearError(input) {
                    let parent = input.closest(".controls");
                    if (!parent) return; 
                    let errorSpan = parent.querySelector(".error-message");
                    if (errorSpan) {
                        errorSpan.style.display = "none";
                        errorSpan.textContent = "";
                    }
                    input.classList.remove("has-error");
                }
                const requiredFields = ["category_name", "sub_category_name", "product_name",
                    "product_details", "product_price"
                ];
                requiredFields.forEach(name => {
                    const input = document.querySelector(`[name='${name}']`);
                    if (input && input.value.trim() === "") {
                        showError(input, "This field is required.");
                    } else if (input) {
                        clearError(input);
                    }
                });
                const productPrice = document.querySelector("input[name='product_price']");
                if (productPrice && productPrice.value.trim() !== "") {
                    const priceValue = parseFloat(productPrice.value);
                    if (isNaN(priceValue) || priceValue <= 0) {
                        showError(productPrice, "Please enter a valid price greater than 0.");
                    }
                }
                const productColor = document.querySelectorAll("input[name='product_color']");
                const colorContainer = productColor.length > 0 ? productColor[0].closest(".controls") :
                    null;
                if (colorContainer && ![...productColor].some(radio => radio.checked)) {
                    showError(colorContainer, "Please select a product color.");
                } else if (colorContainer) {
                    clearError(colorContainer);
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