<?php

session_start();

include 'config.php';

$sql = "SELECT * FROM tbl_categories";
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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
    <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="css/theme.css" rel="stylesheet">
    <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
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
                            <h3>Manage Categories</h3>
                            <div style="text-align: right; margin-top: -25px;">
                                <a href="addProduct.php">
                                    <button class="btn btn-primary">Add Category</button>
                                </a>
                            </div>
                        </div>

                        <div class="module-body table">
                            <table id="productsTable" class="datatable-1 table table-bordered table-striped display"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Category Name</th>
                                        <th>Category Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rows as $row) { ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo htmlspecialchars($row["category_name"]); ?></td>
                                        <td><?php echo htmlspecialchars($row["c_description"]); ?></td>
                                        <td style="white-space: nowrap; display: flex; align-items: center; gap: 15px;">
                                            <!-- Edit Button -->
                                            <a href="editProduct.php?id=<?php echo $row['id']; ?>" class="fa fa-edit"
                                                style="font-size: 24px; color: blue;" title="Edit Product"></a>

                                            <!-- Delete Button -->
                                            <a href="delete.php?id=<?php echo $row['id']; ?>" class="material-icons"
                                                style="font-size: 26px; color: red;"
                                                onclick="return confirm('Are you sure you want to delete this product?');"
                                                title="Delete Product">delete</a>

                                            <!-- Copy Button -->
                                            <a href="copy.php?id=<?php echo $row['id']; ?>" class="fa fa-copy"
                                                style="font-size: 24px; color: green;"
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
    <script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="scripts/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="scripts/common.js" type="text/javascript"></script>
    <script>
    $(document).ready(function() {
        $('#productsTable').DataTable();
    });
    </script>



</body>

</html>