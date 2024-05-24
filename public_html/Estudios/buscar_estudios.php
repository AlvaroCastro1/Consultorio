<?php
// Conexión a la base de datos
include '../includes/conexion.php';
// Obtener el idExpediente y el término de búsqueda de la URL
$idExpediente = $_GET["idExpediente"];
$busqueda = $_GET["busqueda"];

// Consulta SQL para buscar los estudios por nombre o fecha
$sql = "SELECT tipoEstudio, nombreEstudio, descripcionEstudio, fechaEstudio FROM Estudios e INNER JOIN detalleEstudios de ON e.idEstudios = de.idEstudiosDE WHERE de.idExpedienteDE = $idExpediente AND (e.tipoEstudio LIKE '%$busqueda%' OR e.nombreEstudio LIKE '%$busqueda%' OR de.fechaEstudio = '$busqueda')";

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
