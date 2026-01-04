<?php

//Inicia sesión para poder acceder a $_SESSION
session_start();

//Incluye la conexion a la base de dato
require_once "conexion_db.php";

//Si el usuario no esta logueado, se redirige a la pagina principal
if (!isset($_SESSION['id_usuario'])) {
    header("Location: pagina_principal.html");
    exit;
}

//Guardamos el id del usuario logueado
$id_usuario = $_SESSION['id_usuario'];

try {
    // Inicia una transacción
    $conn->beginTransaction();

    // Obtener los productos en el carrito del usuario
    $stmt = $conn->prepare("
        SELECT c.id_producto, c.id_talla, c.cantidad, p.precio
        FROM carro c
        JOIN producto p ON c.id_producto = p.id_producto
        WHERE c.id_usuario = :id_usuario
    ");
    $stmt->execute(['id_usuario' => $id_usuario]);
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Si el carrito está vacío, lanzar excepción
    if (empty($productos)) throw new Exception("Carrito vacío");

    // Preparar sentencia para insertar en historial de compras
    $stmt_insert = $conn->prepare("
        INSERT INTO historial_de_compras
        (id_usuario,id_producto,id_talla,cantidad,fecha,precio_unitario,total)
        VALUES (:id_usuario,:id_producto,:id_talla,:cantidad,NOW(),:precio_unitario,:total)
    ");

    // Preparar sentencia para restar stock de la tabla producto_talla
    $stmt_stock = $conn->prepare("
        UPDATE producto_talla
        SET stock = stock - :cantidad
        WHERE id_producto = :id_producto AND id_talla = :id_talla AND stock >= :cantidad
    ");

    // Procesar cada producto del carrito
    foreach ($productos as $p) {
        $total = $p['precio'] * $p['cantidad'];
        $stmt_insert->execute([
            'id_usuario' => $id_usuario,
            'id_producto' => $p['id_producto'],
            'id_talla' => $p['id_talla'],
            'cantidad' => $p['cantidad'],
            'precio_unitario' => $p['precio'],
            'total' => $total
        ]);

        // Actualizar stock del producto
        $stmt_stock->execute([
            'cantidad' => $p['cantidad'],
            'id_producto' => $p['id_producto'],
            'id_talla' => $p['id_talla']
        ]);
        // Si no se actualizó ningún stock, significa que hay insuficiente
        if ($stmt_stock->rowCount() === 0) throw new Exception("Stock insuficiente");
    }
    // Vaciar el carrito del usuario
    $stmt = $conn->prepare("DELETE FROM carro WHERE id_usuario=:id_usuario");
    $stmt->execute(['id_usuario' => $id_usuario]);


    // Confirmar todas las operaciones
    $conn->commit();
    echo json_encode(['ok' => true]);
} catch (Exception $e) {
    // Si ocurre cualquier error, deshacer todas las operaciones
    $conn->rollBack();
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}
