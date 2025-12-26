<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edmin - Add Categories</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="css/theme.css">
    <link rel="stylesheet" href="images/icons/css/font-awesome.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
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
                            <div class="module-head d-flex justify-content-between align-items-center">
                                <h3>Add Categories</h3>
                                <div style="display: flex; justify-content: flex-end; margin-top: -25px;">
                                    <a href="manageCategory.php" class="btn btn-success">Categories</a>
                                </div>
                            </div>
                            <div class="module-body">
                                <form id="categoryForm" class="form-horizontal row-fluid needs-validation" method="POST"
                                    action="postdata.php" novalidate>
                                    <div class="control-group">
                                        <label class="control-label">Category Name</label>
                                        <div class="controls">
                                            <input type="text" id="category_name" name="category_name"
                                                placeholder="Enter Category Name" class="span8">
                                            <span class="error-message"></span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Category Description</label>
                                        <div class="controls">
                                            <textarea id="c_description" class="span8" rows="5" name="c_description"
                                                placeholder="Enter Category Description"></textarea>
                                            <span class="error-message"></span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <a href="manageCategory.php" class="btn btn-danger">Cancel</a>
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
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("categoryForm");
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
                    if (errorSpan) {
                        errorSpan.textContent = "";
                    }
                    input.classList.remove("has-error");
                }
                const category_name = document.getElementById("category_name");
                if (category_name.value.trim() === "") {
                    showError(category_name, "*Category Name is required.");
                } else {
                    clearError(category_name);
                }
                if (!isValid) {
                    event.preventDefault();
                }
                const categoryDescription = document.getElementById("c_description");
                if (categoryDescription.value.trim() === "") {
                    showError(categoryDescription, "*Category Description is required.");
                } else {
                    clearError(categoryDescription);
                }
                if (!isValid) {
                    event.preventDefault();
                }
            });
            document.querySelectorAll("input, textarea").forEach(input => {
                input.addEventListener("input", function() {
                    clearError(input);
                });
            });
        });
    </script>
</body>

</html>