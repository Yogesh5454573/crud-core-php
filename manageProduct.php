<?php
session_start();
include 'config.php';
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
if (!$result) {
    echo "Error: " . $conn->error;
    exit;
}
$rows = $result->fetch_all(MYSQLI_ASSOC);
$i = 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link type="text/css" href="asset/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="asset/css/theme.css" rel="stylesheet">
    <link type="text/css" href="asset/images/icons/css/font-awesome.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php include('commen/header.php'); ?>
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <?php include('commen/sidebar.php'); ?>
                <div class="span9">
                    <?php if (isset($_SESSION["success"])): ?>
                    <div class="alert alert-success flash-message">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Well done!</strong>
                        <?php
                        $messages = [
                                'added' => 'Data Added Successfully',
                                'updated' => 'Data Updated Successfully',
                                'copied' => 'Data Copied Successfully',
                                'deleted' => 'Data Deleted Successfully'
                              ];
                            echo $messages[$_SESSION['success']] ?? 'Action Completed Successfully';
                          ?>
                    </div>
                    <?php unset($_SESSION["success"]); ?>
                    <?php endif; ?>
                    <div class="module">
                        <div class="module-head">
                            <h3>Manage Products</h3>
                            <div style="text-align: right; margin-top: -25px;">
                                <a href="addProduct.php">
                                    <button class="btn btn-primary">Add Product</button>
                                </a>
                            </div>
                        </div>
                        <div class="module-body table">
                            <table id="productsTable" class="datatable-1 table table-bordered table-striped display"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Product Category</th>
                                        <th>Product Sub-Category</th>
                                        <th>Product Name</th>
                                        <th>Product Details</th>
                                        <th>Product Color</th>
                                        <th>Product Price ($)</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rows as $row) { ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo htmlspecialchars($row["category_name"]); ?></td>
                                        <td><?php echo htmlspecialchars($row["sub_category_name"]); ?></td>
                                        <td><?php echo htmlspecialchars($row["product_name"]); ?></td>
                                        <td><?php echo htmlspecialchars($row["product_details"]); ?></td>
                                        <td><?php echo htmlspecialchars($row["product_color"]); ?></td>
                                        <td><?php echo number_format((float)$row["product_price"], 2, '.', ''); ?></td>
                                        <td class="d-flex justify-content-center align-items-center gap-3">
                                            <a href="editProduct.php?id=<?php echo $row['id']; ?>"
                                                class="fa fa-edit text-primary" style="font-size: 20px;"
                                                title="Edit Product"></a>

                                            <a href="delete.php?id=<?php echo $row['id']; ?>"
                                                class="material-icons text-danger" style="font-size: 22px;"
                                                onclick="return confirm('Are you sure you want to delete this product?');"
                                                title="Delete Product">delete</a>

                                            <a href="copy.php?id=<?php echo $row['id']; ?>"
                                                class="fa fa-copy text-success" style="font-size: 20px;"
                                                onclick="return confirm('Are you sure you want to copy this product?');"
                                                title="Copy Product"></a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'commen/footer.php'; ?>
    <script src="asset/scripts/jquery-1.9.1.min.js"></script>
    <script src="asset/bootstrap/js/bootstrap.min.js"></script>
    <script src="asset/scripts/datatables/jquery.dataTables.js"></script>
    <script src="asset/scripts/common.js"></script>
    <script>
    $(document).ready(function() {
        $('#productsTable').DataTable();
    });
    </script>
</body>
</html>