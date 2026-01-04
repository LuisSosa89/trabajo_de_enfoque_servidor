<?php

//Inicia sesión para poder acceder a $_SESSION
session_start();

//Incluye la conexion a la base de datos
require_once "conexion_db.php";

// Si no llega el id_usuario vía POST, salimos
if (!isset($_POST['id_usuario'])) exit;

// Convertimos a entero el ID del usuario a eliminar
$id_eliminar = intval($_POST['id_usuario']);

//Guardamos el id del usuario logueado
$id_logueado = $_SESSION['id_usuario'];

// No permitir eliminarse a sí mismo
if ($id_eliminar === $id_logueado) {
    http_response_code(403);
    exit("No puedes eliminar tu propio usuario");
}

try {
    // Prepara la consulta para eliminar al usuario seleccionado
    $stmt = $conn->prepare("DELETE FROM usuario WHERE id_usuario = :id");
    $stmt->bindParam(':id', $id_eliminar, PDO::PARAM_INT);
    $stmt->execute();
    echo "Usuario eliminado correctamente";
} catch (PDOException $e) {
    http_response_code(500);
    echo "Error al eliminar usuario: " . $e->getMessage();
}
?>