<?php
// Incluir el archivo de conexión a la base de datos
require '../includes/conexion.php';

// Configurar el manejo de errores
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

header('Content-Type: application/json');

$response = array("success" => false, "message" => "Error desconocido");

try {
    // Verificar si se ha enviado algún dato por POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener el idPaciente del formulario de manera segura
        $idPaciente = isset($_POST['idPaciente']) ? intval($_POST['idPaciente']) : 0;

        // Verificar si se proporcionó un idPaciente válido
        if ($idPaciente > 0) {
            // Preparar la consulta SQL para eliminar la fila con el idPaciente proporcionado
            $sql = "DELETE FROM Paciente WHERE idPaciente = ?";

            // Preparar la sentencia
            $stmt = $conn->prepare($sql);

            // Vincular parámetros
            $stmt->bind_param("i", $idPaciente);

            // Ejecutar la sentencia
            if ($stmt->execute()) {
                $response["success"] = true;
                $response["message"] = "La fila se eliminó correctamente";
            } else {
                $response["message"] = "Error al ejecutar la sentencia: " . $stmt->error;
            }

            // Cerrar la sentencia
            $stmt->close();
        } else {
            $response["message"] = "No se proporcionó un idPaciente válido";
        }
    } else {
        $response["message"] = "No se han recibido datos por POST";
    }
} catch (Exception $e) {
    $response["message"] = "Error: " . $e->getMessage();
}

echo json_encode($response);
?>
