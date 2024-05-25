<?php
// Conexión a la base de datos
include '../includes/conexion.php';

// Obtener el idExpediente y el término de búsqueda de la URL
$idExpediente = $_GET["idExpediente"];
$busqueda = $_GET["busqueda"];

// Limpiar el término de búsqueda para evitar inyección SQL
$busqueda = $conn->real_escape_string($busqueda);

// Inicializar la condición de búsqueda
$searchCondition = "e.tipoEstudio LIKE '%$busqueda%' OR e.nombreEstudio LIKE '%$busqueda%'";

// Verificar si el término de búsqueda es una fecha válida
if (DateTime::createFromFormat('Y-m-d', $busqueda) !== false) {
    $searchCondition .= " OR de.fechaEstudio = '$busqueda'";
}

// Consulta SQL para buscar los estudios por tipo, nombre o fecha
$sql = "SELECT e.idEstudios as idEstudio, tipoEstudio, nombreEstudio, descripcionEstudio, de.fechaEstudio 
        FROM Estudios e 
        INNER JOIN detalleEstudios de ON e.idEstudios = de.idEstudiosDE 
        WHERE de.idExpedienteDE = $idExpediente 
        AND ($searchCondition)";

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
