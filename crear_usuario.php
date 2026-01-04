<?php

//Inicia sesión para poder acceder a $_SESSION
session_start();

//Si el usuario no esta logueado, se redirige a la pagina principal.
if (!isset($_SESSION['id_usuario'])) {
    header("Location: pagina_principal.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="crear_usuario.css">
</head>

<body>

    <!--cabecera de la página-->

    <div id="cabecera">
        <h1><a href="administrar_pagina.php">DAVANT SNEAKERS</a></h1>
    </div>

    <!--Cuerpo de la página-->

    <div id="cuerpo">
        <h2>Crear nuevo usuario</h2>

        <!--Formulario para crear usuario nuevo-->

        <div id="caja_formulario">
            <form action="guardar_usuarios_nuevos.php" method="POST">
                <fieldset id="datos_sesion">
                    <legend>Datos inicio de sesión</legend>
                    <label for="nombre_usuario"><b>Nombre usuario:</b></label>
                    <input type="text" name="nombre_usuario" id="nombre_usuario" size="30" required><br><br>
                    <label for="contrasena"><b>Contraseña:</b></label>
                    <input type="password" name="contrasena" id="contrasena" size="30" required>
                </fieldset>
                <fieldset>
                    <legend>Datos personales</legend>
                    <label for="nombre"><b>Nombre:</b></label>
                    <input type="text" name="nombre" id="nombre" size="30" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+" title="Solo debe contener letras" required><br><br>
                    <label for="apellidos"><b>Apellidos:</b></label>
                    <input type="text" name="apellidos" id="apellidos" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+" title="Solo debe contener letras" size="30" required><br><br>
                    <label for="dni"><b>DNI:</b></label>
                    <input type="text" name="dni" id="dni" pattern="[0-9]{8}[A-Za-z]{1}" title="Debe poner 8 números y una letra" minlength="9" maxlength="9" size="7" required><br><br>
                    <label for="direccion"><b>Dirección:</b></label>
                    <input type="text" name="direccion" id="direccion" size="30" required><br><br>
                    <label for="poblacion"><b>Población:</b></label>
                    <input type="text" name="poblacion" id="poblacion" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+" title="Solo debe contener letras" size="30" required><br><br>
                    <label for="provincia"><b>Provincia:</b></label>
                    <input type="text" name="provincia" id="provincia" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+" title="Solo debe contener letras" size="30" required><br><br>
                    <label for="codigo_postal"><b>Código postal:</b></label>
                    <input type="text" name="codigo_postal" id="codigo_postal" pattern="[0-9]{5}" maxlength="5" minlength="5" title="Debe contener 5 números" size="7" required><br><br>
                    <label for="telefono"><b>Teléfono:</b></label>
                    <input type="text" name="telefono" id="telefono" pattern="[0-9]{9}" maxlength="9" minlength="9" size="7" required><br><br>
                    <label for="Email"><b>Email:</b></label>
                    <input type="text" name="Email" id="Email" size="30" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="Correo mal intriducido" required><br><br>
                    <label type="rol"><b>Seleccione rol:</b></label>
                    <input type="radio" name="rol" value="2" required>Cliente<br><br>
                    <input type="radio" name="rol" value="1">Administrador<br><br>
                    <input id="botones" type="submit" value="Guardar">
                    <input id="botones2" type="reset" value="Borrar">
                </fieldset>
            </form>
        </div>
    </div>
    
</body>

</html>