<?php

//Incluye la conexion a la base de datos
require_once "conexion_db.php";

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
    $Email = $_POST['Email'];

    try {
        // Iniciar transacción
        $conn->beginTransaction();
        $hash_contrasena = password_hash($contrasena, PASSWORD_DEFAULT);

        // Insertar en tabla usuario
        $stmt = $conn->prepare("INSERT INTO usuario (nombre_usuario, contrasena) 
                                VALUES (:nombre_usuario, :contrasena)");
        $stmt->bindParam(':nombre_usuario', $nombre_usuario);
        $stmt->bindParam(':contrasena', $hash_contrasena);
        $stmt->execute();

        // Obtener el id generado automáticamente
        $id_usuario = $conn->lastInsertId();

        // 2 = Cliente

        $id_rol = 2;

        $stmt = $conn->prepare("INSERT INTO usuario_rol (id_usuario, id_rol) VALUES (:id_usuario, :id_rol)");
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':id_rol', $id_rol);
        $stmt->execute();

        // Insertar en tabla datos_usuario
        $stmt = $conn->prepare("INSERT INTO datos_usuario 
            (id_usuario, nombre, apellidos, dni, direccion, poblacion, provincia, codigo_postal, telefono, Email) 
            VALUES (:id_usuario, :nombre, :apellidos, :dni, :direccion, :poblacion, :provincia, :codigo_postal, :telefono, :Email)");

        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':poblacion', $poblacion);
        $stmt->bindParam(':provincia', $provincia);
        $stmt->bindParam(':codigo_postal', $codigo_postal);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':Email', $Email);

        $stmt->execute();

        // Confirmar transacciónº
        $conn->commit();

        header("location: formulario_inicio_de_sesion.html");
        exit();
    } catch (PDOException $e) {
        // Deshacer cambios si ocurre error
        $conn->rollBack();
        echo "Error al guardar el registro: " . $e->getMessage();
    }
}
