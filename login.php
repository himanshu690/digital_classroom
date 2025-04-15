<?php
include 'connect.php';

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    
    if (password_verify($password, $user['password'])) {
        echo "Login successful! Welcome, " . htmlspecialchars($user['first_name']) . "!";
        
        // Optional: start session
        // session_start();
        // $_SESSION['user_id'] = $user['id'];
    } else {
        echo "Incorrect password.";
    }
} else {
    echo "No user found with that email.";
}
?>
