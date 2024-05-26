<?php
include '../includes/conexion.php';

$idExpediente = $_POST['idExpediente'];

$query = "
    SELECT p.nombreProceso, p.descripcionProcedimiento, dp.observaciones, dp.fechaProceso, dp.idDetalleProcedimiento
    FROM Procedimiento p 
    INNER JOIN detalleProcedimiento dp ON p.idProcedimiento = dp.idProcedimientoDP 
    WHERE dp.idExpedienteDP = ?";


$stmt = $conn->prepare($query);
$stmt->bind_param("i", $idExpediente);
$stmt->execute();
$result = $stmt->get_result();

$procedimientos = array();

while ($row = $result->fetch_assoc()) {
    $procedimientos[] = $row;
}

echo json_encode($procedimientos);

$stmt->close();
$conn->close();
?>
