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

//Incluye la función mostrar cantidad de artículos en el logo del carro
require_once "funcion_mostrar_cantidad_articulos_logo_carro.php";

//Guardamos el id del usuario logueado
$id_usuario = $_SESSION['id_usuario'] ?? 0;

try {
    // Obtener historial de compras del usuario
    $stmt = $conn->prepare("
    SELECT  h.fecha,
            p.imagen,
            p.nombre,
            t.talla,
            h.cantidad,
            h.precio_unitario,
            h.total
        FROM historial_de_compras h
        JOIN producto p ON h.id_producto = p.id_producto
        JOIN talla t ON h.id_talla = t.id_talla
        WHERE h.id_usuario = :id_usuario
        ORDER BY h.fecha DESC");

    $stmt->execute(['id_usuario' => $id_usuario]);
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener historial de compras: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="historial_de_compras.css">
    <link rel="stylesheet" href="eliminar_cuenta.css">
    <script src="menu.js"></script>
</head>

<body>

    <!--cabecera de la página-->

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
    <!--Cuerpo de la página-->

    <div id="cuerpo">

        <h2>Historial de Compras</h2>

        <!--Tbala de los diferentes productos-->

        <div class="historial_compras">
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    <div class="producto">
                        <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>"><br>
                        <p><?php echo $producto['fecha']; ?></p><br>
                        <p><?php echo htmlspecialchars($producto['nombre']); ?></p><br>
                        <p>Talla:<?php echo htmlspecialchars($producto['talla']); ?></p><br>
                        <p>Cantidad: <?php echo htmlspecialchars($producto['cantidad']); ?></p><br>
                        <p>Precio unitario: <?php echo htmlspecialchars($producto['precio_unitario']); ?>€</p><br>
                        <p>Total:<?php echo htmlspecialchars($producto['total']); ?>€</p><br>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Haz tu primera compra para ver el historial</p>
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