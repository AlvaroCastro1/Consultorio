<?php
session_start();
require_once '../includes/conexion.php';

if (!isset($_SESSION['nombre_usuario'])) {
    header("Location: ./Login/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_SESSION['nombre_usuario'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validar que las nuevas contraseñas coincidan
    if ($new_password !== $confirm_password) {
        $error_message = "Las nuevas contraseñas no coinciden.";
    } else {
        // Obtener la contraseña actual del usuario
        $sql = "SELECT Contrasena FROM Usuario WHERE Nombre_Usuario = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            // Verificar la contraseña actual
            if ($stmt->num_rows > 0 && password_verify($current_password, $hashed_password)) {
                // Actualizar la nueva contraseña
                $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $sql = "UPDATE Usuario SET Contrasena = ? WHERE Nombre_Usuario = ?";
                if ($update_stmt = $conn->prepare($sql)) {
                    $update_stmt->bind_param("ss", $new_hashed_password, $username);
                    if ($update_stmt->execute()) {
                        // $success_message = "Contraseña actualizada con éxito.";
                        // Contraseña actualizada con éxito, cerrar sesión
                        session_unset();
                        session_destroy();
                        header("Location: ./login.php?message=Contraseña actualizada, por favor inicie sesión nuevamente.");
                        exit();
                    } else {
                        $error_message = "Error al actualizar la contraseña.";
                    }
                } else {
                    $error_message = "Error en la preparación de la consulta de actualización: " . $conn->error;
                }
            } else {
                $error_message = "La contraseña actual es incorrecta.";
            }

            $stmt->close();
        } else {
            $error_message = "Error en la preparación de la consulta de selección: " . $conn->error;
        }
    }
}
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
        <h1 class="text-center mb-5 titulo">Actualizar Contraseña</h1>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success text-center" role="alert">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST" class="text-center">
            <div class="form-group">
                <label for="current_password">Contraseña Actual</label>
                <div class="input-group">
                    <input type="password" id="current_password" name="current_password" class="form-control" required>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility('current_password')">Mostrar</button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="new_password">Nueva Contraseña</label>
                <div class="input-group">
                    <input type="password" id="new_password" name="new_password" class="form-control" required>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility('new_password')">Mostrar</button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirmar Nueva Contraseña</label>
                <div class="input-group">
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility('confirm_password')">Mostrar</button>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Contraseña</button>
        </form>
        <div class="espacio-final"></div>
        <div class="text-center">
            <a id="cancelar" href="../index.php" class="btn btn-danger">Cancelar</a>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
function togglePasswordVisibility(fieldId) {
    var field = document.getElementById(fieldId);
    var fieldType = field.getAttribute('type');
    if (fieldType === 'password') {
        field.setAttribute('type', 'text');
    } else {
        field.setAttribute('type', 'password');
    }
}
</script>
</body>
</html>