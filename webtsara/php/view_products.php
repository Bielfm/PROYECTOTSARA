<?php
include("db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $updateSql = "UPDATE products SET name = ?, price = ?, stock = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("sdii", $name, $price, $stock, $id);

    if ($updateStmt->execute()) {
        echo "<p>Producto actualizado correctamente.</p>";
    } else {
        echo "<p>Error al actualizar el producto.</p>";
    }
}

$search = isset($_POST['search']) ? $_POST['search'] : '';

if ($search) {
    $sql = "SELECT id, name, price, stock FROM products WHERE name LIKE ? OR description LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchTerm = "%" . $search . "%";
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT id, name, price, stock FROM products");
}

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <form method='POST' action='view_products.php'>
                    <td>
                        <img src='" . htmlspecialchars($row['image_url']) . "' alt='Producto' style='width: 100px; height: auto;'>
                    </td>
                    <td>
                        <input type='hidden' name='id' value='" . $row['id'] . "'>
                        <input type='text' name='name' value='" . htmlspecialchars($row['name']) . "' required>
                    </td>
                    <td>
                        <input type='number' step='0.01' name='price' value='" . $row['price'] . "' required>
                    </td>
                    <td>
                        <input type='number' name='stock' value='" . $row['stock'] . "' required>
                    </td>
                    <td>
                        <button type='submit'>Actualizar</button>
                    </td>
                </form>
            </tr>";
    }

    echo "</tbody></table>";
} else {
    echo "<p>No se encontraron productos.</p>";
}

