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

try {
    // Consulta todos los usuarios ordenados por ID ascendente
    $stmt = $conn->prepare("SELECT id_usuario, nombre_usuario FROM usuario ORDER bY id_usuario ASC");
    $stmt->execute();
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al obtener los usuarios: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="modificar_usuarios.css">
</head>

<body>

    <!--cabecera de la página-->

    <div id="cabecera">
        <h1><a href="administrar_pagina.php">DAVANT SNEAKERS</a></h1>
    </div>

    <?php if (!empty($user)): ?>
        <h2>Seleccione el usuario a modificar:</h2>

        <!-- Lista de usuarios disponibles -->
        <ul>
            <?php foreach ($user as $usuario): ?>
                <li>
                    <!-- Enlace a la página de modificación pasando el id del usuario -->
                    <a href="modificar_usuario_seleccionado.php?id=<?= $usuario['id_usuario'] ?>">
                        <span class="id"><?= $usuario['id_usuario'] ?></span>
                        <?= htmlspecialchars($usuario['nombre_usuario']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No hay usuarios registrados.</p>
    <?php endif; ?>

</body>

</html>