<?php
// Incluir el archivo de conexión
include('../includes/conexion.php');

// Verificar si se ha enviado el formulario de inicio de sesión
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $nombreUsuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];

    // Consulta SQL para verificar las credenciales del usuario
    $sql = "SELECT * FROM Usuario WHERE Nombre_Usuario='$nombreUsuario' AND Contrasena='$contrasena'";
    echo $sql;
    $result = $conn->query($sql);

    // Verificar si se encontró un usuario con las credenciales proporcionadas
    if ($result->num_rows > 0) {
        // Inicio de sesión exitoso
        session_start();
        $_SESSION['nombre_usuario'] = $nombreUsuario;
        header("location: ../index.html");// Redirigir a la página de bienvenida
    } else {
        // Credenciales incorrectas
        $error = "SELECT * FROM Usuario WHERE Nombre_Usuario='$nombreUsuario' AND Contrasena='$contrasena'";
        header("location: ../includes/error_sesion.php?error=$error"); // Redirigir de nuevo a la página de login con un mensaje de error
    }
}

// Cerrar conexión a la base de datos (puedes omitir esto si el archivo de conexión ya lo hace)
$conn->close();
?>
