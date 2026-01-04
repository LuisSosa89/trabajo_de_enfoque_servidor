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

//Incluye la funcion de mostrar la cantidad de artículos en el logo del carro
require_once "funcion_mostrar_cantidad_articulos_logo_carro.php";

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
    <link rel="stylesheet" href="pagina_articulos.css">
    <link rel="stylesheet" href="eliminar_cuenta.css">
    <script src="menu.js"></script>
    <script src="eliminar_cuenta.js"></script>
</head>

<body>

    <!--cabecera de la página-->

    <div id="cabecera">
        <h1>DAVANT SNEAKERS</h1>

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
    <!--Cuerpo de la página-->

    <div id="cuerpo">

        <!--Tbala de los diferentes productos-->

        <div class="producto_tabla">
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    <div class="producto">
                        <a href="producto_detalle.php?id=<?php echo $producto['id_producto']; ?>">
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