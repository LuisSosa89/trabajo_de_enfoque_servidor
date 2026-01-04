<?php

//Inicia sesión para poder acceder a $_SESSION
session_start();

// Indica que la respuesta será JSON
header('Content-Type: application/json');

//Si el usuario no esta logueado, se redirige a la pagina principal
if (!isset($_SESSION['id_usuario'])) {
    header("Location: pagina_principal.html");
    exit;
}

//Incluye la conexion a la base de datos
require_once "conexion_db.php";

// Obtener el id del producto desde POST y asegurarnos de que sea entero
$id_producto = (int)($_POST['id_producto'] ?? 0);

try {

    // Preparar y ejecutar la consulta para eliminar el producto
    $stmt = $conn->prepare("DELETE FROM producto WHERE id_producto = ?");
    $stmt->execute([$id_producto]);

    // Comprobar si se eliminó alguna fila
    if ($stmt->rowCount() > 0) {
        echo json_encode(['ok' => true]);
    } else {
        echo json_encode(['ok' => false]);
    }
} catch (PDOException $e) {
    echo json_encode(['ok' => false]);
}
