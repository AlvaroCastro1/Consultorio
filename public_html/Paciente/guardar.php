<?php
// Incluir el archivo de conexión a la base de datos
require '../includes/conexion.php';

// Verificar si se ha enviado algún dato por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario de manera segura
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

    // Iniciar una transacción
    $conn->begin_transaction();

    try {
        // Preparar la consulta SQL para insertar en Paciente
        $sqlPaciente = "INSERT INTO Paciente (nombre, apellidoPaterno, apellidoMaterno, fechaNacimiento, sexo, telefono, email, pais, estado, municipio, localidad, numero_ext, numero_int, codigoPostal, tipoSangre) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Preparar la sentencia
        $stmtPaciente = $conn->prepare($sqlPaciente);

        // Vincular parámetros
        $stmtPaciente->bind_param("sssssssssssssss", $nombre, $apellidoPaterno, $apellidoMaterno, $fechaNacimiento, $sexo, $telefono, $email, $pais, $estado, $municipio, $localidad, $numero_ext, $numero_int, $codigoPostal, $tipoSangre);

        // Ejecutar la sentencia
        if ($stmtPaciente->execute()) {
            // Obtener el ID del paciente insertado
            $idPaciente = $stmtPaciente->insert_id;

            // Obtener la fecha actual
            $fechaActual = date("Y-m-d");

            // Preparar la consulta SQL para insertar en Expediente
            $sqlExpediente = "INSERT INTO Expediente (idPacienteE, fechaUltimaActualizacion) VALUES (?, ?)";

            // Preparar la sentencia
            $stmtExpediente = $conn->prepare($sqlExpediente);

            // Vincular parámetros
            $stmtExpediente->bind_param("is", $idPaciente, $fechaActual);

            // Ejecutar la sentencia
            if ($stmtExpediente->execute()) {
                // Si ambas inserciones son exitosas, confirmar la transacción
                $conn->commit();
                echo json_encode(array("success" => true, "message" => "Datos guardados correctamente"));
            } else {
                // Si la inserción en Expediente falla, lanzar una excepción
                throw new Exception("Error al guardar los datos en Expediente: " . $stmtExpediente->error);
            }

            // Cerrar la sentencia de Expediente
            $stmtExpediente->close();
        } else {
            // Si la inserción en Paciente falla, lanzar una excepción
            throw new Exception("Error al guardar los datos en Paciente: " . $stmtPaciente->error);
        }

        // Cerrar la sentencia de Paciente
        $stmtPaciente->close();
    } catch (Exception $e) {
        // En caso de error, revertir la transacción
        $conn->rollback();
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
    }

} else {
    // Si no se reciben datos por POST, devolver un mensaje de error
    echo json_encode(array("success" => false, "message" => "No se han recibido datos por POST"));
}
?>
