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
    // Obtener productos de la base de datos
    $stmt = $conn->query("SELECT id_producto, nombre, precio, imagen FROM producto");
    $productos = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error al obtener productos: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="modificar_producto.css">
</head>

<body>

    <!--cabecera de la página-->

    <div id="cabecera">
        <h1><a href="administrar_pagina.php">DAVANT SNEAKERS</a></h1>

        <!--Cuerpo de la página-->

        <div id="cuerpo">

            <h2>¿Que prodcuto quiere modificar?</h2>

            <!--Tbala de los diferentes productos-->

            <div class="producto_tabla">
                <?php if (!empty($productos)): ?>
                    <?php foreach ($productos as $producto): ?>
                        <div class="producto">
                            <a href="modificar_producto_seleccionado.php?id=<?php echo $producto['id_producto']; ?>">
                                <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                                <div class="producto-nombre"><?php echo htmlspecialchars($producto['nombre']); ?></div>
                                <div class="producto-precio"><?php echo htmlspecialchars($producto['precio']); ?> €</div>
                            </a>
                            <input type="hidden" id="id_producto" value="<?php echo $producto['id_producto']; ?>">
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay productos disponibles</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>

</html>