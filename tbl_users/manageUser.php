<?php
session_start();
include '../config/config.php';
$sql = "SELECT id, name, email, mobile
        FROM tbl_users";
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
    <title>Manage Users</title>
    <link type="text/css" href="../asset/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="../asset/css/theme.css" rel="stylesheet">
    <link type="text/css" href="../asset/images/icons/css/font-awesome.css" rel="stylesheet">
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
                            <h3>Manage Users</h3>
                            <div style="text-align: right; margin-top: -25px;">
                                <a href="addUser.php" class="btn btn-primary">Add User</a>
                            </div>
                        </div>

                        <div class="module-body table">
                            <table id="productsTable" class="datatable-1 table table-bordered table-striped display"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>Sr. No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rows as $row): ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo htmlspecialchars($row["name"]); ?></td>
                                            <td><?php echo htmlspecialchars($row["email"]); ?></td>
                                            <td><?php echo htmlspecialchars($row["mobile"]); ?></td>
                                            <td style="white-space: nowrap; display: flex; align-items: center; gap: 10px;">
                                                <a href="editUser.php?id=<?php echo $row['id']; ?>" class="fa fa-edit"
                                                    style="font-size: 20px; color: blue;" title="Edit User"></a>
                                                <a href="deleteUser.php?id=<?php echo $row['id']; ?>" class="material-icons"
                                                    style="font-size: 22px; color: red;"
                                                    onclick="return confirm('Are you sure you want to delete this User?');"
                                                    title="Delete User">delete</a>
                                                <a href="copyUser.php?id=<?php echo $row['id']; ?>" class="fa fa-copy"
                                                    style="font-size: 20px; color: green;"
                                                    onclick="return confirm('Are you sure you want to copy this User?');"
                                                    title="Copy User"></a>
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
    <script src="../asset/scripts/jquery-1.9.1.min.js"></script>
    <script src="../asset/scripts/jquery-ui-1.10.1.custom.min.js"></script>
    <script src="../asset/bootstrap/js/bootstrap.min.js"></script>
    <script src="../asset/scripts/datatables/jquery.dataTables.js"></script>
    <script src="../asset/scripts/common.js"></script>
    <script>
        $(document).ready(function() {
            $('#productsTable').DataTable();
        });
    </script>
</body>

</html>