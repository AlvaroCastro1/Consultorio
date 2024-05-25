<?php
header('Content-Type: application/json; charset=utf-8');
require_once "../includes/conexion.php";

// Verificar si se ha recibido una fecha de búsqueda
$fecha = isset($_POST['fechaControl']) ? $_POST['fechaControl'] : null;

// Consulta SQL para buscar registros por fecha
if (!empty($fecha)) {
    // Usamos parámetros preparados para evitar inyección SQL
    $sql = "SELECT * FROM ControlCrecimiento WHERE fechaControl = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $fecha);
    $stmt->execute();
} else {
    // Si no se proporciona fecha, obtenemos todos los registros
    $sql = "SELECT * FROM ControlCrecimiento";
    $result = $conn->query($sql);
}

$response = array();

if (!empty($fecha)) {
    // Si se proporciona fecha, obtenemos los resultados de la consulta preparada
    $result = $stmt->get_result();
}

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $response[] = $row;
    }
} 

echo json_encode($response);

$conn->close();
?>
