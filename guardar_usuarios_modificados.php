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

// ID del usuario que se va a modificar (forzado a entero por seguridad)
$id_usuario = (int)$_POST['id_usuario'];

// Comprobamos que el formulario se envía por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Recogemos los datos del formulario
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $dni = $_POST['dni'];
    $direccion = $_POST['direccion'];
    $poblacion = $_POST['poblacion'];
    $provincia = $_POST['provincia'];
    $codigo_postal = $_POST['codigo_postal'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $id_rol = $_POST['rol'];

    try {
        // Iniciar transacción
        $conn->beginTransaction();

        // Insertar en tabla usuario
        $stmt = $conn->prepare("UPDATE usuario SET nombre_usuario = :nombre_usuario WHERE id_usuario = :id_usuario");
        $stmt->bindParam(':nombre_usuario', $nombre_usuario);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();

        // Cambiar contraseña solo si el usuario escribe algo y la encripta
        if (!empty($_POST['contrasena'])) {
            $hash_contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

            $stmt = $conn->prepare("
        UPDATE usuario 
        SET contrasena = :contrasena
        WHERE id_usuario = :id_usuario
    ");
            $stmt->bindParam(':contrasena', $hash_contrasena);
            $stmt->bindParam(':id_usuario', $id_usuario);
            $stmt->execute();
        }


        // Insertar en tabla datos_usuario
        $stmt = $conn->prepare("UPDATE datos_usuario SET 
            nombre = :nombre, apellidos = :apellidos, dni = :dni, direccion = :direccion, poblacion = :poblacion, provincia = :provincia, codigo_postal = :codigo_postal, telefono = :telefono, email = :email
            WHERE id_usuario = :id_usuario");

        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':poblacion', $poblacion);
        $stmt->bindParam(':provincia', $provincia);
        $stmt->bindParam(':codigo_postal', $codigo_postal);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':email', $email);

        $stmt->execute();

        // Insertar en tabla usuario_rol
        $stmt = $conn->prepare("UPDATE usuario_rol SET 
            id_usuario = :id_usuario, id_rol = :id_rol
            WHERE id_usuario = :id_usuario");

        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':id_rol', $id_rol);

        $stmt->execute();

        // Confirmar transacción
        $conn->commit();

        header("location: administrar_pagina.php");
        exit();
    } catch (PDOException $e) {
        // Deshacer cambios si ocurre error
        $conn->rollBack();
        echo "Error al guardar el registro: " . $e->getMessage();
    }
}
