<?php
include '../includes/conexion.php';


$idDetalleProcedimiento = $_POST['idDetalleProcedimiento'];

$query = "DELETE FROM detalleProcedimiento WHERE idDetalleProcedimiento = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $idDetalleProcedimiento);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => "No se pudo eliminar el procedimiento."]);
}

$stmt->close();
$conn->close();
?>
