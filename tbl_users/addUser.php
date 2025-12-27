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
                                <h3>Add User</h3>
                                <div style="text-align: right; margin-top: -25px;">
                                    <a href="manageUser.php" class="btn btn-success">Users</a>
                                </div>
                            </div>
                            <div class="module-body">
                                <form id="subCategoryForm" class="form-horizontal row-fluid" method="POST" action="postUserData.php">
                                    <div class="control-group">
                                        <label class="control-label">Enter Name</label>
                                        <div class="controls">
                                            <input type="text" id="name" name="name" placeholder="Enter Name" class="span8">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Enter Email</label>
                                        <div class="controls">
                                            <input type="text" id="email" name="email" placeholder="Enter Email" class="span8">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Enter Mobile</label>
                                        <div class="controls">
                                            <input type="text" id="mobile" name="mobile" placeholder="Enter Mobile" class="span8">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Enter Password</label>
                                        <div class="controls">
                                            <input type="text" id="password" name="password" placeholder="Enter Password" class="span8">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <button type="submit" class="btn btn-primary">Submit</button>
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