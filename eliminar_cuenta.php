<?php

//Inicia sesión para poder acceder a $_SESSION
session_start();


//Si el usuario no esta logueado, se redirige a la pagina principal
if (!isset($_SESSION['id_usuario'])) {
    header("Location: pagina_principal.html");
    exit;
}

//Incluye la conexion a la base de datos
require_once "conexion_db.php";

//Guardamos el id del usuario logueado
$id_usuario = $_SESSION['id_usuario'];

try {
    // Iniciar una transacción 
    $conn->beginTransaction();

    // Preparar la sentencia SQL para eliminar el usuario de la tabla 'usuario'
    $stmt = $conn->prepare("DELETE FROM usuario WHERE id_usuario = :id_usuario");
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->execute();

    // Confirmar la transacción
    $conn->commit();

    // Limpiar y destruir la sesión para cerrar sesión del usuario eliminado
    $_SESSION = [];
    session_destroy();
} catch (PDOException $e) {

    // En caso de error, deshacer cambios realizados en la transacción
    $conn->rollBack();
    echo "Error al eliminar la cuenta: " . $e->getMessage();
}
// Redirigir a la página principal después de eliminar la cuenta
header("Location: pagina_principal.html");
exit();
