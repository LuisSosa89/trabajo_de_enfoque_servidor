<?php

//Inicia sesión para poder acceder a $_SESSION
session_start();

//Incluye la conexion a la base de datos
require_once "conexion_db.php";

// Incluye la función que obtiene la cantidad total de productos en el carrito para el logo
require_once "funcion_mostrar_cantidad_articulos_logo_carro.php";

//Si el usuario no esta logueado, se redirige a la pagina principal.
if (!isset($_SESSION['id_usuario'])) {
    header("Location: pagina_principal.html");
    exit;
}

//Guardamos el id del usuario logueado
$id_usuario = $_SESSION['id_usuario'] ?? 0;

// Obtener productos del carrito
$stmt = $conn->prepare("
    SELECT c.id_carro, c.cantidad, p.nombre, p.precio, p.imagen, t.talla
    FROM carro c
    JOIN producto p ON c.id_producto = p.id_producto
    JOIN talla t ON c.id_talla = t.id_talla
    WHERE c.id_usuario = :id_usuario
");
$stmt->execute(['id_usuario' => $id_usuario]);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link rel="stylesheet" href="carro.css">
    <link rel="stylesheet" href="eliminar_cuenta.css">
    <script src="menu.js" defer></script>
    <script src="carro.js" defer></script>
    <script src="eliminar_cuenta.js" defer></script>
</head>

<body>

    <!-- Contenedor principal de la página -->
    <div id="contenedor-principal">

        <!--cabecera de la página-->

        <div id="cabecera">
            <h1><a href="pagina_articulos.php">DAVANT SNEAKERS</a></h1>

            <!--Logos de inicio de sesión y cesta de la compra-->
            <div id="iconos">
                <div id=logo_menu>
                    <img src="Logos/usuario.png" alt="usuario" style="filter: invert(100%);" id="usuario">
                    <ul id="menu_usuario">
                        <li><a href="modificar_datos.php">Modificar datos</a></li>
                        <li><a href="#" id="abrirPopup">Eliminar cuenta</a></li>
                        <li><a href="cerrar_sesion.php">Cerrar sesión</a></li>
                        <li><a href="historial_de_compras.php">Historial de compras</a></li>
                    </ul>
                </div>
                <div id="logo_carro">
                    <a href="carro.php">
                        <img src="Logos/carro.png" alt="carro" style="filter: invert(100%);" id="carro">
                        <span id="contador-carrito">
                            <?= isset($_SESSION['id_usuario']) ? obtenerContadorCarrito($_SESSION['id_usuario'], $conn) : 0 ?>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        <!-- Contenedor de productos -->
        <div class="lista-productos" id="lista-productos">

            <!-- Si hay productos en el carrito -->
            <?php if (count($productos) > 0): ?>
                <?php foreach ($productos as $item): ?>
                    <div class="carro-item">

                        <!-- Imagen del producto -->
                        <img src="<?= htmlspecialchars($item['imagen']) ?>" alt="<?= htmlspecialchars($item['nombre']) ?>">

                        <!-- Información del producto -->
                        <div class="carro-info">
                            <h3><?= htmlspecialchars($item['nombre']) ?></h3>
                            <p>Talla: <?= $item['talla'] ?></p>
                            <p>Precio: <?= $item['precio'] ?> €</p>
                            <p>Cantidad: <?= $item['cantidad'] ?></p>
                            <p>Subtotal: <?= (float)$item['precio'] * (int)$item['cantidad'] ?> €</p>
                        </div>

                        <!-- Botones para actualizar el carrito -->
                        <div class="carro-botones">
                            <button onclick="actualizarCarro(<?= $item['id_carro'] ?>,'aumentar')">Añadir</button>
                            <button onclick="actualizarCarro(<?= $item['id_carro'] ?>,'borrar')">Borrar</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>

                <!-- Mensaje si el carrito está vacío -->
                <p id="carrito-vacio">Carrito vacío</p>
            <?php endif; ?>
        </div>

        <!-- Mostrar botón solo si hay productos, botón de finalizar compra -->
        <?php if (count($productos) > 0): ?>
            <div class="contenedor-finalizar">
                <div class="boton-finalizar">
                    <button onclick="finalizarCompra()">Finalizar compra</button>
                </div>
            </div>
        <?php endif; ?>

        <!-- Modal de éxito cuando la compra se realiza correctamente -->
        <div id="modal-exito">
            <div class="contenido">
                <h2>Compra realizada con éxito 🎉</h2>
                <p>¿Quieres cerrar sesión o ir a la página principal?</p>
                <button onclick="window.location.href='pagina_articulos.php'">Página principal</button>
                <button onclick="window.location.href='cerrar_sesion.php'">Cerrar sesión</button>
            </div>
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