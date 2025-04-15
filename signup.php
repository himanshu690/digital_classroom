<?php
include 'connect.php';

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $firstName, $lastName, $email, $password);

if ($stmt->execute()) {
    echo "Signup successful! <a href='login.html'>Go to Login</a>";
} else {
    echo "Error: " . $stmt->error;
}
?>
