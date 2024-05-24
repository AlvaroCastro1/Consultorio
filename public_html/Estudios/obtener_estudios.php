<?php
include '../includes/conexion.php';

// Obtener el idExpediente de la URL
$idExpediente = $_GET["idExpediente"];

// Consulta SQL para obtener los estudios asociados al idExpediente
$sql = "SELECT tipoEstudio, nombreEstudio, descripcionEstudio, fechaEstudio FROM Estudios e INNER JOIN detalleEstudios de ON e.idEstudios = de.idEstudiosDE WHERE de.idExpedienteDE = $idExpediente";
$result = $conn->query($sql);

$estudios = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $estudios[] = $row;
    }
}

// Devolver los estudios en formato JSON
echo json_encode($estudios);

$conn->close();
?>
