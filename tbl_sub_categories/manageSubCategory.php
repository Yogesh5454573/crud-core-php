<?php
session_start();
include 'config.php';
$sql = "SELECT sc.id, sc.sub_category_name, sc.s_c_description, c.category_name
        FROM tbl_sub_categories sc
        JOIN tbl_categories c ON sc.category_id = c.id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    echo "Error: " . $conn->error;
    exit;
}

$rows = $result->fetch_all(MYSQLI_ASSOC);
$i = 1;

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Sub-Categories</title>
    <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="css/theme.css" rel="stylesheet">
    <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php include('../commen/header.php'); ?>
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <?php include('../commen/sidebar.php'); ?>
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
                            <h3>Manage Sub-Categories</h3>
                            <div style="text-align: right; margin-top: -25px;">
                                <a href="addProduct.php" class="btn btn-primary">Add Sub-Category</a>
                            </div>
                        </div>

                        <div class="module-body table">
                            <table id="productsTable" class="datatable-1 table table-bordered table-striped display"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>Sr. No</th>
                                        <th>Category Name</th>
                                        <th>Sub-Category Name</th>
                                        <th>Category Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rows as $row): ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo htmlspecialchars($row["category_name"]); ?></td>
                                            <td><?php echo htmlspecialchars($row["sub_category_name"]); ?></td>
                                            <td><?php echo htmlspecialchars($row["s_c_description"]); ?></td>
                                            <td style="white-space: nowrap; display: flex; align-items: center; gap: 10px;">
                                                <a href="editProduct.php?id=<?php echo $row['id']; ?>" class="fa fa-edit"
                                                    style="font-size: 20px; color: blue;" title="Edit Product"></a>
                                                <a href="delete.php?id=<?php echo $row['id']; ?>" class="material-icons"
                                                    style="font-size: 22px; color: red;"
                                                    onclick="return confirm('Are you sure you want to delete this product?');"
                                                    title="Delete Product">delete</a>
                                                <a href="copy.php?id=<?php echo $row['id']; ?>" class="fa fa-copy"
                                                    style="font-size: 20px; color: green;"
                                                    onclick="return confirm('Are you sure you want to copy this product?');"
                                                    title="Copy Product"></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../commen/footer.php'; ?>
    <script src="scripts/jquery-1.9.1.min.js"></script>
    <script src="scripts/jquery-ui-1.10.1.custom.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="scripts/datatables/jquery.dataTables.js"></script>
    <script src="scripts/common.js"></script>
    <script>
        $(document).ready(function() {
            $('#productsTable').DataTable();
        });
    </script>
</body>

</html>