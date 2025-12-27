<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /crud-core-php/auth/login.php");
    exit();
}
