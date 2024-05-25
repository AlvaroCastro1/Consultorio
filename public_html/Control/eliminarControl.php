<?php
header("Content-Type: text/plain");
// Datos de conexión a la base de datos
require_once "../includes/conexion.php";
$status = 200;


if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    // Obtener el cuerpo de la solicitud JSON
    $json_data = file_get_contents('php://input');

    // Decodificar el JSON a un array asociativo
    $data = json_decode($json_data, true);

    // Verificar si se pudo decodificar el JSON correctamente
    if ($data === null) {
        // Error al decodificar el JSON
        echo json_encode(array('error' => 'Error al decodificar el JSON.'));
        exit;
    }

    $idControlC = $data['idControlC'];

    $sql = "DELETE FROM ControlCrecimiento WHERE idControlC = $idControlC";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        // Si la consulta se ejecuta correctamente, enviar una respuesta exitosa
        echo "El estudio ha sido eliminado correctamente.";
    } else {
        // Si hay un error, enviar un mensaje de error
        echo "Error al eliminar el estudio: " . $conn->error;
        $status = 500;
    }
} else {
    // Si no se recibió una solicitud POST, enviar un mensaje de error
    echo "Método de solicitud no permitido.";
    $status = 405; // Método no permitido
}

// Cerrar la conexión
$conn->close();
http_response_code($status);
?>
