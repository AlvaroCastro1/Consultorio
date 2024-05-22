<?php
session_start();

// Incluir el archivo de conexión
include('../includes/conexion.php');

// Verificar si se ha enviado el formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $nombreUsuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];

    // Consulta SQL para obtener la contraseña almacenada del usuario
    $sql = "SELECT Contrasena FROM Usuario WHERE Nombre_Usuario=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nombreUsuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $contrasena_hash = $row['Contrasena'];

        // Verificar si la contraseña ingresada coincide con la contraseña almacenada
        if (password_verify($contrasena, $contrasena_hash)) {
            // Inicio de sesión exitoso
            $_SESSION['nombre_usuario'] = $nombreUsuario;
            header("Location: ../index.php");
            exit;
        } else {
            // Credenciales incorrectas
            $error = "Nombre de usuario o contraseña incorrectos.";
        }
    } else {
        // El usuario no existe
        $error = "Nombre de usuario o contraseña incorrectos.";
    }

    // Cerrar la declaración
    $stmt->close();
}

// Cerrar conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DynaPuff:wght@400..700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/LoginStyles.css">
</head>
<body>
    <div class="container2 mt-5">
        <h1 class="text-center mb-5 titulo">¡Bienvenido!</h1>
        <h3 class="text-center mb-5">Ingrese su usuario y contraseña</h3>
        <div class="row justify-content-center">
          <div class="col-md-4">
            <img src="../assets/Imagenes/doctor.png" class="img-fluid" alt="Imagen de fondo">
          </div>
          <div class="col-md-6">
            <div class="card">
              <div class="card-header text-center">Inicio de sesión</div>
              <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                <form method="post" action="login.php">
                  <div class="form-group">
                    <label for="username">Nombre de usuario</label>
                    <input type="text" class="form-control" id="username" name="nombre_usuario" placeholder="Ingrese su nombre de usuario" required>
                  </div>
                  <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="contrasena" placeholder="Ingrese su contraseña" required>
                  </div>
                  <button type="submit" class="btn btn-primary btn-block" id="iniciar">Iniciar Sesión</button>
                </form>
              </div>
              <a href="../Login/crear.php" class="btn btn-danger">Crear Usuario</a>
            </div>
          </div>
        </div>
      </div>
      <div class="espacio-final"></div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
