<?php
// Incluir el archivo de conexión a la base de datos
require '../includes/conexion.php';

// Configurar el manejo de errores
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

header('Content-Type: application/json');

$response = array("success" => false, "data" => [], "message" => "Error desconocido");

// Verificar si se ha enviado algún dato por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el id del paciente del formulario de manera segura
    $idPaciente = isset($_POST['idPaciente']) ? intval($_POST['idPaciente']) : null;

    // Preparar la consulta SQL para buscar los datos del paciente con el id proporcionado
    $sql = "SELECT * FROM Paciente WHERE idPaciente = ?";
    
    // Preparar la sentencia
    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("i", $idPaciente);

    // Ejecutar la sentencia
    if ($stmt->execute()) {
        // Obtener el resultado
        $resultado = $stmt->get_result();  
        $data = $resultado->fetch_assoc();
        if ($data) {
            $response["success"] = true;
            $response["data"] = $data;
            $response["message"] = "Datos encontrados correctamente";
        } else {
            $response["message"] = "No se encontraron datos para el id de paciente proporcionado";
        }

    } else {
        $response["message"] = "Error al ejecutar la sentencia: " . $stmt->error;
    }

    // Cerrar la sentencia
    $stmt->close();
} else {
    $response["message"] = "No se han recibido datos por POST";
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>