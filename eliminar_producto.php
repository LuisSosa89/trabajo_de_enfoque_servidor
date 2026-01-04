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
     echo "<p>Lo sentimos, ocurrió un error al cargar los productos. Por favor, inténtalo más tarde.</p>";
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="eliminar_producto.css">
    <script src="eliminar_producto.js"></script>
</head>

<body>

    <!--cabecera de la página-->

    <div id="cabecera">
        <h1><a href="administrar_pagina.php">DAVANT SNEAKERS</a></h1>



        <!--Cuerpo de la página-->

        <div id="cuerpo">

            <h2>¿Que prodcuto quiere eliminar?</h2>
            <!--Tbala de los diferentes productos-->

            <div class="producto_tabla">
                <?php if (!empty($productos)): ?>
                    <?php foreach ($productos as $producto): ?>
                        <div class="producto" data-id="<?= $producto['id_producto'] ?>">
                            <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                            <div class="producto-nombre"><?php echo htmlspecialchars($producto['nombre']); ?></div>
                            <div class="producto-precio"><?php echo htmlspecialchars($producto['precio']); ?> €</div>

                            <!-- Guardar el ID del producto de forma oculta -->
                            <input type="hidden" id="id_producto" value="<?php echo $producto['id_producto']; ?>">
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay productos disponibles</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación para eliminar producto -->
    <div id="modalEliminar">
        <div class="modal-contenido">
            <p>¿Estás seguro de que deseas eliminar este producto?</p>

            <div class="modal-botones">
                <button id="confirmarEliminar">Eliminar</button>
                <button id="cancelarEliminar">Cancelar</button>
            </div>
        </div>
    </div>





</body>

</html>