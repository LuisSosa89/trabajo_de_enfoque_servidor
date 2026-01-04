<?php

//Función para mostrar la cantidad de articulos que hay en el carrito
function obtenerContadorCarrito($id_usuario, $conn)
{
    $stmt = $conn->prepare("SELECT SUM(cantidad) FROM carro WHERE id_usuario = :id_usuario");
    $stmt->execute(['id_usuario' => $id_usuario]);
    $contador = $stmt->fetchColumn();
    return $contador ?: 0;
}
