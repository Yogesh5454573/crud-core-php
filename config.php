<?php
function parseEnv($file) {
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $env = [];
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue; // skip comments
        [$key, $value] = explode('=', $line, 2);
        $env[trim($key)] = trim($value);
    }
    return $env;
}

$env = parseEnv(__DIR__ . '/.env');

// Use variables
$servername = $env['DB_HOST'];
$username   = $env['DB_USER'];
$password   = $env['DB_PASS'];
$dbname     = $env['DB_NAME'];

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
