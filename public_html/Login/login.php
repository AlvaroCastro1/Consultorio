<?php
// Incluir el archivo de conexión
include('../includes/conexion.php');

// Verificar si se ha enviado el formulario de inicio de sesión
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $nombreUsuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];

    // Consulta SQL para obtener la contraseña almacenada del usuario
    $sql = "SELECT Contrasena FROM Usuario WHERE Nombre_Usuario='$nombreUsuario'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $contrasena_hash = $row['Contrasena'];

        // Verificar si la contraseña ingresada coincide con la contraseña almacenada
        if (password_verify($contrasena, $contrasena_hash)) {
            // Inicio de sesión exitoso
            session_start();
            $_SESSION['nombre_usuario'] = $nombreUsuario;
            header("location: ../index.html");// Redirigir a la página de bienvenida
        } else {
            // Credenciales incorrectas
            $error = "Nombre de usuario o contraseña incorrectos.";
            header("location: ../includes/error_sesion.php?error=$error");
        }
    } else {
        // El usuario no existe
        $error = "Nombre de usuario o contraseña incorrectos.";
        header("location: ../includes/error_sesion.php?error=$error");
    }
}

// Cerrar conexión a la base de datos (puedes omitir esto si el archivo de conexión ya lo hace)
$conn->close();
?>
