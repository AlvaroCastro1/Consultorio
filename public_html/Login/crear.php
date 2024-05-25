<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/barraNav.css">
    <link rel="stylesheet" href="../assets/css/PacientesStyles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../assets/js/header.js"></script>
</head>

<body>

    <script>
        const navItems = [
            { name: "Inicio", uri: "/" },
        ];

        createHeader(navItems); // Llamar a la función para crear el header
    </script>

    <div class="container2 mt-5">
        <h1 class="titulo mb-4">Registro de Usuario</h1>

        <form id="formulario-usuario" action="crear.php" method="POST" onsubmit="return validarFormulario()">
            <!-- Campo para el nombre de usuario -->
            <div class="mb-3">
                <label for="nombre-usuario" class="form-label">Nombre de Usuario</label>
                <input type="text" class="form-control" id="nombre-usuario" name="nombre-usuario" required>
            </div>
            <!-- Campo para la contraseña -->
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                    <button class="btn btn-outline-secondary" type="button" id="toggle-password">Mostrar</button>
                </div>
            </div>
            <!-- Campo para confirmar la contraseña -->
            <div class="mb-3">
                <label for="confirmar-contrasena" class="form-label">Confirmar Contraseña</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="confirmar-contrasena" name="confirmar-contrasena" required>
                    <button class="btn btn-outline-secondary" type="button" id="toggle-confirm-password">Mostrar</button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
    </div>
    <div class="espacio-final"></div>

    <footer>
        <div class="container3">
            <p>Pie de página</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function validarFormulario() {
            const nombreUsuario = document.getElementById('nombre-usuario').value;
            const contrasena = document.getElementById('contrasena').value;
            const confirmarContrasena = document.getElementById('confirmar-contrasena').value;

            // Expresión regular para verificar si el nombre de usuario es alfanumérico
            const nombreUsuarioRegex = /^[a-zA-Z0-9]+$/;
            // Expresión regular para verificar si la contraseña tiene al menos 8 caracteres alfanuméricos
            const contrasenaRegex = /^[a-zA-Z0-9]{8,}$/;

            // Validar nombre de usuario
            if (!nombreUsuarioRegex.test(nombreUsuario)) {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "El nombre de nombre de usuario debe contener solo caracteres alfanumérico."
                });
                return false;
            }

            // Validar contraseña
            if (!contrasenaRegex.test(contrasena)) {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "La contraseña debe tener al menos 8 caracteres alfanuméricos."
                });
                return false;
            }

            // Verificar si las contraseñas coinciden
            if (contrasena !== confirmarContrasena) {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Las contraseñas no coinciden. Por favor, inténtelo de nuevo."
                });
                return false;
            }

            return true; // El formulario es válido
        }

        document.getElementById('toggle-password').addEventListener('click', function () {
            const passwordField = document.getElementById('contrasena');
            const passwordFieldType = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', passwordFieldType);
            this.textContent = passwordFieldType === 'password' ? 'Mostrar' : 'Ocultar';
        });

        document.getElementById('toggle-confirm-password').addEventListener('click', function () {
            const confirmPasswordField = document.getElementById('confirmar-contrasena');
            const confirmPasswordFieldType = confirmPasswordField.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordField.setAttribute('type', confirmPasswordFieldType);
            this.textContent = confirmPasswordFieldType === 'password' ? 'Mostrar' : 'Ocultar';
        });
    </script>

    <?php
    // Incluir el archivo de conexión a la base de datos
    include('../includes/conexion.php');

    // Verificar si se han enviado datos desde el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los valores del formulario
        $nombre_usuario = $_POST["nombre-usuario"];
        $contrasena = $_POST["contrasena"];
        $confirmar_contrasena = $_POST["confirmar-contrasena"];

        // Validar nombre de usuario alfanumérico
        if (!preg_match('/^[a-zA-Z0-9]+$/', $nombre_usuario)) {
            $error_message = "El nombre de usuario debe ser alfanumérico.";
        }

        // Validar contraseña: al menos 8 caracteres alfanuméricos
        if (!preg_match('/^[a-zA-Z0-9]{8,}$/', $contrasena)) {
            $error_message = "La contraseña debe tener al menos 8 caracteres alfanuméricos.";
        }

        // Verificar si las contraseñas coinciden
        if ($contrasena != $confirmar_contrasena) {
            $error_message = "Las contraseñas no coinciden. Por favor, inténtelo de nuevo.";
        } else {
            // Verificar si el nombre de usuario ya existe en la base de datos
            $sql = "SELECT * FROM Usuario WHERE Nombre_Usuario = '$nombre_usuario'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $error_message = "El nombre de usuario ya está en uso. Por favor, elija otro.";
            } else {
                // Encriptar la contraseña antes de almacenarla en la base de datos
                $hash_contraseña = password_hash($contrasena, PASSWORD_DEFAULT);
                
                // Si pasa todas las validaciones, insertar los datos en la tabla Usuario
                // Puedes establecer el privilegio como desees, por ejemplo, aquí lo establezco como 1
                $privilegio = 1;
                $sql_insert = "INSERT INTO Usuario (Nombre_Usuario, Contrasena, Privilegio) VALUES ('$nombre_usuario', '$hash_contraseña', $privilegio)";

                if ($conn->query($sql_insert) === TRUE) {
                    $success_message = "Registro creado exitosamente";
                } else {
                    $error_message = "Error al crear el registro: " . $conn->error;
                }
            }
        }

        // Mostrar mensajes al usuario utilizando SweetAlert
        if (isset($error_message)) {
            echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "' . $error_message . '",
                        confirmButtonText: "Volver",
                        onClose: () => {
                            window.history.back();
                        }
                    });
                </script>';
        } elseif (isset($success_message)) {
            echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Éxito",
                        text: "' . $success_message . '",
                        confirmButtonText: "Aceptar",
                        onClose: () => {
                            window.history.back();
                        }
                    });
                </script>';
        }
    }
    ?>

</body>

</html>
