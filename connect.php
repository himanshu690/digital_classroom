<?php
$host = '127.0.0.1'; // or 'localhost'
$username = 'root';
$password = ''; // usually empty for XAMPP
$database = 'user_auth';
$port = 3306;

$conn = new mysqli($host, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
