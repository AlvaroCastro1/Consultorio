<?php
header("Content-Type: text/plain");
// Datos de conexión a la base de datos
require_once "../includes/conexion.php";
$status = 200;

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    // Obtenemos el cuerpo de la solicitud JSON
    $json_data = file_get_contents('php://input');

    // Decodificamos el JSON a un array asociativo
    $data = json_decode($json_data, true);

    // Verificamos si se pudo decodificar el JSON correctamente
    if ($data === null) {
        // Error al decodificar el JSON
        echo json_encode(array('error' => 'Error al decodificar el JSON.'));
        exit;
    }

    // Accedemos a los datos JSON
    $idEstudio = $data['idEstudio'];
    $idExpediente = $data['idExpediente'];

    // Consulta SQL para eliminar el estudio
    $sql = "DELETE FROM detalleEstudios WHERE idEstudiosDE = $idEstudio AND idExpedienteDE = $idExpediente";
    $sql2 = "DELETE FROM estudios WHERE idEstudios = $idEstudio";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        // Si la consulta se ejecuta correctamente, enviar una respuesta exitosa
        if($conn->query($sql2) === TRUE){
            echo "El estudio ha sido eliminado correctamente.";
        }else{
            echo "Error al intentar eliminar el estudio: ". $conn->error;
            $status = 500;
        }
    } else {
        // Si hay un error, enviar un mensaje de error
        echo "Error al eliminar el estudio: " . $conn->error;
        $status = 500;
    }
} else{
    echo "No se puede realizar esta operación";
    $status = 500;
}

// Cerrar la conexión
$conn->close();
http_response_code($status);
?>
