<?php

//Incluye la conexion a la base de datos
require_once "conexion_db.php";

// Comprobamos que el formulario se envía por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Recogemos los datos del formulario
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $imagen = $_POST['imagen'];

    // Array asociativo: id_talla => stock
    $stockPorTalla = $_POST['talla'];

    try {
        // Iniciar transacción
        $conn->beginTransaction();

        // Insertar en tabla producto
        $stmt = $conn->prepare("INSERT INTO producto (nombre, precio, descripcion, imagen) 
                                VALUES (:nombre, :precio, :descripcion, :imagen)");

        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':imagen', $imagen);

        $stmt->execute();

        // Obtener el ID del producto recién creado
        $id_producto = $conn->lastInsertId();

        // Insertar en tabla producto_talla
        $stmt = $conn->prepare("INSERT INTO producto_talla
            (id_producto, id_talla, stock)     
            VALUES (:id_producto, :id_talla, :stock)");

        // Insertar cada talla con stock > 0
        foreach ($stockPorTalla as $id_talla => $stock) {
            $id_talla = (int)$id_talla;
            $stock = (int)$stock;

            // Solo insertar tallas con stock
            if ($stock > 0) {
                $stmt->execute([
                    ':id_producto' => $id_producto,
                    ':id_talla' => $id_talla,
                    ':stock' => $stock
                ]);
            }
        }
        // Confirmar transacción
        $conn->commit();

        header("location: administrar_pagina.php");
        exit();
    } catch (PDOException $e) {
        // Deshacer cambios si ocurre error
        $conn->rollBack();
        echo "Error al guardar el registro: " . $e->getMessage();
    }
}
