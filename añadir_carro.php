<?php

//Inicia sesión para poder acceder a $_SESSION
session_start();

//Incluye la conexion a la base de datos
require_once "conexion_db.php";

//Si el usuario no esta logueado, se redirige a la pagina principal.
if (!isset($_SESSION['id_usuario'])) {
    header("Location: pagina_principal.html");
    exit;
}

// Recoger datos del formulario
$id_usuario = $_SESSION['id_usuario'];
$id_producto = intval($_POST['id_producto'] ?? 0);
$id_talla = intval($_POST['id_talla'] ?? 0);

// Si alguno de los datos no es válido, detiene la ejecución
if ($id_producto <= 0 || $id_talla <= 0) {
    echo "<p>Datos inválidos. <a href='pagina_articulos.php'>Volver</a></p>";
    exit;
}

// Comprobar stock
$stmt = $conn->prepare("SELECT stock FROM producto_talla WHERE id_producto = :id_producto AND id_talla = :id_talla");
$stmt->execute(['id_producto' => $id_producto, 'id_talla' => $id_talla]);
$stock = $stmt->fetchColumn();

if ($stock === false || $stock <= 0) {
    echo "<p>No hay stock disponible para esa talla. <a href='pagina_articulos.php'>Volver</a></p>";
    exit;
}

// Guardar en el carrito
$stmt = $conn->prepare("SELECT cantidad FROM carro WHERE id_usuario = :id_usuario AND id_producto = :id_producto AND id_talla = :id_talla");
$stmt->execute(['id_usuario' => $id_usuario, 'id_producto' => $id_producto, 'id_talla' => $id_talla]);
$carro_actual = $stmt->fetchColumn();

if ($carro_actual) {
    $stmt = $conn->prepare("UPDATE carro SET cantidad = cantidad + 1 WHERE id_usuario = :id_usuario AND id_producto = :id_producto AND id_talla = :id_talla");
    $stmt->execute(['id_usuario' => $id_usuario, 'id_producto' => $id_producto, 'id_talla' => $id_talla]);
} else {
    $stmt = $conn->prepare("INSERT INTO carro (id_usuario, id_producto, id_talla, cantidad) VALUES (:id_usuario, :id_producto, :id_talla, 1)");
    $stmt->execute(['id_usuario' => $id_usuario, 'id_producto' => $id_producto, 'id_talla' => $id_talla]);
}


// Mostrar modal con opciones
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="añadir_carro.css">
</head>

<body>

    <!-- Clase para el fondo -->
    <div class="modal-fondo">

        <!-- Clase para el contenido -->
        <div class="modal-contenido">
            <h2>Producto añadido al carrito</h2>
            <p>¿Deseas ir al carrito o seguir comprando?</p>

            <!-- Botones para ir al carrito ó seguir comprando -->
            <button class="ir-carro" onclick="window.location.href='carro.php'">Ir al carrito</button>
            <button class="seguir-comprando" onclick="window.location.href='pagina_articulos.php'">Seguir comprando</button>
        </div>
    </div>
</body>

</html>