<?php

// Datos de conexión a la base de datos
$servername = "localhost"; // Servidor donde está la base de datos
$username = "root";        // Usuario de la base de datos
$password = "srl48f3-m";   // Contraseña del usuario
$database = "tienda";       // Nombre de la base de datos a usar

try {
    // Crear una nueva conexión PDO a la base de datos    
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);

    // Configurar PDO para que lance excepciones en caso de error
    // Esto permite capturar errores de conexión o consultas con try/catch
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si ocurre algún error al conectar, se detiene el script y muestra el mensaje de error
    die("Error de conexión: " . $e->getMessage());
}
?>
