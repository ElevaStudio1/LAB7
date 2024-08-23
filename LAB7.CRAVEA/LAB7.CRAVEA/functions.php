<?php
include 'conexion.php'; // Cambié el nombre del archivo de conexión para diferenciarlo

// Función para registrar un nuevo cliente
function registrarCliente($firstName, $lastName, $emailAddress, $street, $streetNumber) {
    global $conn;
    $query = "INSERT INTO Cliente (Nombre, Apellido, Email, Calle, Numero)
              VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $firstName, $lastName, $emailAddress, $street, $streetNumber);
    if ($stmt->execute()) {
        return "Cliente registrado correctamente";
    } else {
        return "Error al registrar el cliente: " . $conn->error;
    }
}

// Función para registrar un nuevo producto
function registrarProducto($productName, $productPrice) {
    global $conn;
    $query = "INSERT INTO Producto (nombreprod, Precio)
              VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sd", $productName, $productPrice);
    if ($stmt->execute()) {
        return "Producto registrado correctamente";
    } else {
        return "Error al registrar el producto: " . $conn->error;
    }
}

// Función para obtener todos los clientes
function obtenerClientes() {
    global $conn;
    $query = "SELECT * FROM Cliente";
    return $conn->query($query);
}

// Función para obtener todos los productos
function obtenerProductos() {
    global $conn;
    $query = "SELECT * FROM Producto";
    return $conn->query($query);
}

// Función para obtener los detalles de los productos
function obtenerDetallesProducto() {
    global $conn;
    $query = "SELECT Producto.nombreprod, Detalle.Descripcion, Detalle.Origen 
              FROM Detalle 
              INNER JOIN Producto ON Detalle.Cod_p = Producto.Cod_p";
    return $conn->query($query);
}

// Función para buscar un producto por ID
function buscarProductoPorId($productId) {
    global $conn;
    $query = "SELECT * FROM Producto WHERE Cod_p = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    return $stmt->get_result();
}
?>
