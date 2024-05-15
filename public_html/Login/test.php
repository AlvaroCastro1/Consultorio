<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['nombre_usuario'])) {
    // Si el usuario ha iniciado sesión, mostrar el nombre de usuario
    $nombreUsuario = $_SESSION['nombre_usuario'];
} else {
    // Si el usuario no ha iniciado sesión, redirigir al formulario de inicio de sesión
    header("location: index.html");
    exit; // Asegurarse de que el script se detenga aquí
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
</head>
<body>
    <h1>Bienvenido, <?php echo $nombreUsuario; ?>!</h1>
    <!-- Aquí puedes agregar más contenido HTML -->
</body>
</html>
