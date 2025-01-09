
<?php
include("db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;


    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "uploads/"; 
        $imageName = basename($_FILES['image']['name']);
        $targetFile = $targetDir . $imageName;
        $imageType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));


        $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageType, $validExtensions)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {

                $sql = "INSERT INTO products (name, description, price, stock, is_featured, image_url, created_at, updated_at) 
                        VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssdiss", $name, $description, $price, $stock, $is_featured, $targetFile);
                if ($stmt->execute()) {
                    echo "Product registered successfully!";
                } else {
                    echo "Error registering the product: " . $stmt->error;
                }
            } else {
                echo "Error uploading the image.";
            }
        } else {
            echo "Invalid image type. Only JPG, JPEG, PNG, and GIF are allowed.";
        }
    } else {
        echo "No image uploaded or an error occurred.";
    }
}

