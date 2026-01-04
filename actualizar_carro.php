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

//Recogemos el id del carrito y la acción enviado por POST
$id_carro = intval($_POST['id_carro'] ?? 0);
$accion = $_POST['accion'] ?? '';

//Si no hay id de carrito o acción salimos del script
if (!$id_carro || !$accion) exit;

try {
    //Si la acción es aumentar, incrementamos la cantidad del producto
    if ($accion === 'aumentar') {
        $stmt = $conn->prepare("UPDATE carro SET cantidad = cantidad + 1 WHERE id_carro = :id_carro AND id_usuario = :id_usuario");
        $stmt->execute(['id_carro' => $id_carro, 'id_usuario' => $id_usuario]);

        //Si la acción es borrar eliminamos, el producto
    } elseif ($accion === 'borrar') {
        $stmt = $conn->prepare("DELETE FROM carro WHERE id_carro = :id_carro AND id_usuario = :id_usuario");
        $stmt->execute(['id_carro' => $id_carro, 'id_usuario' => $id_usuario]);
    }

    // Obtener carrito actualizado
    $stmt = $conn->prepare("
        SELECT c.id_carro, c.cantidad, p.nombre, p.precio, p.imagen, t.talla
        FROM carro c
        JOIN producto p ON c.id_producto = p.id_producto
        JOIN talla t ON c.id_talla = t.id_talla
        WHERE c.id_usuario = :id_usuario
    ");
    $stmt->execute(['id_usuario' => $id_usuario]);

    //Guardamos todos los productos del carrito en un array
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //Variables para construir el html y el contador del carrito
    $html = '';
    $contador = 0;

    //Si el carrito está vacío
    if (empty($productos)) {
        $html = '<p id="carrito-vacio">Carrito vacío</p>';
    } else {

        //recorremos todos los productos 
        foreach ($productos as $item) {

            // Sumamos la cantidad total para el contador del icono carrito
            $contador += (int)$item['cantidad'];

            //Construimos el HTML de cada producto
            $html .= '<div class="carro-item">';
            $html .= '<img src="' . $item['imagen'] . '" alt="' . $item['nombre'] . '">';
            $html .= '<div class="carro-info">';
            $html .= '<h3>' . $item['nombre'] . '</h3>';
            $html .= '<p>Talla: ' . $item['talla'] . '</p>';
            $html .= '<p>Precio: ' . $item['precio'] . ' €</p>';
            $html .= '<p>Cantidad: ' . $item['cantidad'] . '</p>';
            $html .= '<p>Subtotal: ' . ($item['precio'] * $item['cantidad']) . ' €</p>';
            $html .= '</div>';

            //botones para modificar el carrito con AJAX
            $html .= '<div class="carro-botones">';
            $html .= '<button onclick="actualizarCarro(' . $item['id_carro'] . ',\'aumentar\')">Añadir</button>';
            $html .= '<button onclick="actualizarCarro(' . $item['id_carro'] . ',\'borrar\')">Borrar</button>';
            $html .= '</div></div></div> ';
        }
    }
    // Devolvemos la respuesta en formato JSON para AJAX
    echo json_encode(['ok' => true, 'html' => $html, 'contador' => $contador]);
} catch (Exception $e) {

    // Si ocurre algún error, devolvemos el mensaje
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}
