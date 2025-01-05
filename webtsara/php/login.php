<?php
session_start();
include("db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];  // La contraseña sin cifrar

    // Buscar el usuario en la base de datos por email
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verificar si la contraseña es correcta
        if ($password === $user['password']) {  // Comparar texto claro
            // Si la contraseña es correcta
            echo "Login successful! Welcome, " . $user['username'] . ".";
        } else {
            // Si la contraseña no es correcta
            echo "Incorrect password!";
        }
    } else {
        echo "No user found with that email!";
    }
}
?>