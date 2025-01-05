<?php
include("db.php");

// Verificar si se ha enviado un término de búsqueda
$search = isset($_POST['search']) ? $_POST['search'] : '';

// Si hay búsqueda, filtrar los productos según el término de búsqueda
if ($search) {
    $sql = "SELECT id, name, price, stock FROM products WHERE name LIKE ? OR description LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchTerm = "%" . $search . "%";
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Si no hay término de búsqueda, mostrar todos los productos
    $result = $conn->query("SELECT id, name, price, stock FROM products");
}

// Verificar si hay productos
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <form method='POST' action=''>
                    <td>
                        <input type='hidden' name='id' value='" . $row['id'] . "'>
                        <input type='text' name='name' value='" . $row['name'] . "' required>
                    </td>
                    <td>
                        <input type='number' step='0.01' name='price' value='" . $row['price'] . "' required>
                    </td>
                    <td>
                        <input type='number' name='stock' value='" . $row['stock'] . "' required>
                    </td>
                    <td>
                        <button type='submit'>Update</button>
                    </td>
                </form>
            </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No products found.</td></tr>";
}
?>
