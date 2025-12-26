<?php
function parseEnv($file) {
    if (!file_exists($file)) {
        die(".env file not found at $file");
    }
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $env = [];
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || strpos($line, '#') === 0) continue; 
        if (strpos($line, '=') === false) continue;
        [$key, $value] = explode('=', $line, 2);
        $env[trim($key)] = trim($value);
    }
    return $env;
}
$env = parseEnv(__DIR__ . '/.env');
$servername = $env['DB_HOST'] ?? null;
$username   = $env['DB_USER'] ?? null;
$password   = $env['DB_PASS'] ?? null;
$dbname     = $env['DB_NAME'] ?? null;
if (!$servername || !$username || !$dbname) {
    die("Database credentials not set correctly in .env");
}
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
