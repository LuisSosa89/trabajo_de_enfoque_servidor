<?php

//Inicia sesión para poder acceder a $_SESSION
session_start();

//Incluye la conexion a la base de datos
require_once 'conexion_db.php';

// Recoge los datos enviados desde el formulario de login
$usuario = $_POST['nombre'];
$password = $_POST['password'];

// Preparar consulta para obtener información del usuario y su rol
$stmt = $conn->prepare(
    "SELECT u.id_usuario, u.nombre_usuario, u.contrasena, r.id_rol
     FROM usuario u
     JOIN usuario_rol ur ON u.id_usuario = ur.id_usuario
     JOIN rol r ON ur.id_rol = r.id_rol
     WHERE u.nombre_usuario = ?
     LIMIT 1"
);
$stmt->execute([$usuario]);
$fila = $stmt->fetch(PDO::FETCH_ASSOC);

// Si existe el usuario y la contraseña coincide con el hash almacenado
if ($fila && password_verify($password, $fila['contrasena'])) {

    // Guardar datos en sesión
    $_SESSION['id_usuario'] = $fila['id_usuario'];
    $_SESSION['nombre'] = $fila['nombre_usuario'];
    $_SESSION['id_rol'] = $fila['id_rol'];

    // Redirigir según rol
    if ($fila['id_rol'] === 2) { // cliente      
        header("Location:pagina_articulos.php");
        exit;
    } else {
        header("Location: administrar_pagina.php");
        exit;
    }
}

// Usuario o contraseña incorrecta
header("Location: formulario_inicio_de_sesion.html");
exit;
