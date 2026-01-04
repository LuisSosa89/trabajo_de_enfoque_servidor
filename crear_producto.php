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

//Incluye la conexion a la base de datos
require_once "conexion_db.php";

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="crear_producto.css">
    <title>Document</title>
</head>

<body>

    <!-- Nombre tienda con enlace a página principal de administrador -->
    <h1><a href="administrar_pagina.php">DAVANT SNEAKERS</a></h1>

    <!-- Formulario para crear un producto nuevo -->
    <form action="guardar_producto.php" method="POST">
        <fieldset>
            <legend>Crear producto</legend>
            <label for="nombre"><b>Nombre:</b></label>
            <input type="text" name="nombre" id="nombre" size="30" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ0-9 .,;:!@#%&()\-]+" required><br><br>
            <label for="precio"><b>Precio:</b></label>
            <input type="text" name="precio" id="precio" pattern="[0-9]+(\.[0-9]{1,2})?" title="Solo debe contener numeros" size="1" required><br><br>
            <label for="descripcion"><b>Descripción:</b></label>
            <input type="text" name="descripcion" id="descripcion" size="30" required><br><br>
            <label for="imagen"><b>Imagen:</b></label>
            <input type="text" name="imagen" id="imagen" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ0-9 .,;:!@#%&()\-]+" size="30" required><br><br>
            <label for="talla"><b>Talla 36:</b></label>
            <input type="number" name="talla[1]" id="talla" size="1" required min="0" value="0"><br><br>
            <label for="talla"><b>Talla 37:</b></label>
            <input type="number" name="talla[2]" id="talla" size="1" required min="0" value="0"><br><br>
            <label for="talla"><b>Talla 38:</b></label>
            <input type="number" name="talla[3]" id="talla" size="1" required min="0" value="0"><br><br>
            <label for="talla"><b>Talla 39:</b></label>
            <input type="number" name="talla[4]" id="talla" size="1" required min="0" value="0"><br><br>
            <label for="talla"><b>Talla 40:</b></label>
            <input type="number" name="talla[5]" id="talla" size="1" required min="0" value="0"><br><br>
            <label for="talla"><b>Talla 41:</b></label>
            <input type="number" name="talla[6]" id="talla" size="1" required min="0" value="0"><br><br>
            <label for="talla"><b>Talla 42:</b></label>
            <input type="number" name="talla[7]" id="talla" size="1" required min="0" value="0"><br><br>
            <label for="talla"><b>Talla 43:</b></label>
            <input type="number" name="talla[8]" id="talla" size="1" required min="0" value="0"><br><br>
            <label for="talla"><b>Talla 44:</b></label>
            <input type="number" name="talla[9]" id="talla" size="1" required min="0" value="0"><br><br>
            <input id="botones" type="submit" value="Guardar">
            <input id="botones2" type="reset" value="Borrar">
        </fieldset>
    </form>

</body>

</html>