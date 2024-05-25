<?php
// Incluir el archivo de conexión a la base de datos
require '../includes/conexion.php';

// Verificar si se ha enviado algún dato por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario de manera segura
    $idPaciente = isset($_POST['idPaciente']) ? $_POST['idPaciente'] : '';
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $apellidoPaterno = isset($_POST['apellidoPaterno']) ? $_POST['apellidoPaterno'] : '';
    $apellidoMaterno = isset($_POST['apellidoMaterno']) ? $_POST['apellidoMaterno'] : '';
    $fechaNacimiento = isset($_POST['fechaNacimiento']) ? $_POST['fechaNacimiento'] : '';
    $sexo = isset($_POST['sexo']) ? $_POST['sexo'] : '';
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $pais = isset($_POST['pais']) ? $_POST['pais'] : '';
    $estado = isset($_POST['estado']) ? $_POST['estado'] : '';
    $municipio = isset($_POST['municipio']) ? $_POST['municipio'] : '';
    $localidad = isset($_POST['localidad']) ? $_POST['localidad'] : '';
    $numero_ext = isset($_POST['numero_ext']) ? $_POST['numero_ext'] : '';
    $numero_int = isset($_POST['numero_int']) ? $_POST['numero_int'] : '';
    $codigoPostal = isset($_POST['codigoPostal']) ? $_POST['codigoPostal'] : '';
    $tipoSangre = isset($_POST['tipoSangre']) ? $_POST['tipoSangre'] : '';

    // Verificar si se proporcionó un idPaciente válido
    if (!empty($idPaciente)) {
        // Preparar la consulta SQL utilizando consultas preparadas
        $sql = "UPDATE Paciente SET nombre=?, apellidoPaterno=?, apellidoMaterno=?, fechaNacimiento=?, sexo=?, telefono=?, email=?, pais=?, estado=?, municipio=?, localidad=?, numero_ext=?, numero_int=?, codigoPostal=?, tipoSangre=? WHERE idPaciente=?";

        // Preparar la sentencia
        $stmt = $conn->prepare($sql);

        // Vincular parámetros
        $stmt->bind_param("sssssssssssssssi", $nombre, $apellidoPaterno, $apellidoMaterno, $fechaNacimiento, $sexo, $telefono, $email, $pais, $estado, $municipio, $localidad, $numero_ext, $numero_int, $codigoPostal, $tipoSangre, $idPaciente);

        // Ejecutar la sentencia
        if ($stmt->execute()) {
            echo json_encode(array("success" => true, "message" => "Datos modificados correctamente"));
        } else {
            echo json_encode(array("success" => false, "message" => "Error al modificar los datos: " . $conn->error));
        }

        // Cerrar la sentencia
        $stmt->close();
    } else {
        echo json_encode(array("success" => false, "message" => "No se proporcionó un idPaciente válido"));
    }
} else {
    // Si no se reciben datos por POST, devolver un mensaje de error
    echo json_encode(array("success" => false, "message" => "No se han recibido datos por POST"));
}
?>
