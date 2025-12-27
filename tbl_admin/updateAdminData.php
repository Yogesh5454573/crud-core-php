<?php
session_start();
include '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id       = $_POST['id'];
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $mobile   = trim($_POST['mobile']);
    $password = trim($_POST['password']);

    $sql = "UPDATE tbl_admin 
            SET name = ?, email = ?, mobile = ?, password = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $email, $mobile, $password, $id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "User updated successfully!";
        header("Location: manageAdmin.php");
        exit();
    } else {
        $_SESSION['error'] = "Update failed!";
        header("Location: editAdmin.php?id=" . $id);
        exit();
    }
}
