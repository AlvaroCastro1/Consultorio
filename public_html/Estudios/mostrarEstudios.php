<?php
header('Content-Type: application/json; charset=utf-8');
// Datos de conexión a la base de datos
require_once "../includes/conexion.php";

$idExpediente = $_POST["idExpediente"];
$tipoEstudio = isset($_POST['tipoEstudio']) ? $conn->real_escape_string($_POST['tipoEstudio']) : null;
$idEstudios = isset($_POST['idEstudios']) ? $_POST['idEstudios'] : null;

$where = '';

if (isset($idEstudios) || $idEstudios !== null) {
    $where = "AND e.idEstudios = $idEstudios";
}else{
    if ($tipoEstudio != null) {
        $where = "AND e.tipoEstudio LIKE '%$tipoEstudio%'";
    }    
}

$sql = "SELECT 
e.idEstudios,
e.nombreEstudio, 
e.tipoEstudio,
e.descripcionEstudio,
de.idDetalleEstudios,
de.fechaEstudio
FROM estudios e
INNER JOIN detalleEstudios de 
ON e.idEstudios = de.idEstudiosDE
WHERE de.idExpedienteDE = $idExpediente 
$where";

$resultado = $conn->query($sql);

$data = array(); // Arreglo para almacenar los datos

if (!$resultado) {
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    return ;
}

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $data[] = $row; // Agregar cada fila de resultados al arreglo $data
    }
}

// Enviar los datos como respuesta JSON
echo json_encode($data, JSON_UNESCAPED_UNICODE);

$conn->close();
?>
