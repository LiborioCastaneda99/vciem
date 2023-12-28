<?php
// Iniciar la sesión (si no está iniciada)
session_start();

// Destruir todas las variables de sesión
$_SESSION = array();

// Eliminar la cookie de la sesión si está configurada
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// Destruir la sesión
session_destroy();

// Redirigir al usuario a la página de inicio o a donde desees después del logout
header("Location: ../logout.php");
exit();
?>
