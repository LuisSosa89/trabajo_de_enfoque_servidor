<?php

// Inicia la sesión para poder acceder a $_SESSION
session_start();

// Incluye la conexión a la base de datos
require_once "conexion_db.php";

//Si el usuario no esta logueado, se redirige a la pagina principal.
if (!isset($_SESSION['id_usuario'])) {
    header("Location: pagina_principal.html");
    exit;
}

// Guarda el id del usuario logueado
$id_usuario = $_SESSION['id_usuario'];

// Solo se ejecuta si la petición es POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Recoge los datos enviados por el formulario
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

    try {
        // Iniciar transacción
        $conn->beginTransaction();

        // Insertar en tabla usuario
        $stmt = $conn->prepare("UPDATE usuario SET nombre_usuario = :nombre_usuario WHERE id_usuario = :id_usuario");
        $stmt->bindParam(':nombre_usuario', $nombre_usuario);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();

        // Cambiar contraseña solo si el usuario escribe algo
        if (!empty($_POST['contrasena'])) {

            // Genera el hash seguro de la contraseña
            $hash_contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

            // Actualiza los datos personales del usuario
            $stmt = $conn->prepare("
        UPDATE usuario 
        SET contrasena = :contrasena
        WHERE id_usuario = :id_usuarioF
    ");
            // Vincula los parámetros
            $stmt->bindParam(':contrasena', $hash_contrasena);
            $stmt->bindParam(':id_usuario', $id_usuario);
            $stmt->execute();
        }


        // Insertar en tabla datos_usuario
        $stmt = $conn->prepare("UPDATE datos_usuario SET 
            nombre = :nombre, apellidos = :apellidos, dni = :dni, direccion = :direccion, poblacion = :poblacion, provincia = :provincia, codigo_postal = :codigo_postal, telefono = :telefono, email = :email
            WHERE id_usuario = :id_usuario");

        // Vincula los parámetros
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

        // Confirmar transacción
        $conn->commit();

        // Redirige tras guardar correctamente
        header("location: pagina_articulos.php");
        exit();
    } catch (PDOException $e) {
        
        // Deshacer cambios si ocurre error
        $conn->rollBack();
        echo "Error al guardar el registro: " . $e->getMessage();
    }
}
