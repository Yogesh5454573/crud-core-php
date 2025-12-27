<?php
include '../config/config.php';

if (!isset($_GET['id'])) {
    header("Location: manageAdmin.php");
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM tbl_admin WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: manageAdmin.php");
    exit();
}

$user = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
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
                                <h3>Edit Admin</h3>
                                <div style="text-align: right; margin-top: -25px;">
                                    <a href="manageUser.php" class="btn btn-success">Admins</a>
                                </div>
                            </div>
                            <div class="module-body">
                                <form class="form-horizontal row-fluid" method="POST" action="updateAdminData.php">
                                    <input type="hidden" name="id" value="<?= $user['id']; ?>">

                                    <div class="control-group">
                                        <label class="control-label">Name</label>
                                        <div class="controls">
                                            <input type="text" name="name" class="span8" value="<?= $user['name']; ?>">
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Email</label>
                                        <div class="controls">
                                            <input type="email" name="email" class="span8" value="<?= $user['email']; ?>">
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Mobile</label>
                                        <div class="controls">
                                            <input type="text" name="mobile" class="span8" value="<?= $user['mobile']; ?>">
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Password</label>
                                        <div class="controls">
                                            <input type="text" name="password" class="span8">
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <div class="controls">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                            <a href="manageUser.php" class="btn btn-danger">Cancel</a>
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
</body>

</html>