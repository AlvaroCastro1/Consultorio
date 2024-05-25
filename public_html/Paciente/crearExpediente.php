<?php
// Incluir el archivo de conexión a la base de datos
require '../includes/conexion.php';

// Verificar si se ha enviado algún dato por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario de manera segura
    $idPaciente = isset($_POST['idPaciente']) ? $_POST['idPaciente'] : '';
    // Preparar la consulta SQL utilizando consultas preparadas
    $sql = "INSERT INTO Expediente (idExpedienteE, fechaUltimaActualizacion) VALUES (?, ?)";

    // Preparar la sentencia
    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("si",$codigoPostal, $tipoSangre);

    // Ejecutar la sentencia
    if ($stmt->execute()) {
        echo json_encode(array("success" => true, "message" => "Datos de expediente guardados correctamente"));
        
    } else {
        echo json_encode(array("success" => false, "message" => "Error al guardar los datos: " . $conn->error));
    }

    // Cerrar la sentencia
    $stmt->close();
} else {
    // Si no se reciben datos por POST, devolver un mensaje de error
    echo json_encode(array("success" => false, "message" => "No se han recibido datos por POST"));
}
?>
