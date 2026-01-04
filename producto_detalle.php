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

// Comprueba que se reciba un ID válido en la URL
if (!isset($_GET['id']) || intval($_GET['id']) <= 0) {
    header("Location: index.php");
    exit;
}

// Obtener el ID del producto desde la URL
$id_producto = intval($_GET['id']);

// Obtiene los datos del producto
$sql_producto = "SELECT nombre, descripcion, precio, imagen 
                 FROM producto 
                 WHERE id_producto = :id";

$stmt = $conn->prepare($sql_producto);
$stmt->execute(['id' => $id_producto]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

// Si no existe el producto, muestra mensaje y termina
if (!$producto) {
    echo "Producto no encontrado";
    exit;
}

// Obtiene las tallas disponibles del producto junto con el stock
$sql_tallas = "
    SELECT t.id_talla, t.talla, pt.stock
    FROM producto_talla pt
    JOIN talla t ON pt.id_talla = t.id_talla
    WHERE pt.id_producto = :id
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
    <link rel="stylesheet" href="producto_detalle.css">
    <link rel="stylesheet" href="eliminar_cuenta.css">
    <script src="menu.js"></script>
    <script src="eliminar_cuenta.js"></script>
</head>

<body>

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
    <div id="cuerpo">
        <!-- Producto -->
        <div class="producto-detalle">
            <div class="producto-img">
                <img src="<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>">
            </div>
            <div class="producto-info">
                <h2><?= htmlspecialchars($producto['nombre']) ?></h2>
                <p class="precio"><?= $producto['precio'] ?> €</p>
                <p class="descripcion"><?= htmlspecialchars($producto['descripcion']) ?></p>
                <div class="talla-seleccion">
                    <h3>Selecciona la talla:</h3>
                    <form action="añadir_carro.php" method="post">
                        <input type="hidden" name="id_producto" value="<?= $id_producto ?>">
                        <label for="talla">Talla:</label>
                        <select name="id_talla" id="talla" required>
                            <option value="">Selecciona talla</option>
                            <?php foreach ($tallas as $fila): ?>
                                <?php if ($fila['stock'] > 0): ?>
                                    <option value="<?= $fila['id_talla'] ?>">
                                        <?= $fila['talla'] ?> (<?= $fila['stock'] ?> disponibles)
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit">Añadir al carrito</button>
                    </form>
                </div>
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