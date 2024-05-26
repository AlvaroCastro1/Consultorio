<?php
include '../includes/conexion.php';

$nombreProcedimiento = $_POST['nombreProcedimiento'];
$descripcionProcedimiento = $_POST['descripcionProcedimiento'];
$observaciones = $_POST['observaciones'];
$fechaProcedimiento = $_POST['fechaProcedimiento'];
$idExpediente = $_POST['idExpediente']; 

// Insertar el procedimiento en la tabla Procedimiento si no existe
$queryProcedimiento = "INSERT INTO Procedimiento (nombreProceso, descripcionProcedimiento) VALUES (?, ?) ON DUPLICATE KEY UPDATE idProcedimiento=LAST_INSERT_ID(idProcedimiento)";
$stmtProcedimiento = $conn->prepare($queryProcedimiento);
$stmtProcedimiento->bind_param("ss", $nombreProcedimiento, $descripcionProcedimiento);
$stmtProcedimiento->execute();
$idProcedimiento = $stmtProcedimiento->insert_id;
$stmtProcedimiento->close();

// Insertar el detalle del procedimiento en la tabla detalleProcedimiento
$queryDetalle = "INSERT INTO detalleProcedimiento (idExpedienteDP, idProcedimientoDP, observaciones, fechaProceso) VALUES (?, ?, ?, ?)";
$stmtDetalle = $conn->prepare($queryDetalle);
$stmtDetalle->bind_param("iiss", $idExpediente, $idProcedimiento, $observaciones, $fechaProcedimiento);
$stmtDetalle->execute();
$stmtDetalle->close();

$conn->close();

echo json_encode(["success" => true]);
?>
