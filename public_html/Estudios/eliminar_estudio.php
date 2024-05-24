<?php
// Conexión a la base de datos
include '../includes/conexion.php';

// Obtener los datos enviados por la solicitud AJAX
$data = json_decode(file_get_contents("php://input"), true);
$idEstudio = $data["idEstudio"];

// Query para eliminar el estudio
$sqlEliminarEstudio = "DELETE FROM Estudios WHERE idEstudios = $idEstudio";

if ($conn->query($sqlEliminarEstudio)) {
    // Éxito, devolver respuesta HTTP 200 OK
    http_response_code(200);
} else {
    // Error, devolver respuesta HTTP 500 Internal Server Error
    http_response_code(500);
    echo "Error al eliminar el estudio: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
