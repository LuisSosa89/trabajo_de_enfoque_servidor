<?php

//Inicia sesión para poder acceder a $_SESSION
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: pagina_principal.html");
    exit;
}

//Incluye la conexion a la base de datos
require_once "conexion_db.php";

try {
    // Obtiene todos los usuarios ordenados por id_usuario ascendente
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
    <link rel="stylesheet" href="eliminar_usuario.css">
    <script src="eliminar_usuario.js"></script>
</head>

<body>
    <div id="cabecera">
        <h1><a href="administrar_pagina.php">DAVANT SNEAKERS</a></h1>
    </div>
    <h2>Seleccione el usuario a eliminar:</h2>
    <?php if (!empty($user)): ?>
        <ul>
            <?php foreach ($user as $usuario): ?>
                <li>
                    <?php if ($usuario['id_usuario'] != $_SESSION['id_usuario']): ?>

                        <!-- Mostrar usuario que se puede eliminar -->
                        <span class="usuario"
                            onclick="abrirModal(<?= $usuario['id_usuario'] ?>, '<?= htmlspecialchars($usuario['nombre_usuario'], ENT_QUOTES) ?>')">
                            <?= htmlspecialchars($usuario['nombre_usuario']) ?>
                        </span>
                    <?php else: ?>

                        <!-- Usuario actual no se puede eliminar -->
                        <strong><?= htmlspecialchars($usuario['nombre_usuario']) ?> (tú)</strong>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No hay usuarios registrados.</p>
    <?php endif; ?>

    <!-- MODAL -->
    <div id="modalEliminar" class="modal">
        <div class="modal-contenido">
            <p id="textoModal"></p>
            <button onclick="eliminarUsuario()" class="eliminar">Eliminar</button>
            <button onclick="cerrarModal()" class="cancelar">Cancelar</button>
        </div>
    </div>

</body>

</html>