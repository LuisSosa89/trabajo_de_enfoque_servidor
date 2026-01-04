<?php

//Inicia sesión para poder acceder a $_SESSION
session_start();

//Incluye la conexion a la base de datos
require_once "conexion_db.php";

//Si el usuario no esta logueado, se redirige a la pagina principal
if (!isset($_SESSION['id_usuario'])) {
    header("Location: pagina_principal.html");
    exit;
}

//Guardamos el id del usuario logueado
$id_usuario = $_SESSION['id_usuario'];

try {
    // Consulta para obtener los datos del usuario    
    $stmt = $conn->prepare("
        SELECT u.nombre_usuario, d.nombre, d.apellidos, d.dni, d.direccion, d.poblacion, d.provincia, d.codigo_postal, d.telefono, d.email
        FROM usuario u
        JOIN datos_usuario d ON u.id_usuario = d.id_usuario
        WHERE u.id_usuario = :id_usuario");

    $stmt->execute(['id_usuario' => $id_usuario]);
    $datos = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Error al obtener los datos: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="formulario_de_registro.css">
</head>

<body>

    <!--cabecera de la página-->

    <div id="cabecera">
        <h1><a href="pagina_articulos.php">DAVANT SNEAKERS</a></h1>
    </div>

    <!--Cuerpo de la página-->

    <div id="cuerpo">
        <h2>Formulario de registro</h2>

        <!--Formulario para iniciar sesion-->

        <div id="caja_formulario">
            <form action="actualizar_datos_usuario.php" method="POST">
                <fieldset id="datos_sesion">
                    <legend>Datos inicio de sesión</legend>
                    <label for="nombre_usuario"><b>Nombre usuario:</b></label>
                    <input type="text" name="nombre_usuario" id="nombre_usuario" size="40" required value="<?php echo isset($datos['nombre_usuario']) ? $datos['nombre_usuario'] : ''; ?>"><br><br>
                    <label for="contrasena"><b>Contraseña:</b></label>
                    <input type="password" name="contrasena" id="contrasena" size="40">
                </fieldset>
                <fieldset>
                    <legend>Datos personales</legend>
                    <label for="nombre"><b>Nombre:</b></label>
                    <input type="text" name="nombre" id="nombre" size="40" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+" title="Solo debe contener letras" required value="<?php echo isset($datos['nombre']) ? $datos['nombre'] : ''; ?>">
                    <label for="apellidos"><b>Apellidos:</b></label>
                    <input type="text" name="apellidos" id="apellidos" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+" title="Solo debe contener letras" size="40" required value="<?php echo isset($datos['apellidos']) ? $datos['apellidos'] : ''; ?>">
                    <label for="dni"><b>DNI:</b></label>
                    <input type="text" name="dni" id="dni" pattern="[0-9]{8}[A-Za-z]{1}" title="Debe poner 8 números y una letra" minlength="9" maxlength="9" size="7" required value="<?php echo isset($datos['dni']) ? $datos['dni'] : ''; ?>"><br><br>
                    <label for="direccion"><b>Dirección:</b></label>
                    <input type="text" name="direccion" id="direccion" size="60" required value="<?php echo isset($datos['direccion']) ? $datos['direccion'] : ''; ?>">
                    <label for="poblacion"><b>Población:</b></label>
                    <input type="text" name="poblacion" id="poblacion" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+" title="Solo debe contener letras" size="40" required value="<?php echo isset($datos['poblacion']) ? $datos['poblacion'] : ''; ?>"><br><br>
                    <label for="provincia"><b>Provincia:</b></label>
                    <input type="text" name="provincia" id="provincia" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+" title="Solo debe contener letras" size="40" required value="<?php echo isset($datos['provincia']) ? $datos['provincia'] : ''; ?>">
                    <label for="codigo_postal"><b>Código postal:</b></label>
                    <input type="text" name="codigo_postal" id="codigo_postal" pattern="[0-9]{5}" maxlength="5" minlength="5" title="Debe contener 5 números" size="7" required value="<?php echo isset($datos['codigo_postal']) ? $datos['codigo_postal'] : ''; ?>"><br><br>
                    <label for="telefono"><b>Teléfono:</b></label>
                    <input type="text" name="telefono" id="telefono" pattern="[0-9]{9}" maxlength="9" minlength="9" size="7" required value="<?php echo isset($datos['telefono']) ? $datos['telefono'] : ''; ?>">
                    <label for="email"><b>Email:</b></label>
                    <input type="text" name="email" id="email" size="40" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="Correo mal intriducido" required value="<?php echo isset($datos['email']) ? $datos['email'] : ''; ?>"><br><br>
                    <input id="botones" type="submit" value="Guardar">
                    <input id="botones2" type="reset" value="Borrar">
                </fieldset>
            </form>
        </div>
    </div>

    <!--Pie de página-->

    <footer>
        <div id="parrafo_footer">
            <p>Davant Sneakers</p><br>
            <p>Calle Sin salida s/n CP 47896 Sevilla (Sevilla)</p><br>
            <p>Teléfono 900 900 900</p><br>
        </div>
        <div id="logo_footer">
            <img src="Logos/facebook.png" style="filter: invert(100%);" alt="Facebook logo">
            <img src="Logos/instagram.png" style="filter: invert(100%);" alt="Logo de instagram">
            <img src="Logos/twitter.png" style="filter: invert(100%);" alt="Logo de twitter">
        </div>
    </footer>

</body>

</html>