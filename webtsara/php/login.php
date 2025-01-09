<?php
session_start();
include("db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];  


    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        

        if ($password === $user['password']) {  
            echo "Login successful! Welcome, " . $user['username'] . ".";
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "No user found with that email!";
    }
}
?>