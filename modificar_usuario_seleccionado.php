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

// Comprobamos que se recibe un ID válido en la URL
if (!isset($_GET['id']) || intval($_GET['id']) <= 0) {
    header("Location: index.php");
    exit;
}

// Guardamos el id del usuario a modificar
$id_usuario = intval($_GET['id']);

// Consultamos los datos del usuario
$sql_usuario = "SELECT id_usuario, nombre_usuario 
                 FROM usuario
                 WHERE id_usuario = :id";

$stmt = $conn->prepare($sql_usuario);
$stmt->execute(['id' => $id_usuario]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Si no existe el usuario, mostramos mensaje y detenemos
if (!$usuario) {
    echo "Usuario no encontrado";
    exit;
}

// Consultamos los datos personales y el rol del usuario
$sql_datos_usuario = "
SELECT d.nombre, d.apellidos, d.dni, d.direccion,
       d.poblacion, d.provincia, d.codigo_postal,
       d.telefono, d.email, ur.id_rol
FROM datos_usuario d
JOIN usuario_rol ur ON d.id_usuario = ur.id_usuario
WHERE d.id_usuario = :id";

$stmt = $conn->prepare($sql_datos_usuario);
$stmt->execute(['id' => $id_usuario]);
$datos_usuario = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="modificar_usuario_seleccionado.css">
    <title>Document</title>
</head>

<body>

    <!-- Título y enlace a página principal del administrador -->
    <h1><a href="administrar_pagina.php">DAVANT SNEAKERS</a></h1>

    <h2>Modificar datos</h2>

    <div id="caja_formulario">

        <!-- Formulario para modificar usuario -->
        <form action="guardar_usuarios_modificados.php" method="POST">
            <fieldset id="datos_sesion">
                <legend>Datos inicio de sesión</legend>
                <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario'] ?>">
                <label for="nombre_usuario"><b>Nombre usuario:</b></label>
                <input type="text" name="nombre_usuario" id="nombre_usuario" size="30" required value="<?= htmlspecialchars($usuario['nombre_usuario']) ?>"><br><br>
                <label for="contrasena"><b>Contraseña:</b></label>
                <input type="password" name="contrasena" id="contrasena" size="30">
            </fieldset>
            <fieldset>
                <legend>Datos personales</legend>
                <label for="nombre"><b>Nombre:</b></label>
                <input type="text" name="nombre" id="nombre" size="30" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+" title="Solo debe contener letras" required value="<?= htmlspecialchars($datos_usuario['nombre']) ?>"><br><br>
                <label for="apellidos"><b>Apellidos:</b></label>
                <input type="text" name="apellidos" id="apellidos" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+" title="Solo debe contener letras" size="30" required value="<?= htmlspecialchars($datos_usuario['apellidos']) ?>"><br><br>
                <label for="dni"><b>DNI:</b></label>
                <input type="text" name="dni" id="dni" pattern="[0-9]{8}[A-Za-z]{1}" title="Debe poner 8 números y una letra" minlength="9" maxlength="9" size="7" required value="<?= htmlspecialchars($datos_usuario['dni']) ?>"><br><br>
                <label for="direccion"><b>Dirección:</b></label>
                <input type="text" name="direccion" id="direccion" size="30" required value="<?= htmlspecialchars($datos_usuario['direccion']) ?>"><br><br>
                <label for="poblacion"><b>Población:</b></label>
                <input type="text" name="poblacion" id="poblacion" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+" title="Solo debe contener letras" size="30" required value="<?= htmlspecialchars($datos_usuario['poblacion']) ?>"><br><br><br><br>
                <label for="provincia"><b>Provincia:</b></label>
                <input type="text" name="provincia" id="provincia" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+" title="Solo debe contener letras" size="30" required value="<?= htmlspecialchars($datos_usuario['provincia']) ?>"><br><br>
                <label for="codigo_postal"><b>Código postal:</b></label>
                <input type="text" name="codigo_postal" id="codigo_postal" pattern="[0-9]{5}" maxlength="5" minlength="5" title="Debe contener 5 números" size="7" required value="<?= htmlspecialchars($datos_usuario['codigo_postal']) ?>"><br><br>
                <label for="telefono"><b>Teléfono:</b></label>
                <input type="text" name="telefono" id="telefono" pattern="[0-9]{9}" maxlength="9" minlength="9" size="7" required value="<?= htmlspecialchars($datos_usuario['telefono']) ?>"><br><br>
                <label for="email"><b>Email:</b></label>
                <input type="text" name="email" id="email" size="30" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="Correo mal intriducido" required value="<?= htmlspecialchars($datos_usuario['email']) ?>"><br><br>
                <label type="rol"><b>Seleccione rol:</b></label>
                <input type="radio" name="rol" value="2" <?= ($datos_usuario['id_rol'] == 2) ? 'checked' : '' ?>>Cliente<br><br>
                <input type="radio" name="rol" value="1" <?= ($datos_usuario['id_rol'] == 1) ? 'checked' : '' ?>>Administrador<br><br>
                <input id="botones" type="submit" value="Guardar">
                <input id="botones2" type="reset" value="Borrar">
            </fieldset>
        </form>

</body>

</html>