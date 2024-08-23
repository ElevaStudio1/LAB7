<?php
include 'functions.php';

$resultadoProductos = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['registrar_cliente'])) {
        $mensaje = registrarCliente($_POST['nombre'], $_POST['apellido'], $_POST['email'], $_POST['calle'], $_POST['numero']);
        header("Location: index.php?mensaje=" . urlencode($mensaje));
        exit();
    } elseif (isset($_POST['registrar_producto'])) {
        $mensaje = registrarProducto($_POST['nombreprod'], $_POST['precio']);
        header("Location: index.php?mensaje=" . urlencode($mensaje));
        exit();
    } elseif (isset($_POST['buscar_producto_por_id'])) {
        $resultadoProductos = buscarProductoPorId($_POST['id_producto']);
    }
}

// Cargar datos al iniciar la página
$listaClientes = obtenerClientes();
$listaProductos = obtenerProductos();
$listaDetalles = obtenerDetallesProducto();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administración de Clientes y Productos</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js" defer></script>
</head>
<body>
    <h1>Administración de Clientes y Productos</h1>

    <?php if (isset($_GET['mensaje'])) {
        echo "<p>" . htmlspecialchars($_GET['mensaje']) . "</p>";
    } ?>
    <div class="contenedor-formularios">
        <!-- Formulario para registrar cliente -->
        <div class="seccion-formulario">
            <h2>Registrar Cliente</h2>
            <form action="index.php" method="post" onsubmit="return validarCliente(event)">
                Nombre: <input type="text" name="nombre"><br>
                Apellido: <input type="text" name="apellido"><br>
                Email: <input type="text" name="email"><br>
                Calle: <input type="text" name="calle"><br>
                Número: <input type="text" name="numero"><br>
                <input type="submit" name="registrar_cliente" value="Registrar Cliente">
            </form>
        </div>

        <!-- Formulario para registrar producto -->
        <div class="seccion-formulario">
            <h2>Registrar Producto</h2>
            <form action="index.php" method="post" onsubmit="return validarProducto(event)">
                Nombre del Producto: <input type="text" name="nombreprod"><br>
                Precio: <input type="text" name="precio"><br>
                <input type="submit" name="registrar_producto" value="Registrar Producto">
            </form>
        </div>

        <!-- Formulario para buscar producto por ID -->
        <div class="seccion-formulario">
            <h2>Buscar Producto por ID</h2>
            <form action="index.php" method="post" onsubmit="return validarBusqueda(event)">
                ID del Producto: <input type="text" name="id_producto"><br>
                <input type="submit" name="buscar_producto_por_id" value="Buscar Producto">
            </form>
        </div>
    </div>

    <!-- Listado de Clientes -->
    <h2>Clientes Registrados</h2>
    <?php
    if ($listaClientes->num_rows > 0) {
        echo "<table><tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>Email</th><th>Calle</th><th>Número</th></tr>";
        while ($fila = $listaClientes->fetch_assoc()) {
            echo "<tr><td>" . htmlspecialchars($fila["id"]) . "</td><td>" . htmlspecialchars($fila["Nombre"]) . "</td><td>" . htmlspecialchars($fila["Apellido"]) . "</td><td>" . htmlspecialchars($fila["Email"]) . "</td><td>" . htmlspecialchars($fila["Calle"]) . "</td><td>" . htmlspecialchars($fila["Numero"]) . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No hay clientes registrados";
    }
    ?>

    <!-- Listado de Productos -->
    <h2>Productos Registrados</h2>
    <?php
    if ($listaProductos->num_rows > 0) {
        echo "<table><tr><th>ID</th><th>Nombre</th><th>Precio</th></tr>";
        while ($fila = $listaProductos->fetch_assoc()) {
            echo "<tr><td>" . htmlspecialchars($fila["Cod_p"]) . "</td><td>" . htmlspecialchars($fila["nombreprod"]) . "</td><td>" . htmlspecialchars($fila["Precio"]) . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No hay productos registrados";
    }
    ?>

    <!-- Detalles de Productos -->
    <h2>Detalles de Productos</h2>
    <?php
    if ($listaDetalles->num_rows > 0) {
        echo "<table><tr><th>Producto</th><th>Descripción</th><th>Origen</th></tr>";
        while ($fila = $listaDetalles->fetch_assoc()) {
            echo "<tr><td>" . htmlspecialchars($fila["nombreprod"]) . "</td><td>" . htmlspecialchars($fila["Descripcion"]) . "</td><td>" . htmlspecialchars($fila["Origen"]) . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No hay detalles de productos registrados";
    }
    ?>

    <!-- Resultados de Búsqueda -->
    <?php
    if (isset($resultadoProductos) && $resultadoProductos instanceof mysqli_result && $resultadoProductos->num_rows > 0) {
        echo "<h2>Resultados de Búsqueda</h2>";
        echo "<table><tr><th>ID</th><th>Nombre</th><th>Precio</th></tr>";
        while ($fila = $resultadoProductos->fetch_assoc()) {
            echo "<tr><td>" . htmlspecialchars($fila["Cod_p"]) . "</td><td>" . htmlspecialchars($fila["nombreprod"]) . "</td><td>" . htmlspecialchars($fila["Precio"]) . "</td></tr>";
        }
        echo "</table>";
    } elseif (isset($resultadoProductos) && $resultadoProductos instanceof mysqli_result) {
        echo "<p>No se encontraron productos con ese ID</p>";
    }
    ?>
</body>
</html>
