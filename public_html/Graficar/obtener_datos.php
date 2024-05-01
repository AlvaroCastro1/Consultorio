<?php
// Conexión a la base de datos
include '../includes/conexion.php';

$campo = $_GET['campo'];
$idExpediente = $_GET['idExpediente'];

// Consulta para obtener los datos del campo especificado de un expediente específico, ordenados por la fecha de control
$sql = "SELECT cc.fechaControl, cc.$campo 
        FROM ControlCrecimiento cc 
        JOIN detalleControlCrecimiento dcc ON cc.idControlC = dcc.idControlCDC
        WHERE dcc.idExpedienteDC = $idExpediente 
        ORDER BY cc.fechaControl";
$result = $conn->query($sql);

$fechas = [];
$datos = [];

if ($result->num_rows > 0) {
  // Guardar los datos en arreglos
  while($row = $result->fetch_assoc()) {
    array_push($fechas, $row['fechaControl']);
    array_push($datos, $row[$campo]);
  }
}

$conn->close();

// Devolver los datos como JSON
echo json_encode(['fechas' => $fechas, 'datos' => $datos]);
?>
