<?php
$servername = "localhost";
$username = "root"; // Usuario de la base de datos
$password = ""; // Contraseña de la base de datos
$dbname = "tsara"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
