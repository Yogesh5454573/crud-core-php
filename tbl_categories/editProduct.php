<?php
include("config.php");

// Validate and fetch category data securely
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("SELECT * FROM tbl_categories WHERE id = ?");
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

    <!-- Bootstrap & CSS -->
    <link rel="stylesheet" href="../asset/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../asset/bootstrap/css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="../asset/css/theme.css">
    <link rel="stylesheet" href="../asset/images/icons/css/font-awesome.css">

    <!-- Google Fonts & Icons -->
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
                                <h3>Edit Category</h3>
                            </div>
                            <div class="module-body">
                                <form class="form-horizontal row-fluid needs-validation" id="updatedata"
                                    action="updatedata.php?id=<?php echo urlencode($id); ?>" method="POST" novalidate>

                                    <!-- Category Name -->
                                    <div class="control-group">
                                        <label class="control-label">Category Name:</label>
                                        <div class="controls">
                                            <input type="text" name="category_name" placeholder="Enter Category Name"
                                                class="span8"
                                                value="<?php echo htmlspecialchars($row['category_name']); ?>" required>
                                        </div>
                                    </div>

                                    <!-- Category Description -->
                                    <div class="control-group">
                                        <label class="control-label">Category Description:</label>
                                        <div class="controls">
                                            <textarea class="span8" rows="5" name="c_description"
                                                placeholder="Enter Category Description"
                                                required><?php echo htmlspecialchars($row['c_description']); ?></textarea>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="control-group">
                                        <div class="controls">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
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

    <?php include '../commen/footer.php';
    $conn->close();
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("updatedata");

            form.addEventListener("submit", function(event) {
                let isValid = true;

                // Fetch form elements
                const categoryName = document.querySelector("input[name='category_name']");
                const categoryDescription = document.querySelector("textarea[name='c_description']");

                // Clear previous error messages
                document.querySelectorAll(".error-message").forEach(el => el.remove());

                // Validate category name (only letters and spaces)
                const namePattern = /^[a-zA-Z\s]+$/;
                if (!categoryName.value.trim()) {
                    showError(categoryName, "*Category name is required.");
                    isValid = false;
                } else if (!namePattern.test(categoryName.value)) {
                    showError(categoryName, "*Category name should contain only letters and spaces.");
                    isValid = false;
                }

                // Validate category description (not empty)
                if (!categoryDescription.value.trim()) {
                    showError(categoryDescription, "*Category description is required.");
                    isValid = false;
                }

                // Prevent form submission if validation fails
                if (!isValid) {
                    event.preventDefault();
                }
            });

            // Function to display error messages
            function showError(inputElement, message) {
                const errorMessage = document.createElement("div");
                errorMessage.className = "error-message text-danger";
                errorMessage.style.fontSize = "14px";
                errorMessage.textContent = message;
                inputElement.parentNode.appendChild(errorMessage);
            }
        });
    </script>

</body>

</html>