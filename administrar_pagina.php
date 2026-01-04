<?php

//Inicia sesión para poder acceder a $_SESSION
session_start();

//Si el usuario no esta logueado, se redirige a la pagina principal.
if (!isset($_SESSION['id_usuario'])) {
    header("Location: pagina_principal.html");
    exit;
}
//Guardamos el id del usuario logueado
$id_usuario = $_SESSION['id_usuario'] ?? 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="administrar_pagina.css">
    <title>Document</title>
</head>

<body>

    <!-- CONTENEDOR PRINCIPAL PARA EL CSS RESPONSIVE -->
    <div id="cuerpo">

        <!-- Mensaje de bienvenida al usuario -->
        <!-- htmlspecialchars evita ataques XSS -->
        <h2>¡Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?>!</h2>
        <H3>¿Que quieres hacer?</H3>

        <!-- Tabla que actúa como menú de opciones --> 
        <table>

            <!-- Crear, modificar y eliminar porductos -->
            <tr>
                <td><a href="crear_producto.php">Crear producto</a></td>
                <td><a href="modificar_producto.php">Modificar producto</a></td>
                <td><a href="eliminar_producto.php">Eliminar producto</a></td>

            </tr>

            <!-- Crear, modificar y eliminar usuarios -->
            <tr>
                <td><a href="crear_usuario.php">Crear usuario</a></td>
                <td><a href="modificar_usuario.php">Modificar usuario</a></td>
                <td><a href="eliminar_usuario.php">Eliminar usuario</a></td>
            </tr>

            <!-- Cerrar sesión -->
            <tr>
                <td colspan="3" style="text-align:center;">
                    <a href="cerrar_sesion.php">Cerrar sesion</a>
                </td>
            </tr>

        </table>

    </div>

</body>

</html>