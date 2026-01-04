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

// Comprobamos que se pasa un ID válido por GET
if (!isset($_GET['id']) || intval($_GET['id']) <= 0) {
    header("administrar_pagina.php");
    exit;
}

// Obtener el ID del producto desde la URL
$id_producto = intval($_GET['id']);

// Preparar la consulta para obtener los datos del producto
$sql_producto = "SELECT nombre, descripcion, precio, imagen 
                 FROM producto 
                 WHERE id_producto = :id";

$stmt = $conn->prepare($sql_producto);
$stmt->execute(['id' => $id_producto]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

// Si no se encuentra el producto, se muestra un mensaje de error
if (!$producto) {
    echo "Producto no encontrado";
    exit;
}

// Obtener las tallas disponibles y su stock para este producto
$sql_tallas = "
    SELECT 
        t.id_talla,
        t.talla,
        COALESCE(pt.stock, 0) AS stock
    FROM talla t
    LEFT JOIN producto_talla pt 
        ON t.id_talla = pt.id_talla 
        AND pt.id_producto = :id
    ORDER BY t.talla
";

$stmt = $conn->prepare($sql_tallas);
$stmt->execute(['id' => $id_producto]);
$tallas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="modificar_producto_seleccionado.css">
</head>

<body>

    <!-- Título principal con enlace a la página princpal de administrador -->
    <h1><a href="administrar_pagina.php">DAVANT SNEAKERS</a></h1>

    <!-- Formulario para modificar el producto -->
    <form action="verificar_modificar_producto.php" method="POST">
        <fieldset>
            <legend>Modificar producto</legend>
            <input type="hidden" name="id_producto" value="<?= $id_producto ?>">
            <label for="nombre"><b>Nombre:</b></label>
            <input type="text" name="nombre" id="nombre" size="30" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ0-9 .,;:!@#%&()\-]+" rquired value="<?= htmlspecialchars($producto['nombre']) ?>"><br><br>
            <label for="precio"><b>Precio:</b></label>
            <input type="text" name="precio" id="precio" pattern="[0-9]+(\.[0-9]{1,2})?" title="Solo debe contener numeros" size="1" required value="<?= htmlspecialchars($producto['precio']) ?>"><br><br>
            <label for="descripcion"><b>Descripción:</b></label>
            <input type="text" name="descripcion" id="descripcion" size="30" required value="<?= htmlspecialchars($producto['descripcion']) ?>"><br><br>
            <label for="imagen"><b>Imagen:</b></label>
            <input type="text" name="imagen" id="imagen" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ0-9 .,;:!@#%&()\-]+" size="30" required value="<?= htmlspecialchars($producto['imagen']) ?>"><br><br>

            <!-- Generar inputs para cada talla con su stock -->
            <?php foreach ($tallas as $talla): ?>
                <label>
                    <b>Talla <?= htmlspecialchars($talla['talla']) ?>:</b>
                </label>
                <input type="number"
                    name="stock[<?= $talla['id_talla'] ?>]"
                    min="0"
                    value="<?= $talla['stock'] ?>">
                <br><br>
            <?php endforeach; ?>
            <input id="botones" type="submit" value="Guardar">
            <input id="botones2" type="reset" value="Borrar">
        </fieldset>
    </form>

</body>

</html>