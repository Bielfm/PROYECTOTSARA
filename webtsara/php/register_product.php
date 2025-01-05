
<?php
include("db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    // Insertar el usuario en la base de datos
    $sql = "INSERT INTO products (name, description, price, stock, is_featured, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, NOW(), NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdii", $name, $description, $price, $stock, $is_featured);
    if ($stmt->execute()) {
        echo "Product registered successfully!";
    } else {
        echo "Error registering the product: " . $stmt->error;
    }
}
?>

