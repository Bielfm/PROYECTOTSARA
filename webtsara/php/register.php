<?php
include("db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];  

    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $password);  
    if ($stmt->execute()) {
        echo "User registered successfully!";
    } else {
        echo "Error registering user: " . $stmt->error;
    }
}
?>
