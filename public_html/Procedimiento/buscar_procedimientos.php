<?php
include '../includes/conexion.php';


$fechaBusqueda = $_POST['fechaBusqueda'];

$query = "
SELECT P.nombreProceso, P.descripcionProcedimiento, DP.observaciones, DP.fechaProceso, DP.idDetalleProcedimiento
FROM Procedimiento P
INNER JOIN detalleProcedimiento DP ON P.idProcedimiento = DP.idProcedimientoDP
WHERE DP.fechaProceso = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $fechaBusqueda);
$stmt->execute();
$result = $stmt->get_result();

$procedimientos = array();

while ($row = $result->fetch_assoc()) {
    $procedimientos[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($procedimientos);
?>
