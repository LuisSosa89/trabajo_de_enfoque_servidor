<?php

// Inicia sesión para poder acceder a $_SESSION
session_start(); 

// Si el usuario esta logueado
if (isset($_SESSION['id_usuario'])) {

    // Vacía las variables de sesión
    session_unset();  
    
    // Destruye la sesión
    session_destroy();  
}

// Si no esta logueado redirige a la página principal
header("Location: pagina_principal.html");
exit;
?>