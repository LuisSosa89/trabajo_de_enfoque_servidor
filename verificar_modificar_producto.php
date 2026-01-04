<?php

//Inicia sesión para poder acceder a $_SESSION
session_start();;

//Si el usuario no esta logueado, se redirige a la pagina principal
if (!isset($_SESSION['id_usuario'])) {
    header("Location: pagina_principal.html");
    exit;
}

//Incluye la conexion a la base de datos
require_once "conexion_db.php";

// Comprobamos que el formulario se envía por POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: administrar_pagina.php");
    exit;
}

// Datos del formulario
$id_producto = intval($_POST['id_producto']);
$nombre = $_POST['nombre'];
$precio = $_POST['precio'];
$descripcion = $_POST['descripcion'];
$imagen = $_POST['imagen'];
$stocks = $_POST['stock'] ?? [];

try {
    //Inicio de transacción
    $conn->beginTransaction();

    // Actualizar producto
    $sql_producto = "
        UPDATE producto 
        SET nombre = :nombre,
            precio = :precio,
            descripcion = :descripcion,
            imagen = :imagen
        WHERE id_producto = :id
    ";

    $stmt = $conn->prepare($sql_producto);
    $stmt->execute([
        'nombre' => $nombre,
        'precio' => $precio,
        'descripcion' => $descripcion,
        'imagen' => $imagen,
        'id' => $id_producto
    ]);

    // Actualizar stock por talla
    $sql_stock = "
    INSERT INTO producto_talla (id_producto, id_talla, stock)
    VALUES (:id_producto, :id_talla, :stock)
    ON DUPLICATE KEY UPDATE stock = :stock
";

$stmt_stock = $conn->prepare($sql_stock);

foreach ($stocks as $id_talla => $stock) {
    $stmt_stock->execute([
        ':id_producto' => $id_producto,
        ':id_talla' => (int)$id_talla,
        ':stock' => max(0, (int)$stock)
    ]);
}

    //Confirma la transacción
    $conn->commit();
    header("Location: administrar_pagina.php");
    exit;
} catch (PDOException $e) {

    //Si falla la transacción se revierte todo
    $conn->rollBack();
    echo "Error al actualizar el producto: " . $e->getMessage();
}
